<?php
class CommentModel extends Db
{
    //Lấy comment theo product id
    public function getCommentByProductId($productId)
    {
        $sql = parent::$connection->prepare('SELECT * FROM comments WHERE product_id=?');
        $sql->bind_param('i', $productId);
        return parent::select($sql);
    }


    //Thêm comment
    public function addComment($productId, $commentContent, $commentRate)
    {
        $sql = parent::$connection->prepare('INSERT INTO `comments` (`product_id`, `comment_content`, `comment_rate`) VALUES (?, ?, ?)');
        $sql->bind_param('isi', $productId, $commentContent, $commentRate);
        return $sql->execute();
    }
}
