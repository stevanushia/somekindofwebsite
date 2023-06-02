<?php

if (isset($_POST["insertlist"]))
    {  
        Lists::insert($_POST["name"], $_POST["description"]);
        header("Location: listings.php");
        die();
    }

    if (isset($_POST["update"]))
    {  
        $id = $_POST["id"];
        $name = $_POST["name"];
        $price = $_POST["description"];
        Lists::updateList($id, $name, $price, $model);
        $_SESSION["success"] = "hehe";
        header("Location: listings-details.php?listings=".$id);


    }

    if (isset($_POST["delete"]))
    {  
        $id_delete = $_POST["id_delete"];
        Lists::deleteLists($id_delete);
        header("Location: listings.php");
    }

    if (isset($_POST["removefromlist"]))
    {  
        Lists::deleteFrom($_POST["memberid"]);
        header("Location: listings-details.php?listings=".$_POST["listid"]);
        die();
    }

    if (isset($_POST["toggleVisible"]))
    {
        $id = $_POST["listid"];
        $list = Lists::getFromId($id);
        if ($list["status"] == 0)
        {
            Lists::turnVisible($id);
        }
        else if ($list["status"] == 1)
        {
            Lists::turnHidden($id);
        }
        header("Location: listings-details.php?listings=".$id);
        die();
    }

    if (isset($_POST["neworder"]))
    {
        $orderString = $_POST['neworder'];
        if ($orderString != "")
        {
            var_dump($orderString);
            $orderArray = explode(',', $orderString);
            for ($i = 0; $i < count($orderArray); $i++) {
                $orderArray[$i] = intval($orderArray[$i]);
            }

            $lists = Lists::getAll();

            foreach ($lists as $key => $l)
            {
                Lists::setTier($l["id"], $orderArray[$key]);
            }
        }
        header("Location: listings.php");
        die();
    }