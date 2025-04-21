<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin']))
    header("Location: login.php");

try {
    $sql = "SELECT 
    p.id AS product_id,
    p.title,
    p.price,
    p.thumbnail,
    p.description,
    p.discount,
    cat.name AS category_name
FROM product p
JOIN category cat ON p.category_id = cat.id
WHERE 1=1";

    $params = [];

    if (!empty($_GET['min_price'])) {
        $sql .= " AND p.price >= ?";
        $params[] = $_GET['min_price'];
    }

    if (!empty($_GET['max_price'])) {
        $sql .= " AND p.price <= ?";
        $params[] = $_GET['max_price'];
    }
    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] === 'asc') {
            $sql .= " ORDER BY p.price ASC";
        } elseif ($_GET['sort'] === 'desc') {
            $sql .= " ORDER BY p.price DESC";
        }
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin'])) header("Location: login.php");

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
    <?php include '../sidebar.php'; ?>


    <!-- Nội dung chính -->
    <div id="content">
        <h2>Danh sách sản phẩm</h2>
        <form method="get" class="row g-3 mb-4">
            <div class="col-auto">
                <label for="min_price" class="form-label">Giá từ:</label>
                <input type="number" class="form-control" name="min_price" id="min_price"
                    value="<?= $_GET['min_price'] ?? '' ?>" placeholder="0$">
            </div>
            <div class="col-auto">
                <label for="max_price" class="form-label">Đến:</label>
                <input type="number" class="form-control" name="max_price" id="max_price"
                    value="<?= $_GET['max_price'] ?? '' ?>" placeholder="10000$">
            </div>
            <div class="col-auto">
                <label for="sort" class="form-label">Sắp xếp:</label>
                <select class="form-select" name="sort" id="sort">
                    <option value="">-- Chọn --</option>
                    <option value="asc" <?= (($_GET['sort'] ?? '') === 'asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                    <option value="desc" <?= (($_GET['sort'] ?? '') === 'desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                </select>
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="product.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá bán</th>
                    <th>Giá Discount</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>category</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $p['title'] ?></td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?> $</td>
                        <td><?= number_format($p['discount'], 0, ',', '.') ?> $</td>
                        <td><img src="<?= $p['thumbnail'] ?>" width="50"></td>
                        <td><?= $p['description'] ?></td>
                        <td><?= $p['category_name'] ?></td>
                        <td class="text-center">
                            <a href="edit_product.php?id=<?= htmlspecialchars($p['product_id']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="delete_product.php?id=<?= htmlspecialchars($p['product_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</a>
                    </tr>
                <?php endforeach; ?>
                <p class="text-muted">Tổng số sản phẩm: <?= count($product) ?></p>
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