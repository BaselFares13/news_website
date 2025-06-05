<!DOCTYPE html>
<html lang="en" dir="rtl">
<?php 
    include_once "classes/clsNewsItem.php";
    include_once "classes/clsComment.php";
    include_once "classes/clsAd.php";

    $newItem_id = -1;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $newItem_id = (int)$_GET["id"];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newItem_id = (int)$_GET["id"];
        if(isset($_POST["username"]) && isset($_POST["comment"])) {
            $commentObj = new Comment();
            $username = $_POST["username"] == ""? "غير معروف" : $_POST["username"];
            try {
                $commentObj->insertComment($newItem_id, $username, $_POST["comment"]);
            } catch(Exception $e) {
                echo "
                    <div dir='ltr' class='alert alert-primary' role='alert'>
                        $e
                    </div>
                ";
            } 
        }
    }

    $newsObj = new NewsItem();
    $newsItem = $newsObj->getNewsItem($newItem_id);
    $newsObj->updateReadersCountForNewsItem($newItem_id);
    $newsItemTitle = $newsItem["title"];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo "<title>$newsItemTitle</title>";?>
    <!--The Used Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lateef:wght@200;300;400;500;
                            600;700;800&family=Scheherazade+New:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--Bootstrap css file-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Icons Link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!--My Css File-->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="scheherazade-new-regular">

    <!--Start Nav Bar-->
    <?php
        include_once "header.php";
    ?>
    <!--End Nav Bar-->

    <!--Start Detailed News-->
    <main class="detailed-news container mt-7">
        <div class="row">
            <article class="col-lg-8">
                <div class="introduction">
                    <?php 
                        $categoryName = $newsItem["category_name"];
                        $newsItemDate = (new DateTime($newsItem["dateposted"]))->format('Y-m-d');
                        echo "
                            <span class='news-category'>$categoryName</span>
                            <h2 class='news-title scheherazade-new-bold mb-0'>
                                $newsItemTitle
                            </h2>
                            <div class='date'>
                                <i class='fa-solid fa-calendar-week'></i>
                                <span class='me-1'>$newsItemDate</span>
                            </div>
                        ";
                    ?>
                    <div class="share row mt-3">
                        <p class="col-4 scheherazade-new-bold mb-0">شارك القصة</p>
                        <div class="col-8">
                            <ul class="row w-fc me-auto">
                                <li class="col">
                                    <a class="me-auto" href="https://www.facebook.com"><i
                                            class="fa-brands fa-facebook fs-4"></i></a>
                                </li>
                                <li class="col">
                                    <a href="https://www.x.com"><i class="fa-brands fa-square-x-twitter fs-4"></i></a>
                                </li>
                                <li class="col">
                                    <a href="https://www.instagram.com"><i
                                            class="fa-brands fa-square-instagram fs-4"></i></a>
                                </li>
                                <li class="col">
                                    <a href="https://mail.google.com"><i
                                            class="fa-solid fa-square-share-nodes fs-4"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                    $newsItemImage = $newsItem["image"];
                    $newsItemText = nl2br($newsItem["body"]);

                    echo "
                        <div class='image'>
                            <img src='$newsItemImage' alt='news-image'>
                        </div>
                        <div class='text fs-4 mt-4'>
                            $newsItemText
                        </div>
                    ";
                ?>
                <div class="comments mt-5 mb-5">
                    <div class="main-title-container">
                        <h4 class="main-title scheherazade-new-bold m-0 pb-2">التعليقات</h4>
                    </div>
                    <?php 
                        echo "
                            <form class='mb-3 mt-3' action='details.php?id=$newItem_id' method='post'>
                                <div class='form-group'>
                                    <label for='username'>الإسم</label>
                                    <input type='text' class='form-control' id='username' name='username' placeholder='ادخل الإسم'>
                                </div>
                                <div class='form-group mt-2'>
                                    <label for='comment'>التعليق</label>
                                    <input type='text' class='form-control' id='comment' name='comment' placeholder='اكتب تعليق' required>
                                </div>
                                <button type='submit' name='submit' class='btn btn-primary mt-3'>علق</button>
                            </form>
                        ";
                    ?>
                    <hr>
                    <?php 
                        echo "<div style='height: 300px;' id='comment_sections' class='sections overflow-auto' data-newsItemId=$newItem_id>";
                        
                            $commentObj = new Comment();
                            $comments = $commentObj->getCommnetForNewsItem($newItem_id);
                            
                            foreach($comments as $comment) {
                                $username = $comment["user_name"];
                                $text = $comment["comment_text"];
                                $date = (new DateTime($comment["date_posted"]))->format('Y-m-d');

                                echo "
                                    <div class='section border-bottom'>
                                        <div class='mt-4 mb-4'>
                                            <h5 class='scheherazade-new-bold m-0'>$username:</h5>
                                            <p>$date</p>
                                            <p class='title col d-flex align-items-center'>
                                                $text
                                            </p>
                                        </div>
                                    </div>
                                ";
                            }
                        
                        echo '<div/>';
                    ?>
                </div>
            </article>
            <aside class="col-lg-4">
                <div class="more-from-category mt-5 mt-lg-7">
                    <div class="main-title-container">
                        <?php 
                            echo "<h4 class='main-title scheherazade-new-bold m-0 pb-2'>المزيد من ال$categoryName</h4>";
                        ?>
                    </div>
                    <div class="sections">
                        <?php
                            $someNews = $newsObj->getLatestNewsFromCategory($newsItem["category_id"], true, 4);

                            foreach($someNews as $newsItem1) {
                                $newsItem1Id = $newsItem1["news_id"];
                                if($newsItem1Id != $newItem_id) {
                                    $newsItem1Title = $newsItem1["title"];
                                    echo "
                                        <div class='section row border-bottom'>
                                            <a href='details.php?id=$newsItem1Id'>
                                                <h6 class='title col-10 d-flex align-items-center scheherazade-new-bold mt-4 mb-4'>
                                                    $newsItem1Title
                                                </h6>
                                            </a>
                                        </div>
                                    ";
                                }
                            
                            }
                        ?>
                    </div>
                </div>
                <div style="margin-top: 150px;" class="p-1">
                    <?php 
                        $ad = new Ad();
                        $ad_image = $ad->getAd()["ad_image_path"];
                        echo "<img src='$ad_image' alt='Ad_Image'>"
                    ?>
                </div>
            </aside>
        </div>
    </main>
    <!--End Detailed News-->

    <!-- Start Footer-->
    <?php 
        include "footer.php";
    ?>
    <!--End Footer -->

    <!--Async Comments-->
    <script src="js/async_comments.js"></script>
    <!--Bootstrap js file-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>