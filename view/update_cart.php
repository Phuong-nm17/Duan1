<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$cart_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$action = $_GET['action'] ?? '';

if ($cart_id > 0 && in_array($action, ['increase', 'decrease'])) {
    // Lấy số lượng hiện tại từ giỏ hàng
    $sql = "SELECT quantity FROM cart WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $quantity = (int) $result['quantity'];

        if ($action === 'increase') {
            $quantity++;
        } elseif ($action === 'decrease' && $quantity > 1) {
            $quantity--;
        }

        // Cập nhật lại số lượng
        $update_sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $update_stmt->bindParam(':id', $cart_id, PDO::PARAM_INT);
        $update_stmt->execute();
    }
}

header("Location: ../index.php?act=cart");
exit;
?>
