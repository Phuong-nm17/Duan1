<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT pv.*, p.title, p.thumbnail, p.description, p.category_id, p.price 
                        FROM product_variants pv 
                        JOIN product p ON pv.product_id = p.id 
                        WHERE pv.id = ?");
$stmt->execute([$id]);
$product_variant = $stmt->fetch();

if (!$product_variant) {
    die("Biến thể sản phẩm không tồn tại!");
}

$categories = $conn->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);
// Lấy thông tin các màu sắc và kích thước từ cơ sở dữ liệu
$colors = $conn->query("SELECT * FROM color")->fetchAll(PDO::FETCH_ASSOC);
$sizes = $conn->query("SELECT * FROM size")->fetchAll(PDO::FETCH_ASSOC);

// Lấy các biến thể sản phẩm
$stmt = $conn->prepare("SELECT * FROM product_variants WHERE product_id = ?");
$stmt->execute([$product_variant['product_id']]);
$variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $thumbnail = $_POST['thumbnail'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    if ($price > 0 && !empty($title)) {
        $conn->beginTransaction();

        // Tính toán giá discount cho sản phẩm
        $discount = $price * 0.7;

        // Cập nhật thông tin sản phẩm chính
        $stmt = $conn->prepare("UPDATE product SET title=?, description=?, thumbnail=?, category_id=?, price=?, discount=? WHERE id=?");
        $stmt->execute([$title, $description, $thumbnail, $category_id, $price, $discount, $product_variant['product_id']]);

        // Lấy các biến thể của sản phẩm
        $color_price_modifiers = [
            1 => 0, 2 => 3, 3 => 5, 4 => 7, 5 => 2
        ];
        $size_price_modifiers = [
            6 => 0, 7 => 2, 8 => 4, 9 => 7
        ];

        // Lặp qua các biến thể và cập nhật giá trị
        foreach ($_POST['variant'] as $variant_id => $data) {
            $color_id = $data['color_id'];
            $size_id = $data['size_id'];
            $stock = $data['stock'];

            $colorMod = $color_price_modifiers[$color_id] ?? 0;
            $sizeMod = $size_price_modifiers[$size_id] ?? 0;

            // Tính toán lại giá biến thể
            $finalPrice = $price + $colorMod + $sizeMod;
            $stmt = $conn->prepare("UPDATE product_variants SET color_id=?, size_id=?, price=?, stock=? WHERE id=?");
            $stmt->execute([$color_id, $size_id, $finalPrice, $stock, $variant_id]);
        }

        $conn->commit();
        header("Location: product.php");
        exit;
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    }
}


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Biến thể Sản phẩm</title>
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
        <h2>Sửa Sản phẩm</h2>
        <a href="product.php" class="btn btn-secondary">Quay lại</a>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
    <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>

    <div class="mb-3">
        <label>Tên sản phẩm:</label>
        <input type="text" name="title" class="form-control" value="<?= $product_variant['title'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Mô tả sản phẩm:</label>
        <input type="text" name="description" class="form-control" value="<?= $product_variant['description'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Hình ảnh:</label>
        <input type="text" name="thumbnail" class="form-control" value="<?= $product_variant['thumbnail'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Giá:</label>
        <input type="text" name="price" class="form-control" value="<?= $product_variant['price'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Danh mục:</label>
        <select class="form-select" name="category_id" required>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $product_variant['category_id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <h3>Biến thể sản phẩm</h3>
    <?php foreach ($variants as $variant) : ?>
        <div class="variant-section">
            <h4>Biến thể #<?= $variant['id'] ?></h4>

            <input type="hidden" name="variant[<?= $variant['id'] ?>][variant_id]" value="<?= $variant['id'] ?>">

            <!-- Chọn màu -->
            <div class="mb-3">
                <label>Chọn màu:</label>
                <select class="form-select" name="variant[<?= $variant['id'] ?>][color_id]" required>
                    <?php foreach ($colors as $color) : ?>
                        <option value="<?= $color['id'] ?>" <?= $color['id'] == $variant['color_id'] ? 'selected' : '' ?>>
                            <?= $color['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Chọn kích thước -->
            <div class="mb-3">
                <label>Chọn kích thước:</label>
                <select class="form-select" name="variant[<?= $variant['id'] ?>][size_id]" required>
                    <?php foreach ($sizes as $size) : ?>
                        <option value="<?= $size['id'] ?>" <?= $size['id'] == $variant['size_id'] ? 'selected' : '' ?>>
                            <?= $size['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tồn kho -->
            <div class="mb-3">
                <label>Tồn kho:</label>
                <input type="number" name="variant[<?= $variant['id'] ?>][stock]" class="form-control" value="<?= $variant['stock'] ?>" required>
            </div>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-success">Sửa</button>
</form>
    </div>

</body>

</html>
