<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Users</title>
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
        ?>
            <div class="content-wrapper">

            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0">MASTER USERS</h1> <br>
                    <form method="post" action="">
                        <!-- <table>
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
                            <tr>
                        </table> -->
                    </form>
                </div>
            <div>

        <br>
        <div class="card-body p-0">
        <div class="table-responsive">
            <table id="myTable" >
            <thead>
            <tr>
                <th>ID USER</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>STATUS</th>
                <th>TOGGLE</th>
                <th>DETAILS</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $array = Users::getAll();
                $path = base_path();
                foreach ($array as $value)
                {
                    $search = $_POST["search-table"] ?? "";
                    $hashed = password_hash($value["pass"], PASSWORD_DEFAULT);
		    $classBtn = "btn btn-danger";
		    if ($value["status"] == "Inactive") $classBtn = "btn btn-success";
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
                                    {$value["email"]}
                                </td>
                                <td>
                                    {$value["status"]}
                                </td>
                                <td>
                                    <form action='users-action.php' method='post'>
                                        <input type='hidden' name='idUser' value='{$value["id"]}'>
                                        <button type='submit' name='toggleStatus' class='<?= $classBtn ?>'>Toggle</button>
                                    </form>
                                </td>
                                <td>
                                    <form action='users-details.php' method='get'>
                                        <input type='hidden' name='user' value='{$value["id"]}'>
                                        <button type='submit' class='btn btn-primary'>Details</button>
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
</html>
