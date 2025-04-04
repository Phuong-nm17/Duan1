<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Lấy thông tin đơn hàng mới nhất
$order_sql = "SELECT o.*, p.title AS product_name, p.price AS unit_price 
              FROM orders o
              JOIN product p ON o.product_id = p.id
              WHERE o.user_id = :user_id
              ORDER BY o.order_date DESC
              LIMIT 5"; // Giới hạn 5 sản phẩm gần nhất

try {
    $stmt = $conn->prepare($order_sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($order_items)) {
        header("Location: index.php");
        exit();
    }
    
    // Tính tổng tiền
    $total = 0;
    foreach ($order_items as $item) {
        $total += $item['total_money'];
    }
    
} catch (Exception $e) {
    die("Lỗi khi lấy thông tin đơn hàng: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .confirmation-card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card confirmation-card mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">Đặt hàng thành công!</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h4 class="alert-heading">Cảm ơn bạn đã đặt hàng!</h4>
                            <p>Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                            <hr>
                            <p class="mb-0">Mã đơn hàng: #<?= $order_items[0]['id'] ?></p>
                        </div>
                        
                        <h5 class="mb-3">Chi tiết đơn hàng</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $item['thumbnail'] ?? 'img/default-product.jpg' ?>" 
                                                     alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                                     class="product-img me-3">
                                                <span><?= htmlspecialchars($item['product_name']) ?></span>
                                            </div>
                                        </td>
                                        <td>$<?= number_format($item['unit_price'], 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>$<?= number_format($item['total_money'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Tổng cộng:</th>
                                        <th>$<?= number_format($total, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
                            <a href="user_orders.php" class="btn btn-outline-secondary">Xem đơn hàng</a>
                        </div>
                    </div>
                </div>
                
                <div class="card confirmation-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ tên:</strong> Nguyễn Văn A</p>
                                <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận 1, TP.HCM</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Số điện thoại:</strong> 0901234567</p>
                                <p><strong>Email:</strong> customer@example.com</p>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Đơn hàng sẽ được giao trong vòng 2-3 ngày làm việc.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>