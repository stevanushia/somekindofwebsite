<?php
    $q = strtolower($_GET["q"] ?? "");
    $categories = $_GET["categories"] ?? "";
    $db = DB::getInstance();
    $str = "";
    if ($categories)
    {
        $str = "AND id IN (SELECT film FROM film_category WHERE ";
        foreach ($categories as $c) {
            $str = $str. " category = '".$c."' AND";
        }
        $str = substr($str, 0, -3);
        $str = $str.");";
    }
    $stmt = $db->prepare("SELECT id, thumbnail, title, description 
                            FROM film 
                            WHERE title LIKE ? ".$str);
    $stmt->execute(['%' . $q . '%']);
    $result = $stmt->fetchAll();
    if ($result) {
        // Return the movies array as JSON
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo "No movies found";
    }

?>