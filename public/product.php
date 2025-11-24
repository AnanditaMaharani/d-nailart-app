<?php
require __DIR__.'/api/koneksi.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    http_response_code(404);
    echo "Produk tidak ditemukan.";
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($p['name']) ?> - NailArt DApp</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-bg">

<div class="page">
    <?php include __DIR__ . "/components/navbar.php"; ?>
  <a href="index.php" class="back-link">← Kembali ke katalog</a>

  <section class="detail">
    <div class="detail-left">
      <?php if ($p['preview_image']): ?>
        <img src="<?= htmlspecialchars($p['preview_image']) ?>" 
             alt="<?= htmlspecialchars($p['name']) ?>" 
             class="detail-img">
      <?php else: ?>
        <div class="detail-img placeholder">Preview tidak tersedia</div>
      <?php endif; ?>
    </div>

    <div class="detail-right">
      <h1><?= htmlspecialchars($p['name']) ?></h1>

      <div class="chip-row">
        <span class="chip primary">Digital Nail Template</span>
        <span class="chip">Format: PNG / JPG / ZIP</span>
        <span class="chip">Instant Download</span>
      </div>

      <p class="detail-price"><?= htmlspecialchars($p['price_eth']) ?> ETH</p>

      <p class="detail-desc"><?= nl2br(htmlspecialchars($p['description'])) ?></p>

      <div class="detail-meta">
        <span>• Pembayaran via MetaMask (crypto)</span>
        <span>• Link download akan diberikan setelah transaksi tercatat.</span>
      </div>

      <button id="buyBtn" class="btn primary" style="margin-top:10px;">
        Buy with MetaMask
      </button>
      <p id="status" class="status"></p>
    </div>
  </section>
</div>

<script>
  const PRODUCT_ID = <?= (int)$p['id'] ?>;
  const PRICE_ETH  = "<?= $p['price_eth'] ?>";
</script>
<script src="assets/js/buy.js"></script>
</body>
</html>
