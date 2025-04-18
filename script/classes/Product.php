<?php
class Product{
    private $id;
    private $imgurl;
    private $name;
    private $price;
    private $stock;
    
    function __construct($id, $imgurl, $name, $price, $stock){
        $this->id = $id;
        $this->imgurl = $imgurl;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }
    public function __destruct(){
        public function getId(){
            return $this->id;
        }
    
    
    
    function getId(){
        return $this->id;
    }

    public function setImgUrl($imgurl){
        $this->imgurl = $imgurl;
    }

    function getImgUrl(){
        return $this->imgurl;
    }

    public function setName($name){
        $this->name = $name;
    }

    function getName(){
        return $this->name;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    function getPrice(){
        return $this->price;
    }

    public function setStock($stock){
        $this->stock = $stock;
    }

    function getStock(){
        return $this->stock;
    }

function setSttock($stock){
    $this->stock = $stock;
}

}

?>