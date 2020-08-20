<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$input = json_decode(file_get_contents('php://input'), true);
// Danh mục được chọn:
$categoriesCheckedId = $input['categoriesChecked'];

// Số trang hiện tại:
$currentPage = isset($input['currentPage']) ? (int)$input['currentPage'] : 1;
// Số sản phẩn mỗi trang:
$perpage = isset($input['perPage']) ? (int)$input['perPage'] : 2;;

$productModel = new ProductModel();

$items = [];
if ($categoriesCheckedId == []) {
    $items = $productModel->getProductListPage($perpage, $currentPage);
}
else {
    $items = $productModel->getProductByNCategories($categoriesCheckedId, $perpage, $currentPage);
}
echo json_encode($items);