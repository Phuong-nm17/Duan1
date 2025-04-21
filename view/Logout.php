<?php
session_start();
session_destroy();

$redirect_url = $_SERVER['HTTP_REFERER'] ?? 'index.php'; // Nếu không có referer thì về trang chủ
header("Location: $redirect_url");
exit;
