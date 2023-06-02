<?php
    $selectedFilms = json_decode($_POST['tags']);
    $listsId = json_decode($_POST['id']);

    foreach ($selectedFilms as $f) {
        echo Lists::insertInto($listsId, $f);
    }


    // echo "Tags received: " . json_encode($selectedFilms) . " category : " . $listsId;
