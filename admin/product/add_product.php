<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT pv.*, p.title, p.thumbnail, p.description, p.category_id 
                        FROM product_variants pv 
                        JOIN product p ON pv.product_id = p.id 
                        WHERE pv.id = ?");
$stmt->execute([$id]);
$product_variant = $stmt->fetch();

if (!$product_variant) {
    die("Biến thể sản phẩm không tồn tại!");
}

$colors = $conn->query("SELECT * FROM color")->fetchAll(PDO::FETCH_ASSOC);
$sizes = $conn->query("SELECT * FROM size")->fetchAll(PDO::FETCH_ASSOC);
$categories = $conn->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);

$color_price_modifiers = [
    1 => 0, 2 => 3, 3 => 5, 4 => 7, 5 => 2
];

$size_price_modifiers = [
    6 => 0, 7 => 2, 8 => 4, 9 => 7
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $thumbnail = $_POST['thumbnail'];
    $color = $_POST['color_id'];
    $size = $_POST['size_id'];
    $price = $_POST['price']; // Giá bán nhập từ người dùng
    $discount = $_POST['discount']; // Giá giảm nhập từ người dùng
    $stock = $_POST['stock'];
    $sku = $_POST['sku'];
    $category_id = $_POST['category_id'];

    // Set discount to 70% of price if discount is not provided
    if (empty($discount)) {
        $discount = $price * 0.7;
    }

    // Validate price and discount
    if ($price <= 0 || $discount < 0) {
        $error = "Vui lòng nhập giá hợp lệ và mức giảm hợp lệ!";
    } elseif (empty($sku) || empty($title)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Cập nhật thông tin bảng `product` và `product_variants`
        try {
            $conn->beginTransaction();

            // Cập nhật thông tin bảng `product`
            $stmt = $conn->prepare("UPDATE product SET title=?, description=?, thumbnail=?, category_id=? WHERE id=?");
            $stmt->execute([$title, $description, $thumbnail, $category_id, $product_variant['product_id']]);

            // Loop through color and size modifiers to create product variants
            foreach ($color_price_modifiers as $colorId => $colorMod) {
                foreach ($size_price_modifiers as $sizeId => $sizeMod) {
                    // Calculate the final price based on modifiers
                    $finalPrice = $price + $colorMod + $sizeMod;

                    // Generate SKU
                    $sku = "P{$product_variant['product_id']}-C{$colorId}-S{$sizeId}";
                    $stock = 10; // Assume a fixed stock for each variant, adjust as needed

                    // Update or insert the new variant with the calculated price
                    $stmt = $conn->prepare("UPDATE product_variants SET price=?, discount=?, stock=?, sku=?, updated_at=NOW() WHERE product_id=? AND color_id=? AND size_id=?");
                    $stmt->execute([$finalPrice, $discount, $stock, $sku, $product_variant['product_id'], $colorId, $sizeId]);
                }
            }

            $conn->commit();
            header("Location: product.php");
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            $error = "Đã có lỗi xảy ra. Vui lòng thử lại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Thêm Sản phẩm</title>
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

    <?php include '../sidebar.php'; ?>


    <div id="content">
        <h2>Thêm Sản phẩm</h2>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <div class="mb-3">
                <label>Tên sản phẩm:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Giá:</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Hình ảnh:</label>
                <input type="text" name="thumbnail" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mô tả:</label>
                <input type="text" name="description" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>thêm vào danh mục</label>
                <select class="form-select" name="category_id">
                    <?php foreach ($categorys as $c) : ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Thêm Sản Phẩm</button>
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