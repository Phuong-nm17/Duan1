<?php

if (isset($_GET["act"])) {
    $act = $_GET["act"];
    switch ($act) {
        case 'contact':
            include "view/contact.php";
            break;
        case 'register':
            include "view/register.php";
            break;
        case 'cart':
            include "view/cart.php";
            break;
        case 'ProductList':
            include "view/ProductList.php";
            break;
        case 'ProductDetail':
            include "view/ProductDetail.php";
            break;
        default:
            include "view/home.php";
    }
} else {
    include "view/header.php";
    include "view/home.php";
}

// include "view/footer.php";
