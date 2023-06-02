<?php
class History {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM history_user")->fetchAll();
        return $result;
    }

    public static function getHistoryBetweenDatesByFilm($filmId, $startDate, $endDate)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM history_user WHERE
                                film LIKE CONCAT('%',?,'%') AND
                                last_updated >= ? AND last_updated <= ? 
                            ");                        
        $stmt->execute([$filmId, $startDate, $endDate]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getHistoryBetweenDatesByCategory($categoryId, $startDate, $endDate)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM history_user WHERE
                                film IN 
                                ( SELECT film
                                    FROM film_category
                                    WHERE category LIKE CONCAT('%',?,'%')
                                )
                                AND last_updated >= ? AND last_updated <= ? 
                            ");                        
        $stmt->execute([$categoryId, $startDate, $endDate]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getHistoryBetweenDatesByLists($listId, $startDate, $endDate)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM history_user WHERE
                                film IN 
                                ( SELECT film_id
                                    FROM lists_member
                                    WHERE lists_id LIKE CONCAT('%',?,'%')
                                )
                                AND last_updated >= ? AND last_updated <= ? 
                            ");                        
        $stmt->execute([$listId, $startDate, $endDate]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getUsersHistory($user)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM history_user
                                WHERE user = ?
                                ORDER BY last_updated DESC
                            ");                        
        $stmt->execute([$user]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function getByUsersFilm($user, $film)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM history_user
                                WHERE film = ? AND user = ?
                            ");                        
        $stmt->execute([$film, $user]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM history_user ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,7); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 7)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "H" . $newId; ## tambah huruf
    }

    public static function insert($user, $film, $timestamp, $watched)
    {
        $db = DB::getInstance();
        $id = self::generateId();
        $result = $db->prepare("INSERT INTO history_user
                                VALUES (?, ?, ?, ?, ?, {fn NOW()})
                                ");
        $result = $result->execute([$id, $user, $film, $timestamp, $watched]);
        return $result;
    }

    public static function setNewTimestamp($id, $timestamp)
    {
        $db = DB::getInstance();
        $result = $db->prepare("UPDATE history_user
                                SET timestamp = ?, last_updated = {fn NOW()}
                                WHERE id = ?
                                ");
        $result = $result->execute([$timestamp, $id]);
        return $result;
    }

    public static function setWatched($id, $watched)
    {
        $db = DB::getInstance();
        $id = self::generateId();
        $result = $db->prepare("UPDATE history_user
                                SET watched = ?, last_updated = {fn NOW()}
                                WHERE id = ?
                                ");
        $result = $result->execute([$watched, $id]);
        return $result;
    }
}
