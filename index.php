<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرئيسية</title>
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
        include_once "classes/clsNewsItem.php";
    ?>
    <!--End Nav Bar-->

    <!--Start Latest News-->
    <div class="latest-news container mt-6 pt-5">
        <div class="row">
            <div class="right-side col-lg-6 mb-4">
                <?php
                    $newsItem = new NewsItem();
                    $allNews = $newsItem->getLatestNews(5, true);
                    
                    if(count($allNews) > 0) {
                        $firstNewsItem = $allNews[0];
                        $firstNewsItemId = $firstNewsItem["news_id"];
                        $firstNewsItemImage = $firstNewsItem["image"]; 
                        $firstNewsItemCategory = $firstNewsItem["category_name"]; 
                        $firstNewsItemTitle = $firstNewsItem["title"]; 
                        $firstNewsItemIntroText = mb_substr($firstNewsItem["body"], 0, 180, "UTF-8");

                        echo "
                            <div class='news-card focus h-100 w-100'>
                                <div class='image'>
                                    <img src='$firstNewsItemImage' alt='news-image'>
                                </div>
                                <div class='text pt-3 ps-3 pe-3 pb-4'>
                                    <span class='news-category'>$firstNewsItemCategory</span>
                                    <a href='details.php?id=$firstNewsItemId'>
                                        <h5 class='news-title scheherazade-new-bold m-0 text-decoration-underline mb-2'>
                                            $firstNewsItemTitle
                                        </h5>
                                    </a>
                                    <p class='news-text-sample m-0'>$firstNewsItemIntroText...</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="left-side col-lg-6">
                <div class="row row-cols-md-2">
                    <?php 
                        for($i = 1; $i < count($allNews); $i++) {
                            $NewsItem = $allNews[$i];
                            $NewsItemId = $NewsItem["news_id"];
                            $NewsItemImage = $NewsItem["image"]; 
                            $NewsItemCategory = $NewsItem["category_name"]; 
                            $NewsItemTitle = $NewsItem["title"]; 

                            echo "
                                <div class='news-card col-md'>
                                    <div class='image'>
                                        <img src='$NewsItemImage' alt='news-image'>
                                    </div>
                                    <div class='text pt-2 ps-2 pe-2 pb-4'>
                                        <span class='news-category'>$NewsItemCategory</span>
                                        <a href='details.php?id=$NewsItemId'>
                                            <h6 class='news-title scheherazade-new-bold mb-2'>
                                                $NewsItemTitle
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            ";
                        
                        }
                        
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Latest News-->

    <!--Start Featured News-->
    <div class="featured-news container mt-5">
        <div class="row">
            <div class="most-commented col-lg-6 mb-5 ps-4 pe-4">
                <div class="main-title-container">
                    <h4 class="main-title scheherazade-new-bold m-0 pb-2">الأكثر تعليقا</h4>
                </div>
                <div class="sections">
                    <?php 
                        $TopCommentedNewsObj = new NewsItem();
                        $TopCommentedNews = $TopCommentedNewsObj->getTopCommentedNews(5);

                        $num = 1;
                        foreach($TopCommentedNews as $newsItem) {
                            $newsItemId = $newsItem["id"];
                            $newsItemTitle = $newsItem["title"];

                            echo "
                                <div class='section row border-bottom'>
                                    <h6 class='title col-10 d-flex align-items-center scheherazade-new-bold mt-4 mb-4'>
                                        <a href='details.php?id=$newsItemId'>$newsItemTitle</a>
                                    </h6>
                                    <span class='col-2 text-start fs-1 fw-bold text-light-gray mt-3 mb-3'>$num</span>
                                </div>
                            ";
                            $num++;
                        }
                    ?> 
                </div>
            </div>
            <div class="most-read col-lg-6 mb-5 ps-4 pe-4">
                <div class="main-title-container">
                    <h4 class="main-title scheherazade-new-bold m-0 pb-2">الأكثر قراءة</h4>
                </div>
                <div class="sections">
                    <?php 
                        $TopReadNewsObj = new NewsItem();
                        $TopReadNews = $TopReadNewsObj->getTopReadNews(5);

                        $num = 1;
                        foreach($TopReadNews as $newsItem) {
                            $newsItemId = $newsItem["id"];
                            $newsItemTitle = $newsItem["title"];

                            echo "
                                <div class='section row border-bottom'>
                                    <h6 class='title col-10 d-flex align-items-center scheherazade-new-bold mt-4 mb-4'>
                                        <a href='details.php?id=$newsItemId'>$newsItemTitle</a>
                                    </h6>
                                    <span class='col-2 text-start fs-1 fw-bold text-light-gray mt-3 mb-3'>$num</span>
                                </div>
                            ";
                            $num++;
                        }
                    ?> 
                </div>
            </div>
        </div>
    </div>
    <!--End Featured News-->

    <!--Start Politics Section-->
    <div class="politics-section container mt-5">
        <div class="main-title-container row justify-content-between ms-0 me-0">
            <h4 class="main-title scheherazade-new-bold m-0 pb-2 col-10 pe-0 ps-0">سياسة</h4>
            <a href="#" class="col-2 text-start customize-anchor d-flex justify-content-end align-items-end">المزيد</a>
        </div>
        <div class="row mt-4">
            <div class="right-side col-lg-6 mb-4">
                <?php 
                    $newsItem = new NewsItem();
                    $allPoliticsNews= $newsItem->getLatestNewsFromCategory(1, true,5);

                    if(count($allPoliticsNews) > 0) {
                        $firstPoliticsNewsItem = $allPoliticsNews[0];
                        $firstPoliticsNewsItemId = $firstPoliticsNewsItem["news_id"];
                        $firstPoliticsNewsItemImage = $firstPoliticsNewsItem["image"]; 
                        $firstPoliticsNewsItemCategory = $firstPoliticsNewsItem["category_name"]; 
                        $firstPoliticsNewsItemTitle = $firstPoliticsNewsItem["title"]; 
                        $fitstPoliticsNewsItemIntroText = mb_substr($firstPoliticsNewsItem["body"], 0, 180, "UTF-8");
                        
                        echo "
                            <div class='news-card h-100 w-100'>
                                <div class='image'>
                                    <img src='$firstPoliticsNewsItemImage' alt='news-image'>
                                </div>
                                <div class='text pt-3 ps-3 pe-3 pb-4'>
                                    <span class='news-category'>$firstPoliticsNewsItemCategory</span>
                                    <a href='details.php?id=$firstPoliticsNewsItemId'>
                                        <h5 class='news-title scheherazade-new-bold m-0 text-decoration-underline mb-2'>
                                            $firstPoliticsNewsItemTitle
                                        </h5>
                                    </a>
                                    <p class='news-text-sample m-0'>$fitstPoliticsNewsItemIntroText...</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="left-side col-lg-6">
                <div class="row row-cols-md-2">
                    <?php 
                        for($i = 1; $i < count($allPoliticsNews); $i++) {
                            $PoliticsNewsItem = $allPoliticsNews[$i];
                            $PoliticsNewsItemId = $PoliticsNewsItem["news_id"];
                            $PoliticsNewsItemImage = $PoliticsNewsItem["image"]; 
                            $PoliticsNewsItemCategory = $PoliticsNewsItem["category_name"]; 
                            $PoliticsNewsItemTitle = $PoliticsNewsItem["title"]; 

                            echo "
                                <div class='news-card'>
                                    <div class='image'>
                                        <img src='$PoliticsNewsItemImage' alt='news-image'>
                                    </div>
                                    <div class='text pt-2 ps-2 pe-2 pb-4'>
                                        <span class='news-category'>$PoliticsNewsItemCategory</span>
                                        <a href='details.php?id=$PoliticsNewsItemId'>
                                            <h6 class='news-title scheherazade-new-bold mb-2'>
                                                $PoliticsNewsItemTitle
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            ";
                        
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Politics Section-->

    <!--Start Economy Section-->
    <div class="economy-section container mt-5">
        <div class="main-title-container row justify-content-between ms-0 me-0">
            <h4 class="main-title scheherazade-new-bold m-0 pb-2 col-10 pe-0 ps-0">اقتصاد</h4>
            <a href="category.html"
                class="col-2 text-start customize-anchor d-flex justify-content-end align-items-end">المزيد</a>
        </div>
        <div class="row mt-4">
            <div class="right-side col-lg-6 mb-4">
                <?php 
                    $newsItem = new NewsItem();
                    $allEconomyNews= $newsItem->getLatestNewsFromCategory(3, true,5);

                    if(count($allEconomyNews) > 0) {
                        $firstEconomyNewsItem = $allEconomyNews[0];
                        $firstEconomyNewsItemId = $firstEconomyNewsItem["news_id"];
                        $firstEconomyNewsItemImage = $firstEconomyNewsItem["image"]; 
                        $firstEconomyNewsItemCategory = $firstEconomyNewsItem["category_name"]; 
                        $firstEconomyNewsItemTitle = $firstEconomyNewsItem["title"]; 
                        $fitstEconomyNewsItemIntroText = mb_substr($firstEconomyNewsItem["body"], 0, 180, "UTF-8");
                        
                        echo "
                            <div class='news-card h-100 w-100'>
                                <div class='image'>
                                    <img src='$firstEconomyNewsItemImage' alt='news-image'>
                                </div>
                                <div class='text pt-3 ps-3 pe-3 pb-4'>
                                    <span class='news-category'>$firstEconomyNewsItemCategory</span>
                                    <a href='details.php?id=$firstEconomyNewsItemId'>
                                        <h5 class='news-title scheherazade-new-bold m-0 text-decoration-underline mb-2'>
                                            $firstEconomyNewsItemTitle
                                        </h5>
                                    </a>
                                    <p class='news-text-sample m-0'>$fitstEconomyNewsItemIntroText...</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="left-side col-lg-6">
                <div class="row row-cols-md-2">
                    <?php 
                        for($i = 1; $i < count($allEconomyNews); $i++) {
                            $EconomyNewsItem = $allEconomyNews[$i];
                            $EconomyNewsItemId = $EconomyNewsItem["news_id"];
                            $EconomyNewsItemImage = $EconomyNewsItem["image"]; 
                            $EconomyNewsItemCategory = $EconomyNewsItem["category_name"]; 
                            $EconomyNewsItemTitle = $EconomyNewsItem["title"]; 

                            echo "
                                <div class='news-card'>
                                    <div class='image'>
                                        <img src='$EconomyNewsItemImage' alt='news-image'>
                                    </div>
                                    <div class='text pt-2 ps-2 pe-2 pb-4'>
                                        <span class='news-category'>$EconomyNewsItemCategory</span>
                                        <a href='details.php?id=$EconomyNewsItemId'>
                                            <h6 class='news-title scheherazade-new-bold mb-2'>
                                                $EconomyNewsItemTitle
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            ";
                        
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Economy Section-->

    <!--Start Sport Section-->
    <div class="sport-section container mt-5">
        <div class="main-title-container row justify-content-between ms-0 me-0">
            <h4 class="main-title scheherazade-new-bold m-0 pb-2 col-10 pe-0 ps-0">رياضة</h4>
            <a href="#" class="col-2 text-start customize-anchor d-flex justify-content-end align-items-end">المزيد</a>
        </div>
        <div class="row mt-4">
            <div class="right-side col-lg-6 mb-4">
                <?php 
                    $newsItem = new NewsItem();
                    $allSportNews= $newsItem->getLatestNewsFromCategory(4, true,5);

                    if(count($allSportNews) > 0) {
                        $firstSportNewsItem = $allSportNews[0];
                        $firstSportNewsItemId = $firstSportNewsItem["news_id"];
                        $firstSportNewsItemImage = $firstSportNewsItem["image"]; 
                        $firstSportNewsItemCategory = $firstSportNewsItem["category_name"]; 
                        $firstSportNewsItemTitle = $firstSportNewsItem["title"]; 
                        $fitstSportNewsItemIntroText = mb_substr($firstSportNewsItem["body"], 0, 180, "UTF-8");
                        
                        echo "
                            <div class='news-card h-100 w-100'>
                                <div class='image'>
                                    <img src='$firstSportNewsItemImage' alt='news-image'>
                                </div>
                                <div class='text pt-3 ps-3 pe-3 pb-4'>
                                    <span class='news-category'>$firstSportNewsItemCategory</span>
                                    <a href='details.php?id=$firstSportNewsItemId'>
                                        <h5 class='news-title scheherazade-new-bold m-0 text-decoration-underline mb-2'>
                                            $firstSportNewsItemTitle
                                        </h5>
                                    </a>
                                    <p class='news-text-sample m-0'>$fitstSportNewsItemIntroText...</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="left-side col-lg-6">
                <div class="row row-cols-md-2">
                    <?php 
                        for($i = 1; $i < count($allSportNews); $i++) {
                            $SportNewsItem = $allSportNews[$i];
                            $SportNewsItemId = $SportNewsItem["news_id"];
                            $SportNewsItemImage = $SportNewsItem["image"]; 
                            $SportNewsItemCategory = $SportNewsItem["category_name"]; 
                            $SportNewsItemTitle = $SportNewsItem["title"]; 

                            echo "
                                <div class='news-card'>
                                    <div class='image'>
                                        <img src='$SportNewsItemImage' alt='news-image'>
                                    </div>
                                    <div class='text pt-2 ps-2 pe-2 pb-4'>
                                        <span class='news-category'>$SportNewsItemCategory</span>
                                        <a href='details.php?id=$SportNewsItemId'>
                                            <h6 class='news-title scheherazade-new-bold mb-2'>
                                                $SportNewsItemTitle
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Sport Section-->

    <!--Start Health Section-->
    <div class="health-section container mt-5">
        <div class="main-title-container row justify-content-between ms-0 me-0">
            <h4 class="main-title scheherazade-new-bold m-0 pb-2 col-10 pe-0 ps-0">صحة</h4>
            <a href="#" class="col-2 text-start customize-anchor d-flex justify-content-end align-items-end">المزيد</a>
        </div>
        <div class="row mt-4">
            <div class="right-side col-lg-6 mb-4">
                <?php 
                    $newsItem = new NewsItem();
                    $allHealthNews= $newsItem->getLatestNewsFromCategory(2,true ,5);

                    if(count($allHealthNews) > 0) {
                        $firstHealthNewsItem = $allHealthNews[0];
                        $firstHealthNewsItemId = $firstHealthNewsItem["news_id"];
                        $firstHealthNewsItemImage = $firstHealthNewsItem["image"]; 
                        $firstHealthNewsItemCategory = $firstHealthNewsItem["category_name"]; 
                        $firstHealthNewsItemTitle = $firstHealthNewsItem["title"]; 
                        $fitstHealthNewsItemIntroText = mb_substr($firstHealthNewsItem["body"], 0, 180, "UTF-8");
                        
                        echo "
                            <div class='news-card h-100 w-100'>
                                <div class='image'>
                                    <img src='$firstHealthNewsItemImage' alt='news-image'>
                                </div>
                                <div class='text pt-3 ps-3 pe-3 pb-4'>
                                    <span class='news-category'>$firstHealthNewsItemCategory</span>
                                    <a href='details.php?id=$firstHealthNewsItemId'>
                                        <h5 class='news-title scheherazade-new-bold m-0 text-decoration-underline mb-2'>
                                            $firstHealthNewsItemTitle
                                        </h5>
                                    </a>
                                    <p class='news-text-sample m-0'>$fitstHealthNewsItemIntroText...</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
            <div class="left-side col-lg-6">
                <div class="row row-cols-md-2">
                    <?php 
                        for($i = 1; $i < count($allHealthNews); $i++) {
                            $HealthNewsItem = $allHealthNews[$i];
                            $HealthNewsItemId = $HealthNewsItem["news_id"];
                            $HealthNewsItemImage = $HealthNewsItem["image"]; 
                            $HealthNewsItemCategory = $HealthNewsItem["category_name"]; 
                            $HealthNewsItemTitle = $HealthNewsItem["title"]; 

                            echo "
                                <div class='news-card'>
                                    <div class='image'>
                                        <img src='$HealthNewsItemImage' alt='news-image'>
                                    </div>
                                    <div class='text pt-2 ps-2 pe-2 pb-4'>
                                        <span class='news-category'>$HealthNewsItemCategory</span>
                                        <a href='details.php?id=$HealthNewsItemId'>
                                            <h6 class='news-title scheherazade-new-bold mb-2'>
                                                $HealthNewsItemTitle
                                            </h6>
                                        </a>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--End Health Section-->

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