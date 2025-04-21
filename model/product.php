<?php
class Product
{
    private $conn;
    public function __construct()
    {
        include('Connect.php');
        $this->conn = $conn;
    }
    public function getAll()
    {
        $sql = 'SELECT * FROM product';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
