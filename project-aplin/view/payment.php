<?php

    $clientKey = Midtrans::getClientKey();
    // $price = $_POST["price"];
    // $model = $_POST["id"];

    $logged = $_SESSION["logged"];

    if (!$logged) header("Location: login.php");
    // if (!$model) header("Location: payment.php");

    if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo "<script>alert('$msg')</script>";
    }

    $checkSub = Users::checkSubscription($logged["id"]);
    $checkRenew = Users::getUsersSubscription($logged["id"]);

    if($checkRenew){
        $now = time(); 
        $expDate = strtotime($checkRenew['exp_date']);
        $datediff = (round(($expDate - $now) / (60 * 60 * 24)));
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
    <link rel="stylesheet" href="css/style-subscription.css">
    <link rel="stylesheet" href="css/style-index.css">
    <title>Payment</title>
</head>

<body>
    <div class="main-nav">
        <div class="brand" style="display: flex; cursor: pointer;" onclick="window.location.href='index.php'">
            <img src="../assets/favicon.ico" alt="" style="border-radius: 15px;">
            <h1 class="white" style="margin-left: 15px; font-family: 'Anton', sans-serif;">VIDEO ON DEMAND</h1>
        </div>
    </div>
    <div class="pricingTable">
        <h2 class="pricingTable-title">Find a plan that's right for you.</h2>
        <h3 class="pricingTable-subtitle">Every plan comes with a 30-day free trial.</h3>
        <ul class='pricingTable-firstTable'>
        <?php
        if ($checkSub && $datediff >= 8)
        {
            echo "<h2 style='color: white'>User already has a subscription</h2>";
        }
        else {

            if ($checkRenew && $datediff < 8) echo "<h2 style='color: white'>Choose your renew option</h2> <br>";
        
            $arr = Subs::getAllModel();
            foreach ($arr as $a) {
                $price = $a['price'];
                $model = $a['id'];
                // var_dump($a);
                $snapToken = Midtrans::getSnapToken($price, $logged["id"]);

                echo "
                
                <li class='pricingTable-firstTable_table'>
                    <h1 class='pricingTable-firstTable_table__header'>{$a['name']}</h1>
                    <p class='pricingTable-firstTable_table__pricing'><span>Rp</span><span>{$a['price']}</span><span>{$a['name']}</span>
                    </p>
                    <ul class='pricingTable-firstTable_table__options'>
                        <li>Stream Anytime Anywhere</li>
                        <li>Top Box Office Movies</li>
                        <li>Continue Where You Left</li>
                ";
                if($price == 399999){
                    echo "<li><b>Cheaper Price!</b></li>";
                }
                echo "
                    </ul>
                    <form method='post' action='' id='payment-form'>
                        <input type='hidden' name='snap' class='snaptoken' value='".$snapToken."'>
                        <input type='hidden' id='amount' name='amount' required disabled value='".$price."'>
                        <button class='pricingTable-firstTable_table__getstart pay-button' type='button' name='pay-button'>Get Started Now</button>
                    </form>
                    <form class='payment-completion' action='payment_handling.php' method='post'>
                        <input type='hidden' name='user' value='".$logged["id"]."'>
                        <input type='hidden' name='model' value='".$model."'>
                        <input type='hidden' name='price' value='".$price."'>
                    </form>
                </li>
                ";
            }
        }
    ?>
    </ul>
    </div>

    
</body>

<script>
    var payButton = document.getElementsByClassName('pricingTable-firstTable_table__getstart pay-button');
    console.log(payButton);
    var snapToken = document.getElementsByClassName('snaptoken');
    for (let i = 0; i < payButton.length; i++) {
        payButton[i].addEventListener('click', function () {
        window.snap.pay(snapToken[i].value, {
            onSuccess: function (result) {
                const form = document.getElementsByClassName('payment-completion');
                form[i].submit();
            },
            onPending: function (result) {
                alert("wating your payment!");
                console.log(result);
            },
            onError: function (result) {
                alert("payment failed!");
                console.log(result);
            },
            onClose: function () {
                alert('you closed the popup without finishing the payment');
            }
        })
    });
    }
    
</script>

</html>