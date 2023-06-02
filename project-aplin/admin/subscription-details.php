<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Subscription Details</title> 
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
            include_once base_path()."/admin/preloader.php"; 
            
            if (isset($_GET["subscription"]))
            {
                $subs = Subs::getModelFromId($_GET["subscription"]);
                $iddelete = $_GET["subscription"] . "-delete";

            } else header("Location: userss.php")

        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          <a href="subscription.php" type="submit" class="btn btn-secondary">Back</a>

            <div class="col-sm-6">
              <h1><?= $subs["id"] ?></h1>
            </div>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
        <form action='subscription-action.php' method='post'>

          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary">
                
                <div class="card-header">
                  <h3 class="card-title">Subscription Model Details</h3>
                </div>
                <div role="form">
                  <div class="card-body">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name" value="<?= $subs["name"]?>" disabled>
                    </div>
                    <div class="form-group">
                      <label >Price</label>
                      <input type="number" class="form-control" name="price" value="<?= $subs["price"]?>" disabled>
                    </div>
                    <div class="form-group">
                      <label >Pricing Model : (Expire Every <?= $subs["pricing_model"]?> Days)</label>
                      <input type="number" class="form-control" name="pricing" value="<?= $subs["pricing_model"]?>" disabled>
                    </div>
                    <div class="form-group">
                      <label >Subscribers : <?= Subs::getModelsCount($subs["id"]) ?></label>
                    </div>
                    <div class="form-group">
                      <label >Users with this Subscription</label>
                      <table class="table m-0">
                        <thead>
                        <tr>
                            <th>NAME</th>
                            <th>PURCHASE DATE</th>
                            <th>EXP DATE</th>
                        </tr>
                        </thead>
                        <?php
                            $members = Subs::getModelsSubscribers($subs["id"]);
                            foreach ($members as $mem)
                            {   
                                $user = Users::getFromId($mem["user"]);
                                echo "
                                    <tr>
                                        <td>   
                                            <a style='color:white; text-decoration: underline;'  href='../admin/users-details.php?user={$user["id"]}'>{$user["name"]}</a>
                                        </td>
                                        <td>
                                           {$mem["purchase_date"]}
                                        </td>
                                        <td>
                                           {$mem["exp_date"]}
                                        </td>
                                    <tr>
                                ";
                            }
                        ?>
                        </table>
                    </div>
                  
                    <div style="float: right;" class="form-group">
                        <table>
                            <tr>
                                <td>
                                        
                                    </form>
                                </td>
                                <td>
                                    <form action='subscription-edit.php' method='get'>
                                      <input type="hidden" name="subscription" value="<?= $_GET["subscription"] ?>">
                                      <button style="width: 100px" type='submit' class='btn btn-warning'>Edit</button>
                                  </form>
                                </td>
                            </tr>
                        </table>

                    </div>
                   
                    
                <div>
                        </div>

                
                

        <br>
        <div class="card-body p-0">

    </body>
</html>
