<?php
    $user = $_POST["user"];
    $price = $_POST["price"];
    $model = $_POST["model"];

    $htransId = Transaksi::generateIdHtrans();

    $checkRenew = Users::checkSubscription($user);

    if ($checkRenew)
    {
        Transaksi::insertHtrans($htransId, $user, $price);
        for ($i=0; $i < 1; $i++) { 
            Transaksi::insertDtrans($htransId, $model, 1, $price);
        }

        Subs::renew($user, $model);

        $_SESSION["okMsg"] = "Renew successful!";
        header("Location: index.php");
        die();
    }

    Transaksi::insertHtrans($htransId, $user, $price);
    for ($i=0; $i < 1; $i++) { 
        Transaksi::insertDtrans($htransId, $model, 1, $price);
    }

    Subs::insert($user, $model);

    $_SESSION["okMsg"] = "Subscription successful!";
    header("Location: index.php");
    die();
