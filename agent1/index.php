
<!DOCTYPE html>
<html lang="en">

<head>

<?php include"head.php" ?>


    <title>SCCLUB99 แผงควบคุม Agent1</title>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>


    <?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        echo "Please Login!";
        exit();
    }

    if($_SESSION['adminlevel'] != "1")
    {
        echo "<h1>คุณไม่มีสิทธิ์ใช้งานในหน้านี้</h1>";
        header( "location: register.php" );
        exit(5);
    }


    mysql_connect($HOST_NAME,$USERNAME,$PASSWORD);
    mysql_select_db($DB_NAME);
    mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
    $strSQL = "SELECT * FROM administrator WHERE userid = '".$_SESSION['userid']."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
?>

    <div id="wrapper">

<?php include'nav.php'?>



        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">แผงควบคุม Agent1 (<?php echo date("d-m-Y");  ?>)</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

<?php
        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);
        $sql = "SELECT * FROM `scclub_data` WHERE liststatus = 'confirm' AND `date_now` LIKE '%".date("Y-m-d")."%'";
        $result=mysql_query("SELECT count(*) as registercount from scclub_data WHERE category = 'สมัครสมาชิก' AND `date_now` LIKE '%".date("Y-m-d")."%'");
$data=mysql_fetch_assoc($result);



$query = $db->query($sql);


        $totaldeposit = 0;
        $totalbonus = 0;
        $totalwithdraw =0;
        while($row = $query->fetch()) {
            $totaldeposit = $totaldeposit + $row["deposit"];
            $totalbonus = $totalbonus + $row["bonus"];
            $totalwithdraw = $totalwithdraw + $row["withdraw"];
            $totalregister = 1;

        }



//print_r ($row);

        ?>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo number_format($totaldeposit); ?>
                                    </div>
                                    <div>รวมฝาก <?php echo number_format($totaldeposithead); ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="depositlog.php"><span class="pull-left">ดูรายละเอียด</span></a>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-minus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo number_format($totalwithdraw); ?></div>
                                    <div>รวมถอน <?php echo number_format($totalwithdrawhead); ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="withdraw.php"><span class="pull-left">ดูรายละเอียด</span></a>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-money fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo number_format($totalbonus); ?></div>
                                    <div>รวมแจกโบนัส <?php echo number_format($totalbonushead); ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="bonus.php"><span class="pull-left">ดูรายละเอียด</span></a>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading" id="resultshow">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo number_format($totaldeposit-$totalwithdraw); ?></div>
                                    <div>กำไร / ขาดทุน <?php echo number_format($totaldeposithead-$totalwithdrawhead); ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="results.php"><span class="pull-left">ดูรายละเอียด</span></a>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $data['registercount']; ?></div>
                                    <div>สมาชิกทั้งหมด <?php echo number_format($data2['registercount']); ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="userlist.php">
                            <div class="panel-footer">
                                <span class="pull-left">ดูรายละเอียด</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">0</div>
                                    <div>ปัญหาการใช้งานวันนี้</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">ดูรายละเอียด</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> ยอดค้างเดิมพันสมาชิก
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

<iframe src="http://ag.ufabet.com/_Age/MemberOuts.aspx?role=ag&userName=uffq01
" height="500" width="100%" scrolling="yes";></iframe>


                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> การทำรายการล่าสุด
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <!-- /.panel -->
                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <iframe src="https://pulsesms.app/thread/538352187222730" height="500" width="100%" scrolling="yes";></iframe>




                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

            <script>
    $(document).ready(function() {
    var Totalall = <?php echo $totaldeposit+-$totalwithdraw; ?>;
            if(Totalall < 0){
                $("#resultshow").css("background", "#d9534f");
            }
        });
    </script>

</body>

</html>
