<?php
session_start();
require '../../model/connect.php';
if (!isset($_SESSION['admin']))
    header("Location: login.php");
try {
    $sql = "
        SELECT SUM(order_details.quantity * order_details.price + 10) AS total_revenue
        FROM orders
        JOIN order_details ON orders.id = order_details.order_id
        WHERE orders.status = 'hoàn thành'
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_revenue = $result['total_revenue'] ?? 0;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $sql_total_orders = "SELECT COUNT(*) AS total_orders FROM orders";
    $stmt = $conn->prepare($sql_total_orders);
    $stmt->execute();
    $total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'] ?? 0;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

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
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-weight: 600;
            color: #333;
        }

        .card-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
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

        .card-header {
            background-color: #007bff !important;
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .section-title {
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 24px;
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            .card-text {
                font-size: 1.2rem;
            }
        }

        /* Sidebar */
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

        #sidebar h4 {
            transition: opacity 0.3s;
        }

        #sidebar.collapsed h4 {
            opacity: 0;
        }

        #sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            white-space: nowrap;
            transition: background 0.3s ease-in-out;
            position: relative;
        }

        #sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        /* Submenu */
        .submenu {
            display: none;
            background: #495057;
            padding-left: 20px;
        }

        .menu-item:hover .submenu {
            display: block;
        }

        /* Sidebar */
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

        #sidebar h4 {
            transition: opacity 0.3s;
        }

        #sidebar.collapsed h4 {
            opacity: 0;
        }

        #sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            white-space: nowrap;
            transition: background 0.3s ease-in-out;
            position: relative;
        }

        #sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        /* Submenu */
        .submenu {
            display: none;
            background: #495057;
            padding-left: 20px;
        }

        .menu-item:hover .submenu {
            display: block;
        }

        /* Nếu sidebar thu nhỏ, hiển thị submenu bên cạnh */
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
        <div class="container pt-5">
            <h2 class="section-title">Thống Kê Shop Farah</h2>
            <div class="row">
                <!-- Doanh thu -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Doanh Thu</h5>
                            <p class="card-text">$<?= number_format($total_revenue, 2) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Tổng số đơn hàng -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Tổng Đơn Hàng</h5>
                            <p class="card-text"><?= $total_orders ?> đơn</p>
                        </div>
                    </div>
                </div>

                <!-- Tổng số sản phẩm -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Tổng Sản Phẩm</h5>
                            <p class="card-text"><?= $total_products ?> sản phẩm</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng gần đây -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            Đơn Hàng Gần Đây
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0 text-center">
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
                                    $sql_recent_orders = "SELECT id, created_at, total_price, status FROM orders ORDER BY created_at DESC LIMIT 5";
                                    $result_recent_orders = $conn->query($sql_recent_orders);
                                    while ($order = $result_recent_orders->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                        <tr>
                                            <td><?= $order['id'] ?></td>
                                            <td><?= $order['created_at'] ?></td>
                                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                                            <td>
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
                                                    case 'hoàn thành':
                                                        echo '<span style="color: blue;">Completed</span>';
                                                        break;
                                                    case 'đã hủy':
                                                        echo '<span style="color: red;">Cancelled</span>';
                                                        break;
                                                    default:
                                                        echo '<span style="color: gray;">Unknown</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>