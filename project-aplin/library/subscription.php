<?php
class Subs {

    public static function getAll()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM subscription_user")->fetchAll();
        return $result;
    }

    public static function getModelFromId($id)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM subscription_model WHERE id = '$id'")->fetch();
        return $result;
    }

    public static function getSubscriptionBetweenDates($modelId, $startDate, $endDate)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                              FROM subscription_user WHERE
                              sub_model LIKE CONCAT('%',?,'%')
                              AND purchase_date >= ? AND purchase_date <= ? 
                            ");                        
        $stmt->execute([$modelId, $startDate, $endDate]);
        $result = $stmt->fetchAll();
        return $result;
    }


    public static function updateModel($id, $name, $price, $model)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("UPDATE subscription_model
                            SET name = ?, price = ?, pricing_model = ?
                            WHERE id = ?");
        $stmt->execute([$name, $price, $model, $id]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function getAllModel()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM subscription_model")->fetchAll();
        return $result;
    }

    public static function getModelsCount($modelId)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT COUNT(*) AS NUMBER FROM subscription_user WHERE sub_model = '$modelId'")->fetch();
        return $result["NUMBER"];
    }

    public static function getModelsSubscribers($modelId)
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM subscription_user WHERE sub_model = '$modelId'")->fetchAll();
        return $result;
    }

    public static function getUsersSubscription($user)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                            FROM subscription_user
                            WHERE user = ?");
        $stmt->execute([$user]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function getSub($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT *
                            FROM subscription_model
                            WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function getModelDate($modelId)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT pricing_model
                            FROM subscription_model
                            WHERE id = ?");
        $stmt->execute([$modelId]);
        $result = $stmt->fetch();
        $date = date('Y-m-d', strtotime("+".$result["pricing_model"]." days"));
        return $date;
    }

    public static function generateId()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM subscription_user ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,7); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 7)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "S" . $newId; ## tambah huruf
    }

    public static function generateIdModel()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT IFNULL(id,0) AS id FROM subscription_model ORDER BY id DESC")->fetch(); ## ambil id paling tinggi
        $newId = substr($result["id"],1,5); ## potong jadi angka saja
        $newId = (int) $newId; ## jadikan int
        $newId++; ## increment 1+
        while (strlen($newId) < 5)
        {
            $newId = "0" . $newId; ## tambah 0 sampai total digit ada 5
        }
        return "M" . $newId; ## tambah huruf
    }

    public static function insertModel($name, $price, $model) //bagian insert new subs
    {
        if ($name && $price && $model != "") {
            $db = DB::getInstance();
            $id = self::generateIdModel();
            $stmt = $db->prepare("INSERT INTO subscription_model 
                                VALUES (?,?,?,?)
                                ");
            $result = $stmt->execute([$id, $name, $price, $model]);
            return $result;
        }
        else{
            $_SESSION['msg'] = "Field tidak boleh kosong! ";
            return;
        }
    }

    public static function deleteModel($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("DELETE FROM subscription_user 
                              WHERE sub_model = ?
                            ");
        $stmt->execute([$id]);
        $stmt = $db->prepare("DELETE FROM subscription_model 
                              WHERE id = ?
                            ");
        $result = $stmt->execute([$id]);
        return $result;
    }

    public static function insert($user, $model)
    {
        $db = DB::getInstance();
        $id = self::generateId();
        $date = self::getModelDate($model);
        $stmt = $db->prepare("INSERT INTO subscription_user
                              VALUES (?,?,?, {fn NOW()}, ?)
                            ");
        $result = $stmt->execute([$id, $model, $user ,$date]);
        return $result;
    }

    public static function renew($user, $model)
    {
        $db = DB::getInstance();

        $stmt = $db->prepare("SELECT pricing_model
                            FROM subscription_model
                            WHERE id = ?");
        $stmt->execute([$model]);
        $extendedDays = $stmt->fetch();

        $stmt = $db->prepare("SELECT exp_date
                            FROM subscription_user
                            WHERE user = ?");
        $stmt->execute([$user]);
        $expireDate = $stmt->fetch();
        
        $expireDate= date_create($expireDate["exp_date"]);
        date_add($expireDate,date_interval_create_from_date_string($extendedDays["pricing_model"]." days"));
        $date =  date_format($expireDate,"Y-m-d");
      

        $stmt = $db->prepare("UPDATE subscription_user
                              SET sub_model = ?, purchase_date = {fn NOW()}, exp_date = ?
                              WHERE user = ?
                            ");

        $result = $stmt->execute([$model, $date, $user]);
        return $result;
    }

    public static function getmonth()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM subscription_model where name='Monthly'")->fetchAll();
        return $result;
    }
    public static function getyear()
    {
        $db = DB::getInstance();
        $result = $db->query("SELECT * FROM subscription_model where name='yearly'")->fetchAll();
        return $result;
    }

    public static function deleteSubs($id)
    {
        $db = DB::getInstance();
        $stmt = $db->prepare("DELETE FROM subscription_user 
                                WHERE id = ?
                            ");
        $result = $stmt->execute([$id]);
        return $result;
    }
}
