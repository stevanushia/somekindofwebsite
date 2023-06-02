<?php

    if (isset($_POST["insertsub"]))
    {  
        $name = $_POST["name"];
        $price = $_POST["price"];
        $model = $_POST["model"];
        Subs::insertModel($name, $price, $model);
        header("Location: subscription.php");
    }


    if (isset($_POST["update"]))
    {  
        $id = $_POST["id"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $model = $_POST["pricing"];
        Subs::updateModel($id, $name, $price, $model);
        header("Location: subscription.php");
    }

    if (isset($_POST["deletesub"]))
    {  
        $id_delete = $_POST["id_delete"];
        Subs::deleteModel($id_delete);
        header("Location: subscription.php");
    }