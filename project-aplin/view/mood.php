<?php
    if (isset($_SESSION["logged"])) { # cek bila user log in
        $user = $_SESSION["logged"];
    }
    else header("Location: index.php");

    // if (Users::checkSubscription($user["id"])) # cek bila user telah ada subscription
    // {
    //     $adaRecom = Recom::getUsersRecom($user["id"]);
    // } 
    // else header("Location: index.php");

    // if ($adaRecom) { # cek bila user telah memiliki recommendation (bukan fresh account)
    //     header("Location: index.php");
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <title>Video On Demand | Mood</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="./css/style-index.css">

</head>
<style>
    .bottom {
        position: fixed;
        bottom: 0;
    }
    .mood-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }
    .mood-bg  video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .mood-content {
        font-family: 'Montserrat', sans-serif;
        text-align: center;
        margin-top: 31vh;
    }
    .mood-content h1{
        color: white;
    }
    .sel{
        color: white;
        background: transparent;
    }
    .less-go{
        color: white;
        background: transparent;
        border: solid white 2px;
        margin: 10px 10px 10px 10px;
        padding: 10px 10px 10px 10px;
        border-radius: 10px;
    }
    #video-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); 
        z-index: -1;
    }
    .select2-container--default .select2-selection--multiple {
        background-color: transparent;
        border: 1px solid #fff;
        color: #fff;
        margin-left: -9vw;
        margin-right: -9vw;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: transparent;
        border: 2px solid #fff;
        color: #fff;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        color: #fff;
        background-color: transparent;

    }
    
    .select2-container--default .select2-results__option--selected {
        background-color: transparent;
        color: #fff;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: 2px solid #fff !important;
        box-shadow: none !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple .select2-selection__choice,
    .select2-container--default .select2-selection--multiple .select2-selection__choice--highlighted {
        background-color: transparent;
        border: 1px solid #fff;
        color: #fff;
    }
    
    .select2-container--default .select2-search--inline .select2-search__field {
        color: #fff !important;
    }

</style>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<body>
    <div class="content">
            <div class="header" id="home">
                <div class="brand">
                    <img src="../assets/favicon.ico" alt="" style="border-radius: 15px;">
                    <h1 class="white" style="margin-left: 15px;">VIDEO ON DEMAND</h1>
                </div>
                <div class="main-nav">
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
    
        </div>
            <div class="mood-bg">
                <video autoplay muted loop id="myVideo">
                    <source src="../assets/bg.mp4" type="video/mp4">
                </video>
            </div>

            <div id="video-overlay"></div>
    
            <div class="mood-content">
                <h1>What are you in the <i>mood</i> for ?</h1>
                <br>
                <div>
                    <select class="select2" multiple="multiple" style="width: 200px;">
                        <?php
                            $categories = Category::getAll();
                            foreach ($categories as $c) {
                                echo "<option value='{$c['id']}'>{$c['name']}</option>";
                            }    
                        ?>
                    </select>
                </div>
                <br>
                <br>
                <div>
                    <button id="getValues" class="less-go" style="cursor: pointer;"><b>Les go!</b></button>      
                </div>
            </div>
            
            <?php
                include_once base_path()."/template/index-footer.php";
            ?>
</body>
<script>
    let selectedValues = [];

    $(document).ready(function() {
        $('.select2').select2();
    }); 

    $('#getValues').on('click', function() {
        selectedValues = $('.select2').val();
        executePhpFunction(selectedValues);
    });

    function executePhpFunction(selectedTags) {
        fetch('../view/set_recommended.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'tags=' + encodeURIComponent(JSON.stringify(selectedTags))
        })
            .then(response => response.text())
            .then(result => {
                console.log(result);
                location.replace("index.php");

            });
    }
    </script>
</html>
