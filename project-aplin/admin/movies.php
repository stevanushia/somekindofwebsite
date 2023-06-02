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
        ?>
            <div class="content-wrapper">

            <div class="content-header">
            <div class="container-fluid">
                <div class="">
                <div class="col-sm-8">
                    <h1 class="m-0">MASTER MOVIES</h1> <br>

                </div>
            <div>

        <div class="card-body p-0">
        <form method="post" action="movies-add.php">
            <button type="submit" class="btn btn-success">Add New Movie</button>
        </form>
        <br><br>
        <div class="table-responsive">
            <table id="myTable">
            <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>TITLE</th>
                <th>PLAY</th>
                <th>DETAIL</th>
		        <th>DELETE</th>
                <th>IMDB</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $array = Film::getAll();
                $path = base_path();
                $search = $_POST["search-table"] ?? "";
                foreach ($array as $value)
                {
                    $iddelete = $value["id"] . '-delete';
                    if ( str_contains($value["title"] , $search) )
                    {
                        
                        echo 
                        "
                            <tr>
                                <td>
                                    {$value["id"]}
                                </td>
                                <td>
                                    <img style='width:100px' src='../admin/{$value["thumbnail"]}'>
                                </td>
                                <td>
                                    {$value["title"]}
                                </td>
    
                                <td>
                                    <form method='get' action='preview-admin.php'>
                                        <input type='hidden' name='film' value='{$value["id"]}'>
                                        <button class='btn btn-primary' type='submit'>Preview</button>
                                    </form>
                                    </td>
                                    <td>
                                        <form method='get' action='movie-details.php'>
                                        <input type='hidden' name='film' value='{$value["id"]}'/>
                                        <button class='btn btn-primary' type='submit'>Detail</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form id='{$iddelete}' action='movies-action.php' method='post'>
                                            <input type='hidden' name='id_delete' value='{$value["id"]}'>
                                            <input type='hidden' name='delete'>
                                            <button type='button' onclick='showConfirmation(`{$iddelete}`)' name='delete' class='btn btn-danger'>Delete</button>
                                        </form>
                                    </td>
                                    
                                <td>
                            ";
                            ?>
                                    <button onclick="window.open('<?= $value['imdb'] ?>', '_blank')" class='btn btn-warning'>IMDB</button>
                            <?php
                                echo   "</td>
                            </tr>
                        "
                        ;
                    }
                }
            ?>
            </tbody>
            </table>
        </div>

    </body>
    <script>
        new DataTable( '#myTable', {
            ordering: false
        } );
    </script>
</html>
