<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Subscription</title> 
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
            include_once base_path()."/admin/preloader.php"; 
        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
              <a href="subscription.php" type="submit" class="btn btn-secondary">Back</a>
            <div class="col-sm-6">
             
              <h1>New Subscription Model</h1>
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
                  <h3 class="card-title">Subscription Model Details</h3>
                </div>
                <form role="form" method="post" action="subscription-action.php">
                  <div class="card-body">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                      <label >Price</label>
                      <input type="number" class="form-control" name="price">
                    </div>
                    <div class="form-group">
                      <label >Pricing Model : (Expire Every # Days)</label>
                      <input type="number" class="form-control" name="model">
                    </div>
                    
                  
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" name="insertsub">Add</button>
                    </div>
                   
                </form>
                <div>
                
                

        <br>
        <div class="card-body p-0">

    </body>
</html>