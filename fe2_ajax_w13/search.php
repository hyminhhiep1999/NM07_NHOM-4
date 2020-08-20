<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$q = $_GET['q'];
$productModel = new ProductModel();
$items = $productModel->searchProduct($q);
echo json_encode($items);