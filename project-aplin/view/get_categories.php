<?php
$tags = category::getAll();

header('Content-Type: application/json');
echo json_encode(array('tags' => $tags));