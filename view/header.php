<?php
session_start();

require_once(__DIR__ . '/../model/connect.php');

try {

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if (!empty($search)) {
        $sql = "SELECT * FROM product WHERE title LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM product";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();

    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
try {

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if (!empty($search)) {
        $sql = "SELECT * FROM product WHERE title LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM product";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();

    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
try {

    $sql = "SELECT * FROM category;";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
if (isset($_SESSION['email'])) {
    try {
        $sql = "SELECT fullname FROM user WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Lỗi truy vấn: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShopper - Bootstrap Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="view/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="view/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="view/css/style.css" rel="stylesheet">
    <style>
        .menu-item {
            position: relative;
            display: inline-block;
        }

        .menu-item .submenu {
            display: none;
            position: absolute;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            min-width: 80px;
            z-index: 10;
        }

        .menu-item:hover .submenu {
            display: block;
        }
        .submenu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }
        .submenu a:hover {
            background: #f1f1f1;
        }
    </style>

</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary px-xl-5 py-2">
            <div class="col-lg-6 d-lg-block d-none">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fa-facebook-f fab"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fa-twitter fab"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fa-linkedin-in fab"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fa-instagram fab"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fa-youtube fab"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="index.php?act=home" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                <a href="index.php?act=home" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="index.php" method="GET">
                    <input type="hidden" name="act" value="home">
                <form action="index.php" method="GET">
                    <input type="hidden" name="act" value="home">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control" placeholder="Search for products"
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <input name="search" type="text" class="form-control" placeholder="Search for products"
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-6 col-lg-3 text-right">
                <a href="" class="btn border">
                    <i class="text-primary fa-heart fas"></i>
                    <span class="badge">0</span>
                </a>
                <a href="" class="btn border">
                    <i class="text-primary fa-shopping-cart fas"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
                    id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden">
                        <?php foreach ($category as $cat): ?>
                            <a href="index.php?act=cate&id=<?= $cat['id'] ?>"
                                class="nav-item nav-link"><?= htmlspecialchars($cat['name']) ?></a>
                        <?php endforeach; ?>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="index.php" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php?act=home" class="nav-item nav-link active">Home</a>
                            <a href="index.php?act=ProductList" class="nav-item nav-link">Shop</a>
                            <a href="index.php?act=contact" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <?php if (!isset($_SESSION['email'])) : ?>
                                <a href="index.php?act=login" class="nav-item nav-link">Login</a>
                                <a href="index.php?act=register" class="nav-item nav-link">Register</a>
                            <?php else : ?>
                                <div class="menu-item">
                                    <a href="#" class="nav-item nav-link"><?= htmlspecialchars($user['fullname'] ?? 'user') ?></a>
                                    <div class="submenu">
                                        <a href="index.php?act=cart">Cart</a>
                                        <a href="index.php?act=cart">Cart</a>
                                        <a href="index.php?act=Logout">LogOut</a>
                                        <a href="#"></a>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="active carousel-item" style="height: 410px;">
                            <img src="view/img/carousel-1.jpg" alt="Image">
                            <div class="d-flex flex-column align-items-center justify-content-center carousel-caption">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First
                                        Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                                    <a href="" class="btn btn-light px-3 py-2">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img src="view/img/carousel-2.jpg" alt="Image">
                            <div class="d-flex flex-column align-items-center justify-content-center carousel-caption">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First
                                        Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                                    <a href="" class="btn btn-light px-3 py-2">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


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