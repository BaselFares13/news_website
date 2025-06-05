<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-main-color fixed-top pt-3 pb-3">
        <div class="container">
            <h2 class="navbar-brand fs-4 scheherazade-new-bold m-0 ms-4">
                <a class="text-white" href="index.php">أخبار اليوم</a>
            </h2>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="index.php">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="category.php?id=1">سياسة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="category.php?id=3">اقتصاد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="category.php?id=4">رياضة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fs-6" href="category.php?id=2">صحة</a>
                    </li>
                    <li class='nav-item me-lg-3'>
                        <a class='nav-link text-white fs-6' href='logIn.php'>ادارة الاخبار</a>
                    </li>
                </ul>
                <form class="NavSearch d-flex mb-2 mt-2 m-lg-0" role="search">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">بحث</button>
                </form>
            </div>
        </div>
    </nav>
</body>

</html>