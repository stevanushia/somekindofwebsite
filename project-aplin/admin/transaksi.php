<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Transaction</title>
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php"; 
        ?>
            <br>

            <div class="content-wrapper">

            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0">TRANSACTION HISTORY</h1> <br>
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>Start Date</td>
                                <td>:</td>
                                <td><input class="form-control" type="date" name="startDate" id="" value="<?= $_POST["startDate"] ?? date("1999-05-24") ?>"></td>
                                <td> - </td>
                                <td><input class="form-control" type="date" name="endDate" id="" value="<?= $_POST["endDate"] ?? date('Y-m-d') ?>"></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            <div>

        <br>
        <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>DATE</th>
                <th>USER</th>
                <th>TOTAL PAID</th>
                <th>DETAILS</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $array = Transaksi::getAllHtrans();
                $path = base_path();
                $startDate = $_POST["startDate"] ?? date("1999-05-24");
                $endDate = $_POST["endDate"] ?? date("2999-05-24");
                foreach ($array as $value)
                {
                    $price = number_format(($value["total_cost"]), 0);;

                    if ( $value["purchase_date"] > $startDate && $value["purchase_date"] < $endDate)
                    {
                        echo 
                        "
                            <tr>
                                <td>
                                    {$value["id"]}
                                </td>
    
                                <td>
                                    {$value["purchase_date"]}
                                </td>
    
                                <td>
                                    <a style='color: white; text-decoration: underline;' href='../admin/users-details.php?user={$value["user"]}'>{$value["user"]}</a>
                                </td>

                                <td>
                                    Rp. {$price}
                                </td>

                                <td>
                                    <form method='get' action='transaksi-details.php'>
                                        <input type='hidden' name='htrans' value='{$value["id"]}'/>
                                        <button class='btn btn-primary' type='submit'>Detail</button>
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
</html>
