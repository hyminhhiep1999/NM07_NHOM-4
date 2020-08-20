<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getCategoryList();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <!-- Chi tiet san pham -->
            <div class="col-md-4">
                <h3>Danh muc</h3>
                <ul style="list-style: none;">
                <?php
                foreach ($categoryList as $item) {
                ?>
                <li>
                    <input type="checkbox" id="<?php echo $item['category_id']; ?>" value="<?php echo $item['category_id']; ?>"/>
                    <label for="<?php echo $item['category_id']; ?>"><?php echo $item['category_name']; ?></label>
                </li>                    
                <?php
                }
                ?>
                </ul>
                <input type="text" name="q" id="q" class="form-control" placeholder="Search...">
                <ul id="search-result"></ul>
            </div>

            <!-- Danh sach san pham -->
            <div class="col-md-8">
                <div id="result">
                </div>
                <button class="btn btn-primary" id="btn-loadmore">Load more</button>
                    
            </div>
        </div>
    </div>
    <div class="mymodal">
        <div class="bg-black" onclick="modalClose()"></div>
        <div class="mymodal-body">
        </div>
    </div>
    
    <script src="/<?php echo BASE_URL; ?>/public/js/ajax.js"></script>
    <script src="/<?php echo BASE_URL; ?>/public/js/autocomplete.js"></script>
</body>
</html>