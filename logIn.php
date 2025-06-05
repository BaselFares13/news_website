<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تسجيل الدخول</title>
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
            include_once "classes/clsUser.php";

            session_start();

            if(isset($_GET["d"])) {
                session_destroy();
                setcookie("user_id", "", time() - 100, "/");
                setcookie("user_role", "", time() - 100, "/");
            }

            if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_role'])) {
                $_SESSION["user_id"] = $_COOKIE['user_id'];
                if($_COOKIE['user_role'] === "author") {
                    header("Location: author.php");
                } else if($_COOKIE['user_role'] === "admin") {
                    header("Location: admin.php");
                } else { 
                    header("Location: editor.php");
                }
                exit;
            }

            if(isset($_POST["email"]) && isset($_POST["password"])) {
                $user = new User();
                try {
                    $user_info = $user->getUser($user->LogUserIn($_POST["email"], $_POST["password"]));
                    if($user_info) {
                        $_SESSION["user_id"] = $user_info["id"]; 

                        if(isset($_POST["remember"])) {
                            if (!isset($_COOKIE['user_id']) && !isset($_COOKIE['user_role'])) {
                                setcookie("user_id", $user_info["id"], time() + (365 * 24 * 60 * 60), "/");
                                setcookie("user_role", $user_info["role"], time() + (365 * 24 * 60 * 60), "/");
                            }
                        }

                        if($user_info["role"] === "author") {
                            header("Location: author.php");
                        } else if($user_info["role"] === "admin") {
                            header("Location: admin.php");
                        } else { 
                            header("Location: editor.php");
                        }
                        exit;
                        
                    } else {
                        throw new Exception("There is no user with this information !");
                    }
                } catch(Exception $e) {
                    echo "
                        <div dir='ltr' class='alert alert-primary' role='alert'>
                            $e
                        </div>
                    ";
                }
            }
        ?> 

        <div class="login-form mt-6">
            <form class="m-auto w-25 border border-primary p-4 rounded" action="logIn.php" method="POST">
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">الإيميل:</label>
                    <input type="email" class="form-control" id="email" placeholder="أدخل الإيميل" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">كلمة المرور:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="أدخل كلمة المرور" name="password" required>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember" value="yes"> تذكرني
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
            </form>
        </div>

        <!--Bootstrap js file-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>