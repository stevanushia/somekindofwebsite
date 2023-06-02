<?php
class Film {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM film")->fetchAll();
        return $result;
    }

    public static function getGlobalWatchtime()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT SUM(timestamp) as NUMBER FROM history_user")->fetch();
        return $result["NUMBER"];
    }

    public static function getAllNotInCategory($categoryId)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM film WHERE
                              id NOT IN (
                                        SELECT film
                                        FROM film_category
                                        WHERE category = ?
                                        );
                            ");                        
        $stmt->execute([$categoryId]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getAllInCategory($categoryId)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM film WHERE
                              id IN (
                                        SELECT film
                                        FROM film_category
                                        WHERE category = ?
                                        );
                            ");                        
        $stmt->execute([$categoryId]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getFilmsCategory($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM category WHERE
                              id IN (
                                        SELECT category
                                        FROM film_category
                                        WHERE film = ?
                                        );
                            ");                        
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getFilmsLists($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM lists WHERE
                              id IN (
                                        SELECT lists_id
                                        FROM lists_member
                                        WHERE film_id = ?
                                        );
                            ");                        
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getAllNotInLists($listsId)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM film WHERE
                              id NOT IN (
                                        SELECT film_id
                                        FROM lists_member
                                        WHERE lists_id = ?
                                        );
                            ");                        
        $stmt->execute([$listsId]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function searchKeyword($keyword) 
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM film
                              WHERE title LIKE '%?%'
                            ");                        
        $stmt->execute([$keyword]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getFromId($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                            FROM film
                            WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function getViewsFromId($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT COUNT(H.id) as NUMBER 
                              FROM history_user H
                              WHERE H.film = ?
                            "
                              );
        $stmt->execute([$id]);
        $result = $stmt->fetch();                   
        return $result["NUMBER"];
    }

    public static function getWatchtimeFromId($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT IFNULL(SUM(H.timestamp),0) as NUMBER 
                              FROM history_user H
                              WHERE H.film = ?
                            "
                              );
        $stmt->execute([$id]);
        $result = $stmt->fetch();    
        return $result["NUMBER"];
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM film ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "F" . $newId; ## tambah huruf
    }

    public static function generateToken($userid, $filmid)
    {
        $db = DB::getInstance();
        $value = $userid.$filmid;
        $token = password_hash($value, PASSWORD_BCRYPT);

        return $token;
    }

    public static function insert($title,$description,$age_rating,$date,$link,$thumbnail,$imdb,$score)
    {
        $db = DB::getInstance();
        $id = self::generateId();
        $result = $db->prepare("INSERT INTO film
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                                ");
        $result = $result->execute([$id, $title, $description, $age_rating, $date, $link, $thumbnail, $imdb, $score]);
        return $result;            

    }

    public static function update($id,$title,$description,$age_rating,$date,$link,$thumbnail,$imdb,$score)
    {
        $db = DB::getInstance();
        $result = $db->prepare("UPDATE film
                                SET title = ?, description = ?, age_rating = ?, release_date = ?, link = ?, thumbnail = ?, imdb = ?, score = ? 
                                WHERE id = ?");
        $result = $result->execute([$title, $description, $age_rating, $date, $link, $thumbnail, $imdb, $score, $id]);
        return $result;
    }

    public static function delete($id)
    {
        $db = DB::getInstance();

        $result = $db->prepare("DELETE 
                                FROM lists_member
                                WHERE film_id = ?");
        $result = $result->execute([$id]);

        $result = $db->prepare("DELETE 
                                FROM film_category
                                WHERE film = ?");
        $result = $result->execute([$id]);

        $result = $db->prepare("DELETE 
                                FROM film
                                WHERE id = ?");
        $result = $result->execute([$id]);

        return $result;
    }
}
