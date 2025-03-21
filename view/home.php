<?php

require_once(__DIR__ . '/../model/connect.php');


try {

    $sql = "SELECT * FROM productrandy;";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die($e->getMessage());
}
?>

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


    <!-- Products Start -->
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
                        <a href="index.php?act=ProductDetail&id=<?= $p['id'] ?>" class="btn btn-sm p-0 text-dark"><i class="text-primary fa-eye fas mr-1"></i>View Detail</a>
                        <a href="" class="btn btn-sm p-0 text-dark"><i class="text-primary fa-shopping-cart fas mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center px-xl-5 py-5">
            <div class="col-12 col-md-6 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="mb-3 px-5 section-title"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Subscribe End -->

    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-1.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-2.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-3.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-4.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-5.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-6.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-7.jpg" alt="">
                    </div>
                    <div class="border p-4 vendor-item">
                        <img src="view/img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->