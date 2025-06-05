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
            include_once "classes/clsUser.php";

            session_start();

            if(!isset($_SESSION["user_id"])) {
                header("Location: logIn.php");
                exit;
            }

            $adminid = $_SESSION["user_id"];
            $adminname = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = new User();
                
                try {
                    if(isset($_POST['delete'])) {
                        $id = $_GET['id'];
                        $user->deleteUser($id);
                    } else if(isset($_POST['save'])) {
                        $id = $_GET['id'];
                        $name = $_POST['name'];
                        $user->updateUser($id, $name);
                    } else if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role']) ) {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $role = $_POST['role'];
                        $user->insertUser($name, $email, $password, $role);
                    }
                } catch (Exception $e) {
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
                    if($adminid != -1) {
                        $user = new User();
                        $userInfo = $user->getUser($adminid);
                        $adminname = $userInfo["name"];
                    }
                    echo "<h1 class=''>مرحبا $adminname...</h1>" 
                ?>
                <div class="">
                    <a href="logIn.php?d=1" class="btn btn-primary">تسجيل الخروج</a>
                    <a href="index.php" class="btn btn-primary">الصفحة الرئيسية</a>
                </div>
            </div>
            <div class="mb-5">
                <div class="row">
                    <div class="col-lg-8"> 
                        <ul class="list-group">
                            <li class="list-group-item active fs-3" aria-current="true">قائمة المستخدمين</li>
                            <li style="height: 470px" class="list-group-item overflow-auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">id</th>
                                            <th scope="col">الاسم</th>
                                            <th scope="col">نوع المستخدم</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $user = new User();
                                            $rows = $user->getAllUsers();

                                            foreach($rows as $row) {
                                                $name = $row["name"];
                                                $email = $row["email"];
                                                $password = $row["password"];
                                                $role = $row["role"];
                                                if($role == "author") {
                                                    $role = "مؤلف";
                                                } else if($role == "editor"){
                                                    $role = "محرر";
                                                }
                                                $id = $row["id"];

                                                if($row["role"] != "admin") {
                                                    echo "
                                                        <tr>
                                                            <form action='admin.php?id=$id' method='post'>
                                                                <td>$id</td>
                                                                <td>
                                                                    <input type='text' class='form-control' name='name' value='$name'>
                                                                </td>
                                                                <td>$role</td>
                                                                <td>
                                                                    <div style='width: fit-content;' class='me-auto mt-2 mt-md-0'>
                                                                        <input type='submit' name='save' value='حفظ'>
                                                                        <input type='submit' name='delete' value='حذف'> 
                                                                    </div>
                                                                </td>
                                                            </form>
                                                        </tr>
                                                    ";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4"> 
                        <ul class="list-group" class="col">
                            <li class="list-group-item active fs-3" aria-current="true">إضافة مستخدم جديد</li>
                            <li class="list-group-item mt-2 mb-2">
                                <?php echo "<form action='admin.php' method='post'>" ?>
                                    <div class="mt-3">
                                        <input type="text" class="form-control" name='name' placeholder="الأسم" required>
                                    </div>
                                    <div class="mt-3">
                                        <input type="text" class="form-control" name='email' placeholder="البريد" required>
                                    </div>
                                    <div class="mt-3">
                                        <input type="text" class="form-control" name='password' placeholder="كلمة المرور" required>
                                    </div>
                                    <div class="mt-3">
                                        <select class="form-select" name="role" required>
                                            <?php  
                                                $roles = ["author" => "مؤلف", "editor" => "محرر"];

                                                foreach($roles as $key => $value) {
                                                    echo "<option value='$key'>$value</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="submit" class="btn btn-primary mt-3">أضف</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            
                
            </div>
        </div>

        <!--Bootstrap js file-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>