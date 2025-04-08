<?php
session_start();
require_once 'connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Lấy đơn hàng mới nhất
$order_sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($order_sql);
$stmt->execute([$user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Không tìm thấy đơn hàng.";
    exit();
}

// Lấy chi tiết sản phẩm trong đơn hàng
$details_sql = "SELECT od.*, p.name AS product_name, p.thumbnail, s.name AS size_name, c.name AS color_name 
                FROM order_details od
                JOIN product p ON od.product_id = p.id
                JOIN size s ON od.size_id = s.id
                JOIN color c ON od.color_id = c.id
                WHERE od.order_id = ?";
$stmt = $conn->prepare($details_sql);
$stmt->execute([$order['id']]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng tiền (chưa cộng phí ship)
$total = 0;
foreach ($order_items as $item) {
    $total += $item['unit_price'] * $item['quanity'];
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
                            <th>Size</th>
                            <th>Màu</th>
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
                                         class="product-img">
                                </td>
                                <td class="align-middle"><?= htmlspecialchars($item['product_name']) ?></td>
                                <td class="align-middle"><?= htmlspecialchars($item['size_name']) ?></td>
                                <td class="align-middle"><?= htmlspecialchars($item['color_name']) ?></td>
                                <td class="align-middle">$<?= number_format($item['unit_price'], 2) ?></td>
                                <td class="align-middle"><?= $item['quanity'] ?></td>
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
</body>
</html>
