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
            require "classes/clsCategory.php";
            require "classes/clsUser.php";

            session_start();

            if(!isset($_SESSION["user_id"])) {
                header("Location: logIn.php");
                exit;
            }

            $authorid = $_SESSION["user_id"];
            $authorname = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['submit'])) { 
                    $newsItem = new NewsItem();
                    $numOfImage = $newsItem->getLastInsertedId();
                    $numOfImage++;

                    $image = $_FILES['image'];
                    $imageName = $image['name'];
                    $tmpName = $image['tmp_name'];
                    $path = pathinfo($imageName);
                    $extension = $path['extension'];

                    $imagePath = 'images/' . 'img' . $numOfImage . '.' . $extension;

                    $title = $_POST["title"];
                    $category = (int)$_POST["category"];
                    $body = $_POST["body"];

                    try {
                        $newsItem->insertNewsItem($title, $body, $imagePath, $category, $authorid);
                        move_uploaded_file($tmpName, $imagePath);
                    }catch (Exception $e) {
                        echo "
                            <div dir='ltr' class='alert alert-primary' role='alert'>
                                $e
                            </div>
                        ";
                    }
                }
            }
            
        ?>

        <div class="container">
            <div class="d-flex justify-content-between mt-5 mb-3">
                <?php 
                    if($authorid != -1) {
                        $user = new User();
                        $userInfo = $user->getUser($authorid);
                        $authorname = $userInfo["name"];
                    }
                    echo "<h1 class=''>مرحبا $authorname...</h1>" 
                ?>
                <div class="">
                    <a href="logIn.php?d=1" class="btn btn-primary">تسجيل الخروج</a>
                    <a href="index.php" class="btn btn-primary">الصفحة الرئيسية</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-5">
                    <ul class="list-group" class="col">
                        <li class="list-group-item active fs-3" aria-current="true">قم بنشر خبر جديد</li>
                        <li class="list-group-item mt-2 mb-2">
                            <form action="author.php" method="post" enctype="multipart/form-data">
                                <div>
                                    <input type="text" class="form-control" name='title' placeholder="العنوان" required>
                                </div>
                                <div>
                                    <select class="form-select mt-3" name="category" required>
                                        <?php  
                                            $categoryObj = new Category();
                                            $categories = $categoryObj->getAll();

                                            foreach($categories as $category) {
                                                $categoryName = $category["name"];
                                                $categoryId = $category["id"];

                                                echo "<option value='$categoryId'>$categoryName</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <input type="file" class="form-control mt-3" name="image" required>
                                </div>
                                <div>
                                    <textarea class="form-control mt-3" rows="3" name='body' placeholder="ادخل محتوى الخبر" required></textarea>
                                </div>
                                <div>
                                    <button type="submit" name="submit" class="btn btn-primary mt-3">أنشر</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 mb-5">
                    <ul class="list-group" class="col">
                        <li class="list-group-item active fs-3" aria-current="true">قائمة الاخبار المنشورة سابقاً</li>
                        <li style="height: 450px" class="list-group-item overflow-auto">
                            <ul class="list-group mt-2 mb-2">
                                <?php 
                                    $newsItem = new NewsItem();
                                    $rows = $newsItem->getNewsForAuthor($authorid);
                                    
                                    $counter = 1;
                                    foreach($rows as $row) {
                                        $id = $row["news_id"];
                                        $title = $row["title"];
                                        $date = new DateTime($row["dateposted"]);
                                        $date = $date->format("d/m/Y h:i A");
                                        $status = $row["status"];
                                        $hrf = "";
                                        if($status == 1) {
                                            $status = "تم القبول";
                                            $hrf = "details.php?id=$id";
                                        } else {
                                            $status = "لم يقبل بعد"; 
                                        }

                                        echo "
                                            <li class='list-group-item'>
                                                <a href='$hrf'><span class='badge bg-primary ms-2'>$counter</span>$title - $date - $status</a>
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
        </div>

        <!--Bootstrap js file-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>