<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>category</title>
  <?php
  include_once base_path() . "/admin/cdn.php";
  ?>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <?php
  include_once base_path() . "/admin/main-header.php";
  include_once base_path() . "/admin/sidebar.php";
  include_once base_path() . "/admin/preloader.php";

  if (isset($_GET["category"])) {
    $category = Category::getFromId($_GET["category"]);
    $views = Category::getViewsFromId($_GET["category"]);
    $watchtime = Category::getWatchtimeFromId($_GET["category"]);
    $films = Category::getFilmsFromId($_GET["category"]);
    $iddelete = $_GET["category"] . "-delete";
  } else header("Location: category.php")
  ?>
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <a href="category-details.php?category=<?= $_GET["category"] ?>" type="submit" class="btn btn-secondary">Back</a>
          <div class="col-sm-6">
            <h1><?= $category["id"] ?></h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
              </div>

              <form method="post" action="category-action.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" class="form-control" id="title" placeholder="Enter category name" value="<?= $category["name"] ?>">
                  </div>
                  <div class="form-group">
                    <table>
                      <tr>
                        </form>

                        <td>
                          <form id='update1-form' action='category-action.php' method='post'>
                <input type='hidden' name='id' value='<?= $category["id"] ?>'>
                <input type="hidden" id="namaKategori" name="name" value="<?= $category["name"] ?>">
                <input type='hidden' name='update'>
                <button type="button" onclick='showNotif()' name="update" class="btn btn-primary">Update Name</button>
              </form>
                        </td>
                      
              
              </td>
              <td>
                <form id='<?= $iddelete ?>' action='category-action.php' method='post'>
                    <input type='hidden' name='id_delete' value='<?= $category["id"] ?>'>
                    <input type='hidden' name='delete'>
                    <button type='button' onclick='showConfirmation("<?= $iddelete ?>")' name='delete' class='btn btn-danger'>Delete category</button>
                </form>
              </td>
              </tr>
              </table>
            </div>
            <div class="form-group">
              <label>Add Movies : </label>
              <select class="select2" multiple="multiple" style="width: 100%;" class="form-control">
                <?php
                $arr = Film::getAllNotInCategory($category["id"]);
                foreach ($arr as $f) {
                  echo "<option value='{$f['id']}'>{$f['title']}</option>";
                }
                ?>
              </select>
              <input type="hidden" class="categoryId" value="<?= $category["id"]  ?>">
              <button type="button" id="btnSetCategory" class="btn btn-primary">Add Films</button>
            </div>
            <div class="form-group">
              <label for="description">Films in this category</label>
              <table>
                <tbody>
                  <?php
                  foreach ($films as $f) {
                    echo "
                                      
                                        <tr>
                                            <td>
                                              <form method='post' action='category-action.php'>
                                                <input type='hidden' name='idcategory' value='{$category['id']}'>
                                                <input type='hidden' name='idfilm' value='{$f['id']}'>
                                                <button type='submit' name='removeFilm' class='btn btn-dark'>X</button>
                                              </form>
                                            </td>
                                            <td>
                                                <a style='color:white; text-decoration: underline;' href='../admin/movie-details.php?film={$f["id"]}'>{$f["title"]}</a>
                                            </td>
                                        </tr>
                                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <div>



              <br>
              <div class="card-body p-0">

</body>
<script>
  $("#title").on("change", function(){
    $("#namaKategori").val(this.value);
  })

  $('#btnSetCategory').on('click', function() {
    var selectedValues = $('.select2').val();
    var categoryId = $('.categoryId').val();

    executePhpFunction(selectedValues, categoryId);
  });

  function executePhpFunction(selectedTags, categoryId) {
    fetch('../admin/set-category.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'tags=' + encodeURIComponent(JSON.stringify(selectedTags)) + '&id=' + encodeURIComponent(JSON.stringify(categoryId))
      })
      .then(response => response.text())
      .then(result => {
        console.log(result);
        location.reload();

      });
  }
</script>

</html>
