<?php

$id = $_SESSION["logged"]["id"];
$db = DB::getInstance();
$stmt = $db->prepare("SELECT *
                    FROM film
                    WHERE id in (
                        SELECT film
                        FROM recommendation
                        WHERE user = ?
                        )
                    LIMIT 8");
$stmt->execute([$id]);
$result = $stmt->fetchAll();

if ($result) {
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    echo "No movies found";
}