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

        ?>
            <div class="content-wrapper">

            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0">MASTER LISTINGS</h1> <br>
                    <!-- <form method="post" action=""> -->
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
                                </form>
                                <form method="post" action="listings-add.php">
                                            <td>
                                                <button type="submit" class="btn btn-success">Add</button>
                                            </td>
                                        <tr>
                                    </table>
                                </form>
                            <tr>
                        </table> -->
                </div>
            <div>

        <div class="card-body p-0">
        <form method="post" action="listings-add.php">
            <button type="submit" class="btn btn-success">Add New Listing</button>
        </form>
        <br><br>
        <div class="table-responsive">
            <table id="myTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>DESCRIPTION</th>
                <th>TIER</th>
                <th>STATUS</th>
                <th>MEMBERS</th>
                <th>DETAILS</th>
		<th>DELETE</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $array = Lists::getAll();
                    $path = base_path();
                    foreach ($array as $value)
                    {
                        $member_count = count(Lists::getMembersFromId($value["id"]));
                        $search = $_POST["search-table"] ?? "";
                        $iddelete = $value["id"] . '-delete';
                        if ($value["status"] == 1) $status = "Visible";
                        else $status = "Invisible";
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
                                        {$value["description"]}
                                    </td>
                                    <td>
                                        {$value["tier"]}
                                    </td>
                                    <td>
                                        {$status}
                                    </td>
                                    <td>
                                        {$member_count}
                                    </td>
                                    <td>
                                        <form action='listings-details.php' method='get'>
                                            <input type='hidden' name='listings' value='{$value["id"]}'>
                                            <button type='submit' class='btn btn-primary'>Details</button>
                                        </form>
                                    </td>
                                    <td>
                                    <form id='{$iddelete}' action='listings-action.php' method='post'>
                                        <input type='hidden' name='id_delete' value='{$value["id"]}'>
                                        <input type='hidden' name='delete'>
                                        <button type='button' onclick='showConfirmation(`{$iddelete}`)' name='delete' class='btn btn-danger'>Delete</button>
                                    </form>
                                    </td>
                                </tr>
                            ";
                        }
                    }
                ?>

            
            </tbody>
            </table>
            <div class="card-body">
                <h1>Set Order</h1> <br>
                <?php   
                    $arrLists = Lists::getAll();
                    echo "<ul id='sortable-list' class='list-group'>";
                    foreach ($arrLists as $l)
                    {
                        $index = key($arrLists) + 1;
                        if ($l["status"] == 0) echo "<i>";
                        echo "
                            <li id='{$index}'>
                                <form method='get' action='listings-details.php'>
                                    <input type='hidden' name='listid' value='{$l["id"]}'>
                                    {$l['id']} {$l['name']}
                                </form>
                            </li>
                        ";
                        if ($l["status"] == 0) echo "</i>";
                        next($arrLists);
                    }
                    echo "</ul>";
                ?>
                <br>
                <form action="listings-action.php" method="post" id="form-reoder">
                    <input type="hidden" name="neworder" id="orderings">
                    <button type="submit" onclick="setOrder()" class="btn btn-primary">Save Order</button>
                </form>
            </div>
        </div>

    </body>
    <script>
        new DataTable( '#myTable', {
            ordering: false
        } );
    </script>
</html>
