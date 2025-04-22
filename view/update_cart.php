<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

if (!isset($_SESSION['id'])) {
    die("Please login to perform this action.");
}

$cart_id = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

if ($cart_id && ($action == 'increase' || $action == 'decrease')) {
    try {
        $stmt = $conn->prepare("
            SELECT c.*, pv.stock 
            FROM cart c
            JOIN product_variants pv ON c.product_id = pv.product_id 
                AND c.color_id = pv.color_id 
                AND c.size_id = pv.size_id
            WHERE c.id = ?
        ");
        $stmt->execute([$cart_id]);
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cart_item) {
            $_SESSION['error'] = "Product does not exist in cart.";
            header("Location: ../index.php?act=cart");
            exit;
        }

        $new_quantity = $action == 'increase' ? $cart_item['quantity'] + 1 : $cart_item['quantity'] - 1;

        // Check stock quantity when increasing
        if ($action == 'increase' && $new_quantity > $cart_item['stock']) {
            $_SESSION['error'] = "Cannot add more quantity. Only " . $cart_item['stock'] . " items left in stock.";
            header("Location: ../index.php?act=cart");
            exit;
        }

        // Check minimum quantity
        if ($new_quantity < 1) {
            // Remove product from cart
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $stmt->execute([$cart_id]);
        } else {
            // Update quantity
            $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $stmt->execute([$new_quantity, $cart_id]);
        }

        header("Location: ../index.php?act=cart");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: ../index.php?act=cart");
        exit;
    }
}

header("Location: ../index.php?act=cart");
exit;
?>
