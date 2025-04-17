<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin']))
    header("Location: login.php");

try {
    $sql = "SELECT 
                pv.id AS variant_id,
                p.title,
                p.description,
                p.thumbnail,
                pv.price,
                pv.discount,
                pv.stock,
                pv.sku,
                size.name AS size_name,
                color.name AS color_name,
                category.name AS category_name
            FROM product_variants pv
            JOIN product p ON pv.product_id = p.id
            JOIN size ON pv.size_id = size.id
            JOIN color ON pv.color_id = color.id
            JOIN category ON p.category_id = category.id
            WHERE 1=1";

    $params = [];

    if (!empty($_GET['min_price'])) {
        $sql .= " AND pv.price >= ?";
        $params[] = $_GET['min_price'];
    }

    if (!empty($_GET['max_price'])) {
        $sql .= " AND pv.price <= ?";
        $params[] = $_GET['max_price'];
    }

    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] === 'asc') {
            $sql .= " ORDER BY pv.price ASC";
        } elseif ($_GET['sort'] === 'desc') {
            $sql .= " ORDER BY pv.price DESC";
        }
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { display: flex; }
        #sidebar {
            width: 250px; height: 100vh; background-color: #343a40; color: white;
            padding: 20px; position: fixed; transition: width 0.3s; overflow: hidden;
        }
        #sidebar.collapsed { width: 80px; }
        #sidebar h4 { transition: opacity 0.3s; }
        #sidebar.collapsed h4 { opacity: 0; }
        #sidebar a {
            color: white; display: flex; align-items: center;
            padding: 10px; text-decoration: none; border-radius: 5px;
            white-space: nowrap; transition: background 0.3s;
        }
        #sidebar a:hover { background-color: #495057; }
        .submenu {
            display: none; background: #495057; padding-left: 20px;
        }
        .menu-item:hover .submenu { display: block; }
        #sidebar.collapsed .submenu {
            display: none; position: absolute; left: 80px; top: 0;
            background: #495057; padding: 10px; min-width: 150px;
            border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        #sidebar.collapsed .menu-item:hover .submenu { display: block; }
        #toggle-btn {
            position: absolute; top: 10px; right: 10px;
            background: transparent; border: none; color: white;
            font-size: 20px; cursor: pointer;
        }
        #content {
            margin-left: 260px; width: 100%; padding: 20px;
            transition: margin-left 0.3s;
        }
        #content.full-width { margin-left: 90px; }
    </style>
</head>
<body>
    <?php include '../sidebar.php'; ?>

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
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Giảm giá</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả</th>
                    <th>SKU</th>
                    <th>Màu sắc</th>
                    <th>Size</th>
                    <th>Danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($p['title']) ?></td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?> $</td>
                        <td><?= number_format($p['discount'], 0, ',', '.') ?> $</td>
                        <td><img src="<?= htmlspecialchars($p['thumbnail']) ?>" width="50"></td>
                        <td><?= htmlspecialchars($p['description']) ?></td>
                        <td><?= htmlspecialchars($p['sku']) ?></td>
                        <td><?= htmlspecialchars($p['color_name']) ?></td>
                        <td><?= htmlspecialchars($p['size_name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td class="text-center">
                            <a href="edit_product.php?id=<?= $p['variant_id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="delete_product.php?id=<?= $p['variant_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</a>
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
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('full-width');
            });
        }
    </script>
</body>
</html>
