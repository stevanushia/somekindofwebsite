<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Listings</title> 
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
              <a href="listings.php" type="submit" class="btn btn-secondary">Back</a>
            <div class="col-sm-6">
             
              <h1>New Listings</h1>
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
                  <h3 class="card-title">Listings Details</h3>
                </div>
                <form role="form" method="post" action="listings-action.php">
                  <div class="card-body">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Enter listings name">
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" name="description" placeholder="Enter listings description"  ></textarea>
                    </div>
                    <div class="form-group">
                      <label >Tier : <?= Lists::generateTier(); ?></label>
                    </div>
    
                    
                  
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" name="insertlist">Add</button>
                    </div>
                   
                </form>
                <div>
                
                

        <br>
        <div class="card-body p-0">

    </body>
</html>