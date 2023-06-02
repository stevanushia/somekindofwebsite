<?php
    $selectedFilms = json_decode($_POST['tags']);
    $categoryId = json_decode($_POST['id']);

    foreach ($selectedFilms as $f) {
        Category::insertCategory($f, $categoryId);
    }


    echo "Tags received: " . json_encode($selectedFilms) . " category : " . $categoryId;
    // header("Location: category-details.php?category=".$categoryId);