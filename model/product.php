<?php
class Product {
    private $conn;

    public function __construct() {
        include('Connect.php');
        $this->conn = $conn;
    }

    public function getAll() {
        $sql = 'SELECT * FROM product';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function get_filtered_products($keyword, $min_price, $max_price) {
        $sql = "SELECT * FROM product WHERE title LIKE ? AND price BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        $kw = "%$keyword%";
        $stmt->execute([$kw, $min_price, $max_price]);
        return $stmt->fetchAll();
    }
}