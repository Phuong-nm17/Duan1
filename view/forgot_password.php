<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expires = date("Y-m-d H:i:s", strtotime('+15 minutes'));

            $updateStmt = $conn->prepare("UPDATE user SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
            $updateStmt->execute([$token, $expires, $email]);

            header("Location: index.php?act=reset_password&token=$token");
            exit;
        } else {
            $message = "Không tìm thấy email trong hệ thống.";
        }
    } catch (PDOException $e) {
        die("Lỗi kết nối CSDL: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu - EShopper</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Styles -->
    <link href="view/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <style>
        .form-wrapper {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .text-danger,
        .text-success {
            text-align: center;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center px-xl-5 py-3">
            <div class="col-lg-3 d-lg-block d-none">
                <a href="index.php" class="text-decoration-none">
                    <h1 class="display-5 m-0 font-weight-semi-bold"><span class="border text-primary font-weight-bold mr-1 px-3">E</span>Shopper</h1>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Header -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="text-uppercase font-weight-semi-bold mb-2">Quên mật khẩu</h1>
        </div>
    </div>

    <!-- Form -->
    <div class="container">
        <form method="POST" class="form-wrapper">
            <h4 class="text-center mb-4">Nhập email để lấy lại mật khẩu</h4>

            <div class="mb-3">
                <label for="email" class="form-label">Email của bạn</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <?php if (!empty($message)): ?>
                <div class="<?php echo strpos($message, 'Đường dẫn') !== false ? 'text-success' : 'text-danger'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Gửi yêu cầu</button>

            <div class="text-center mt-3">
                <a href="index.php?act=login">Quay lại đăng nhập</a>
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
</body>

</html>