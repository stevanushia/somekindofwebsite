<?php
    $history_id = $_POST['id'];
    $timestamp = $_POST['timestamp']; 
    $duration = $_POST['duration'];

    History::setNewTimestamp($history_id, $timestamp);
    if ($timestamp >= $duration - 1)
    {
        History::setWatched($history_id, 1);
    }

    // $duration = gmdate("H:i:s", $duration);
    // $timestamp = gmdate("H:i:s", $timestamp);
    // $_SESSION["msg"] = $timestamp . " New Timestamp " . $history_id . " dur : " . $duration;
    

    
?>