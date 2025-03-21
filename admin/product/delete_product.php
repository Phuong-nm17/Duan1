<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
$stmt->execute([$id]);

header("Location: product.php");
exit;
