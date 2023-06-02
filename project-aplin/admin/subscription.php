<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Subscription Models</title>
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
                    <h1 class="m-0">MASTER SUBSCRIPTION MODELS</h1> <br>
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
                                <form method="post" action="subscription-add.php">
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
        <form method="post" action="subscription-add.php">
            <button type="submit" class="btn btn-success">Add New Subscription</button>
        </form>
        <br><br>
        <div class="table-responsive">
            <table id="myTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>PRICE</th>
                <th>PRICING</th>
                <th>SUBSCRIBED USERS</th>
                <th>DETAILS</th>
            	<th>DELETE</th>
	    </tr>
            </thead>
            <tbody>
                <?php
                // echo phpversion();
                $array = Subs::getAllModel();
                $path = base_path();
                foreach ($array as $value)
                {
                    $count = Subs::getModelsCount($value["id"]);
                    $search = $_POST["search-table"] ?? "";
                    $iddelete = $value["id"] . '-delete';
                    if ( str_contains($value["name"] , $search) )
                    {
                        $price = number_format(($value["price"]), 0);;
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
                                    Rp. {$price}
                                </td>
                                <td>
                                    Every {$value["pricing_model"]} days
                                </td>
                                <td>
                                    {$count}
                                </td>
                                <td>
                                    <form action='subscription-details.php' method='get'>
                                        <input type='hidden' name='subscription' value='{$value["id"]}'>
                                        <button type='submit' class='btn btn-primary'>Details</button>
                                    </form>
                                </td>
                                <td>
                                    <form id='{$iddelete}' action='subscription-action.php' method='post'>
                                        <input type='hidden' name='id_delete' value='{$value["id"]}'>
                                        <input type='hidden' name='deletesub'>
                                        <button type='button' onclick='showConfirmation(`{$iddelete}`)' name='deletesub' class='btn btn-danger'>Delete</button>
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
