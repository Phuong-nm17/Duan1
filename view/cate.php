<?php

session_start();



require_once(__DIR__ . '/../model/connect.php');

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

try {

    $category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;



    $sql = "SELECT product.id AS product_id, product.title, product.price, product.thumbnail, product.discount, category.name 
            FROM product 
            JOIN category ON product.category_id = category.id";

    $conditions = [];
    $params = [];

    if ($category_id > 0) {
        $conditions[] = "product.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }

    if (!empty($search)) {
        $conditions[] = "product.title LIKE :search";
        $params[':search'] = "%$search%";
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $conn->prepare($sql);

    if ($category_id > 0) {
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    }

    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}

try {
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Thời trang Farah</title>
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
            top: 100%;
            right: 0;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            min-width: 150px;
            z-index: 1000;
            padding: 8px 0;
            transition: all 0.3s ease;
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
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
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
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="index.php?act=home" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">Farah</span></h1>

                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="index.php" method="GET">
                    <input type="hidden" name="act" value="cate">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control" placeholder="Search for products"
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
</body>
<!-- Navbar Start -->
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">

            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">

                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 120px">

                    <?php foreach ($category as $cat) : ?>
                        <a href="index.php?act=cate&id=<?= $cat['id'] ?>" class="nav-item nav-link"><?= htmlspecialchars($cat['name']) ?></a>

                    <?php endforeach; ?>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold text-primary font-weight-bold px-3 mr-1">
                        Farah
                    </h1>
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
                        <?php if (!isset($_SESSION['email'])): ?>
                            <a href="index.php?act=login" class="nav-item nav-link">Login</a>
                            <a href="index.php?act=register" class="nav-item nav-link">Register</a>
                        <?php else: ?>
                            <div class="menu-item">
                                <a href="#" class="nav-item nav-link">
                                    <?= htmlspecialchars($user['fullname'] ?? 'user') ?>
                                    <i class="fas fa-chevron-down ml-1"></i>
                                </a>
                                <div class="submenu">
                                    <a href="index.php?act=profile">Profile</a>
                                    <a href="index.php?act=cart">Cart</a>
                                    <a href="index.php?act=Logout">Logout</a>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">

        <h1 class="font-weight-semi-bold text-uppercase mb-3"> <?= isset($category_id) && $category_id > 0 ? ($category[array_search($category_id, array_column($category, 'id'))]['name'] ?? 'Category') : 'Category' ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="index.php?act=home">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">
                <?= isset($category_id) && $category_id > 0 ? ($category[array_search($category_id, array_column($category, 'id'))]['name'] ?? 'Category') : 'Category' ?>
            </p>
        </div>
    </div>
</div>
<!-- Page Header End -->
<!-- Products start -->
<?php
if (isset($_GET['search'])): ?>
    <h2 class="text-primary text-uppercase mb-3" style="margin-left: 40px;">
        Kết quả tìm kiếm cho: "<?= htmlspecialchars($_GET['search']) ?>"
    </h2>


    <?php if (empty($product)): ?>
        <p class="text-danger mb-3" style="margin-left: 60px; font-size: 20px; font-weight: bold;">No products found.
        </p>
    <?php else: ?>
        <div class=" row pb-3 px-xl-5">
            <?php foreach ($product as $p) : ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card border-0 mb-4 product-item">
                        <div class="card-header bg-transparent border p-0 position-relative overflow-hidden product-img">
                            <img class="w-100 img-fluid" src="<?= $p['thumbnail'] ?>" alt="">
                        </div>
                        <div class="card-body border-left border-right p-0 text-center pb-3 pt-4">
                            <h6 class="text-truncate mb-3"><?= $p['title'] ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6> $ <?= number_format($p['discount']) ?></h6>
                                <h6 class="text-muted ml-2"><del>$<?= number_format($p['price']) ?></del></h6>
                            </div>
                        </div>
                        <div class="d-flex card-footer bg-light border justify-content-between">
                            <a href="index.php?act=ProductDetail&id=<?= $p['product_id'] ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm p-0 text-dark"><i class="text-primary fa-shopping-cart fas mr-1"></i>Add To
                                Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2"><?= isset($category_id) && $category_id > 0 ? ($category[array_search($category_id, array_column($category, 'id'))]['name'] ?? 'Category') : 'Category' ?></span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php if (!empty($product)) : ?>
                <?php foreach ($product as $p): ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <a href="index.php?act=ProductDetail&id=<?= $p['product_id'] ?>">
                                    <img class="img-fluid w-100" src="<?= $p['thumbnail'] ?>" alt="">
                                </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><?= $p['title'] ?></h6>
                                <div class="d-flex justify-content-center">
                                    <h6>$ <?= number_format($p['price']) ?></h6>
                                    <h6 class="text-muted ml-2">$ <del><?= number_format($p['discount']) ?> </del></h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="index.php?act=ProductDetail&id=<?= $p['product_id'] ?>" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <a href="index.php?act=ProductDetail&id=<?= $p['product_id'] ?>" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">There are no products in this category.</p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Products End -->
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