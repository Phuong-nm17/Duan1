<?php

require_once(__DIR__ . '/../model/connect.php');

try {

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if (!empty($search)) {
        $sql = "SELECT * FROM product WHERE title LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM productrandy";
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    die($e->getMessage());
}

?>

<?php
    if (isset($_GET['search'])): ?>
<h2 class="text-primary text-uppercase mb-3" style="margin-left: 40px;">
    Kết quả tìm kiếm cho: "<?= htmlspecialchars($_GET['search']) ?>"
</h2>


<?php if (empty($product)): ?>
<p class="text-danger mb-3" style="margin-left: 60px; font-size: 20px; font-weight: bold;">Không tìm thấy sản phẩm nào.
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
                <a href="index.php?act=ProductDetail&id=<?= $p['id'] ?>" class="btn btn-sm p-0 text-dark"><i
                        class="text-primary fa-eye fas mr-1"></i>View Detail</a>
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
<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row pb-3 px-xl-5">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="m-0 text-primary fa fa-check mr-3"></h1>
                <h5 class="m-0 font-weight-semi-bold">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="m-0 text-primary fa fa-shipping-fast mr-2"></h1>
                <h5 class="m-0 font-weight-semi-bold">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="m-0 text-primary fa-exchange-alt fas mr-3"></h1>
                <h5 class="m-0 font-weight-semi-bold">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="m-0 text-primary fa fa-phone-volume mr-3"></h1>
                <h5 class="m-0 font-weight-semi-bold">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="row pb-3 px-xl-5">
        <div class="col-lg-4 col-md-6 pb-1">
            <div class="d-flex flex-column border cat-item mb-4" style="padding: 30px;">
                <p class="text-right">15 Products</p>
                <a href="" class="position-relative cat-img mb-3 overflow-hidden">
                    <img class="img-fluid" src="view/img/cat-1.jpg" alt="">
                </a>
                <h5 class="m-0 font-weight-semi-bold">Men's dresses</h5>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
            <div class="d-flex flex-column border cat-item mb-4" style="padding: 30px;">
                <p class="text-right">15 Products</p>
                <a href="" class="position-relative cat-img mb-3 overflow-hidden">
                    <img class="img-fluid" src="view/img/cat-2.jpg" alt="">
                </a>
                <h5 class="m-0 font-weight-semi-bold">Women's dresses</h5>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
            <div class="d-flex flex-column border cat-item mb-4" style="padding: 30px;">
                <p class="text-right">15 Products</p>
                <a href="" class="position-relative cat-img mb-3 overflow-hidden">
                    <img class="img-fluid" src="view/img/cat-4.jpg" alt="">
                </a>
                <h5 class="m-0 font-weight-semi-bold">Accerssories</h5>
            </div>
        </div>
    </div>
</div>
<!-- Categories End -->


<!-- Offer Start -->
<div class="container-fluid offer pt-5">
    <div class="row px-xl-5">
        <div class="col-md-6 pb-4">
            <div class="bg-secondary position-relative text-center text-md-right text-white mb-2 px-5 py-5">
                <img class="img-banner" src="view/img/offer-1.png" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-primary text-uppercase mb-3">20% off the all order</h5>
                    <h1 class="font-weight-semi-bold mb-4">Spring Collection</h1>
                    <a href="" class="btn btn-outline-primary px-md-3 py-md-2">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 pb-4">
            <div class="bg-secondary position-relative text-center text-md-left text-white mb-2 px-5 py-5">
                <img class="img-banner" src="view/img/offer-2.png" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-primary text-uppercase mb-3">20% off the all order</h5>
                    <h1 class="font-weight-semi-bold mb-4">Winter Collection</h1>
                    <a href="" class="btn btn-outline-primary px-md-3 py-md-2">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->


<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="px-5 section-title"><span class="px-2">Trandy Products</span></h2>
    </div>
    <div class="row pb-3 px-xl-5">
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
                    <a href="index.php?act=ProductDetail&id=<?= $p['id'] ?>" class="btn btn-sm p-0 text-dark"><i
                            class="text-primary fa-eye fas mr-1"></i>View Detail</a>
                    <a href="" class="btn btn-sm p-0 text-dark"><i
                            class="text-primary fa-shopping-cart fas mr-1"></i>Add To Cart</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Products End -->