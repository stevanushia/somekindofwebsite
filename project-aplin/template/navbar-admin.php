<?php
    $db = DB::getInstance();

?>
<link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>


<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../admin/manage.php">Halaman admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Master
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../admin/category.php">category</a></li>
                    <li><a class="dropdown-item" href="../admin/movie.php">Movies</a></li>
                    <li><a class="dropdown-item" href="../admin/upload.php">Upload</a></li>
                </ul>
            </li>
            <!-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="../view/explore.php">Explore</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/payment.php">Subscription</a>
            </li>
        </ul>
        
            <button class="btn btn-outline-success" type="submit"><a style="text-decoration: none;" href="../view/login.php">LOGOUT</a></button>
        
        
        </div>
    </div>
</nav>
