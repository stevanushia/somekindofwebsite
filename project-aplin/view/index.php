<?php
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

  $db = DB::getInstance();
	
// var_dump($_SESSION['okMsg']);
//     if (isset($_SESSION['okMsg'])) {
//         $msg = $_SESSION['okMsg'];
//         unset($_SESSION['okMsg']);
//         echo "<script>alert('$msg')</script>";
//     }
// test

    if (isset($_SESSION["logged"])) {
        $user = $_SESSION["logged"];
        if (Users::checkSubscription($user["id"]))
        {
            $adaRecom = Recom::getUsersRecom($user["id"]);
            $adaHistory = History::getUsersHistory($user["id"]);
            if (!$adaRecom) {
                header("Location: mood.php");
                die();
            }
            else if ($adaHistory) {
                $recom = Recom::getRecomFromUsersHistory($user["id"]);
                Recom::setUsersRecom($user["id"], $recom);
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Video On Demand</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">

    <link rel="stylesheet" href="./css/style-index.css">

</head>
<style>
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        opacity: 1;
        pointer-events: none;
        transition: opacity 1s ease-in-out;
    }

    .fade-out {
        opacity: 0;
    }

    .star-rating {
        unicode-bidi: bidi-override;
        text-align: center;
        font-size: 24px;
        color: #ffd700;
        overflow: hidden;
        white-space: nowrap;
        width: 120px;
    }

    .star-rating::before {
        content: "★★★★★";
        display: inline-block;
        width: calc(100% * var(--rating) / 5);
        overflow: hidden;
        white-space: nowrap;
    }
  
</style>

<body>
    <!-- partial:index.partial.html -->
    <!-- <div id="loadingDiv">
        <div class="loader">Loading...</div>
    </div> -->
    <html>

    <head>
        <title>Streaming Service</title>
    </head>
    <body
        onload="AddLists();  CheckSizeAttributes(); MakeJumbotron(); CheckCards(); ResizeHeader();"
        onscroll="ScrollFunction();" onresize="CheckSizeAttributes(); CheckCards(); MakeJumbotron(); ResizeHeader();">

        <div class="content">

            <div class="header" id="home">
                <div class="brand">
                    <img src="../assets/favicon.ico" alt="" style="border-radius: 15px;">
                    <h1 class="white" style="margin-left: 15px;">VIDEO ON DEMAND</h1>
                </div>
                <div class="main-nav">
                    <a class="button-container">
                        <h2>HOME</h2>
                    </a>
                    <?php
                        $lists = Lists::getAll();
                        // var_dump($lists);
                        $i = -1;
                        foreach ($lists as $key => $value) {
                            $i++;
                            echo "<a onclick='SmoothScroll({$i});' class='button-container'>
                                    <h2>".strtoupper($value['name'])."</h2>
                                </a>";
                        }
                    ?>
                </div>
                <div class="right-nav">
                    <div class="search-button">
                        <button id="search-toggle"
                            style="border: none; background-color: transparent; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white"
                                class="bi bi-search" viewBox="0 0 16 16" style="margin-right: 15px;">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            <!-- <img src="search-icon.png" alt="Search"> -->
                        </button>
                    </div>
                    <form action="controller.php" method="post">
                        <a href="login.php"><button class="button-container login" style="border: none;"
                                name="to-login">
                                <?php
                                    if (isset($_SESSION["logged"])) 
                                        echo '<h2>Log Out</h2>';
                                    else 
                                        echo '<h2>Log In</h2>';
                                ?>
                            </button>
                    </form>
                    </a>
                    <form action="controller.php" method="post">
                        <button name="profile-clicked"
                            style="border: none; background-color: transparent; cursor: pointer;"><img
                                src="../assets/img/user.png" alt=""
                                style="width: 40px; height: 40px; margin-left: 20px; background-color: gray; border-radius: 200px;"></button>
                    </form>

                </div>
            </div>
            <?php
                $films = Film::getAll();
                $randomFilmIndex = mt_rand(0, count($films) - 1);
                $randomFilm = $films[$randomFilmIndex];
                
                $randomThumbnail = $randomFilm['thumbnail'];
                $randomTitle = $randomFilm['title'];
                $randomDesc = $randomFilm['description'];
                $randomScore = $randomFilm['score'];
                
            ?>
            <div class="top" style="background-image: url(../admin/<?= $randomThumbnail ?>);">
                <div class="image-container">
                    <div class="left-side">
                        <h1><?= $randomTitle ?></h1>
                        <p><?= $randomDesc ?></p>
                        <p>Critics Score : <?= $randomScore ?> <div class="star-rating" style="--rating: <?= $randomScore ?>;"></div></p>
                        <div class="button-section">
                            <div class="watch">
                                <h3>Play</h3>
                                <svg fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mid">
            <div class="card-carousel-recommend"></div>

                <?php
                    // $i = -1;
                    // foreach ($lists as $key => $value) {
                    //     $i++;
                    //     echo "<div class='content-area' id='{$i}'>
                    //     <h2 class='content-title'>{$value['name']}</h2>
                    //     <div class='card-carousel'></div>
                    // </div>";
                    // }
                ?>
            </div>

            <div id="overlay" class="fade-out"></div>
            <?php
            include_once base_path()."/template/index-footer.php";
            include_once base_path()."/template/index-search.php";
            ?>





    </body>

    </html>
    <!-- partial -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/script-index.js"></script>
    <script src="./js/script-recommendation.js"></script>
    <script>
        var overlay = document.getElementById('overlay');
        setTimeout(function () {
            overlay.style.opacity = '0';
        }, 500); // Adjust the delay as desired

        document.addEventListener('DOMContentLoaded', function () {
            // Add the fade-out class to the overlay after 1-2 seconds

            var searchToggle = document.getElementById('search-toggle');
            var searchOverlay = document.getElementById('search-overlay');
            var searchInput = document.getElementById('search-input');


            searchToggle.addEventListener('click', function () {
                searchOverlay.style.display = 'flex';
                console.log('clicked');

            });

            searchOverlay.addEventListener('click', function (event) {
                if (event.target === searchOverlay) {
                    searchOverlay.style.display = 'none';
                }
            });

            searchInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    // Perform the desired action here
                    var searchText = searchInput.value;
                    console.log('Search:', searchText);
                    if (searchText.trim() !== '') {
                        var url = 'search.php?q=' + encodeURIComponent(searchText);
                        window.location.href = url;
                    }
                    // You can add your own code to process the search query
                }
            });
        });
    </script>

    <?php include_once base_path()."/template/swal-okmsg.php"; ?>


</body>

</html>
