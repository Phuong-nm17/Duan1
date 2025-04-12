<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$token = $_GET['token'] ?? '';
$message = "";
$redirect = false;
$validToken = false;
$showForm = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $message = "⚠️ Mật khẩu xác nhận không khớp!";
    } elseif (strlen($password) < 6) {
        $message = "⚠️ Mật khẩu phải có ít nhất 6 ký tự!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE reset_token = ?");
        $update->execute([$hashed, $token]);

        $message = "✅ Mật khẩu đã được thay đổi thành công!";
        $redirect = true;
        $showForm = false;
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <?php if (!empty($redirect)): ?>
        <meta http-equiv="refresh" content="3;url=index.php?act=login">
    <?php endif; ?>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-wrapper {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .message {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
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

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button,
        .login-link {
            display: block;
            width: 100%;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        button:hover,
        .login-link:hover {
            background-color: #0056b3;
        }

        .login-link {
            margin-top: 10px;
            background-color: #28a745;
        }

        .login-link:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <form class="form-wrapper" method="POST">
        <h3>Reset password</h3>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?> -->

        <?php if ($showForm): ?>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div>
                <label>New password:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>Re-enter the password:</label>
                <input type="password" name="confirm" required>
            </div>
            <button type="submit">Update password</button>
        <?php endif; ?>
    </form>
</body>

</html>