<?php
class Transaksi {

    public static function getAllHtrans()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM htrans")->fetchAll();
        return $result;
    }

    public static function getAllDtrans()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM htrans")->fetchAll();
        return $result;
    }

    public static function getDtransFromHtrans($htrans)
    {
        $db = DB::getInstance();
        $result = $db->prepare("SELECT *
                                FROM dtrans
                                WHERE htrans = ?
                                ");
        $result->execute([$htrans]);
        $result = $result->fetchAll();
        return $result;
    }

    public static function generateIdHtrans()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM htrans ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "H" . $newId; ## tambah huruf
    }

    public static function generateIdDtrans()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM dtrans ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,7   ); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 7)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "D" . $newId; ## tambah huruf
    }

    public static function insertHtrans($id, $user, $total)
    {
        $db = DB::getInstance();
        $result = $db->prepare("INSERT INTO htrans
                                VALUES (?, {fn NOW()}, ?, ?) #id, tgl, total cost, user pembeli
                                ");
        $result = $result->execute([$id, $total, $user]);
        return $result;
    }

    public static function insertDtrans($htrans, $subscription, $qty, $subtotal)
    {
        $db = DB::getInstance();
        $id = self::generateIdDtrans();
        $result = $db->prepare("INSERT INTO dtrans
                                VALUES (?, ?, ?, ?, ?) #id, subscription, qty, subtotal
                                ");
        $result = $result->execute([$id, $htrans, $subscription, $qty, $subtotal]);
        return $result; 
    }

}