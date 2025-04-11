<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__ . '/../model/connect.php');

$message = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = $conn->prepare("SELECT password FROM user WHERE id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current, $user['password'])) {
        $message = 'Mật khẩu hiện tại không đúng.';
    } elseif ($new !== $confirm) {
        $message = 'Mật khẩu mới và xác nhận không khớp.';
    } elseif (strlen($new) < 6) {
        $message = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $_SESSION['id']]);
        $message = 'Đổi mật khẩu thành công!';
        $success = true;
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: linear-gradient(to right, #f9f9f9, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 460px;
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 24px;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #444;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        input[type="password"]:focus {
            border-color: #ee4d2d;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: #ee4d2d;
            border: none;
            color: white;
            font-size: 15px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #d63a21;
        }

        .message {
            margin-bottom: 18px;
            padding: 12px;
            text-align: center;
            font-size: 14px;
            border-radius: 6px;
        }

        .success {
            background-color: #e6f9f0;
            color: #27ae60;
            border: 1px solid #b2e2cd;
        }

        .error {
            background-color: #ffe6e6;
            color: #c0392b;
            border: 1px solid #f5b5b5;
        }

        .back-link {
            display: inline-block;
            margin-top: 18px;
            font-size: 14px;
            color: #777;
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #ee4d2d;
        }
    </style>
</head>

<body>

    <!-- phần PHP thông báo thành công -->
    <?php if ($success): ?>
        <script>
            setTimeout(() => {
                window.location.href = 'index.php?act=profile';
            }, 2000);
        </script>
    <?php endif; ?>

    <div class="container">
        <h2>Đổi mật khẩu</h2>

        <?php if ($message): ?>
            <div class="message <?= $success ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="current_password">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button class="btn" type="submit">Cập nhật mật khẩu</button>
        </form>

        <a href="index.php?act=profile" class="back-link">← Quay lại hồ sơ</a>
    </div>
</body>

</html>