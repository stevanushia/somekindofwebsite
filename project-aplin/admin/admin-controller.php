<?php

if (isset($_POST["logout"]))
{
    unset($_SESSION["admin"]);
    header("Location: ../view/login.php");
    die();
}

//test push