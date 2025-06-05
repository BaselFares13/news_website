<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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
        <?php
            require "classes/clsNewsItem.php";
            require "classes/clsUser.php";

            session_start();

            if(!isset($_SESSION["user_id"])) {
                header("Location:logIn.php");
                exit;
            }

            $editorid = $_SESSION["user_id"];
            $editorname = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $editorid = $_GET["editorid"];
                $command = "";
                $id = $_GET['id'];

                $news_item = new NewsItem();

                try {
                    if(isset($_POST['deny'])) {
                        $news_item->denyNewsItem($id);
                    } else if(isset($_POST['approve'])) {
                        $news_item->approveNewsItem($id);
                    } else if(isset($_POST['delete'])) {
                        $news_item->deleteNewsItem($id);
                    }
                }catch(Exception $e) {
                    echo "
                        <div dir='ltr' class='alert alert-primary' role='alert'>
                            $e
                        </div>
                    ";
                }

            }

        ?>
        <div class="container">
            <div class="d-flex justify-content-between mt-5 mb-3">
                <?php 
                    if($editorid != -1) {
                        $user1 = new User();
                        $userInfo = $user1->getUser($editorid);
                        $editorname = $userInfo["name"];
                    }
                    echo "<h1 class=''>مرحبا $editorname...</h1>" 
                ?>
                <div class="">
                    <a href="logIn.php?d=1" class="btn btn-primary">تسجيل الخروج</a>
                    <a href="index.php" class="btn btn-primary">الصفحة الرئيسية</a>
                </div>
            </div>
            <div class="mb-5">
                <ul class="list-group" class="col">
                    <li class="list-group-item active fs-3" aria-current="true">قائمة الاخبار</li>
                    <li style="height: 470px" class="list-group-item overflow-auto">
                        <ul class="list-group">
                                <?php 

                                    $newsItem = new NewsItem();
                                    $rows = $newsItem->getLatestNews();
                                    
                                    $counter = 1;
                                    foreach($rows as $row) {
                                        $title = $row["title"];
                                        $date = new DateTime($row["dateposted"]);
                                        $date = $date->format("d/m/Y h:i A");
                                        $option = "";
                                        $news_id = $row["news_id"];

                                        if($row["status"] == 0) {
                                            $option = "<input type='submit' name='approve' value='قبول'>";
                                        } else {
                                            $option = "<input type='submit' name='deny' value='رفض'>";
                                        }
                                        echo "
                                            <li class='list-group-item'>
                                                <div class='row mb-3 mt-3'>
                                                    <div class='col-md-9'>
                                                        <a href='#'><span class='badge bg-primary ms-2'>$counter</span> $title - $date</a>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <form action='editor.php?id=$news_id&editorid=$editorid' method='post' style='width: fit-content;' class='me-auto mt-2 mt-md-0'>
                                                            $option                                                        
                                                            <input type='submit' name='delete' value='حذف'> 
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        ";
                                        $counter++;
                                    }
                                ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!--Bootstrap js file-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>