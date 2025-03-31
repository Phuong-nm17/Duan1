<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

if (!isset($_SESSION['id'])) {

    header("Location: ../index.php?act=login");

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int) $_SESSION['id'];
    $product_id = (int) ($_POST['product_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 1);
    $size_id = (int) ($_POST['size_id'] ?? 0);
    $color_id = (int) ($_POST['color_id'] ?? 0);

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ chưa
    $sql_check = "SELECT id, quantity FROM cart 
                  WHERE user_id = ? AND product_id = ? AND size_id = ? AND color_id = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->execute([$user_id, $product_id, $size_id, $color_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Đã có sản phẩm trong giỏ → cập nhật số lượng
        $new_quantity = $result['quantity'] + $quantity;

        $sql_update = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->execute([$new_quantity, $result['id']]);
    } else {
        // Chưa có → thêm mới
        $sql_insert = "INSERT INTO cart (user_id, product_id, quantity, size_id, color_id)
                       VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->execute([$user_id, $product_id, $quantity, $size_id, $color_id]);
    }

    // Chuyển về trang giỏ hàng
    header("Location: ../index.php?act=cart");
    exit;
}
?>