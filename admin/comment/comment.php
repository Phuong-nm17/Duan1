<?php
session_start();
require '../../model/connect.php';
if (!isset($_SESSION['admin']))
    header("Location: login.php");

$stmt = $conn->prepare("SELECT c.id, c.content, c.created_at, u.fullname AS user_name, p.title AS product_name FROM comments c JOIN user u ON c.user_id = u.id JOIN product p ON c.product_id = p.id ORDER BY c.created_at DESC");
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Bình luận</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="view/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #007bff !important;
            color: white;
            border-radius: 12px 12px 0 0;
            font-weight: bold;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .section-title {
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 24px;
            color: #2c3e50;
        }

        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
            transition: width 0.3s ease-in-out;
            overflow: hidden;
        }

        #sidebar.collapsed {
            width: 80px;
        }

        #sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }

        #sidebar a i {
            margin-right: 10px;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        .submenu {
            display: none;
            background: #495057;
            padding-left: 20px;
        }

        .menu-item:hover .submenu {
            display: block;
        }

        #sidebar.collapsed .submenu {
            display: none;
            position: absolute;
            left: 80px;
            top: 0;
            background: #495057;
            padding: 10px;
            min-width: 150px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        #sidebar.collapsed .menu-item:hover .submenu {
            display: block;
        }

        #main-content {
            margin-left: 250px;
            /* độ rộng sidebar */
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php include '../sidebar.php'; ?>
    <div id="main-content">
        <div class="container pt-5 ml-3">
            <h2 class="section-title">Quản lý Bình luận</h2>
            <div class="card">
                <div class="card-header">Danh sách bình luận</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <?php if (count($comments) > 0): ?>
                            <table class="table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nội dung</th>
                                        <th>Người bình luận</th>
                                        <th>Sản phẩm</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($comment['id']) ?></td>
                                            <td><?= htmlspecialchars($comment['content']) ?></td>
                                            <td><?= htmlspecialchars($comment['user_name']) ?></td>
                                            <td><?= htmlspecialchars($comment['product_name']) ?></td>
                                            <td><?= htmlspecialchars($comment['created_at']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="p-3">Không có bình luận nào.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>