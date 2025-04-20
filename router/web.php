<?php

$role = isset($_GET['role']) ? $_GET['role'] : "user";
$act = isset($_GET['act']) ? $_GET['act'] : "";

if($role == "user"){
    switch($act){
        
        case 'my-account'; {
            $dashBoardController = new DashboardController();
            $dashBoardController->myAccount();
            break;
        }

        case 'account-detal'; {
            $dashBoardController = new DashboardController();
            $dashBoardController->accountDetal();
            break;
        }

        case 'account-update'; {
            $dashBoardController = new DashboardController();
            $dashBoardController->accountUpdate();
            break;
        }

    }
}else{
    switch($act){
        //http://localhost/duan1/?role=admin&act=home
    }
}