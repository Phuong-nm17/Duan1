<?php
session_start();
require '../../model/connect.php';
if (!isset($_SESSION['admin'])) header("Location: login.php");

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    $sql = "SELECT 
                od.*, 
                p.title AS product_name, 
                p.thumbnail AS product_thumbnail, 
                s.name AS size_name, 
                c.name AS color_name,
                o.address,
                o.city,
                o.country,
                o.payment_method,
                o.phone,
                o.fullname,
                o.email,
                o.note
            FROM order_details od
            JOIN product p ON od.product_id = p.id
            JOIN size s ON od.size_id = s.id
            JOIN color c ON od.color_id = c.id
            JOIN orders o ON od.order_id = o.id
            WHERE od.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$order_id]);
    $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
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

        /* Nút thu nhỏ sidebar */
        #toggle-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        #content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }

        table td,
        table th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include '../sidebar.php'; ?>

    <div id="content">
        <h2>Chi tiết đơn hàng #<?= htmlspecialchars($order_id) ?></h2>
        <a href="orderS.php" class="btn btn-secondary mb-3">← Quay lại danh sách</a>
        <div class="order-customer-info" style="padding: 15px; background: #f8f9fa; border-bottom: 1px solid #eaeaea;">
            <?php foreach ($order_items as $item): ?>
                <h5 style="margin-bottom: 10px;">Customer Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?= htmlspecialchars($item['fullname']) ?? '' ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($item['email']) ?? '' ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($item['address']) ?? '' ?>, <?= htmlspecialchars($item['city']) ?? '' ?>, <?= htmlspecialchars($item['country']) ?? '' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Phone:</strong> <?= htmlspecialchars($item['phone']) ?? '' ?></p>
                        <p><strong>Payment Method:</strong> <?= htmlspecialchars($item['payment_method']) ?? '' ?></p>
                        <p><strong>Note:</strong> <?= htmlspecialchars($item['note']) ?? '' ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Kích cỡ</th>
                    <th>Màu sắc</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($order_items as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total + 10;
                    $total += $subtotal;
                ?>
                    <tr class="text-center">

                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                <img src="<?= htmlspecialchars($item['product_thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($item['product_name']) ?>"
                                    width="60" height="60" style="object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                <span><?= htmlspecialchars($item['product_name']) ?></span>
                            </div>

                        </td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> $</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['size_name'] ?></td>
                        <td><?= $item['color_name'] ?></td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?> $</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <?php $shipping = 10; ?>
                <tfoot>
                    <tr class="text-end">
                        <td colspan="5">Phí vận chuyển:</td>
                        <td><?= number_format($shipping, 0, ',', '.') ?> $</td>
                    </tr>
                    <tr class="fw-bold text-end">
                        <td colspan="5">Tổng cộng:</td>
                        <td><?= number_format($total + $shipping, 0, ',', '.') ?> $</td>
                    </tr>
                </tfoot>

            </tfoot>
        </table>
    </div>
</body>

</html>