<?php
class Lists {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM lists ORDER BY tier")->fetchAll();
        return $result;
    }

    public static function getAllVisible()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM lists WHERE status = 1 ORDER BY tier")->fetchAll();
        return $result;
    }
    
    public static function getFromId($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                            FROM lists
                            WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result;
    } 

    public static function updateList($id, $name, $desc)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("UPDATE lists
                            SET name = ?, description = ?
                            WHERE id = ?");
        $stmt->execute([$name, $desc, $id]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function getMembersFromId($id)
    {   
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                            FROM lists_member
                            WHERE lists_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM lists ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "L" . $newId; ## tambah huruf
    }

    public static function generateTier()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT COUNT(*) + 1 AS id FROM lists")->fetch();
        return $result["id"];
    }

    public static function generateListId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM lists_member ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],2,10); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 10)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "LM" . $newId; ## tambah huruf
    }

    public static function insert($name, $desc)
    {
        $db = DB::getInstance();
        $tier = self::generateTier();
        $id = self::generateId();
        $result = $db->prepare("INSERT INTO lists
                                VALUES (?, ?, ?, ?, 0)
                                ");
        $result = $result->execute([$id, $name, $desc, $tier]);
        return $result;
    }

    public static function turnVisible($id)
    {
        $db = DB::getInstance();
        $result = $db->prepare("UPDATE lists
                                SET status = 1 WHERE id = ?
                                ");
        $result = $result->execute([$id]);
        return $result;
    }

    public static function turnHidden($id)
    {
        $db = DB::getInstance();
        $result = $db->prepare("UPDATE lists
                                SET status = 0 WHERE id = ?
                                ");
        $result = $result->execute([$id]);
        return $result;
    }

    public static function setTier($id, $tier)
    {
        $db = DB::getInstance();
        $result = $db->prepare("UPDATE lists
                                SET tier = ? WHERE id = ?
                                ");
        $result = $result->execute([$tier, $id]);
        return $result;
    }

    public static function deleteLists($id)
    {
        $db = DB::getInstance();
        $result = $db->prepare("DELETE FROM lists
                                WHERE id = ?
                                ");
        $result = $result->execute([$id]);
        return $result;
    }

    public static function insertInto($listId, $filmId)
    {
        $db = DB::getInstance();
        $id = self::generateListId();
        $result = $db->prepare("INSERT INTO lists_member
                                VALUES(?,?,?)
                                ");
        $result = $result->execute([$id, $listId, $filmId]);
        return $result;
    }

    public static function deleteFrom($id)
    {
        $db = DB::getInstance();
        $result = $db->prepare("DELETE FROM lists_member
                                WHERE id = ?
                                ");
        $result = $result->execute([$id]);
        return $result;
    }
}
