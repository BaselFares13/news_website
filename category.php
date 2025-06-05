<!DOCTYPE html>
<html lang="en" dir="rtl">
<?php 
    include_once "classes/clsNewsItem.php";
    include_once "classes/clsCategory.php";

    $category = new Category();
    $category_id = -1;

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $category_id = $_GET["id"];
    }

    $newsItem = new NewsItem();
    $news = $newsItem->getLatestNewsFromCategory($category_id, true);
    $category_name = $category->getCategoryName($category_id);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        echo "<title>$category_name</title>" ;
    ?>
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

    <!--Start Important News-->
    <div class="important-news container mt-6 pt-5">
        <div class="main-title-container">
            <?php 
                echo "<h2 class='main-title scheherazade-new-bold m-0 pb-2'>$category_name</h2>" 
            ?>
        </div>
        <div class="row mt-4">
            <div class="right-side col-lg-8 mb-4">
                <?php
                    if(count($news) > 0) {
                        $newsItem1 = $news[0];
                        $newsItem1Id = $newsItem1["news_id"]; 
                        $newsItem1Image = $newsItem1["image"]; 
                        $newsItem1Title = $newsItem1["title"];
                        $newsItem1CategoryName = $newsItem1["category_name"];
                        $newsItem1IntroText = mb_substr($newsItem1["body"], 0, 180, "UTF-8");
                
                        echo "<div class='news-card h-100 w-100 mb-3'>
                            <div class='image'>
                                <img src='$newsItem1Image' alt='news-image'>
                            </div>
                            <div class='text ps-3 pe-3 mt-3 mb-3'>
                                <span class='news-category'>$newsItem1CategoryName</span>
                                <a href='details.php?id=$newsItem1Id'>
                                    <h5 class='news-title scheherazade-new-bold m-0 text-decoration-underline mb-2'>
                                        $newsItem1Title
                                    </h5>
                                </a>
                                <p class='news-text-sample m-0'>$newsItem1IntroText...</p>
                            </div>
                        </div>";
                    }
                ?>
            </div>
            <div class="left-side col-lg-4">
                <?php 
                    if(count($news) > 1) {
                        $newsItem2 = $news[1];
                        $newsItem2Id = $newsItem2["news_id"]; 
                        $newsItem2Image = $newsItem2["image"]; 
                        $newsItem2Title = $newsItem2["title"];
                        $newsItem2CategoryName = $newsItem2["category_name"];
                
                        echo "
                            <div class='news-card row mb-3'>
                                <div class='image'>
                                    <img src='$newsItem2Image' alt='news-image'>
                                </div>
                                <div class='text mt-3 mb-3 ps-3 pe-3'>
                                    <span class='news-category'>$newsItem2CategoryName</span>
                                    <a href='details.php?id=$newsItem2Id'>
                                        <h6 class='news-title scheherazade-new-bold mb-2'>
                                            $newsItem2Title
                                        </h6>
                                    </a>
                                </div>
                            </div>
                        ";
                    }

                    for($i = 2; $i < 4; $i++) {
                        if(count($news) > $i) {
                            $newsItem3 = $news[$i];
                            $newsItem3Id = $newsItem3["news_id"];
                            $newsItem3Image = $newsItem3["image"]; 
                            $newsItem3Title = $newsItem3["title"];
                            $newsItem3CategoryName = $newsItem3["category_name"];
                            
                            echo "
                                <div class='news-card row mb-3'>
                                    <div class='image col-lg'>
                                        <img src='$newsItem3Image' alt='news-image'>
                                    </div>
                                    <div class='col-lg text mt-3 mb-3 m-lg-auto ps-3 pe-3'>
                                        <span class='news-category'>$newsItem3CategoryName</span>
                                        <a href='details.php?id=$newsItem3Id'>
                                            <h6 class='news-title scheherazade-new-bold mb-2'>
                                                $newsItem3Title
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            ";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <!--End Important News-->

    <!--Start The Rest Of News-->
    <div class="rest-news container mt-2">
        <?php
            for($i = 4; $i < count($news); $i++) {
                $newsItem4 = $news[$i];
                $newsItem4Id = $newsItem4["news_id"];
                $newsItem4Image = $newsItem4["image"]; 
                $newsItem4Title = $newsItem4["title"];
                $newsItem4CategoryName = $newsItem4["category_name"];
                $newsItem4IntroText = mb_substr($newsItem1["body"], 0, 180, "UTF-8");

                echo "
                    <div class='news-card row mb-3'>
                        <div class='image col-lg-3'>
                            <img src='$newsItem4Image' alt='news-image'>
                        </div>
                        <div class='col-lg-9 text mt-3 mb-3 m-lg-auto ps-3 pe-3'>
                            <span class='news-category'>$newsItem4CategoryName</span>
                            <a href='details.php?id=$newsItem4Id'>
                                <h6 class='news-title scheherazade-new-bold mb-2'>
                                    $newsItem4Title
                                </h6>
                            </a>
                            <p class='news-text-sample m-0'>$newsItem4IntroText...</p>
                        </div>
                    </div>
                ";
            }
        ?>

    </div>
    <!--End The Rest Of News-->

    <!--Start Footer-->
    <?php 
        include "footer.php";
    ?>

    <!--End Footer-->

    <!--Bootstrap js file-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>