<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("Sản phẩm không tồn tại!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    if (!empty($fullname) && $email > 0) {
        // if ($image['size'] > 0) {
        // $imageName = time() . '_' . $image['name'];
        // move_uploaded_file($image['tmp_name'], "assets/images/" . $imageName);
        $stmt = $conn->prepare("UPDATE user SET fullname=?, email=?,phone_number=?, address=? WHERE id=?");
        $stmt->execute([$fullname, $email, $phone_number, $address, $id]);
        // } else {
        // $stmt = $conn->prepare("UPDATE products SET title=?, price=? WHERE id=?");
        // $stmt->execute([$title, $price, $id]);
        // }
        header("Location: user_management.php");
        exit;
    } else {
        $error = "Vui lòng nhập đầy đủ tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>sửa Sản phẩm</title>
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
        <h2>Chỉnh sửa thông tin khách hàng</h2>
        <form method="POST" enctype="multipart/form-data" class="mt-3">
            <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <div class="mb-3">
                <label>Họ và tên:</label>
                <input type="text" name="fullname" class="form-control" value="<?= $user['fullname'] ?>" required>
            </div>
            <div class="mb-3">
                <label>email:</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Số điện thoại:</label>
                <input type="number" name="phone_number" class="form-control" value="<?= $user['phone_number'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Địa chỉ:</label>
                <input type="text" name="address" class="form-control" value="<?= $user['address'] ?>" required>
            </div>
            <button type="submit" class="btn btn-success">chỉnh sửa</button>
        </form>
    </div>
</body>

</html>