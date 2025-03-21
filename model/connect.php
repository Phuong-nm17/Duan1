<?php
$host = 'localhost';//Hosting
$db_name = 'dan1';//Tên của database
$db_user = 'root';//User truy cập mysql
$db_pass = '';//pass truy cập mysql
try{
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
    // echo 'Kết nối thành công.................';
}catch(Exception $e){
    echo 'Lỗi kết nối'. $e->getMessage();
}