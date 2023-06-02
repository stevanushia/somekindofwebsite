<?php
class Category {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM category")->fetchAll();
        return $result;
    }

    public static function getFromId($id)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM category WHERE id = '$id'")->fetch();
        return $result;
    }

    public static function getViewsFromId($id)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT COUNT(H.id) as NUMBER 
                              FROM history_user H, film F, film_category FC, category C
                              WHERE C.id = '$id' 
                                    AND FC.category = C.id
                                    AND F.id = FC.film
                                    AND H.film = F.id
                                    "
                              )->fetch();
        return $result["NUMBER"];
    }

    public static function getWatchtimeFromId($id)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(SUM(H.timestamp),0) as NUMBER 
                              FROM history_user H, film F, film_category FC, category C
                              WHERE C.id = '$id'
                                    AND FC.category = C.id
                                    AND F.id = FC.film
                                    AND H.film = F.id
                                    "
                              )->fetch();
        return $result["NUMBER"];
    }

    public static function getFilmsFromId($id)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT F.* 
                            FROM film F, film_category FC 
                            WHERE FC.category = '$id' AND F.id = FC.film"
                            )->fetchAll();
        return $result;
    }

    public static function getCountMovies($idCategory)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT COUNT(*) as NUMBER FROM film_category WHERE category = '$idCategory'")->fetch();
        return $result["NUMBER"];
    }

    public static function updateCategory($id, $name)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("UPDATE category
                            SET name = ?
                            WHERE id = ?");
        $stmt->execute([$name, $id]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM category ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "C" . $newId; ## tambah huruf
    }

    public static function generateIdEntry()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM film_category ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,7); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 7)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "C" . $newId; ## tambah huruf
    }

    public static function insert($name)
    {
        if($name != ""){
            $db = DB::getInstance();
            $id = self::generateId();
            $result = $db->prepare("INSERT INTO category
                                    VALUES (?, ?)
                                    ");
            $result = $result->execute([$id, $name]);
            return $result;
        }
        else{
            $_SESSION['msg'] = "Field tidak boleh kosong! ";
            return;
        }
    }

    public static function insertCategory($film, $category)
    {
        $db = DB::getInstance();
        $id = self::generateIdEntry();
        if (!self::checkHasCategory($film, $category))
        {
            $result = $db->prepare("INSERT INTO film_category 
                                    VALUES (?, ?, ?)
                                    ");
            $result = $result->execute([$id, $category, $film]);
            return $result;
        }
    }

    public static function checkHasCategory($film, $category)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT COUNT(*) AS AMOUNT
                                FROM film_category
                                WHERE category = ? AND film = ?
                                ");
        $stmt->execute([$film, $category]);
        $result = $stmt->fetch();
        return $result["AMOUNT"];
    }

    public static function nameTaken($name)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM category WHERE name=?");
        $stmt->execute([$name]); 
        $result = $stmt->fetch();
        return $result;
    }

    public static function clearFilmsCategory($film)
    {   
        $db = DB::getInstance();
        $result = $db->prepare("DELETE FROM film_category
                                WHERE film = ?
                                ");
        $result = $result->execute([$film]);
        return $result;
    }

    public static function removeFromCategory($film, $category)
    {   
        $db = DB::getInstance();
        $result = $db->prepare("DELETE FROM film_category
                                WHERE film = ? AND category = ?
                                ");
        $result = $result->execute([$film, $category]);
        return $result;
    }

    public static function delete($id)
    {   
        $db = DB::getInstance();
        $result = $db->prepare("DELETE FROM film_category
                                WHERE category = ?
                                ");
        $result = $result->execute([$id]);
        $result = $db->prepare("DELETE FROM category
                                WHERE id = ?
                                ");
        $result = $result->execute([$id]);
        return $result;
    }
}   
