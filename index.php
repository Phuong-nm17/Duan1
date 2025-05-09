<?php

if (isset($_GET["act"])) {
    $act = $_GET["act"];
    switch ($act) {
        case 'contact':
            include "view/contact.php";
            break;
        case 'orderconfirm':
            include "view/order_confirmation.php";
            break;
        case 'home':
            include "view/header.php";
            include "view/home.php";
            include "view/footer.php";
            break;
        case 'register':
            include "view/register.php";    
            break;
        case 'login':
            include "view/login.php";
            break;
        case 'forgot_password':
            include "view/forgot_password.php";
            break;

        case 'change_password':
            include "view/change_password.php";
            break;
        case 'profile':
            include "view/profile.php";
            break;
        case 'orders':
            include "view/orders.php";
            break;

        case 'reset_password':
            include "view/reset_password.php";
            break;
        case 'Logout':
            include "view/Logout.php";
            break;
        case 'cart':
            include "view/cart.php";
            break;
        case 'cate':
            include "view/cate.php";
            break;
        case 'ProductList':
            include "view/ProductList.php";
            include "view/footer.php";
            break;
        case 'ProductDetail':
            include "view/ProductDetail.php";
            include "view/footer.php";
            break;
        case 'checkout':
            include "view/checkout.php";
            break;
        default:
            include "view/home.php";
    }
} else {
    include "view/header.php";
    include "view/home.php";
    include "view/footer.php";
}
