<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Lấy thông tin đơn hàng mới nhất
$order_sql = "SELECT o.*, 
                     p.title AS product_name, 
                     p.price AS unit_price, 
                     p.thumbnail, 
                     o.quanity 
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
        $total += $item['unit_price'] * $item['quanity'];
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
    <link href="view/css/style.css" rel="stylesheet">
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
        .table-bordered {
            border: 2px solid #dee2e6;
        }
        .bg-secondary {
            background-color: #f8f9fa !important;
        }
        .text-dark {
            color: #343a40 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Bảng chi tiết đơn hàng -->
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td class="align-middle">
                                    <img src="<?= htmlspecialchars($item['thumbnail'] ?? 'img/default-product.jpg') ?>" 
                                         alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                         style="width: 50px;">
                                </td>
                                <td class="align-middle"><?= htmlspecialchars($item['product_name']) ?></td>
                                <td class="align-middle">$<?= number_format($item['unit_price'], 2) ?></td>
                                <td class="align-middle"><?= htmlspecialchars($item['quanity']) ?></td>
                                <td class="align-middle">$<?= number_format($item['unit_price'] * $item['quanity'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tóm tắt đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tạm tính</h6>
                            <h6 class="font-weight-medium">$<?= number_format($total, 2) ?></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí vận chuyển</h6>
                            <h6 class="font-weight-medium">$10.00</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng cộng</h5>
                            <h5 class="font-weight-bold">$<?= number_format($total + 10, 2) ?></h5>
                        </div>
                        <a href="index.php" class="btn btn-block btn-primary my-3 py-3">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>