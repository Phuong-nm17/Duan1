<?php
require_once '../model/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $size = $_POST['size'] ?? null;
    $color = $_POST['color'] ?? null;

    if ($productId && $size && $color) {
        $stmt = $conn->prepare("SELECT stock FROM product_variants WHERE product_id = ? AND size = ? AND color = ?");
        $stmt->execute([$productId, $size, $color]);
        $stock = $stmt->fetchColumn();

        echo json_encode(['stock' => $stock ?: 0]);
    } else {
        echo json_encode(['stock' => 0]);
    }
}