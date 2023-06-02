<?php  $db = DB::getInstance();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Video On Demand</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
        onload="AddCarouselButtons(); CheckSizeAttributes(); AddCards(); MakeJumbotron(); CheckCards(); ResizeHeader();"
        onscroll="ScrollFunction();" onresize="CheckSizeAttributes(); CheckCards(); MakeJumbotron(); ResizeHeader();">

        <div class="content">

            <div class="header" id="home">
                <div class="brand" onclick="window.location.href='index.php'" style="cursor: pointer;">
                    <img src="../assets/favicon.ico" alt="" style="border-radius: 15px;">
                    <h1 class="white" style="margin-left: 15px;">VIDEO ON DEMAND</h1>
                </div>
                <div class="main-nav">
                    <a class="button-container">
                        <!-- <h2>HOME</h2> -->
                    </a>
                </div>
                <div class="right-nav">
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
            
            <div class="top" style="background-color: #141414; display: block; padding-left: 100px; margin-bottom: -300px;">
                <h1 style="font-size: 50px; margin-top: 100px;"><?= $_SESSION["logged"]["name"] ?>'s Profile</h1>
                <div style="display: flex;">
                    
                <?php
                    $id = $_SESSION["logged"]["id"];
                    if (Users::checkSubscription($id)){
                        $userSub = Subs::getUsersSubscription($id);
                        if ($userSub) {
                            $subModel = Subs::getSub($userSub['sub_model']);
                                
                            $now = time(); 
                            $expDate = strtotime($userSub['exp_date']);
                            $datediff = (round(($expDate - $now) / (60 * 60 * 24)));
                            echo "<div>";
                            echo '</br> <p style="padding: 0px;"><b> Subscription Model</b> : ' . $subModel['name'] . '</p>';
                            echo '<p style="padding: 0px;"> <b>Purchased On</b> : ' . $userSub['purchase_date'] . '</p>';
                            echo '<p style="padding: 0px;"><b>Will Expire In</b> : ' . $userSub['exp_date'] . " (" . $datediff ." Days)</p>";
                                
                            if ($datediff < 8)
                            {
                                echo "<p style='padding: 0px; color: red;'><b> Your Subscription is About to Expire!</b></p>";
                            }
                            echo "<form method='post' action='payment.php'>
                                <button class='btn btn-danger'>Renew Subscription</button>
                            </form>";
                            echo "</div>";
                        }
                    }
                    else {
                        echo '<p style="padding: 0px;">You have not purchased a subscription yet.</p>';
                        echo '<p style="padding: 0px;"><a href="payment.php">Click Here To Purchase</a></p>';
                    }
                ?>
                </div>
                
                <!-- <p style="padding: 0px;">sugeng*8</p> -->
            </div>


            <div class="mid">
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

                <div class="card-carousel-recommend"></div>
              
                <div class="content-area" id="1">
                    <h2 class="content-title">HISTORY</h2>
                    <div class="card-carousel"></div>
                </div>

            <!-- <div id="overlay" class="fade-out"></div> -->
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
    <script src="js/script-history.js"></script>
    <script src="js/script-recommendation.js"></script>
    <script>
        
        // var overlay = document.getElementById('overlay');
        // setTimeout(function () {
        //     overlay.style.opacity = '0';
        // }, 500); // Adjust the delay as desired

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