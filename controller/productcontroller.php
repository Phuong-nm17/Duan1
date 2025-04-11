<?php
class ProductController
{
    private $model_product;
    public function __construct()
    {
        require_once('model/product.php');
        $this->model_product = new Product(); //Khởi tạo model product
    }
    public function listing()
    {
        $arr_products = $this->model_product->getAll();
        //print_r($arr_products);die();//debug dữ liệu
        include('views/listing.php');
    }
}
