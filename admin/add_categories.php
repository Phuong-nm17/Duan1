<?php
session_start();
require '../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (!empty($name)) {
       
        $stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)");
        $stmt->execute([$name]);

        header("Location: categories.php");
        exit;
    } else {
        $error = "Vui lòng nhập tên!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Thêm danh mục</title>
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
            left: 0;
            top: 0;
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
            margin-left: 250px;
            /* Để tránh bị sidebar che */
            width: calc(100% - 250px);
            padding: 20px;
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        #content.full-width {
            margin-left: 300px;
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
            <a href="product.php"><i>📦</i> <span>Quản lý sản phẩm</span></a>
            <div class="submenu">
                <a href="product.php">Danh sách sản phẩm</a>
                <a href="add_product.php">Thêm sản phẩm</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="categories.php"><i>📦</i> <span>Quản lý danh mục</span></a>
            <div class="submenu">
                <a href="categories.php">Danh sách danh mục</a>
                <a href="add_categories.php">Thêm danh mục</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="user_management.php"><i>👤</i> <span>Quản lý khách hàng</span></a>
            <div class="submenu">
                <a href="user_management.php">Danh sách khách hàng</a>
            </div>
        </div>

        <div class="menu-item">
            <a href="#"><i>🛒</i> <span>Quản lý đơn hàng</span></a>
            <div class="submenu">
                <a href="order_management.php">Danh sách đơn hàng</a>
                <a href="order_pending.php">Đơn hàng chờ xử lý</a>
            </div>
        </div>

        <a href="logout.php" class="text-danger"><i>🚪</i> <span>Đăng xuất</span></a>
    </div>

    <div id="content">
        <h2>Thêm danh mục </h2>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <div class="mb-3">
                <label>Tên danh mục :</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm danh mục </button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            document.getElementById('toggle-btn').addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('full-width');
            });
        });
    </script>
</body>

</html>