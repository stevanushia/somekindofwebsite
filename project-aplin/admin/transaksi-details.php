<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Transaksi Details</title> 
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
            include_once base_path()."/admin/preloader.php"; 
            
            if (isset($_GET["htrans"]))
            {
                $htrans = $_GET["htrans"];
                $trans = Transaksi::getDtransFromHtrans($_GET["htrans"]);
            } else header("Location: transaksi.php")

        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          <a href="transaksi.php" type="submit" class="btn btn-secondary">Back</a>

            <div class="col-sm-6">
              <h1><?= $htrans ?></h1>
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
                  <h3 class="card-title">Details Transaksi</h3>
                </div>
                <div role="form">
                  <div class="card-body">
                    <div class="form-group">
                      <label ></label>
                      <table class="table m-0">
                        <thead>
                        <tr>
                            <th>DTRANS ID</th>
                            <th>SUB MODEL</th>
                            <th>QTY</th>
                            <th>SUBTOTAL</th>
                        </tr>
                        </thead>
                        <?php
                            foreach ($trans as $t)
                            {   
                                echo "
                                    <tr>
                                        <td>   
                                            {$t['id']}
                                        </td>
                                        <td>   
                                            <a style='color:white; text-decoration: underline;'  href='../admin/subscription-details.php?subscription={$t['subscription_model_id']}'>{$t['subscription_model_id']}</a>
                                        </td>
                                        <td>
                                            {$t['qty']}
                                        </td>
                                        <td>
                                            {$t['subtotal']}
                                        </td>
                                    <tr>
                                ";
                            }
                        ?>
                        </table>
                    </div>
                  </div>
                   
                    
                <div>
                        </div>

                
                

        <br>
        <div class="card-body p-0">

    </body>
</html>

