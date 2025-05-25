<?php
class Product {
    private $id;
    private $imgurl;
    private $name;
    private $price;
    private $stock;
    
    function __construct($id, $imgurl, $name, $price, $stock) {
        $this->id = $id;
        $this->imgurl = $imgurl;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function __destruct() {
      
    }

    public function decreaseStock($quantity) {
        if ($quantity <= $this->stock) {
            $this->stock -= $quantity; 
            return true;
        }
        return false; 
    }

    function getId() {
        return $this->id;
    }

    public function setImgUrl($imgurl) {
        $this->imgurl = $imgurl;
    }

    function getImgUrl() {
        return $this->imgurl;
    }

    public function setName($name) {
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    function getPrice() {
        return $this->price;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    function getStock() {
        return $this->stock;
    }

    public function displayInfo() {
        echo "ID: " . $this->id . "<br>";
        echo "Name: " . $this->name . "<br>";
        echo "Price: $" . $this->price . "<br>";
        echo "Stock: " . $this->stock . "<br>";
        echo "Image URL: " . $this->imgurl . "<br>";
    }
}
?>
