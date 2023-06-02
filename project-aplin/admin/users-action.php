<?php

if (isset($_POST["toggleStatus"]))
{
    $idUser = $_POST["idUser"];
    Users::toggleStatus($idUser);
    header("Location: users.php");
    die();
}

if (isset($_POST["toggleStatusDetail"]))
{
    $idUser = $_POST["idUser"];
    Users::toggleStatus($idUser);
    header("Location: users-details.php?user=".$idUser);
    die();
}
if (isset($_POST["cancel-subs"])){
    $idSubs = $_POST["id"];
    $idUser = $_POST["id-user"];
    Subs::deleteSubs($idSubs);
    header("Location: users-details.php?user=".$idUser);
    die();
}