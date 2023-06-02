<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Movies</title> 
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
            include_once base_path()."/admin/preloader.php"; 
            
            if (isset($_GET["user"]))
            {
                $users = Users::getFromId($_GET["user"]);
                $classBtn = "btn btn-danger";
		if ($users["status"] == "Inactive") $classBtn = "btn btn-success";
            } else header("Location: userss.php")
        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <a href="users.php" type="submit" class="btn btn-secondary">Back</a>

            <div class="col-sm-6">
                <h1><?= $users["id"] ?></h1>
            </div>
            </div>
        </div>
        </section>
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <!-- Form -->
            <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Users Details</h3>
                </div>
                <div role="form">
                    <div class="card-body">
                    <div class="form-group">
                        <label for="description">Name : <?= $users["name"]?></label> <br>
                        <label for="description">Email : <?= $users["email"]?></label><br>
                        <label for="description">Status : <?= $users["status"]?></label>
                        <form action='users-action.php' method='post'>
                            <input type='hidden' name='idUser' value='<?= $users["id"]?>'>
                            <button type='submit' name='toggleStatusDetail' class='<?= $classBtn ?>'>Toggle</button>
                        </form>
                    </div>

                    <div class="form-group">
                        <label for="description">Subscription : </label> <br>
                        <?php
                            $id = $users["id"];
                            $userSub = Subs::getUsersSubscription($id);
                            if ($userSub) {
                                $subModel = Subs::getSub($userSub['sub_model']);
                                    
                                $now = time(); 
                                $expDate = strtotime($userSub['exp_date']);
                                $datediff = abs(round(($now - $expDate) / (60 * 60 * 24)));
                            
                                echo 'Subscription Model : ' . $subModel['name'] . '<br>';
                                echo 'Purchased On : ' . $userSub['purchase_date'] . '<br>';
                                echo 'Will Expire In : ' . $userSub['exp_date'] . " (" . $datediff ." Days)" . '<br>';
                                echo "<form action='users-action.php' method='post'>
                                        <input type='hidden' name='id' value='{$userSub['id']}'>
                                        <input type='hidden' name='id-user' value='{$id}'>
                                        <button class='btn btn-warning' name='cancel-subs'>Cancel Subscription</button>
                                        </form>";
                                // echo '<button class="btn btn-warning">Cancel</button>';
                            }
                            else {
                                echo 'Have not purchased a subscription.';
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="description">Recommended : </label> <br>
                        <?php
                            $arrForYou = Recom::getUsersForYou($id);
                            foreach ($arrForYou as $h)
                            {
                                $filmName = Film::getFromId($h['id']);
                                echo "
                                    <a style='color: white; text-decoration: underline;' href='../admin/movie-details.php?film={$filmName["id"]}'>{$filmName["title"]}</a>
                                    <br>
                                ";
                            }
            
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="description">History : </label> <br>
                        <?php
                            $arrHistory = History::getUsersHistory($id);
                            foreach ($arrHistory as $h)
                            {
                                $filmName = Film::getFromId($h['film']);
                                $minutes = floor($h['timestamp'] / 60);
                                $seconds = $h['timestamp'] % 60;
                                $timestamp = sprintf("%02d:%02d", $minutes, $seconds);

                                echo "
                                    <a style='color: white; text-decoration: underline;' href='../admin/movie-details.php?film={$filmName["id"]}'>{$filmName["title"]}</a>
                                     - {$timestamp} - {$h['last_updated']} <br>
                                ";
                            }
                        ?>
                    </div>
                    
                <div>
                
                

        <br>
        <div class="card-body p-0">

    </body>
</html>
