<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once(__DIR__ . '/../model/connect.php');
require_once(__DIR__ . '/../model/PHPMailer/src/PHPMailer.php');
require_once(__DIR__ . '/../model/PHPMailer/src/SMTP.php');
require_once(__DIR__ . '/../model/PHPMailer/src/Exception.php');
require_once(__DIR__ . '/mail_config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";
$redirect = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(16));
            $resetLink = "http://duan1.test/index.php?act=reset_password&token=$token";

            $expires = date("Y-m-d H:i:s", strtotime('+15 minutes'));
            $updateStmt = $conn->prepare("UPDATE user SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
            $updateStmt->execute([$token, $expires, $email]);


            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username = 'linhnp992004@gmail.com';
                $mail->Password = 'wmvd lvel fkgl lcqk';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('linhnp992004@gmail.com', 'EShopper Support');
                $mail->addAddress($email, $user['name'] ?? 'User');

                $mail->isHTML(true);
                $mail->Subject = 'Reset Your Password - EShopper';
                $mail->Body = "
    <div style='font-family: Arial, sans-serif; padding: 20px;'>
        <h2 style='color: #007bff;'>Xin chào,</h2>
        <p>Bạn đã yêu cầu <strong>đặt lại mật khẩu</strong> cho tài khoản EShopper.</p>
        <p>Nhấn vào nút bên dưới để tiếp tục:</p>
        <p>
            <a href='$resetLink' style='display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>
                Đặt lại mật khẩu
            </a>
        </p>
        <p>Nếu không nhấn được nút, hãy sao chép và dán đường dẫn sau vào trình duyệt:</p>
        <p><a href='$resetLink'>$resetLink</a></p>
        <hr>
        <p style='font-size: 12px; color: #888;'>Nếu bạn không yêu cầu, hãy bỏ qua email này.</p>
    </div>
";

                $mail->send();
                $message = "✅ Đường dẫn đặt lại mật khẩu đã được gửi tới email của bạn. Vui lòng kiểm tra hộp thư.";
                $redirect = true;
            } catch (Exception $e) {
                $message = "❌ Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
            }
        } else {
            $message = "⚠️ Email không tồn tại trong hệ thống!";
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

    <?php if ($redirect): ?>
        <meta http-equiv="refresh" content="5;url=index.php?act=login">
    <?php endif; ?>

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