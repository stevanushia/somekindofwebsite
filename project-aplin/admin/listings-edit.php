<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Listings</title> 
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
            include_once base_path()."/admin/preloader.php"; 
            include_once base_path()."/admin/message.php"; 

            
            if (isset($_GET["listings"]))
            {
                $list = Lists::getFromId($_GET["listings"]);
                $iddelete = $_GET["listings"] . "-delete";
                if ($list["status"] == 1) $status = "Visible";
                else $status = "Invisible";
            } else header("Location: userss.php")

        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          <a href="listings-details.php?listings=<?= $_GET["listings"] ?>" type="submit" class="btn btn-secondary">Back</a>

            <div class="col-sm-6">
              <h1><?= $list["id"] ?></h1>
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
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">Edit Lists</h3>
                </div>
                <form method="post" action="listings-action.php">
                  <div class="card-body">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name" value="<?= $list["name"]?>" >
                    </div>
                    <div class="form-group">
                      <label >Description</label>
                      <input type="text" class="form-control" name="description" value="<?= $list["description"]?>" >
                    </div>
                    <div class="form-group">
                      <label >Tier : <?= $list["tier"] ?></label>
                    </div>
                    <div class="form-group">
                      <label >Status : <?= $status?></label>
                    </div>

                    <div style="float: right;" class="form-group">
                        <table>
                            <tr>
                                <td>
                                        <input type='hidden' name='id' value='<?= $list["id"] ?>'>
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="listings-action.php">
                                            <input type='hidden' name='listid' value='<?= $list["id"]?>'>
                                            <button type='submit' name='toggleVisible' class='btn btn-warning'>Toggle</button>
                                    </form>
                                </td>
                                <td>
                                    <form id='<?= $iddelete ?>' action='listings-action.php' method='post'>
                                      <input type='hidden' name='id_delete' value='<?= $list["id"] ?>'>
                                      <input type='hidden' name='delete'>
                                      <button type='button' onclick='showConfirmation("<?= $iddelete ?>")' name='delete' class='btn btn-danger'>Delete Listings</button>
                                  </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                      <label >Add Movies : </label>
                      <select class="select2" multiple="multiple" style="width: 100%;" class="form-control">
                        <?php
                          $arr = Film::getAllNotInLists($list["id"]);
                          foreach ($arr as $f) {
                            echo "<option value='{$f['id']}'>{$f['title']}</option>";
                          }
                        ?>
                      </select>
                      <input type="hidden" class="listsId" value="<?= $list["id"]  ?>">
                      <button style="float: right;" type="button" id="btnSetLists"  class="btn btn-primary">Add Films</button>
                    </div>
                    <br>

                    <div class="form-group">
                      <label >Movies in this List</label>
                        <table>
                        <?php
                            $members = Lists::getMembersFromId($list["id"]);
                            foreach ($members as $mem)
                            {
                                $arrId[] = $mem['film_id'];
                                $f = Film::getFromId($mem['film_id']);
                                echo "
                                    <tr>
                                        <td>
                                            <form method='post' action='listings-action.php'>
                                                <input type='hidden' name='memberid' value='{$mem['id']}'>
                                                <input type='hidden' name='listid' value='{$list['id']}'>
                                                <button type='submit' name='removefromlist' class='btn btn-dark'>x</button>
                                            </form>
                                        </td>
                                        <td>
                                            <a style='color:white;text-decoration:underline;' href='../admin/movie-details.php?film={$f["id"]}'>{$f["title"]}</a>
                                        </td>
                                    <tr>
                                ";
                            }
                        ?>
                        </table>
                    </div>
                   
                    
                <div>
                
                

        <br>
        <div class="card-body p-0">

    </body>

    <script>
      $('#btnSetLists').on('click', function() {
            var selectedValues = $('.select2').val();
            var listId = $('.listsId').val();
            
            executePhpFunction(selectedValues, listId);
        });

        function executePhpFunction(selectedTags, listId) {
            fetch('../admin/set-lists.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'tags=' + encodeURIComponent(JSON.stringify(selectedTags)) + '&id=' + encodeURIComponent(JSON.stringify(listId))
            })
                .then(response => response.text())
                .then(result => {
                    console.log(result);
                    location.reload();

                });
        }
    </script>
</html>
