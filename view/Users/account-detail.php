


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">


<!-- Mirrored from themesflat.co/html/ecomus/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Nov 2024 14:40:41 GMT -->
<head>
    <meta charset="utf-8">
    <title>My Account</title>

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
    <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-hover-btn btn-fill">RTL</a>
    <!-- /RTL  -->

    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">
        <!-- Header -->
        <?php include 'app/Views/Users/layouts/header.php' ?>
        <!-- /Header -->
        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Account Detail</div>
            </div>
        </div>
        <section class="flat-spacing-11">
            <div class="container">
                <div class="row">
                    <?php include 'app/Views/Users/layouts/my-account-sidebar.php'; ?>
                    <div class="col-lg-9">
                        <div class="my-account-content account-edit">
                            <div class="">
                                <?php if(isset($_SESSION['message'])){
                                    echo"<p>" . $_SESSION['message'] ."</p>";
                                    unset($_SESSION['message']);
                                } ?>
                                <form class="" id="form-password-change" action="<?=BASE_URL?>?act=account-update" method="post" enctype="multipart/form-data">
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="property2" name="name"             value="<?=$user->name?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property2">Name</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="email" id="property3" name="email" 
                                        value="<?=$user->email?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property3">Email</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="property4" name="address" 
                                        value="<?=$user->address?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property4">Address</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="property5" name="phone" 
                                        value="<?=$user->phone?>">
                                        <label class="tf-field-label fw-4 text_black-2" for="property5">Phone</label>
                                    </div>
                                    <div class="tf-field style-1 mb_15">
                                        <img src="<?=$user->image?>" alt="" width="200px"> <br>
                                        <input class="tf-field-input tf-input" type="file" id="property6" name="image" accept="image/*">
                                        <label class="tf-field-label fw-4 text_black-2" for="property6">Image</label>
                                    </div>
                                    <h6 class="mb_20">Password Change</h6>
                                    <div class="tf-field style-1 mb_30">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password" id="property7" name="current-password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property7">Current password</label>
                                    </div>
                                    <div class="tf-field style-1 mb_30">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password" id="property8" name="new-password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property8">New password</label>
                                    </div>
                                    <div class="tf-field style-1 mb_30">
                                        <input class="tf-field-input tf-input" placeholder=" " type="password" id="property9" name="confirm-password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property9">Confirm password</label>
                                    </div>
                                    <div class="mb_20">
                                        <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        <?php include 'app/Views/Users/layouts/footer.php' ?>

        <!-- /Footer -->
        
    </div>
     


    <!-- gotop -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;"></path>
        </svg>
    </div>
    <!-- /gotop -->



    <!-- Javascript -->
    <script type="text/javascript" src="assets/Users/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/carousel.js"></script>
    <script type="text/javascript" src="assets/Users/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/lazysize.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/count-down.js"></script>
    <script type="text/javascript" src="assets/Users/js/wow.min.js"></script>
    <script type="text/javascript" src="assets/Users/js/multiple-modal.js"></script>
    <script type="text/javascript" src="assets/Users/js/main.js"></script>
</body>


<!-- Mirrored from themesflat.co/html/ecomus/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Nov 2024 14:42:11 GMT -->
</html>