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
          <a href="category.php" type="submit" class="btn btn-secondary">Back</a>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Category Details</h3>
              </div>

                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" class="form-control" id="title" placeholder="Enter category name" value="<?= $category["name"] ?>" disabled>
                  </div>
               
            <div class="form-group">
              <label for="description">Views in this category : <?= $views ?> </label>
            </div>
            <div class="form-group">
              <label for="description">Watchtime in this category : <?= gmdate("H:i:s", $watchtime); ?> </label>
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
                                                <a style='color:white; text-decoration: underline;' href='../admin/movie-details.php?film={$f["id"]}'>{$f["title"]}</a>
                                            </td>
                                        </tr>
                                    ";
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <div style="float: right;" class="form-group">
                        <table>
                            <tr>
                                <td>
                                    <form action='category-edit.php' method='get'>
                                      <input type="hidden" name="category" value="<?= $_GET["category"] ?>">
                                      <button style="width: 100px" type='submit' class='btn btn-warning'>Edit</button>
                                    </form>
                                </td>
                            </tr>
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
