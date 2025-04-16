<?php
session_start();

require_once(__DIR__ . '/../model/connect.php');


$message = "";
$redirect = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {

            // Tạo token và lưu vào DB
            $token = bin2hex(random_bytes(16));
            $expires = date("Y-m-d H:i:s", strtotime('+15 minutes'));

            $updateStmt = $conn->prepare("UPDATE user SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
            $updateStmt->execute([$token, $expires, $email]);

            $message = "✅ Đã gửi liên kết đặt lại mật khẩu. Đang chuyển hướng...";
            $redirect = true;
        } else {
            $message = "❌ Email không tồn tại trong hệ thống.";
        }
    } catch (PDOException $e) {
        $message = "⚠️ Lỗi hệ thống: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="vi">


<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu - EShopper</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if ($redirect): ?>
        <meta http-equiv="refresh" content="3;url=index.php?act=reset_password&token=<?= urlencode($token) ?>">
    <?php endif; ?>

    <!-- CSS -->

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


        .message {
            text-align: center;
            font-weight: 500;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 6px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;

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
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="text-uppercase font-weight-semi-bold mb-2">Forgot Password</h1>
        </div>
    </div>

    <div class="container">
        <form method="POST" class="form-wrapper">
            <h4 class="text-center mb-4">Enter email to reset password</h4>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>

                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <?php if (!empty($message)): ?>

                <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary w-100">Gửi yêu cầu</button>

            <div class="text-center mt-3">
                <a href="index.php?act=login">⬅️ Back to login</a>
            </div>
        </form>
    </div>

</body>

</html>