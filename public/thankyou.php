<?php
// sangat sederhana: hanya menampilkan info order
$orderId = (int)($_GET['id'] ?? 0);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Terima kasih - NailArt DApp</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-bg">
<div class="page">
  <h1>Terima kasih!</h1>
  <p>Pembayaran kamu sudah tercatat.</p>
  <p>ID Order: <strong>#<?= $orderId ?></strong></p>
  <p>Untuk demo sederhana, link download bisa kamu arahkan ke file ZIP langsung:<br>
     <code>assets/products/floral.zip</code> (silakan sesuaikan sendiri).</p>

  <a href="index.php" class="btn">Kembali ke katalog</a>
</div>
</body>
</html>
