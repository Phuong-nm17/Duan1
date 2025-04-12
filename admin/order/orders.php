<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
$from = $_GET['from_date'] ?? null;
$to = $_GET['to_date'] ?? null;

$where = "";
$params = [];

if ($from && $to) {
    $where = "WHERE DATE(order_date) BETWEEN :from AND :to";
    $params = ['from' => $from, 'to' => $to];
} elseif ($from) {
    $where = "WHERE DATE(order_date) >= :from";
    $params = ['from' => $from];
} elseif ($to) {
    $where = "WHERE DATE(order_date) <= :to";
    $params = ['to' => $to];
}


try {
    $sql = "SELECT * FROM orders $where ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($id && $status) {
            $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE id = :id");
            $stmt->execute(['status' => $status, 'id' => $id]);
        }
        $redirect = 'orders.php';
        header("Location: $redirect");
        exit();
    }
} catch (Exception $e) {
    die("Lỗi: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            width: 100%;
            padding: 20px;
        }
    </style>
</head>

<body>
    <?php include '../sidebar.php'; ?>

    <div id="content">
        <h2>Danh sách đơn hàng</h2>
        <form method="get" class="row g-3 mb-4">
            <div class="col-auto">
                <label for="from_date" class="form-label">Từ ngày:</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="<?= $_GET['from_date'] ?? '' ?>">
            </div>
            <div class="col-auto">
                <label for="to_date" class="form-label">Đến ngày:</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?= $_GET['to_date'] ?? '' ?>">
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="orders.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Phương thức</th>
<<<<<<< HEAD
                    <th>trạng thái</th>
=======
                    <th>Trạng thái đơn hàng</th>
>>>>>>> 7a667765d640e45cd3bb29fc581db778663ce16d
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td><?= htmlspecialchars($order['fullname']) ?></td>
                        <td><?= htmlspecialchars($order['email']) ?></td>
                        <td><?= htmlspecialchars($order['phone']) ?></td>
                        <td>
                            <?= htmlspecialchars($order['address']) ?>,
                            <?= htmlspecialchars($order['city']) ?>,
                            <?= htmlspecialchars($order['country']) ?>,
                            <?= $order['zipcode'] ?>
                        </td>
                        <td><?= htmlspecialchars($order['payment_method']) ?></td>
<<<<<<< HEAD
                        <td><?= htmlspecialchars($order['status']) ?></td>
=======
                        <td>
                            <form method="POST" class="mt-3">
                                <input type="hidden" name="order_id" id="" value="<?= $order['id'] ?>">
                                <select class="form-select" name="status" onchange="this.form.submit()">
                                    <option value=""><?php echo htmlspecialchars($order['status']); ?></option>
                                    <option value="chờ xử lý">chờ xử lý</option>
                                    <option value="đang giao">đang giao</option>
                                    <option value="Hoàn thành">Hoàn thành</option>
                                    <option value="đã hủy">đã hủy</option>
                                </select>
                            </form>
                        </td>
>>>>>>> 7a667765d640e45cd3bb29fc581db778663ce16d
                        <td class="text-center">
                            <a href="view_order.php?id=<?= htmlspecialchars($order['id']) ?>" class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="edit_order.php?id=<?= htmlspecialchars($order['id']) ?>" class="btn btn-success btn-sm">sửa</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script>
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('full-width');
        });
    </script>
</body>

</html>