<?php  $db = DB::getInstance();

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

    $searched = $_GET['q'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Video On Demand</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">

    <link rel="stylesheet" href="./css/style-index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    .category-selection {
        font-family: 'Montserrat', sans-serif;
        /* text-align: center; */
        margin-left: 49px;
    }
    .btn-category{
        border: solid white 2px;
        background-color: transparent;
        color: white;
        font-weight: bold;
        height: 30px;
        width: 80px;
    }
    .category-selected{
        color: white;
    }
    .category-unselected{
        color: gray;
    }
</style>


<body>
    <!-- partial:index.partial.html -->
    <html>

    <head>
        <title>Streaming Service</title>
    </head>

    <body
        onload="AddCarouselButtons(); CheckSizeAttributes(); AddCards(); MakeJumbotron(); CheckCards(); ResizeHeader();"
        onscroll="ScrollFunction();" onresize="CheckSizeAttributes(); CheckCards(); MakeJumbotron(); ResizeHeader();">

        <div class="content">

            <div class="header" id="home">
                <div class="brand">
                    <img src="../assets/favicon.ico" alt="" style="border-radius: 15px;">
                    <h1 class="white" style="margin-left: 15px;">VIDEO ON DEMAND</h1>
                </div>
                <div class="main-nav">
                    <a class="button-container" href="index.php">
                        <h2>HOME</h2>
                    </a>
                    <?php
                        $lists = Lists::getAll();
                        // var_dump($lists);
                        $i = -1;
                        foreach ($lists as $key => $value) {
                            $i++;
                            echo "<a onclick='SmoothScroll({$i});' class='button-container' href='index.php#{$i}'>
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
                foreach ($films as $key => $value) {
                    $latestThumbnail = $value['thumbnail'];
                    $latestTitle = $value['title'];
                    $latestDesc = $value['description'];
                }
            ?>
            <div class="mid" style="padding-top: 100px;">

                
                <div class="content-area" id="1">
                    <h2 class="content-title">RESULT ON "<?= $searched ?>"</h2>
                    <div class="category-selection">
                        <form action="search.php" method="get">
                            <input type="hidden" name="q" value="<?= $searched ?>">
                            <?php
                                    $categories = Category::getAll();
                                    $selected = $_GET["categories"] ?? [""];
                                    foreach ($categories as $c) {
                                        $class = "category-unselected";
                                        if (in_array($c['id'], $selected)) $class = "category-selected";
                                        echo " <span name='category' onclick='toggleSelect(this)' cat='{$c['name']}' id='{$c['id']}' class='{$class}'>
                                            {$c['name']}
                                                </span><b style='color: gray'> | </b> ";
                                    }    
                            ?>
    
                            <button class="btn-category" type="submit">Search</button>
                        </form>
                        <div class="card-carousel-searched"></div>
                    </div>
                </div>

                <div class="content-area" id="1">
                    <h2 class="content-title">YOU MIGHT ALSO LIKE</h2>
                    <div class="card-carousel"></div>
                </div>
                <?php
                    include_once base_path()."/template/index-footer.php";
                    include_once base_path()."/template/index-search.php";
                ?>


    </body>

    </html>
    <!-- partial -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/script-search.js"></script>
    <!-- <script src="js/script-history.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSelect(category)
        {
            if (category.className == "category-unselected")
            {
                category.className = "category-selected";
                let input = document.createElement("input");
                input.type = "checkbox";
                input.style.display = "none";
                input.value = category.id;
                input.checked = true;
                input.name = "categories[]";
                category.appendChild(input);
            }
            else {
                category.className = "category-unselected";
                category.innerHTML = category.getAttribute("cat");
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
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
