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
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
$size_id = isset($_POST['size_id']) ? $_POST['size_id'] : null;
$color_id = isset($_POST['color_id']) ? $_POST['color_id'] : null;

try {
    // Lấy tất cả biến thể của sản phẩm
    $sql = "SELECT * FROM product_variants WHERE product_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $product_variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_submit'])) {
    $comment_content = trim($_POST['comment_content']);
    $user_id = $_SESSION['id'] ?? null;

    if ($user_id && $comment_content !== '') {
        $sql = "INSERT INTO comments (user_id, product_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id, $id, $comment_content]);
    }
}
$sql = "SELECT c.content, c.created_at, u.fullname 
        FROM comments c 
        JOIN user u ON c.user_id = u.id 
        WHERE c.product_id = ? 
        ORDER BY c.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
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
                <h3 class="font-weight-semi-bold mb-4" id="priceDisplay">$ <?= number_format($product['discount'], 2) ?></h3>
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
                            <input type="text" name="quantity" class="form-control bg-secondary text-center" value="1">
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <p id="stock-warning" class="text-danger mt-2" style="display: none;"></p>
                    </div>

                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i>Add to cart

                    </button>
            </div>
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

    <!-- Comment Section Start -->
    <div class="col-12 mt-5">
        <h4 class="mb-4">Customer Comments</h4>

        <!-- Comment Form (Only if user is logged in) -->
        <?php if (isset($_SESSION['id'])): ?>
            <form method="POST" class="mb-4">
                <div class="form-group">
                    <label for="comment_content">Leave a comment:</label>
                    <textarea name="comment_content" id="comment_content" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" name="comment_submit" class="btn btn-primary">Post Comment</button>
            </form>
        <?php else: ?>
            <p>Please <a href="index.php?act=login">log in</a> to leave a comment.</p>
        <?php endif; ?>

        <!-- Comments List -->
        <div class="comments-list mt-4">
            <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="border p-3 mb-3">
                        <strong><?= htmlspecialchars($comment['fullname']) ?></strong>
                        <small class="text-muted ml-2"><?= date("d/m/Y H:i", strtotime($comment['created_at'])) ?></small>
                        <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Comment Section End -->




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

    <script>
        const variants = <?= json_encode($product_variants) ?>;
        const priceDisplay = document.getElementById('priceDisplay');
        const quantityInput = document.querySelector('input[name="quantity"]');
        const stockWarning = document.getElementById('stock-warning');

        function getSelectedValue(name) {
            const selected = document.querySelector(`input[name="${name}"]:checked`);
            return selected ? selected.value : null;
        }

        function updatePrice() {
            const colorId = getSelectedValue('color_id');
            const sizeId = getSelectedValue('size_id');

            if (!colorId || !sizeId) {
                priceDisplay.textContent = 'Vui lòng chọn màu và size';
                quantityInput.value = 1;
                quantityInput.disabled = true;
                stockWarning.style.display = 'none';
                return;
            }

            const match = variants.find(v =>
                v.color_id == colorId && v.size_id == sizeId
            );

            if (match) {
                priceDisplay.textContent = '$ ' + match.price.toLocaleString();
                quantityInput.disabled = false;
                quantityInput.max = match.stock;
                checkQuantity(match.stock);
            } else {
                priceDisplay.textContent = 'Không có giá cho lựa chọn này';
                quantityInput.value = 1;
                quantityInput.disabled = true;
                stockWarning.style.display = 'none';
            }
        }

        function checkQuantity(stock) {
            const quantity = parseInt(quantityInput.value);
            if (quantity > stock) {
                stockWarning.textContent = 'Số lượng vượt quá tồn kho. Số lượng còn lại: ' + stock;
                stockWarning.style.display = 'block';
                quantityInput.value = stock;
                alert('Số lượng vượt quá tồn kho. Số lượng tối đa là: ' + stock);
            } else {
                stockWarning.style.display = 'none';
            }
        }

        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('click', updatePrice);
        });

        quantityInput.addEventListener('change', function() {
            const colorId = getSelectedValue('color_id');
            const sizeId = getSelectedValue('size_id');
            if (colorId && sizeId) {
                const match = variants.find(v =>
                    v.color_id == colorId && v.size_id == sizeId
                );
                if (match) {
                    checkQuantity(match.stock);
                }
            }
        });

        document.querySelector('.btn-plus').addEventListener('click', function() {
            const colorId = getSelectedValue('color_id');
            const sizeId = getSelectedValue('size_id');
            if (colorId && sizeId) {
                const match = variants.find(v =>
                    v.color_id == colorId && v.size_id == sizeId
                );
                if (match) {
                    if (parseInt(quantityInput.value) < match.stock) {
                        quantityInput.value = parseInt(quantityInput.value) + 1;
                        checkQuantity(match.stock);
                    } else {
                        alert('Số lượng vượt quá tồn kho. Số lượng tối đa là: ' + match.stock);
                    }
                }
            }
        });

        document.querySelector('.btn-minus').addEventListener('click', function() {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                stockWarning.style.display = 'none';
            }
        });
    </script>
</body>

</html>