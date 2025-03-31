<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) header("Location: login.php");
try {
    $sql = "  SELECT 
            product.id AS product_id, 
            product.title, 
            product.price, 
            product.thumbnail, 
            product.discount, 
            product.description, 
            size.name AS size_name, 
            color.name AS color_name,
            category.name AS category_name
        FROM product 
        JOIN size ON product.size_id = size.id
        JOIN color ON product.color_id = color.id
        JOIN category ON product.category_id = category.id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }

        /* Sidebar */
        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
            transition: width 0.3s ease-in-out;
            overflow: hidden;
        }

        #sidebar.collapsed {
            width: 80px;
        }

        #sidebar h4 {
            transition: opacity 0.3s;
        }

        #sidebar.collapsed h4 {
            opacity: 0;
        }

        #sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            white-space: nowrap;
            transition: background 0.3s ease-in-out;
            position: relative;
        }

        #sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        /* Submenu */
        .submenu {
            display: none;
            background: #495057;
            padding-left: 20px;
        }

        .menu-item:hover .submenu {
            display: block;
        }

        /* Nếu sidebar thu nhỏ, hiển thị submenu bên cạnh */
        #sidebar.collapsed .submenu {
            display: none;
            position: absolute;
            left: 80px;
            top: 0;
            background: #495057;
            padding: 10px;
            min-width: 150px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        #sidebar.collapsed .menu-item:hover .submenu {
            display: block;
        }

        /* Nút thu nhỏ sidebar */
        #toggle-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        /* Nội dung chính */
        #content {
            margin-left: 260px;
            width: 100%;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        #content.full-width {
            margin-left: 90px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <h4>Admin Panel</h4>

        <div class="menu-item">
            <a href="index.php"><i>🏠</i> <span>Trang chủ</span></a>
        </div>

        <div class="menu-item">
            <a href="../product/product.php"><i>📦</i> <span>Quản lý sản phẩm</span></a>
            <div class="submenu">
                <a href="../product/product.php">Danh sách sản phẩm</a>
                <a href="../product/add_product.php">Thêm sản phẩm</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="../category/categories.php"><i>📦</i> <span>Quản lý danh mục</span></a>
            <div class="submenu">
                <a href="../category/categories.php">Danh sách danh mục</a>
                <a href="../category/add_categories.php">Thêm danh mục</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="../user/user_management.php"><i>👤</i> <span>Quản lý khách hàng</span></a>
            <div class="submenu">
                <a href="../user/user_management.php">Danh sách khách hàng</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#"><i>🛒</i> <span>Quản lý đơn hàng</span></a>
            <div class="submenu">
                <a href="order_management.php">Danh sách đơn hàng</a>
                <a href="order_pending.php">Đơn hàng chờ xử lý</a>
            </div>
        </div>

        <a href="../auth/logout.php" class="text-danger"><i>🚪</i> <span>Đăng xuất</span></a>
    </div>

    <!-- Nội dung chính -->
    <div id="content">
        <h2>Danh sách sản phẩm</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá bán</th>
                    <th>Giá Discount</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>Màu sắc</th>
                    <th>Size</th>
                    <th>category</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $index => $p): ?>
                    <tr>
                        <td><?= $index ?></td>
                        <td><?= $p['title'] ?></td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?> $</td>
                        <td><?= number_format($p['discount'], 0, ',', '.') ?> $</td>
                        <td><img src="<?= $p['thumbnail'] ?>" width="50"></td>
                        <td><?= $p['description'] ?></td>
                        <td><?= $p['color_name'] ?></td>
                        <td><?= $p['size_name'] ?></td>
                        <td><?= $p['category_name'] ?></td>
                        <td class="text-center">
                            <a href="edit_product.php?id=<?= htmlspecialchars($p['product_id']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="delete_product.php?id=<?= htmlspecialchars($p['product_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('full-width');
        });
    </script>
</body>

</html>