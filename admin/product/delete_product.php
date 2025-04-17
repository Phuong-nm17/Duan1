<?php
session_start();
require '../../model/connect.php';

// Ensure the user is an admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit; // Halt further script execution
}

// Ensure the product ID is present and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID sản phẩm không hợp lệ!'); window.location.href='product.php';</script>";
    exit;
}

$product_id = $_GET['id'];

try {
    // Bước 1: Lấy tất cả các variant_id từ bảng product_variants dựa vào product_id
    $stmt = $conn->prepare("SELECT id FROM product_variants WHERE product_id = ?");
    $stmt->execute([$product_id]);
    $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($variants) {
        // Bước 2: Xóa tất cả các variants
        foreach ($variants as $variant) {
            $stmt = $conn->prepare("DELETE FROM product_variants WHERE id = ?");
            $stmt->execute([$variant['id']]);
        }

        // Bước 3: Xóa sản phẩm từ bảng product
        $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->execute([$product_id]);

        // Redirect after successful deletion
        echo "<script>alert('Xóa sản phẩm và variants thành công!'); window.location.href='product.php';</script>";
        exit; // Ensure script halts after redirection
    } else {
        echo "<script>alert('Không tìm thấy sản phẩm với product_id này!'); window.location.href='product.php';</script>";
        exit;
    }
} catch (Exception $e) {
    // Log the error message (consider writing to a file or logging system in production)
    error_log($e->getMessage());

    // Display a user-friendly error message
    echo "<script>alert('Đã xảy ra lỗi. Vui lòng thử lại sau.'); window.location.href='product.php';</script>";
    exit;
}
?>
