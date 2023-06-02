<?php

if (isset($_POST["update"]))
{
    $id = $_POST["id"];
    $name = $_POST["name"];
    Category::updateCategory($id, $name);

    header("Location: category.php");
    // die();
    
}

if (isset($_POST["insert"]))
{
    $name = $_POST["name"];
    Category::insert($name);
    header("Location: category.php");
    die();
}

if (isset($_POST["delete"]))
{  
    $id_delete = $_POST["id_delete"];
    Category::delete($id_delete);
    header("Location: category.php");
}

if (isset($_POST["removeFilm"]))
{
    $film = $_POST["idfilm"];
    $category = $_POST["idcategory"];
    Category::removeFromCategory($film, $category);
    header("Location: category-details.php?category=".$category);
    die();
}