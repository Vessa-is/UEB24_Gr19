<?php
require_once 'Product.php';
class DigitalProduct extends Product {
    private $fileSize;
    private $downloadLink;
    public function __construct($id, $imgurl, $name, $price, $stock, $fileSize, $downloadLink) {
        parent::__construct($id, $imgurl, $name, $price, $stock);
        $this->fileSize = $fileSize;
        $this->downloadLink = $downloadLink;
    }
    public function getFileSize() {
        return $this->fileSize;
    }

    public function setFileSize($fileSize) {
        $this->fileSize = $fileSize;
    }
    public function getDownloadLink() {
        return $this->downloadLink;
    }

    public function setDownloadLink($downloadLink) {  
        $this->downloadLink = $downloadLink;
    }
}
?>



