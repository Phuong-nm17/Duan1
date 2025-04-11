<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

date_default_timezone_set('Asia/Ho_Chi_Minh');

$token = $_GET['token'] ?? '';
$message = "";
$validToken = false;

// Kiểm tra token từ link email (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($token) {
        $stmt = $conn->prepare("SELECT id FROM user WHERE reset_token = ? AND reset_token_expires > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        if ($user) {
            $validToken = true;
        } else {
            $message = "❌ Token không hợp lệ hoặc đã hết hạn.";
        }
    } else {
        $message = "❌ Liên kết không hợp lệ.";
    }
}

// Khi người dùng submit form cập nhật mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $message = "⚠️ Mật khẩu xác nhận không khớp!";
    } elseif (strlen($password) < 6) {
        $message = "⚠️ Mật khẩu phải có ít nhất 6 ký tự!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM user WHERE reset_token = ? AND reset_token_expires > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
            $update->execute([$hashed, $user['id']]);
            $message = "✅ Mật khẩu đã được thay đổi thành công!";
        } else {
            $message = "❌ Token không hợp lệ hoặc đã hết hạn.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #d7e1ec, #f0f4f8);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-wrapper {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 6px;
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
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button,
        .login-link {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
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

        <?php if ($message): ?>
            <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (($validToken || $_SERVER['REQUEST_METHOD'] === 'POST') && strpos($message, '✅') === false): ?>
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
        <?php elseif (strpos($message, '✅') !== false): ?>
            <a class="login-link" href="index.php?act=login">➡️ Return to login</a>
        <?php endif; ?>
    </form>
</body>

</html>