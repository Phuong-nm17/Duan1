<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

function fetchProducts($conn, $search = '', $min_price = 0, $max_price = 0, $sort = 'asc')
{
    $sql = "SELECT * FROM product WHERE 1=1";

    if (!empty($search)) {
        $sql .= " AND title LIKE :search";
    }
    if ($min_price > 0) {
        $sql .= " AND discount >= :min_price";  // Thay đổi từ price sang discount
    }
    if ($max_price > 0) {
        $sql .= " AND discount <= :max_price";  // Thay đổi từ price sang discount
    }

    $sort = strtolower($sort) === 'desc' ? 'DESC' : 'ASC';
    $sql .= " ORDER BY discount $sort";  // Thay đổi từ price sang discount

    $stmt = $conn->prepare($sql);

    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    if ($min_price > 0) {
        $stmt->bindValue(':min_price', $min_price, PDO::PARAM_INT);
    }
    if ($max_price > 0) {
        $stmt->bindValue(':max_price', $max_price, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy dữ liệu từ GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$min_price = isset($_GET['min_price']) ? (int) $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int) $_GET['max_price'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';

try {
    $products = fetchProducts($conn, $search, $min_price, $max_price, $sort);
} catch (Exception $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
}

// Lấy thông tin user nếu đã đăng nhập
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

// Lấy danh sách categories
try {
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Lỗi truy vấn: " . $e->getMessage());
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

        .filter-form .form-label {
            font-weight: 600;
        }

        .filter-form .form-control,
        .filter-form .form-select {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filter-form button {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .filter-form button:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .filter-form a {
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            color: #333;
        }

        .filter-form a:hover {
            background-color: #e2e6ea;
            color: #007bff;
        }

        .product-container {
            display: flex;
            /* flex-wrap: wrap; */
            gap: 20px;
            justify-content: flex-start;
            align-items: stretch;
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
                    <h1 class="m-0 display-5 font-weight-semi-bold text-primary font-weight-bold px-3 mr-1">
                        Farah
                    </h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">

                <form action="index.php" method="GET">
                    <input type="hidden" name="act" value="ProductList">
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
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">

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
                <a href="index.php?act=home" class="text-decoration-none d-block d-lg-none">
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
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="index.php?act=home">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop</p>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <form method="GET" action="index.php" class="filter-form mb-5">
                <input type="hidden" name="act" value="ProductList">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price-range" class="form-label">Price Range:</label>
                        <div class="d-flex align-items-center">
                            <span id="min-price-display">$0</span>
                            <input type="range" class="form-range mx-2" id="price-range" 
                                min="0" max="200" step="1"
                                value="<?= htmlspecialchars($max_price ?: '200') ?>">
                            <span id="max-price-display">$200</span>
                        </div>
                        <input type="hidden" name="min_price" id="min_price" value="<?= htmlspecialchars($min_price) ?>">
                        <input type="hidden" name="max_price" id="max_price" value="<?= htmlspecialchars($max_price) ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="sort" class="form-label">Sort by:</label>
                        <select class="form-control" name="sort" id="sort">
                            <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <a href="index.php?act=ProductList" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row px-xl-5">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <a href="index.php?act=ProductDetail&id=<?= $product['id'] ?>"><img class="img-fluid w-100" src="<?= htmlspecialchars($product['thumbnail']) ?>" alt=""></a>
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?= htmlspecialchars($product['title']) ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6><?= number_format($product['discount'], 0, ',', '.') ?>đ</h6>
                                <?php if ($product['price'] > $product['discount']): ?>
                                    <h6 class="text-muted ml-2"><del><?= number_format($product['price'], 0, ',', '.') ?>đ</del></h6>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="index.php?act=ProductDetail&id=<?= $product['id'] ?>" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-eye text-primary mr-1"></i>View Detail
                            </a>
                            <a href="index.php?act=ProductDetail&id=<?= $product['id'] ?>" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">No products found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

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

<!-- Thêm style cho thanh range slider -->
<style>
    .form-range {
        width: 100%;
        height: 10px;
        padding: 0;
        background: #d3d3d3;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
        border-radius: 5px;
    }

    .form-range:hover {
        opacity: 1;
    }

    .form-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: #007bff;
        cursor: pointer;
        border-radius: 50%;
    }

    .form-range::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: #007bff;
        cursor: pointer;
        border-radius: 50%;
    }

    #min-price-display, #max-price-display {
        min-width: 80px;
    }
</style>

<!-- Thêm script để xử lý thanh range -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('price-range');
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');
    const minPriceDisplay = document.getElementById('min-price-display');
    const maxPriceDisplay = document.getElementById('max-price-display');

    function formatPrice(price) {
        return '$' + new Intl.NumberFormat().format(price);
    }

    priceRange.addEventListener('input', function() {
        const value = this.value;
        maxPriceInput.value = value;
        maxPriceDisplay.textContent = formatPrice(value);
    });

    // Khởi tạo giá trị ban đầu
    maxPriceDisplay.textContent = formatPrice(priceRange.value);
});
</script>