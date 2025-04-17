<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$categorys = $conn->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $thumbnail = htmlspecialchars($_POST['thumbnail']);
    $description = htmlspecialchars($_POST['description']);
    $category_id = $_POST['category_id'];
    $discount = $price * 0.7; // Apply discount to the product price

    if (!empty($title) && $price > 0 && !empty($thumbnail)) {
        // Insert the product with both discounted price and original price
    $stmt = $conn->prepare("INSERT INTO product (title, discount, price, thumbnail, description, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $discount, $price, $thumbnail, $description, $category_id]); // Store discounted price and original price
        $productId = $conn->lastInsertId(); // Get the ID of the newly added product

        // Create variants
        $color_price_modifiers = [
            1 => 0, 2 => 3, 3 => 5, 4 => 7, 5 => 2
        ];
        $size_price_modifiers = [
            6 => 0, 7 => 2, 8 => 4, 9 => 7
        ];

        // Loop through color and size modifiers to create product variants
        foreach ($color_price_modifiers as $colorId => $colorMod) {
            foreach ($size_price_modifiers as $sizeId => $sizeMod) {
                $sku = "P{$productId}-C{$colorId}-S{$sizeId}";
                $stock = 10;
                $finalPrice = $price + $colorMod * 1 + $sizeMod * 1;

                // Prepare the insert statement for product variants
                $stmtVar = $conn->prepare("INSERT INTO product_variants (product_id, color_id, size_id, sku, stock, price) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtVar->execute([$productId, $colorId, $sizeId, $sku, $stock, $finalPrice]);
            }
        }
        
        header("Location: product.php");
        exit;
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin và tải lên hình ảnh!";
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