<?php
require_once('../../model/connect.php');

if (!isset($_GET['id'])) {
    echo "<script>alert('Thiếu ID sản phẩm.'); window.location.href='product.php';</script>";
    exit;
}

$product_id = $_GET['id'];

// Kiểm tra xem sản phẩm có tồn tại trong đơn hàng không
$stmt = $conn->prepare("SELECT COUNT(*) FROM order_details WHERE product_id = ?");
$stmt->execute([$product_id]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    // Nếu có đơn hàng đang sử dụng sản phẩm, không cho phép xóa
    echo "<script>alert('Không thể xóa sản phẩm vì đã tồn tại trong đơn hàng.'); window.location.href='product.php';</script>";
    exit;
}

// Nếu không có đơn hàng nào, tiến hành xóa sản phẩm
$stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
$stmt->execute([$product_id]);

echo "<script>alert('Xóa sản phẩm thành công!'); window.location.href='product.php';</script>";
exit;
