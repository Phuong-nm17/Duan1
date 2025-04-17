<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin']))
    header("Location: login.php");

if (!isset($_GET['id'])) {
    echo "<script>alert('Thiếu ID sản phẩm'); window.location.href='product.php';</script>";
    exit;
}

$variant_id = $_GET['id'];

try {
    // Bước 1: Lấy thông tin sản phẩm
    $stmt = $conn->prepare("SELECT product_id FROM product_variants WHERE id = ?");
    $stmt->execute([$variant_id]);
    $variant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($variant) {
        $product_id = $variant['product_id'];

        // Bước 2: Xóa sản phẩm từ bảng product_variants
        $stmt = $conn->prepare("DELETE FROM product_variants WHERE id = ?");
        $stmt->execute([$variant_id]);

        // Bước 3: Kiểm tra nếu không còn variants nào liên kết với sản phẩm này, thì xóa luôn sản phẩm
        $stmt = $conn->prepare("SELECT COUNT(*) FROM product_variants WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Nếu không còn variant nào, xóa sản phẩm từ bảng product
            $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
            $stmt->execute([$product_id]);
        }

        echo "<script>alert('Xóa sản phẩm thành công!'); window.location.href='product.php';</script>";
    } else {
        echo "<script>alert('Không tìm thấy sản phẩm!'); window.location.href='product.php';</script>";
    }
} catch (Exception $e) {
    die($e->getMessage());
}
?>
