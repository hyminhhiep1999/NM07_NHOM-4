<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$input = json_decode(file_get_contents('php://input'), true);

$productId = $input['productId'];
$commentContent = $input['commentContent'];
$commentRate = $input['commentRate'];
$firstTime = $input['firstTime'];

$commentModel = new CommentModel();
if (!$firstTime) {
    $result = $commentModel->addComment($productId, $commentContent, $commentRate);
}

$items = $commentModel->getCommentByProductId($productId);
echo json_encode($items);