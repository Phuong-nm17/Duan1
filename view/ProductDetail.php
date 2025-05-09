<?php
session_start();
require_once(__DIR__ . '/../model/connect.php');

try {
    $id = $_GET['id'] ?? null; // Get 'id' from the URL
    if ($id) {
        $sql = "SELECT * FROM product WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]); // Pass the ID parameter
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("Invalid product ID");
    }
} catch (Exception $e) {
    die($e->getMessage());
}
try {

    $sql = "SELECT * FROM size;";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $size = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
try {

    $sql = "SELECT * FROM color;";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $color = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Farah</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
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


    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 120px">
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
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span>Sarah</h1>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="<?= $product['thumbnail'] ?>" alt="Image">
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold"><?= $product['title'] ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(50 Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">$ <?= number_format($product['discount'], 2) ?></h3>
                <p class="mb-4"><?= $product['description'] ?></p>
                <form action="view/add_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="d-flex mb-3">
                        <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                        <?php foreach ($size as $index => $s): ?>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="size<?= $index ?>" name="size_id" value="<?= $s['id'] ?>"
                                    class="custom-control-input" required>
                                <label class="custom-control-label" for="size<?= $index ?>"><?= $s['name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex mb-4">
                        <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                        <?php foreach ($color as $index => $c): ?>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="color<?= $index ?>" name="color_id" value="<?= $c['id'] ?>"
                                    class="custom-control-input" required>
                                <label class="custom-control-label" for="color<?= $index ?>"><?= $c['name'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <button type="button" class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" class="form-control bg-secondary text-center"
                                value="1" min="1" max="5" readonly>
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary px-3">
                            <i class="fa fa-shopping-cart mr-1"></i>Add to cart
                        </button>
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Xử lý nút tăng số lượng
                            $('.btn-plus').click(function(e) {
                                e.preventDefault();
                                var quantityInput = $(this).parent().find('input[name="quantity"]');
                                var currentVal = parseInt(quantityInput.val());
                                if (currentVal < 5) {
                                    quantityInput.val(currentVal + 1).change();
                                } else {
                                    alert('You can only purchase up to 5 items');
                                }
                            });

                            // Xử lý nút giảm số lượng
                            $('.btn-minus').click(function(e) {
                                e.preventDefault();
                                var quantityInput = $(this).parent().find('input[name="quantity"]');
                                var currentVal = parseInt(quantityInput.val());
                                if (currentVal > 1) {
                                    quantityInput.val(currentVal - 1).change();
                                }
                            });

                            // Xử lý nhập trực tiếp
                            $('input[name="quantity"]').on('change keyup', function() {
                                var value = parseInt($(this).val());
                                if (isNaN(value) || value < 1) {
                                    $(this).val(1);
                                } else if (value > 5) {
                                    $(this).val(5);
                                    alert('You can only purchase up to 5 items');
                                }
                            });
                        });
                    </script>
                </form>
            </div>
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex">
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
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam
                        invidunt
                        duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur
                        invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam
                        stet
                        rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut
                        diam
                        consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor
                        accusam,
                        ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr
                        sanctus eirmod takimata dolor ea invidunt.</p>
                    <p>Dolore magna est eirmod sanctus dolor, amet diam et eirmod et ipsum. Amet dolore tempor
                        consetetur sed lorem dolor sit lorem tempor. Gubergren amet amet labore sadipscing clita
                        clita
                        diam clita. Sea amet et sed ipsum lorem elitr et, amet et labore voluptua sit rebum. Ea erat
                        sed
                        et diam takimata sed justo. Magna takimata justo et amet magna et.</p>
                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3">Additional Information</h4>
                    <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam
                        invidunt
                        duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur
                        invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam
                        stet
                        rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut
                        diam
                        consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor
                        accusam,
                        ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr
                        sanctus eirmod takimata dolor ea invidunt.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                </li>
                                <li class="list-group-item px-0">
                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                </li>
                                <li class="list-group-item px-0">
                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                </li>
                                <li class="list-group-item px-0">
                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                </li>
                                <li class="list-group-item px-0">
                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                </li>
                                <li class="list-group-item px-0">
                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                </li>
                                <li class="list-group-item px-0">
                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                            <div class="media mb-4">

                                <img src="view/img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                    style="width: 45px;">

                                <div class="media-body">
                                    <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                    <div class="text-primary mb-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum
                                        et no
                                        at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            <small>Your email address will not be published. Required fields are marked *</small>
                            <div class="d-flex my-3">
                                <p class="mb-0 mr-2">Your Rating * :</p>
                                <div class="text-primary">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="message">Your Review *</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name">Your Name *</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email *</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Shop Detail End -->


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
    <script>
        $(document).ready(function() {
            // Xử lý nút tăng số lượng
            $('.btn-plus').click(function(e) {
                e.preventDefault();
                var quantityInput = $(this).closest('.input-group').find('input[name="quantity"]');
                var currentVal = parseInt(quantityInput.val());
                if (currentVal >= 5) {
                    quantityInput.val(5);
                    alert('Bạn chỉ có thể mua tối đa 5 sản phẩm cho mỗi đơn hàng');
                    return false; // Chặn không cho tăng thêm
                }
                quantityInput.val(currentVal + 1).change();
            });

            // Xử lý nút giảm số lượng
            $('.btn-minus').click(function(e) {
                e.preventDefault();
                var quantityInput = $(this).closest('.input-group').find('input[name="quantity"]');
                var currentVal = parseInt(quantityInput.val());
                if (currentVal > 1) {
                    quantityInput.val(currentVal - 1).change();
                }
            });

            // Xử lý nhập trực tiếp
            $('input[name="quantity"]').on('change keyup', function() {
                var value = parseInt($(this).val());
                if (isNaN(value) || value < 1) {
                    $(this).val(1);
                } else if (value > 5) {
                    $(this).val(5);
                    alert('Bạn chỉ có thể mua tối đa 5 sản phẩm cho mỗi đơn hàng');
                }
            });
        });
    </script>