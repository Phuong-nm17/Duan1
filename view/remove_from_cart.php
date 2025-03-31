<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    die("Bạn cần đăng nhập để xóa sản phẩm.");
}

$user_id = (int) $_SESSION['id']; // ID người dùng
$cart_id = (int) ($_GET['id'] ?? 0); // ID mục trong giỏ hàng

if ($cart_id <= 0) {
    die("ID sản phẩm không hợp lệ.");
}

// Chuẩn bị câu SQL DELETE
$sql = "DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id";
$stmt = $conn->prepare($sql);

// Dùng bindParam
$stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Thực thi lệnh
$stmt->execute();

header("Location: ../index.php?act=cart");
exit;
