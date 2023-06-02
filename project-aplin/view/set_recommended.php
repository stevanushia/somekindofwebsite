<?php
    $selectedTags = json_decode($_POST['tags']);
    $logged = $_SESSION['logged'];
    $recom = Recom::getRecomFromCategories($selectedTags);

    Recom::setUsersRecom($logged["id"], $recom);

    // echo "Tags received: " . json_encode($recom);