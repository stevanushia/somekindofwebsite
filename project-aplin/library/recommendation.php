<?php
class Recom {

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM recommendation ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,7); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 7)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "R" . $newId; ## tambah huruf
    }

    public static function getUsersRecom(string $id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                            FROM recommendation
                            WHERE user = ?
                            LIMIT 8");
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getUsersForYou(string $id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT F.*
                            FROM film F, recommendation R
                            WHERE R.user = ? AND R.film = F.id
                            LIMIT 8");
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function setUsersRecom(string $userId, array $films) #user id, array of films
    {
        $db = DB::getInstance();
        $result = $db->prepare("DELETE 
                                FROM recommendation
                                WHERE user = ?");
        $result->execute([$userId]);

        foreach ($films as $f)
        {
            $id = self::generateId();
            $filmId = $f["id"];
            $recom = $db->prepare("INSERT INTO recommendation
                                    VALUES (?,?,?)
                                    ");
            $recom->execute([$id, $userId, $filmId]);
        }

        return $result;
    }

    public static function getRecomFromUsersHistory(string $id) #user id
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT C.id as id
                            FROM history_user H, category C, film_category FC 
                            WHERE H.user = ? AND FC.category = C.id AND FC.film = H.film
                            LIMIT 8");
        $stmt->execute([$id]);
        $categories = $stmt->fetchAll();

        $categoryQuery = "";
        foreach ($categories as $c)
        {
            $category = $c["id"];
            $categoryQuery = $categoryQuery . " C.id = '$category' OR ";
        }
        $categoryQuery = substr($categoryQuery, 0, -3);

        $stmt = $db->prepare("SELECT DISTINCT F.id AS id
                                FROM film F, film_category FC, category C 
                                WHERE F.id = FC.film AND C.id = FC.category AND ($categoryQuery) 
                                AND F.id NOT IN (
                                    SELECT film
                                    FROM history_user
                                    WHERE user = ?
                                )
                                LIMIT 8");
        $stmt->execute([$id]);
        $categories = $stmt->fetchAll();
        return $categories;
    }

    public static function getRecomFromCategories(array $categories) #array of category id
    {
        if (sizeof($categories) <= 0) return;
        $db = DB::getInstance();
        $result = [];
        $categoryQuery = "";
        foreach ($categories as $c)
        {
            $categoryQuery = $categoryQuery . " C.id = '$c' OR";
        }
        $categoryQuery = substr($categoryQuery, 0, -3);

        $result = $db->query(  
            "SELECT DISTINCT F.id AS id
            FROM film F, film_category FC, category C 
            WHERE F.id = FC.film AND C.id = FC.category AND ($categoryQuery)
            LIMIT 8"
        )->fetchAll();

        return $result;
    }

}