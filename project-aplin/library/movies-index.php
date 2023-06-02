<?php
$db = DB::getInstance();
$lists = $db->query("SELECT *
                    FROM lists
                    WHERE status = 1
                    ORDER BY tier
                        ")->fetchAll();

$display = [];
foreach ($lists as $l) {
    $id = $l["id"];
    $films = $db->query("SELECT DISTINCT F.*
                        FROM film F
                        WHERE F.id in (
                            SELECT film_id
                            FROM lists_member
                            WHERE lists_id = '$id'
                        )
                        ")->fetchAll();
    array_push($l,$films);
    array_push($display,$l);
}

array_walk($display, function (& $item) {
    $item['films'] = $item['0'];
    unset($item['0']);
    });

if ($lists) {
    header('Content-Type: application/json');
    echo json_encode($display);
} else {
    echo "No movies found";
}