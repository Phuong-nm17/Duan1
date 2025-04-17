<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

// Truy vấn tổng doanh thu
try {
    $sql = "
        SELECT SUM(order_details.quantity * order_details.price) AS total_revenue
        FROM orders
        JOIN order_details ON orders.id = order_details.order_id
        WHERE orders.status = 'completed'
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Lấy kết quả tổng doanh thu
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_revenue = $result['total_revenue'] ?? 0;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Truy vấn tổng số đơn hàng
try {
    $sql_total_orders = "SELECT COUNT(*) AS total_orders FROM orders WHERE status = 'completed'";
    $stmt = $conn->prepare($sql_total_orders);
    $stmt->execute();
    $total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'] ?? 0;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Truy vấn tổng số sản phẩm
try {
    $sql_total_products = "SELECT COUNT(*) AS total_products FROM product";
    $stmt = $conn->prepare($sql_total_products);
    $stmt->execute();
    $total_products = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'] ?? 0;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="view/css/style.css" rel="stylesheet">
    <style>
        /* Custom styles for the dashboard */
.card {
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.card-text {
    font-size: 1.1rem;
    margin-top: 10px;
}

.table th, .table td {
    text-align: center;
    padding: 10px;
}

.table th {
    background-color: #f8f9fa;
}

.table-bordered {
    border: 1px solid #ddd;
}

    </style>
</head>

<body>
    <!-- Dashboard Start -->
    <div class="container-fluid pt-5">
        <div class="row">
            <!-- Doanh thu -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Doanh Thu</h5>
                        <p class="card-text">$<?= number_format($total_revenue, 2) ?></p>
                    </div>
                </div>
            </div>

            <!-- Tổng số đơn hàng -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Tổng Số Đơn Hàng</h5>
                        <p class="card-text"><?= $total_orders ?> đơn hàng</p>
                    </div>
                </div>
            </div>

            <!-- Tổng số sản phẩm -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Tổng Số Sản Phẩm</h5>
                        <p class="card-text"><?= $total_products ?> sản phẩm</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thêm các thông tin khác nếu cần -->
        <div class="row mt-4">
            <!-- Ví dụ về bảng hiển thị các đơn hàng gần đây -->
            <div class="col-lg-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">Đơn Hàng Gần Đây</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Ngày Đặt</th>
                                    <th>Giá Trị</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Truy vấn các đơn hàng gần đây
                                $sql_recent_orders = "SELECT id, created_at, total_price, status FROM orders ORDER BY created_at DESC LIMIT 5";
                                $result_recent_orders = $conn->query($sql_recent_orders);
                                while ($order = $result_recent_orders->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                    <tr>
                                        <td><?= $order['id'] ?></td>
                                        <td><?= $order['created_at'] ?></td>
                                        <td>$<?= number_format($order['total_price'], 2) ?></td>
                                        <td><?= ucfirst($order['status']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard End -->
</body>

</html>
