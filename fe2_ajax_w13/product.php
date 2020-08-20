<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$path = explode('-', $_SERVER['REQUEST_URI']);
$id = $path[count($path) - 1];

$productModel = new ProductModel();
$item = $productModel->getProductById($id);

$categoryModel = new CategoryModel();
$categoryList = $categoryModel->getCategoryList();

// $commentModel = new CommentModel();
// $items = $commentModel->getCommentByProductId($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/public/css/font-awesome-4.7.0/css/font-awesome.min.css">
    <style>
        .fa-star {
            color: #888;
            margin-right: 5px;
            cursor: pointer;
        }

        .rate {
            color: gold;
        }

        /* .fa-star:hover {
            color: gold;
        } */
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/<?php echo BASE_URL; ?>/">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                foreach ($categoryList as $cat) {
                    $catName = strtolower(str_replace(' ', '-', $cat['category_name']));
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo BASE_URL; ?>/category.php/<?php echo $catName . '-' . $cat['category_id'] ?>"><?php echo $cat['category_name'] ?></a>
                </li>
                <?php
                }
                ?>

            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="/<?php echo BASE_URL ?>/result.php">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" name="keyword">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- Hiển thị chi tiết sản phẩm-->
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/<?php echo BASE_URL; ?>/public/images/<?php echo $item['product_image'] ?>" alt="" class="img-fluid">
            </div>
            <div class="col-md-10">
                <h4><?php echo $item['product_name']; ?></h4>
                <p><?php echo $item['product_price']; ?></p>
                <p><?php echo $item['product_description']; ?></p>
            </div>
        </div>
        <div class="mb-3">
            <label for="rating">Rate:</label>
            <ul id="rating" style="list-style:none; padding-left:0; display:flex;margin-bottom: 5px;">
                <li>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </li>
                <li>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </li>
                <li>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </li>
                <li>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </li>
                <li>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </li>
            </ul>
            <label for="validationTextarea">Comment:</label>
            <textarea class="form-control" id="validationTextarea" placeholder="Required example textarea" required></textarea>
            <button class="btn btn-primary px-4 mt-2" id="btnPost">Post</button>
        </div>
        <ul id="commentArea">
            <!-- <?php
            foreach ($items as $item) {
            ?>
                <li><?php echo $item['comment_rate']; ?> - <?php echo $item['comment_content']; ?></li>
            <?php
            }
            ?> -->
        </ul>
    </div>
    <script>
        const productId = <?php echo $id; ?>;
		const baseUrl = '<?php echo BASE_URL; ?>';
    </script>
    <script src="/<?php echo BASE_URL; ?>/public/js/comment.js"></script>
</body>
</html>