<?php
    if (isset($_SESSION["logged"])) {
        $user = $_SESSION["logged"];
        if (Users::checkSubscription($user["id"]))
        {
            $adaRecom = Recom::getUsersRecom($user["id"]);
            $adaHistory = History::getUsersHistory($user["id"]);
            if (!$adaRecom) {
                header("Location: mood.php");
                die();
            }
            else {
        
                $recom = Recom::getRecomFromUsersHistory($user["id"]);
                Recom::setUsersRecom($user["id"], $recom);
            }

        }
    }
?>