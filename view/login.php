<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header("Location: index.php?act=home");
                exit();
            } else {
                $error = "Sai mật khẩu!";
            }
        } else {
            $error = "Email không tồn tại!";
        }
    } catch (PDOException $e) {
        die("Lỗi kết nối: " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Thời trang Farah</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="view/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="view/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
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
            height: 40vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .login-form {
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
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center px-xl-5 py-3">
            <div class="col-lg-3 d-lg-block d-none">
                <a href="index.php?act=home" class="text-decoration-none">
                    <h1 class="display-5 m-0 font-weight-semi-bold"><span
                            class="border text-primary font-weight-bold mr-1 px-3">E</span>Shopper</h1>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="text-uppercase font-weight-semi-bold mb-2">Login</h1>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="conteiner">
        <form method="POST" class="center login-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php if (!empty($error)) : ?>
                <div class="text-danger mb-3"><?php echo $error; ?></div>
            <?php endif; ?>

            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <div class="text-center mt-3">
                <p>Do you have account? <a href="index.php?act=register">SignUp</a></p>
            </div>
        </form>
    </div>
    <div class="text-center mt-4">
        <p>Or login with:</p>
        <a class="text-dark px-2" href="" class="btn btn-google">
            <i class="fa-google fab"></i>
        </a>
        <a class="text-dark px-2" href="" class="btn btn-facebook">
            <i class="fa-facebook fab"></i>
        </a>
        <a class="text-dark px-2" href="" class="btn btn-twitter">
            <i class="fa-twitter fab"></i>
        </a>
    </div>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="view/lib/easing/easing.min.js"></script>
    <script src="view/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="view/mail/jqBootstrapValidation.min.js"></script>
    <script src="view/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="view/js/main.js"></script>
</body>

</html>