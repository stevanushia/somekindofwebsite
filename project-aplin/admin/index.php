<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <?php
            include_once base_path()."/admin/cdn.php"; 
    ?>
    <style>
        #line-chart-container .ct-label,
        #line-chart-container .ct-grid {
            stroke: white;
            fill: white;
            color: white;
        }

        #line-chart-container {
            width: 100%;
            height: 400px; /* Adjust the height as per your requirement */
        }
    </style>
    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php
            include_once base_path()."/admin/main-header.php"; 
            include_once base_path()."/admin/sidebar.php";  
            include_once base_path()."/admin/preloader.php"; 

            $filmCount = count(Film::getAll());
            // $globalWatchtime = Film::getGlobalWatchtime();

            $userCount = count(Users::getAll()); 
            $categoryCount = count(Category::getAll());
            $subCount = count(Users::getAllSubscribed());

            if (isset($_POST["clearBtn"]))
            {
                unset($_SESSION["datay"]);
                unset($_SESSION["datay-names"]);
            }
        ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                    <h1 class="m-0">DASHBOARD</h1><br><br>
            </div>
            
            <section class="content">
            <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $filmCount ?></h3>
                            <h4>Films</h4>
                        </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                                <a href="movies.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $categoryCount ?></h3>
                                    <h4>Categories</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                    <a href="category.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $userCount ?></h3>
                                    <h4>User Registered</h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                    <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3><?= $subCount ?></h3>
                                        <h4>User Subscribe</h4>
                                    </div>
                                <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="subscription.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div >
                    <table>
                    <form method="post">
                        <tr>
                            <td><b>X Axis : </b></td>
                            <td><input class="form-control" type="date" name="startDate" id="" value="<?= $_POST["startDate"] ?? date('Y-m-d', strtotime('-1 month')); ?>"></td>
                            <td><input class="form-control" type="date" name="endDate" id="" value="<?= $_POST["endDate"] ?? date('Y-m-d'); ?>"></td>
                            <td>
                                <select name="xAxisMode" id="xAxisMode" class="form-control">
                                    <option value="+1 month">Monthly</option>
                                    <option value="+1 week">Weekly</option>
                                    <option value="+1 day">Daily</option>
                                </select>
                            </td>
                        </tr>
                            <?php
                                function getDatesBetween($startDate, $endDate, $interval) {
                                    $dates = array();
                                    $currentDate = strtotime($startDate);
                                    $endDate = strtotime($endDate);

                                    while ($currentDate <= $endDate) {
                                        $dates[] = date('Y-m-d', $currentDate);
                                        $currentDate = strtotime($interval, $currentDate);
                                    }
                                    return $dates;
                                }

                                $startDate = $_POST["startDate"] ?? date('Y-m-d', strtotime('-1 month'));
                                $endDate = $_POST["endDate"] ?? date('Y-m-d');

                                $mode = $_POST["xAxisMode"] ?? "+1 month";
                                $data = $_POST["yAxis"] ?? "";

                                if (isset($_POST["xAxisMode"]))
                                {
                                    echo "
                                        <script>
                                            var modex = document.getElementById('xAxisMode');
                                            modex.value = '{$_POST['xAxisMode']}';
                                        </script>
                                    ";
                                }

                                $arrx = [];
                                $arrx = getDatesBetween($startDate, $endDate, $mode);

                                $txtBox = $_POST["txtBox"] ?? "";
                                $arry= [];

                                for ($i=0; $i < count($arrx); $i++) { 
                                    if ($data == "Film Id")
                                    {
                                        // hitung brp banya history dari film nonton antara 2 tanggal
                                        $arry[] = count(History::getHistoryBetweenDatesByFilm($txtBox, $arrx[$i],  date("Y-m-d", strtotime($mode.$arrx[$i]))));
                                    }
                                    else if ($data == "Category Id")
                                    {
                                        // hitung brp banya history fari category nonton antara 2 tanggal
                                        $arry[] = count(History::getHistoryBetweenDatesByCategory($txtBox, $arrx[$i],  date("Y-m-d", strtotime($mode.$arrx[$i]))));
                                    }
                                    else if ($data == "List Id")
                                    {
                                        // hitung brp banya history dari list nonton antara 2 tanggal
                                        $arry[] = count(History::getHistoryBetweenDatesByLists($txtBox, $arrx[$i],  date("Y-m-d", strtotime($mode.$arrx[$i]))));
                                    }
                                    else if ($data == "Model Id")
                                    {
                                        //hitung brp banya subscription dibeli antara dua tgl
                                        $arry[] = count(Subs::getSubscriptionBetweenDates($txtBox, $arrx[$i],  date("Y-m-d", strtotime($mode.$arrx[$i]))));
                                    }
                                    else if ($data == "User Id")
                                    {
                                        $arry[] = count(Confirmation::getConfirmationBetweenDates($arrx[$i],  date("Y-m-d", strtotime($mode.$arrx[$i]))));
                                    }
                                }

                                $dataX = json_encode($arrx);
                                $datay = json_encode($arry);

                            

                                if (isset($_SESSION["datay"]))
                                {
                                    $arrofdatay = json_decode($_SESSION["datay"]);
                                    $arrofdatay[] = json_decode($datay);
                                    $_SESSION["datay"] = json_encode($arrofdatay);

                                    $arrofdatanames = json_decode($_SESSION["datay-names"]);
                                    $dataname = $txtBox;
                                    if ($txtBox == "") $dataname = "Global";
                                    $arrofdatanames[] = $data . " - " . $dataname . " - " . $mode;
                                    $_SESSION["datay-names"] = json_encode($arrofdatanames);

                                    $newarray = json_decode($_SESSION["datay"]);
                                    $newarraynames = json_decode($_SESSION["datay-names"]);
                                    $displayDataY = [];

                                    $ctr = 0;
                                    foreach ($newarray as $n) {
                                        $displayDataY[] = $n;
                                        $ctr++;
                                    }

                                    $displayDataY = json_encode($displayDataY);
                                    // var_dump($displayDataY);
                                } 
                                else 
                                {
                                    if ($datay != "[]")
                                    {
                                        $arrofdatay = [];
                                        $arrofdatay[] = json_decode($datay);
                                        $_SESSION["datay"] = json_encode($arrofdatay);

                                        $arrofdatanames = [];
                                        $dataname = $txtBox;
                                        if ($txtBox == "") $dataname = "Global";
                                        $arrofdatanames[] = $data . " - " . $dataname . " - " . $mode;
                                        $_SESSION["datay-names"] = json_encode($arrofdatanames);

                                        $displayDataY = json_encode($arrofdatay);
                                        // var_dump($displayDataY);
                                    }
                                    else {
                                        $arrofdatay[] = $datay;
                                        $displayDataY = json_encode($arrofdatay);
                                        // var_dump($displayDataY);
                                    }
                                }

                                // var_dump($displayDataY);
                                // var_dump($_SESSION["datay"]);
                                // var_dump($_SESSION["datay-names"]);
                                
                                echo "
                                    <script>
                                        var lineChartData = {
                                            labels: {$dataX},
                                            series: 
                                                    {$displayDataY}
                                                    
                                        };
                                    </script>
                                    ";

                            ?>
                        </tr>
                        <tr>
                            <td><b>Y Axis : </b></td>
                            <td>
                                <select onchange="logSelectedOption()" name="yAxis" id="yAxis" class="form-control">
                                        <option value="Film Id">Film's Watch History</option>
                                        <option value="Category Id">Category's Watch History</option>
                                        <option value="List Id">Listings's Watch History</option>
                                        <option value="Model Id">Subscription History</option>
                                        <option value="User Id">Registration History</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="txtBox" id="yAxisTextbox" placeholder="Film Id">
                            </td>
                            <td>
                                <button type="submit" name="reportBtn" class="btn btn-secondary">Report</button>
                            </form>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <button type="submit" name="clearBtn" class="btn btn-warning">Clear</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="line-chart-container"></div>

            <?php
                    $arr = $arrofdatanames ?? [];
                    echo "<div class='row'>
                            <table class='table m-3'>";
                    $ctr = 1;
                    // var_dump($arr);
                    foreach ($arr as $n) {
                        echo "<tr><td><b>{$ctr}.</b> {$n}</td></tr>";
                        $ctr++;
                    }
                    echo "</table>
                        </div>";
            ?>    




            <section class="col-lg-5 connectedSortable ui-sortable">

            
            </div>

            </div>

            </div>

            </section>

            </div>

            </div>
            </section>
            </div>
            </div>
        </div>
        </div>
    </div>

    </body>
    <?php
    if (isset($_POST["yAxis"]))
    {
        
        echo "
            <script>
                var modey = document.getElementById('yAxis');
                var txty = document.getElementById('yAxisTextbox');
                modey.value = '{$_POST['yAxis']}';
                txty.placeholder = '{$_POST['yAxis']}';
            </script>
        ";
    }
    ?>
    <script>

        function logSelectedOption() {
            // Get the select element
            var selectElement = document.getElementById("yAxis");
            var textboxElement = document.getElementById("yAxisTextbox");

            // Get the selected option
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            // Log the selected option's value to the console
            console.log(selectedOption.value);
            textboxElement.placeholder = selectedOption.value;
        }

        // Line chart data
        // var lineChartData = {
        //     labels: ["January", "February", "March", "April", "May", "June", "July"],
        //     series: [
        //             [65, 59, 80, 81,56, 55, 12]
        //     ]
        // };

        // Line chart options
        var lineChartOptions = {
            fullWidth: true,
            chartPadding: {
                right: 40
            },
                axisX: {
                showGrid: true,
                offset: 50 // Increase the width of the X-axis scale
            },
            axisY: {
                onlyInteger: true,
                showGrid: true,
                offset: 20 // Increase the height of the Y-axis scale
            }
        };

        // Create the line chart
        new Chartist.Line('#line-chart-container', lineChartData, lineChartOptions);
    </script>

</html>