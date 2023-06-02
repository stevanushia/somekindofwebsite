<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>category</title>
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    <!-- <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script> -->
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
                <h1 class="m-0">MASTER CATEGORY</h1>
                <!-- <div class="row mb-2">

                    <form method="post" action="">
                        <table border="1px solid black ">
                            <tr>
                                <td>
                                    <b>Search :</b>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="search-table" id="">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </td>
                    </form>
                                <form method="post" action="category-add.php">
                                            <td>
                                                <button type="submit" class="btn btn-success">Add</button>
                                            </td>
                                </form>
                                        <tr>
                                    </table>
                            <tr>
                        </table>
                </div> -->
            <div>

        <br>
        <div class="card-body p-0">
        <form method="post" action="category-add.php">
            <button type="submit" class="btn btn-success">Add New category</button>
        </form>
        <br><br>
        <div class="table-responsive">
            <table id="myTable" >
                <thead>
                    <tr>
                        <th>ID category</th>
                        <th>TITLE</th>
                        <th>TOTAL MOVIES</th>
                        <th>DETAILS</th>
			<th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $array = Category::getAll();
                    $path = base_path();
                    foreach ($array as $value)
                    {
                        $count = Category::getCountMovies($value["id"]);
                        $search = $_POST["search-table"] ?? "";
                        $iddelete = $value["id"] . '-delete';
                        if ( str_contains($value["name"] , $search) )
                        {
                            echo 
                            "
                                <tr>
                                    <td>
                                        {$value["id"]}
                                    </td>
                                    <td>
                                        {$value["name"]}
                                    </td>
                                    <td>
                                        {$count}
                                    </td>
                                    <td>
                                        <form action='category-details.php' method='get'>
                                            <input type='hidden' name='category' value='{$value["id"]}'>
                                            <button type='submit' class='btn btn-primary'>Details</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form id='{$iddelete}' action='category-action.php' method='post'>
                                            <input type='hidden' name='id_delete' value='{$value["id"]}'>
                                            <input type='hidden' name='delete'>
                                            <button type='button' onclick='showConfirmation(`{$iddelete}`)' name='delete' class='btn btn-danger'>Delete</button>
                                        </form>
                                    </td>
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
    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
</html>
