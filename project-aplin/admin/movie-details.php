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
            include_once base_path()."/admin/message.php"; 
            
            if (isset($_GET["film"]))
            {
                $movie = Film::getFromId($_GET["film"]);
                $views = Film::getViewsFromId($_GET["film"]);
                $watchtime = Film::getWatchtimeFromId($_GET["film"]);
                $iddelete = $_GET["film"] . "-delete";

            } else header("Location: movies.php")
        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          <a href="movies.php" type="submit" class="btn btn-secondary">Back</a>
            <div class="col-sm-6">
              <h1><?= $movie["id"] ?></h1>
            </div>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Form -->
          <div class="row">
            <div>
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Movie Details</h3>
                </div>
                <!-- Movie Details Form -->
                <video id="my-video" class="video-js vjs-default-skin vjs-sleek-skin" controls preload="auto" width="782" height="386" data-setup='{"plugins":{"httpStreaming":{"beforeRequest": function(options) {options.headers = options.headers || {};options.headers.Authorization = "ADMIN";}}}}'>
                        <source src="../admin/<?=$movie["link"]  ?>" type="application/x-mpegURL">
                </video>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Enter movie title" value="<?=$movie["title"] ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" name="desc" id="description" placeholder="Enter movie description" disabled ><?=  $movie["description"] ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="age_rating">Age Rating</label>
                      <input type="text" name="age" class="form-control" id="age_rating" placeholder="Enter age rating" value="<?=$movie["age_rating"] ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="release_date">Release Date</label>
                      <input type="date" name="releasedate" class="form-control" id="release_date" value="<?= date("Y-m-d", strtotime($movie["release_date"] ?? "")) ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="score">Video Directory</label>
                      <input type="text" name="video_link" class="form-control" id="score" placeholder="admin/movies/" value="<?=$movie["link"] ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="score">Thumbnail Directory</label>
                      <input type="text" name="thumbnail_link" class="form-control" id="score" placeholder="admin/thumbnail/" value="<?=$movie["thumbnail"] ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="score"><a style='color:white; text-decoration: underline;' href="<?=$movie["imdb"] ?>">IMDB</a></label>
                      <input type="text" name="imdb" class="form-control" id="score" placeholder="admin/movies/" value="<?=$movie["imdb"] ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="score">Score</label>
                      <input type="number" name="score" class="form-control" id="score" placeholder="Enter movie score" value="<?=$movie["score"] ?>" disabled>
                    </div>
                
                    <div class="form-group">
                      <label for="score">Categories : <?php
                          $arr = Film::getFilmsCategory($_GET["film"]);
                          foreach ($arr as $c) {
                              echo "<a style='color:white; text-decoration: underline;' href='./category-details.php?category={$c['id']}'>{$c['name']}</a> ";
                          }
                      ?></label> <br>
                      <label for="score">Lists : <?php
                          $arr = Film::getFilmsLists($_GET["film"]);
                          foreach ($arr as $l) {
                              echo "<a style='color:white; text-decoration: underline;' href='./listings-details.php?listings={$l['id']}'>{$l['name']}</a> ";
                          }
                      ?></label> <br>
                      <label for="score">Views : <?= $views ?></label> <br>
                      <label for="score">Watchtime : <?= gmdate("H:i:s", $watchtime); ?></label>
                      </div>
                <div>
                <div style="float: right;" class="form-group">
                        <table>
                            <tr>
                                <td>
                                    <form action='movie-edit.php' method='get'>
                                      <input type="hidden" name="film" value="<?= $_GET["film"] ?>">
                                      <button style="width: 100px" type='submit' class='btn btn-warning'>Edit</button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                
        <br>
        <div class="card-body p-0">

    </body>
</html>
