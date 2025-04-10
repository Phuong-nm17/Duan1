
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">


<!-- Mirrored from themesflat.co/html/ecomus/index.html by HTTrack Website Copzier/3.x [XR&CO'2014], Wed, 06 Nov 2024 14:40:41 GMT -->
<head>
    <meta charset="utf-8">
    <title>My account</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!-- font -->
   <link rel="stylesheet" href="assets/Users/fonts/fonts.css">
   <link rel="stylesheet" href="assets/Users/fonts/font-icons.css">
   <link rel="stylesheet" href="assets/Users/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/Users/css/swiper-bundle.min.css">
   <link rel="stylesheet" href="assets/Users/css/animate.css">
   <link rel="stylesheet"type="text/css" href="assets/Users/css/styles.css"/>

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="assets/Users/images/logo/logomain_preview_rev.png">
    <link rel="apple-touch-icon-precomposed" href="assets/Users/images/logo/logomain_preview_rev.png">
    <style>
        .header-default{
            margin-bottom: 0 !important;
        }
    </style>
</head>

<body class="preload-wrapper popup-loader">

    <!-- RTL -->
    <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-hover-btn btn-fill"></a>
    <!-- /RTL  -->

    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">


        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Chi tiết tài khoản</div>
            </div>
        </div>

        <section class="flat-spacing-11">
            <div class="container">
                <div class="row">
                <?php include 'view/Users/layout/my-account.php'; ?>
                    <div class="col-lg-9">
                        <div class="my-account-content account-edit">
                            <div class="">
                                <?php
                                    if(isset($_SESSION['message'])){
                                        echo "<p>" . $_SESSION['message'] . "</p>";
                                        unset($_SESSION['message']);
                                    }
                                ?>
                                <form class="" id="form-password-change" action="<?= BASE_URL?>?act=account-update" method="post" enctype="multipart/form-data">
                                    
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="property1" name="name" value="<?= $user->name ?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property1">Tên tài khoản</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="email" id="property2" name="email" value="<?= $user->email ?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property2">Email</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="property3" name="address" value="<?= $user->address ?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property3">Địa chỉ</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="property4" name="phone" value="<?= $user->phone ?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property4">Số điện thoại</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <img src="<?= $user->image ?>" alt="" width="100"> <br>
                                        <input class="tf-field-input tf-input" placeholder=" " type="file" id="property5" name="image" accept="image/*">
                                        <label class="tf-field-label fw-4 text_black-2" for="property5">Ảnh đại diện</label>
                                    </div>
                                    <h6 class="mb_20">Đổi mật khẩu</h6>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password" id="property6" name="current-password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property6">Mật khẩu cũ</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password" id="property7" name="new-password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property7">Mật khẩu mới</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password" id="property8" name="confirm-password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property8">Xác nhận mật khẩu</label>
                                    </div>
                                    <div class="mb_20">
                                        <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <?php include 'view/footer.php' ?>
        <!-- /Footer -->
        
    </div>
     


  