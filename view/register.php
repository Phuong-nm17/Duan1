<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $default_avatar = 'default.png'; // Avatar mặc định

    if (empty($fullname) || empty($email) || empty($address) || empty($phone_number) || empty($password) || empty($confirm)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } elseif ($password !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO user (fullname, email, address, phone_number, password, avatar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$fullname, $email, $address, $phone_number, $hashed_password, $default_avatar]);

        header("Location: index.php?act=login");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Thời trang Farah</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="view/img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="view/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="view/css/style.css" rel="stylesheet">

    <style>
        .btn-google {
            background-color: white;
            color: #db4437;
            border: 1px solid #db4437;
        }

        .btn-facebook {
            background-color: white;
            color: #1877f2;
            border: 1px solid #1877f2;
        }

        .form-control {
            padding: 8px 12px;
            font-size: 14px;
        }

        .conteiner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .register-form {
            width: 800px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            align-items: center;
        }

        .btn {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="font-weight-semi-bold text-uppercase mb-2">Register</h1>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container">
        <form class="register-form" method="POST" style="max-width: 500px; margin: 0 auto; padding: 30px;">
            <h3 class="text-center mb-4">Register</h3>

            <div class="mb-3">
                <label for="fullname" class="form-label">Fullname</label>
                <input type="text" class="form-control" name="fullname" placeholder="Enter your fullname" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" placeholder="Enter your address" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phone_number" placeholder="Enter your phone number" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
            </div>

            <div class="mb-3">
                <label for="confirm" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm" placeholder="Confirm your password" required>
            </div>

            <?php if (!empty($error)) : ?>
                <div class="text-danger mb-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>

            <div class="text-center mt-3">
                Already have an account? <a href="index.php?act=login">Login</a>
            </div>
        </form>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="view/lib/easing/easing.min.js"></script>
    <script src="view/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="view/mail/jqBootstrapValidation.min.js"></script>
    <script src="view/mail/contact.js"></script>
    <script src="view/js/main.js"></script>
</body>
</html>