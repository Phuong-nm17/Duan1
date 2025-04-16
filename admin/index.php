<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header("Location: auth/login.php");
    exit;
}

// Tạo CSRF Token nếu chưa có
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <a href="./auth/logout.php" class="btn btn-danger">Đăng xuất</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card p-4">
            <h2 class="mb-3">Chào mừng, Admin</h2>
            <a href="product/product.php" class="btn btn-success mb-3">Quản lý Sản phẩm</a>
            <a href="category/categories.php" class="btn btn-secondary mb-3">Quản lý danh mục</a>
            <a href="user/user_management.php" class="btn btn-primary mb-3">Quản lý khách hàng</a>
            <a href="order/orders.php" class="btn btn-info ">Quản lý đơn hàng</a>
        </div>
    </div>
</body>

</html>