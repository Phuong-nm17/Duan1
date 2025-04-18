<?php
session_start();
require '../../model/connect.php';
if (!isset($_SESSION['admin']))
    header("Location: login.php");

try {
    $sql = "SELECT * FROM user WHERE 1=1";
    $params = [];

    if (!empty($_GET['keyword'])) {
        $sql .= " AND (fullname LIKE ? OR email LIKE ?)";
        $keyword = '%' . $_GET['keyword'] . '%';
        $params[] = $keyword;
        $params[] = $keyword;
    }

    if (!empty($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'name_asc':
                $sql .= " ORDER BY fullname ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY fullname DESC";
                break;
            case 'email_asc':
                $sql .= " ORDER BY email ASC";
                break;
            case 'email_desc':
                $sql .= " ORDER BY email DESC";
                break;
        }
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $user = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Danh sách khách hàng</title>
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

        /* Nội dung chính */
        #content {
            margin-left: 260px;
            width: 100%;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        #content.full-width {
            margin-left: 90px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include '../sidebar.php'; ?>


    <!-- Nội dung chính -->
    <div id="content">
        <h2>Danh sách khách hàng</h2>
        <form method="get" class="row g-3 mb-4">
            <div class="col-auto">
                <label for="keyword" class="form-label">Tìm kiếm:</label>
                <input type="text" class="form-control" name="keyword" id="keyword"
                    value="<?= $_GET['keyword'] ?? '' ?>" placeholder="Nhập tên hoặc email">
            </div>
            <div class="col-auto">
                <label for="sort" class="form-label">Sắp xếp theo:</label>
                <select class="form-select" name="sort" id="sort">
                    <option value="">-- Mặc định --</option>
                    <option value="name_asc" <?= ($_GET['sort'] ?? '') === 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                    <option value="name_desc" <?= ($_GET['sort'] ?? '') === 'name_desc' ? 'selected' : '' ?>>Tên Z-A</option>
                    <option value="email_asc" <?= ($_GET['sort'] ?? '') === 'email_asc' ? 'selected' : '' ?>>Email A-Z</option>
                    <option value="email_desc" <?= ($_GET['sort'] ?? '') === 'email_desc' ? 'selected' : '' ?>>Email Z-A</option>
                </select>
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary">Tìm</button>
                <a href="user_management.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= $u['fullname'] ?></td>
                        <td><?= $u['email'] ?></td>
                        <td><?= $u['phone_number'] ?></td>
                        <td><?= $u['address'] ?></td>
                    </tr>
                <?php endforeach; ?>
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