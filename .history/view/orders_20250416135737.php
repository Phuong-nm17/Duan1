<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__ . '/../model/connect.php');

// Truy vấn dữ liệu từ bảng orders và order_details
$stmt = $conn->prepare("
    SELECT 
        o.id AS order_id, 
        o.created_at, 
        o.status, 
        o.order_date,
        o.fullname, 
        o.email, 
        o.address,
        o.payment_method, 
        o.phone, 
        od.product_id, 
        od.quantity, 
        od.price,
        od.color_id, 
        od.size_id, 
        p.title AS product_name,
        p.thumbnail AS product_thumbnail,
        c.name AS color,
        s.name AS size
    FROM orders o
    JOIN order_details od ON o.id = od.order_id
    JOIN product p ON od.product_id = p.id
    JOIN color c ON od.color_id = c.id
    JOIN size s ON od.size_id = s.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");

$stmt->execute([$_SESSION['id']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$orders = [];
foreach ($rows as $row) {
    $id = $row['order_id'];
    if (!isset($orders[$id])) {
        $orders[$id] = [
            'created_at' => $row['created_at'],
            'status' => $row['status'],
            'order_date' => $row['order_date'],
            'fullname' => $row['fullname'],
            'email' => $row['email'],
            'address' => $row['address'],
            'payment_method' => $row['payment_method'],
            'phone' => $row['phone'],
            'items' => []
        ];
    }
    $orders[$id]['items'][] = [
        'product_name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'product_thumbnail' => $row['product_thumbnail'],
        'color' => $row['color'],
        'size' => $row['size'],
        'address' => $row['address'],
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? 0;

    // Kiểm tra quyền sở hữu đơn hàng
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->execute([$order_id, $_SESSION['id']]);
    $order = $stmt->fetch();

    if ($order && $order['status'] !== 'đã hủy' && $order['status'] !== 'Hoàn thành') {
        // Cập nhật trạng thái đơn hàng thành "đã hủy"
        $update_stmt = $conn->prepare("UPDATE orders SET status = 'đã hủy' WHERE id = ?");
        $update_stmt->execute([$order_id]);

        // Chuyển hướng về trang orders
        header("Location: index.php?act=orders");
        exit();
    } else {
        // Nếu không hợp lệ, hiển thị thông báo lỗi
        echo "<script>alert('Không thể hủy đơn hàng này.'); window.location.href='index.php?act=orders';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Orders - EShopper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="view/css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .order-block {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .order-header {
            background-color: #f8f8f8;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #555;
            border-bottom: 1px solid #eaeaea;
        }

        .order-header strong {
            color: #333;
        }

        .order-content {
            padding: 20px;
        }

        .order-content table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-content table th,
        .order-content table td {
            padding: 12px;
            text-align: left;
            font-size: 0.9rem;
            border-bottom: 1px solid #eaeaea;
        }

        .order-content table th {
            background-color: #f8f8f8;
            color: #333;
        }

        .order-content table td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .order-content table tr:last-child td {
            border-bottom: none;
        }

        .order-footer {
            padding: 10px 20px;
            background-color: #f8f8f8;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-top: 1px solid #eaeaea;
        }

        .order-footer span {
            font-size: 1rem;
            color: #333;
            font-weight: bold;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #ff5722;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            text-align: center;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background: #e64a19;
        }

        .no-orders {
            text-align: center;
            color: #999;
            font-size: 1rem;
            margin-top: 20px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center px-xl-5 py-3">
            <div class="col-lg-3 d-lg-block d-none">
                <a href="index.php?act=home" class="text-decoration-none">
                    <h1 class="display-5 m-0 font-weight-semi-bold"><span class="border text-primary font-weight-bold mr-1 px-3">E</span>Shopper</h1>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="text-uppercase font-weight-semi-bold mb-2">Order</h1>
        </div>
    </div>
    <!-- Page Header End -->
<div class="container">
    <h1>Your Orders</h1>
    <?php if (count($orders) > 0): ?>
        <?php foreach ($orders as $id => $order): ?>
            <div class="order-header">
                    <span><strong>Order ID:</strong> #<?= htmlspecialchars($id) ?></span>
                    <span><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></span>
                    <span><strong>Status:</strong>
                        <?php
                        switch ($order['status']) {
                            case 'chờ xác nhận':
                                echo '<span style="color: purple;">Awaiting Confirmation</span>';
                                break;
                            case 'chờ xử lý':
                                echo '<span style="color: orange;">Pending</span>';
                                break;
                            case 'đang giao':
                                echo '<span style="color: green;">In Transit</span>';
                                break;
                            case 'Hoàn thành':
                                echo '<span style="color: blue;">Completed</span>';
                                break;
                            case 'đã hủy':
                                echo '<span style="color: red;">Cancelled</span>';
                                break;
                            default:
                                echo '<span style="color: gray;">Unknown</span>';
                        }
                        ?>
                    </span>
                    <span><strong>Payment:</strong> <?= htmlspecialchars($order['payment_method']) ?></span>

                    <?php if ($order['status'] !== 'đã hủy' && $order['status'] !== 'Hoàn thành'): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($id) ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                        </form>
                    <?php endif; ?>
                </div>
            <div class="order-block">
            <div class="order-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Address</th>
                                <th>Attributes</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <img src="<?= htmlspecialchars($item['product_thumbnail'] ?? 'https://via.placeholder.com/50') ?>"
                                            alt="<?= htmlspecialchars($item['product_name'] ?? 'No Image') ?>">
                                    </td>
                                    <td><?= htmlspecialchars($item['product_name'] ?? 'Unknown Product') ?></td>
                                    <td><?= htmlspecialchars($order['address'] ?? 'Address not specified') ?></td>
                                    <td><?= htmlspecialchars($item['color'] ?? 'N/A') ?>, <?= htmlspecialchars($item['size'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($item['quantity'] ?? 0) ?></td>
                                    <td>$<?= number_format(($item['quantity'] ?? 0) * ($item['price'] ?? 0), 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="order-footer">
                    <span>Total: $<?= number_format(array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $order['items'])), 2) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-orders">You have no orders yet.</p>
    <?php endif; ?>
    <a href="index.php?act=profile" class="btn-back">⬅ Back to Profile</a>
</div> <!-- Đóng container ở đây, sau khi tất cả đơn hàng đã được hiển thị -->
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="view/lib/easing/easing.min.js"></script>
<script src="view/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="view/mail/jqBootstrapValidation.min.js"></script>
<script src="view/mail/contact.js"></script>

<!-- Template Javascript -->
<script src="view/js/main.js"></script>
</body>

</html>