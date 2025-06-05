<?php 

    include_once "classes/clsComment.php";

    if(isset($_GET['id'])) {
        $news_id = (int)$_GET['id'];
        $comments = [];

        if ($news_id > 0) {
            $commentObj = new Comment();
            $comments = $commentObj->getCommnetForNewsItem($news_id);
        }

        echo json_encode($comments);
    }
?>