<?php   
        
        // if (isset($_SESSION['msg'])) {
        //     $msg = $_SESSION['msg'];
        //     unset($_SESSION['msg']);
        //     // echo "<script>alert('$msg')</script>";
        //     // echo "<div class='alert alert-warning' role='alert'> $msg </div>";
        //     echo "swal('Hello world!');";
        // }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | VOD</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">

</head>

<body>
    <!-- partial:index.partial.html -->
    <!DOCTYPE html>
    <html lang="es" dir="ltr">

    <head>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="main.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="main">
            <!-- register -->
            <div class="container a-container" id="a-container">
                <form class="form" id="a-form" method="post" action="controller.php">
                    <h2 class="form_title title">Create Account</h2>
                    <input class="form__input" type="text" placeholder="Username" name="regis_user">
                    <input class="form__input" type="text" placeholder="Email" name="regis_email">
                    <input class="form__input" type="password" placeholder="Password" name="regis_pass">
                    <input class="form__input" type="password" placeholder="Confirm Password" name="regis_confirm">
                    <button class="switch__button button" name="registering" type="submit">SIGN UP</button>
                    <!-- <button>SIGN UP</button> -->
                </form>
            </div>
            <!-- register -->

            <!-- login -->
            <div class="container b-container" id="b-container">
                <form class="form" id="b-form" method="post" action="controller.php">
                    <a href="index.php" class="switch__title backNav">Go Back?</a>
                    <h2 class="form_title title">Sign In</h2>
                    <input class="form__input" type="text" placeholder="Username" name="login_user">
                    <input class="form__input" type="password" placeholder="Password" name="login_pass">
                    <a class="form__link">Forgot your password?</a>
                    <button class="switch__button button" name="logging-in" type="submit">SIGN IN</button>

                </form>
            </div>
            <!-- login -->

            <div class="switch" id="switch-cnt">
                <div class="switch__circle"></div>
                <div class="switch__circle switch__circle--t"></div>
                <div class="switch__container" id="switch-c1">
                    <a href="index.php" class="switch__title backNav">Go Back?</a>

                    <h2 class="switch__title title">Welcome Back !</h2>
                    <p class="switch__description description">To keep connected with us please login with your personal
                        info</p>
                    <button class="switch__button button switch-btn">SIGN IN</button>
                </div>
                <div class="switch__container is-hidden" id="switch-c2">
                    <h2 class="switch__title title">Hello Friend !</h2>
                    <p class="switch__description description">Enter your personal details and start journey with us</p>
                    <button class="switch__button button switch-btn">SIGN UP</button>
                </div>
            </div>
        </div>
        <script src="main.js"></script>
    </body>

    </html>
    <!-- partial -->
    <script src="./js/login-script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
        if (isset($_SESSION['errMsg'])) {
            $msg = $_SESSION['errMsg'];
            ?>
            <script>
            swal({
                title: "<?= $msg ?>",
                icon: "error",
                button: "Continue",
            });
            </script>
    <?php
            unset($_SESSION['errMsg']);
            // echo "<script>alert('$msg')</script>";
        }
        else if(isset($_SESSION['okMsg'])){
            $msg = $_SESSION['okMsg'];
            $txt = $_SESSION['txtMsg'];
    ?>
            <script>
                swal({
                    title: "<?= $msg ?>",
                    text: "<?= $txt ?>",
                    icon: "success",
                    button: "Continue",
                });
            </script>
    <?php
            unset($_SESSION['okMsg']);
            unset($_SESSION['txtMsg']);
        }
    ?>


</body>

</html>