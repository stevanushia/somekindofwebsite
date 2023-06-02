<?php

if (isset($_GET["code"]))
{        
    $account = Confirmation::getFromCode($_GET["code"]);

    if ($account)
    {
        $username = $account["username"];
        $email = $account["email"];
        $password = $account["password"];
    
        Users::insert($username, $email, $password);
        Confirmation::confirmFromEmail($email);
    
        $_SESSION["msg"] = "Berhasil konfirmasi, selamat datang !";
        $_SESSION['logged'] = Users::logging($username, $password);
    
        header('Location: payment.php');
    }
    else header("Location: index.php");
}
else header("Location: index.php");
?>
