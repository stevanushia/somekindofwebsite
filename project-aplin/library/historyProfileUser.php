<?php
    
class HistoryUser{
    public function getUsersHistory($user)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT F.*
                                FROM history_user H
                                JOIN film F ON F.id = H.film
                                WHERE H.user = ?
                                ORDER BY H.last_updated DESC
                            ");                        
        $stmt->execute([$user]);
        $result = $stmt->fetchAll();
        if ($result) {
            // Return the movies array as JSON
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            echo "No movies found";
        }
        return $result;
    }

}

$id = $_SESSION["logged"]["id"];
$userHistory = new HistoryUser();
$userHistory->getUsersHistory($id);

?>