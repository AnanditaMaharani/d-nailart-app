const statusEl = document.getElementById('status');
const buyBtn   = document.getElementById('buyBtn');

// GANTI dengan wallet kamu
const SELLER_ADDRESS = "0xYOUR_WALLET_ADDRESS_HERE";

function setStatus(msg, type = "") {
  if (!statusEl) return;
  statusEl.textContent = msg;
  statusEl.className = "status " + type;
}

function parseEtherToHexWei(str){
  if(typeof str !== "string") str = String(str);
  str = str.trim();
  const [intPart, decPartRaw = ""] = str.split(".");
  const intBig = BigInt(intPart || "0");
  const decStr = (decPartRaw.replace(/\D/g,"") + "0".repeat(18)).slice(0,18);
  const wei = intBig * (10n ** 18n) + BigInt(decStr || "0");
  return "0x" + wei.toString(16);
}

if (buyBtn) {
  buyBtn.addEventListener("click", async () => {
    if (!window.ethereum) {
      alert("MetaMask tidak ditemukan. Install extension MetaMask dulu.");
      return;
    }
    if (!/^0x[a-fA-F0-9]{40}$/.test(SELLER_ADDRESS)) {
      setStatus("SELLER_ADDRESS belum di-set dengan benar di buy.js", "error");
      return;
    }

    try {
      buyBtn.disabled = true;
      setStatus("Menghubungkan ke MetaMask...");

      const accounts = await ethereum.request({ method: "eth_requestAccounts" });
      const buyer = accounts[0];

      const valueHex = parseEtherToHexWei(PRICE_ETH);
      setStatus("Menunggu konfirmasi transaksi di MetaMask...");

      const txHash = await ethereum.request({
        method: "eth_sendTransaction",
        params: [{
          from: buyer,
          to: SELLER_ADDRESS,
          value: valueHex,
        }]
      });

      setStatus("Menyimpan data transaksi ke server...");

      const res = await fetch("api/save_order.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          product_id: PRODUCT_ID,
          buyer_address: buyer,
          amount_eth: PRICE_ETH,
          tx_hash: txHash
        })
      });
      const json = await res.json();

      if (json.success) {
        setStatus("Pembayaran berhasil! Mengalihkan ke halaman terima kasih...", "ok");
        window.location.href = "thankyou.php?id=" + json.order_id;
      } else {
        setStatus("Gagal menyimpan order: " + (json.error || ""), "error");
      }

    } catch (err) {
      console.error(err);
      if (err && err.code === 4001) {
        setStatus("Transaksi dibatalkan oleh pengguna.", "error");
      } else {
        setStatus("Terjadi error saat mengirim transaksi.", "error");
      }
    } finally {
      buyBtn.disabled = false;
    }
  });
}
