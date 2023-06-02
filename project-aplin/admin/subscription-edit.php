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
          <a href="subscription-details.php?subscription=<?= $_GET["subscription"] ?>" type="submit" class="btn btn-secondary">Back</a>

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
              <div class="card card-warning">
                
                <div class="card-header">
                  <h3 class="card-title">Edit Subscription Model</h3>
                </div>
                <div role="form">
                  <div class="card-body">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name" value="<?= $subs["name"]?>" >
                    </div>
                    <div class="form-group">
                      <label >Price</label>
                      <input type="number" class="form-control" name="price" value="<?= $subs["price"]?>" >
                    </div>
                    <div class="form-group">
                      <label >Pricing Model : (Expire Every <?= $subs["pricing_model"]?> Days)</label>
                      <input type="number" class="form-control" name="pricing" value="<?= $subs["pricing_model"]?>" >
                    </div>

                    <div style="float: right;" class="form-group">
                        <table>
                            <tr>
                                <td>
                                        <input type='hidden' name='id' value='<?= $subs["id"] ?>'>
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form id='<?= $iddelete ?>' action='subscription-action.php' method='post'>
                                      <input type='hidden' name='id_delete' value='<?= $subs["id"] ?>'>
                                      <input type='hidden' name='deletesub'>
                                      <button type='button' onclick='showConfirmation("<?= $iddelete ?>")' name='deletesub' class='btn btn-danger'>Delete Listings</button>
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
