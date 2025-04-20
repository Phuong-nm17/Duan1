<?php
class DashboardController {

    public function myAccount(){
        include 'app/Views/Users/myaccount.php';
    }

    public function accountDetal(){
        $userModel = new UserModel2();
        $user= $userModel->getCurrenUser();
        include 'app/Views/Users/account-detal.php';
    }

    public function accountUpdate(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->changePassword();
            $userModel = new UserModel2();
            $user = $userModel->getCurrenUser();

            //Them anh
            $uploadDir = 'assets/Admin/upload/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $destPath = $user->image;

            if(!empty($_FILES['image']['name'])){
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileType = mime_content_type($fileTmpPath);
                $fileName = basename($_FILES['image']['name']);
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $newFileName = uniqid() . '.' . $fileExtension;
                if(in_array($fileType, $allowedTypes)){
                    $destPath = $uploadDir . $newFileName;
                    if(!move_uploaded_file($fileTmpPath, $destPath)){
                        $destPath = "";
                    }
                    //xóa ảnh cũ
                    unlink($user->image);
                }
            }

            $userModel = new UserModel2();
            $message = $userModel->updateCurrentUser($destPath);


            if($message){
                $_SESSION['message'] = "Cập nhật thành công!";
                header("Location: " . BASE_URL . "?act=account-detal");
                exit;
            }else{
                $_SESSION['message'] = "Cập nhật không thành công!";
                header("Location: " . BASE_URL . "?act=account-detal");
                exit;
            }
        }
    }

    public function changePassword(){
        if(
            $_POST['current-password'] != "" &&
            $_POST['new-password'] != "" &&
            $_POST['confirm-password'] != "" &&
            $_POST['new-password'] == $_POST['confirm-password']
        ){
            $userModel = new UserModel2();
            $userModel->changePassword();

        }
    }

    // public function writeReview() {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $productModel = new ProductUserModel();
    //         $productModel->saveRating();
    //         $categoryId = $productModel->saveComment(); // Lấy category_id từ saveComment
    
    //         // Kiểm tra và chuyển hướng
    //         if ($categoryId !== false) {
    //             $productId = $_POST['productId'];
    //             header("Location: " . BASE_URL . "?act=product-detail&product_id=" . $productId . "&category_id=" . $categoryId);
    //             exit();
    //         } else {
    //             echo "Không thể lấy được category_id.";
    //         }
    //     }
        // }
    }