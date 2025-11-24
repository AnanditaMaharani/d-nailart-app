<?php
require __DIR__.'/api/koneksi.php';

// ambil semua produk
$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>NailArt DApp - Katalog</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page-bg">

<div class="page">

    <?php include __DIR__ . "/components/navbar.php"; ?>
  <!-- HERO -->
  <section class="hero">
    <div class="hero-text">
      <h1>
        Katalog <span>Nail Art Digital</span><br>
        Siap pakai untuk salon & creator.
      </h1>
      <p>
        Pilih desain nail art favoritmu, bayar dengan crypto via MetaMask,
        dan dapatkan file desain digital siap cetak.
      </p>
    </div>
  </section>

  <!-- KATALOG -->
  <section class="catalog">
    <div class="section-head">
      <h2>Semua Desain</h2>
      <span><?= count($products) ?> item</span>
    </div>

    <?php if (empty($products)): ?>
      <p class="empty">
        Belum ada produk. Tambahkan data di tabel <code>products</code> terlebih dahulu 😊
      </p>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($products as $p): ?>
          <article class="card">
            <div class="thumb-wrap">
              <?php if (!empty($p['preview_image'])): ?>
                <img src="<?= htmlspecialchars($p['preview_image']) ?>"
                     alt="<?= htmlspecialchars($p['name']) ?>"
                     class="thumb">
              <?php else: ?>
                <div class="thumb placeholder">No Image</div>
              <?php endif; ?>
            </div>
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <div class="card-bottom">
              <span class="price"><?= htmlspecialchars($p['price_eth']) ?> ETH</span>
              <a class="btn" href="product.php?id=<?= (int)$p['id'] ?>">Detail</a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</div>

</body>
</html>
