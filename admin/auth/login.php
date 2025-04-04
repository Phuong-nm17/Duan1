<?php
session_start();
require '../../model/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user_admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['admin'] = $username;
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <form method="POST" class="p-4 border rounded">
        <h2 class="mb-3">Admin Login</h2>
        <?php if (!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</body>

</html>