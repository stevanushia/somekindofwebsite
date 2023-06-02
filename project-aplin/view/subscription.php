<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscriptions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>
    <?php   
        include_once base_path()."/template/navbar.php"; 
        require_once base_path().'\vendor\autoload.php';
        if (isset($_SESSION['msg'])) {
            $msg = $_SESSION['msg'];
            unset($_SESSION['msg']);
            echo "<script>alert('$msg')</script>";
        }
    ?>




    <h1 style="text-align: center; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;">Pilih Subscription Model</h1>
    <!-- <div class="card border-success mb-3" style="max-width: 18rem; margin-left: 400px;">
        <div class="card-header bg-transparent border-success">MONTH</div>
        <div class="card-body text-success">
            <h5 class="card-title">Price : </h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <div class="card-footer bg-transparent border-success">Footer</div>
    </div>

    <div class="card border-success mb-3" style="max-width: 18rem; margin-left: 800px; margin-top: -235px;">
        <div class="card-header bg-transparent border-success">YEAR</div>
        <div class="card-body text-success">
            <h5 class="card-title">Price :</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <div class="card-footer bg-transparent border-success">Footer</div>
    </div> -->
    



    <!-- ====================================================================================== -->
    <br>
    <table border="0px" style="margin-left: 610px;">
        <tr>
            <td>
                <b></b>
                <div class="card border-success mb-3" style="max-width: 18rem; width: 900px;">
                    <div class="card-header bg-transparent border-success">Subscription</div>
                    <div class="card-body text-success" >
                        <h5 class="card-title">Price : </h5>
                        <p class="card-text">Ini bulanan</p>
                        <?php
                            $arrModels = Subs::getmonth();
                            foreach ($arrModels as $m) {
                                echo "
                                <tr>
                                    <td>
                                        Rp. {$m['price']} - {$m['name']}
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                        
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        <?php
                            $arrModels = Subs::getmonth();
                            foreach ($arrModels as $m) {
                                echo "
                                <tr>
                                    <td>
                                        <form method='post' action='payment.php'>
                                            <input type='hidden' name='price' value='{$m['price']}'>
                                            <input type='hidden' name='id' value='{$m['id']}'>
                                            <button type='submit'>Purchase</button>
                                        </form>
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                    </div>
                    
                </div>
            </td>
            
            
        </tr>

        <tr>
            <td>
                <b></b>
                <div class="card border-success mb-3" style="max-width: 18rem; width: 900px;">
                    <div class="card-header bg-transparent border-success">Subscription</div>
                    <div class="card-body text-success  " >
                        <h5 class="card-title">Price :</h5>
                        <p class="card-text">Ini tahunan
                        <?php
                            $arrModels = Subs::getyear();
                            foreach ($arrModels as $m) {
                                echo "
                                <tr>
                                <td>
                                    Rp. {$m['price']} - {$m['name']}
                                </td>
                                
                                
                                </tr>
                                ";
                            }
                        ?>
                        </p>
                        
                    </div>

                    <div class="card-footer bg-transparent border-success">
                        <?php
                            $arrModels = Subs::getyear();
                            foreach ($arrModels as $m) {
                                echo "
                                <tr>
                                    <td>
                                        <form method='post' action='payment.php'>
                                            <input type='hidden' name='price' value='{$m['price']}'>
                                            <input type='hidden' name='id' value='{$m['id']}'>
                                            <button type='submit'>Purchase</button>
                                        </form>
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                    </div>
                    
                </div>
            </td>
        </tr>

        <!-- <?php
            $arrModels = Subs::GetAllModel();
            foreach ($arrModels as $m) {
                echo "
                <tr>
                <td>
                    Rp. {$m['price']}
                </td>
                <td>
                    {$m['name']}
                </td>
                <td>
                    <form method='post' action='payment.php'>
                        <input type='hidden' name='price' value='{$m['price']}'>
                        <input type='hidden' name='id' value='{$m['id']}'>
                        <button type='submit'>Purchase</button>
                    </form>
                </td>
                </tr>
                ";
            }
        ?> -->
    </table>




    
</body>
</html>