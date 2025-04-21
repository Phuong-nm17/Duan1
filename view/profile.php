<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__ . '/../model/connect.php');

// Lấy thông tin user từ DB
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();
$updateSuccess = false;
// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    // Upload avatar nếu có
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['avatar']['tmp_name'];
        $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
        $destination = __DIR__ . '/../uploads/avatar/' . $fileName;

        // Tạo thư mục nếu chưa có
        if (!is_dir(__DIR__ . '/../uploads/avatar')) {
            mkdir(__DIR__ . '/../uploads/avatar', 0755, true);
        }

        move_uploaded_file($fileTmp, $destination);

        // Cập nhật avatar
        $stmt = $conn->prepare("UPDATE user SET avatar = ? WHERE id = ?");
        $stmt->execute([$fileName, $_SESSION['id']]);
    }

    // Cập nhật thông tin khác
    $stmt = $conn->prepare("UPDATE user SET fullname = ?, phone_number = ?, address = ? WHERE id = ?");
    $stmt->execute([$fullname, $phone_number, $address, $_SESSION['id']]);
    header("Location: index.php?act=profile&success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hồ sơ người dùng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="view/img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="view/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="view/css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            padding: 30px 60px;
            gap: 40px;
        }

        .sidebar {
            width: 220px;
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            color: #333;
            cursor: pointer;
        }

        .profile-form {
            flex: 1;
            background-color: white;
            border-radius: 6px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .profile-form h2 {
            font-size: 20px;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .gender-options input {
            margin-right: 6px;
        }

        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-left: 1px solid #eee;
            padding-left: 30px;
        }

        .avatar-section img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .choose-img {
            border: 1px solid #ccc;
            background: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-bottom {
            display: flex;
            justify-content: flex-start;
            margin-top: 30px;
        }

        .btn-save {
            background-color: #ee4d2d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
        }

        .row {
            display: flex;
            gap: 20px;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center px-xl-5 py-3">
            <div class="col-lg-3 d-lg-block d-none">
                <a href="index.php?act=home" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold text-primary font-weight-bold px-3 mr-1">
                        Farah
                    </h1>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="text-uppercase font-weight-semi-bold mb-2">Profile</h1>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container">
        <div class="sidebar">
            <h3>My Account</h3>
            <ul>
                <li>Profile</li>
                <li><a href="index.php?act=change_password" style="color: inherit; text-decoration: none;">Change Password</a></li>
                <li><a href="index.php?act=orders" style="color: inherit; text-decoration: none;">Orders</a></li>
            </ul>
        </div>

        <div class="profile-form">
            <h2>My Profile</h2>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div id="success-message" style="background: #e6ffed; color: #2f855a; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    ✅ Thông tin đã được cập nhật thành công!
                </div>
                <script>
                    const url = new URL(window.location.href);
                    url.searchParams.delete('success');
                    window.history.replaceState({}, document.title, url);
                </script>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div style="flex: 2;">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Fullname</label>
                            <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                        </div>
                        <div class="form-bottom">
                            <button type="submit" class="btn-save">Save</button>
                        </div>
                    </div>
                    <div class="avatar-section">
                        <img src="<?= isset($user['avatar']) ? '../uploads/avatar/' . $user['avatar'] : 'https://via.placeholder.com/100' ?>" alt="Avatar">
                        <label class="choose-img">
                            Choose Image
                            <input type="file" name="avatar" hidden>
                        </label>
                        <small>Max size: 1MB<br>Formats: .JPEG, .PNG</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="view/lib/easing/easing.min.js"></script>
    <script src="view/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="view/mail/jqBootstrapValidation.min.js"></script>
    <script src="view/mail/contact.js"></script>
    <script src="view/js/main.js"></script>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('success-message');
            if (msg) {
                msg.style.display = 'none';
            }
        }, 1000); // 1000ms = 1s
    </script>

</body>

</html>