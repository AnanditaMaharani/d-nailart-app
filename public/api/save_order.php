<?php
header('Content-Type: application/json');
require __DIR__.'/koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

$productId = (int)($data['product_id'] ?? 0);
$buyer     = $data['buyer_address'] ?? '';
$amount    = $data['amount_eth'] ?? '';
$txHash    = $data['tx_hash'] ?? '';

if (!$productId || !$buyer || !$amount || !$txHash) {
    echo json_encode(['success' => false, 'error' => 'Field tidak lengkap']);
    exit;
}

$stmt = $pdo->prepare("
  INSERT INTO orders (product_id, buyer_address, tx_hash, amount_eth)
  VALUES (:pid, :buyer, :tx, :amount)
");
try {
    $stmt->execute([
        ':pid'    => $productId,
        ':buyer'  => $buyer,
        ':tx'     => $txHash,
        ':amount' => $amount,
    ]);
    $orderId = $pdo->lastInsertId();
    echo json_encode(['success' => true, 'order_id' => $orderId]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
