<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__ . '/../model/connect.php');

class ProfileManager
{
    private $conn;
    private $userId;

    public function __construct($conn, $userId)
    {
        $this->conn = $conn;
        $this->userId = $userId;
    }

    public function getUserData()
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$this->userId]);
        return $stmt->fetch();
    }

    public function updateProfile($data, $files)
    {
        if (isset($files['avatar']) && $files['avatar']['error'] === UPLOAD_ERR_OK) {
            $this->handleAvatarUpload($files['avatar']);
        }

        $this->updateUserInfo($data);
        return true;
    }

    private function handleAvatarUpload($file)
    {
        $uploadDir = __DIR__ . '/../uploads/avatar/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPEG and PNG are allowed.');
        }

        // Validate file size (1MB max)
        if ($file['size'] > 1048576) {
            throw new Exception('File too large. Maximum size is 1MB.');
        }

        $fileName = uniqid() . '-' . basename($file['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $stmt = $this->conn->prepare("UPDATE user SET avatar = ? WHERE id = ?");
            $stmt->execute([$fileName, $this->userId]);
        }
    }

    private function updateUserInfo($data)
    {
        $stmt = $this->conn->prepare("UPDATE user SET fullname = ?, phone_number = ?, address = ? WHERE id = ?");
        $stmt->execute([
            $data['fullname'] ?? '',
            $data['phone_number'] ?? '',
            $data['address'] ?? '',
            $this->userId
        ]);
    }
}

// Initialize profile manager
$profileManager = new ProfileManager($conn, $_SESSION['id']);
$user = $profileManager->getUserData();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $profileManager->updateProfile($_POST, $_FILES);
        header("Location: index.php?act=profile&success=1");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hồ sơ người dùng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="User Profile" name="description">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="view/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="view/css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            padding: 30px 60px;
            gap: 40px;
        }

        .sidebar {
            width: 220px;
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            color: #333;
            cursor: pointer;
        }

        .profile-form {
            flex: 1;
            background-color: white;
            border-radius: 6px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .profile-form h2 {
            font-size: 20px;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .gender-options input {
            margin-right: 6px;
        }

        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-left: 1px solid #eee;
            padding-left: 30px;
        }

        .avatar-section img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .choose-img {
            border: 1px solid #ccc;
            background: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-bottom {
            display: flex;
            justify-content: flex-start;
            margin-top: 30px;
        }

        .btn-save {
            background-color: #ee4d2d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
        }

        .row {
            display: flex;
            gap: 20px;
        }
    </style>
</head>

<body>
    <?php include 'partials/header.php'; ?>

    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="text-uppercase font-weight-semi-bold mb-2">Profile</h1>
        </div>
    </div>

    <div class="container">
        <?php include 'partials/sidebar.php'; ?>

        <div class="profile-form">
            <h2>My Profile</h2>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div id="success-message" class="alert alert-success">
                    ✅ Thông tin đã được cập nhật thành công!
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div style="flex: 2;">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>"
                                pattern="[0-9]{10}" title="Please enter a valid phone number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" class="form-control">
                        </div>
                        <div class="form-bottom">
                            <button type="submit" class="btn-save">Save Changes</button>
                        </div>
                    </div>
                    <div class="avatar-section">
                        <img src="<?= isset($user['avatar']) ? 'uploads/avatar/' . htmlspecialchars($user['avatar']) : 'assets/img/default-avatar.png' ?>"
                            alt="Profile Avatar" class="profile-avatar">
                        <label class="choose-img">
                            Choose Image
                            <input type="file" name="avatar" accept="image/jpeg,image/png" hidden>
                        </label>
                        <small>Max size: 1MB<br>Formats: .JPEG, .PNG</small>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Auto-hide success message
        setTimeout(() => {
            const msg = document.getElementById('success-message');
            if (msg) {
                msg.style.opacity = '0';
                setTimeout(() => msg.style.display = 'none', 300);
            }
        }, 3000);

        // Preview avatar image before upload
        document.querySelector('input[name="avatar"]').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-avatar').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>

</html>