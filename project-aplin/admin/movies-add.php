<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Movie</title> 
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
            
        ?>
            <div class="content-wrapper">

            <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          <a href="movies.php" type="submit" class="btn btn-secondary">Back</a>
            <div class="col-sm-6">
              <h1>New Movie</h1>
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
                  <h3 class="card-title">Movie Details</h3>
                </div>
                
                <div role="form">
                  <div class="card-body">
                    <div class="form-group">
                        <form method="post" action="">
                            <label for="title">TMDB</label>
                            <input type="text" name="search_tmdb" class="form-control" id="title" placeholder="Enter TMDB title" >
                            <button name="tmdb" class="btn btn-secondary" >Import</button>
                        </form>
                        <?php
                            $results = "";
                            if (isset($_POST["search_tmdb"])) $results = $_POST["search_tmdb"];
                            $searched = TMDB::searchMovies($results);
                            foreach ($searched as $movie) {
                                $year = " (" . substr($movie['release_date'],0,4) . ")";
                                echo "<form method='post' action=''>"
                                    .$movie['title'].$year.
                                    "<input type='hidden' name='movie_tambahed' value='".json_encode($movie)."'>
                                    <button name='menambah'>Tambah</button>
                                    </form>";
                                $movie = null;
                            }
                            
                            if(isset($_POST["menambah"]))
                            {
                                $imported = (array) json_decode($_POST["movie_tambahed"]);
                            }
                        ?>
                    </div>
                    <hr>
                <form method="post" action="movies-action.php" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Enter movie title" value="<?= $imported["title"] ?? "" ?>">
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" name="desc" id="description" placeholder="Enter movie description"  ><?=  $imported["overview"] ?? "" ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="age_rating">Age Rating</label>
                      <input type="text" name="age" class="form-control" id="age_rating" placeholder="Enter age rating" value="<?= TMDB::getAgeRating($imported['id'] ?? "") ?>">
                    </div>
                    <div class="form-group">
                      <label for="release_date">Release Date</label>
                      <input type="date" name="releasedate" class="form-control" id="release_date" value="<?= date("Y-m-d", strtotime($imported["release_date"] ?? "")) ?>">
                    </div>
                    <div class="form-group">
                      <label for="score">Video Directory</label>
                      <input type="text" name="video_link" class="form-control" id="score" placeholder="admin/movies/" value="">
                      <input type="file" name="video_file" id="fileInput" class="form-control-file">
                    </div>
                    <div class="form-group">
                      <label for="score">ts</label>
                      <input type="file" name="ts_file[]" id="fileInput" class="form-control-file" multiple>
                    </div>
                    <div class="form-group">
                      <label for="score">Thumbnail Directory</label>
                      <input type="text" name="thumbnail_link" class="form-control" id="score" placeholder="admin/thumbnail/" value="">
                      <input type="file" name="thumbnail_file" id="fileInput" class="form-control-file">
                    </div>
                    <div class="form-group">
                      <label for="score">IMDB</label>
                      <input type="text" name="imdb" class="form-control" id="score" placeholder="admin/movies/" value="<?= TMDB::getImdbLink($imported['id'] ?? "") ?>">
                    </div>
                    <div class="form-group">
                      <label for="score">Score</label>
                      <input type="number" name="score" class="form-control" id="score" placeholder="Enter movie score" value="<?= $imported["vote_average"] ?>">
                    </div>
                    <div class="form-group">
                        <button name="upload" type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
                    <div>
                
                

        <br>
        <div class="card-body p-0">

    </body>
</html>