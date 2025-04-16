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
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-wrapper {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

            width: 100%;
            max-width: 400px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;

            font-weight: 600;
            font-size: 18px;

        }

        .message {
            margin-bottom: 15px;
            padding: 12px;

            border-radius: 8px;
            font-weight: 500;
            text-align: center;
            font-size: 14px;
        }

        .message.success {
            background-color: #e6f9f0;
            color: #27ae60;
            border: 1px solid #b2e2cd;
        }

        .message.error {
            background-color: #ffe6e6;
            color: #c0392b;
            border: 1px solid #f5b5b5;

        }

        label {
            display: block;

            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 14px;

        }

        input[type="password"] {
            width: 100%;

            padding: 12px 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="password"]:focus {
            border-color: #ee4d2d;
            outline: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 12px;
            background: #ee4d2d;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #d63a21;
        }

        .login-link {
            display: block;
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            color: #555;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #ee4d2d;

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
        <?php endif; ?>


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