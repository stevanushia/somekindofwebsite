<?php
class Users {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM users")->fetchAll();
        return $result;
    }

    public static function getAllSubscribed()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT DISTINCT * FROM users WHERE id IN (SELECT user FROM subscription_user)")->fetchAll();
        return $result;
    }

    public static function getFromId($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM users
                              WHERE id = ?
                                ");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM users ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "U" . $newId; ## tambah huruf
    }

    public static function checkTaken($name)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE name=?");
        $stmt->execute([$name]); 
        $result = $stmt->fetch();
        return $result;
    }

    public static function cekEmailAda($email)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]); 
        $result = $stmt->fetch();
        return $result;
    }

    public static function insert($name,$email,$pass)
    {
        $db = DB::getInstance();
        $id = users::generateId();
        $stmt = $db->prepare("INSERT INTO users VALUES (?, ?, ?, ?, '', 'Active')");
        $result = $stmt->execute([$id, $name, $email, $pass]);
        return $result;
    }

    public static function delete($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $result = $stmt->execute([$id]);
        return $result;
    }

    public static function logging(string $username, string $password)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * 
                                FROM users 
                            WHERE name=? AND pass = ? AND status = 'Active'");
        $stmt->execute([$username, $password]); 
        $result = $stmt->fetch();
        return $result;
    }

    public static function checkSubscription($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * 
                                FROM users 
                                WHERE id=? 
                                AND id IN  (SELECT user FROM subscription_user WHERE exp_date > {fn NOW()})");
        $stmt->execute([$id]); 
        $result = $stmt->fetch();
        return $result;
    }

    public static function getUsersSubscription($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * 
                                FROM subscription_user 
                                WHERE user=? 
                                ");
        $stmt->execute([$id]); 
        $result = $stmt->fetch();
        return $result;
    }

    public static function toggleStatus($idUser)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * 
                                FROM users 
                                WHERE id = ? 
                                ");
        $stmt->execute([$idUser]); 
        $result = $stmt->fetch();
        if ($result["status"] == "Active")
        {
            $stmt = $db->prepare("UPDATE users 
                                    SET status = 'Inactive'
                                    WHERE id=? 
                                ");
        }
        else if ($result["status"] == "Inactive")
        {
            $stmt = $db->prepare("UPDATE users 
                                    SET status = 'Active'
                                    WHERE id=? 
                                ");
        }
        
        $result = $stmt->execute([$idUser]); 
        return $result;
    }
}
