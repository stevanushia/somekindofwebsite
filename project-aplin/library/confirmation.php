<?php
class Confirmation {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM confirmation")->fetchAll();
        return $result;
    }

    public static function getConfirmationBetweenDates($startDate, $endDate)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM confirmation WHERE
                                date_confirmed >= ? AND date_confirmed <= ? 
                            ");                        
        $stmt->execute([$startDate, $endDate]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public static function cekNamaAda($nama)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM confirmation
                                WHERE username = ?
                                ");                        
        $stmt->execute([$nama]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function cekEmailAda($email)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM confirmation
                                WHERE email = ?
                                ");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM confirmation ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],2,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "CO" . $newId; ## tambah huruf
    }

    public static function getFromCode($code)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                                FROM confirmation
                                WHERE code = ?
                                ");                        
        $stmt->execute([$code]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function insert($name, $email, $pass, $code)
    {
        $db = DB::getInstance();
        $id = self::generateId();
        $result = $db->prepare("INSERT INTO confirmation
                                (id, username, email, password, code, date_created)
                                VALUES (?, ?, ?, ?, ?, {fn NOW()})
                                ");
        $result = $result->execute([$id, $name, $email, $pass, $code]);
        return $result;
        
    }

    public static function delete($id)
    {   
        $db = DB::getInstance();
        $result = $db->prepare("DELETE FROM confirmation
                                WHERE id = ?
                                ");
        $result = $result->execute([$id]);
        return $result;
    }

    public static function confirmFromEmail($email)
    {   
        $db = DB::getInstance();
        $result = $db->prepare("UPDATE confirmation 
                                SET date_confirmed = {fn NOW()}
                                WHERE email = ?
                                ");
        $result = $result->execute([$email]);
        return $result;
    }
}
