<?php
class MoviesData{

    public function getMoviesData() {
        // Query to fetch data from the "movies" table
        $db = DB::getInstance();
        $result = $db->query("SELECT id, thumbnail, title, description, score FROM film")->fetchAll();
        
        if ($result) {
            // Return the movies array as JSON
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            echo "No movies found";
        }
    }
}

$moviesData = new MoviesData();
// if (isset($_GET['q'])){
//     $q = $_GET['q'];
//     $moviesData->getDataFromSearch($q);
// }
// else{
    $moviesData->getMoviesData();
// }

// $moviesData->closeConnection();
?>