
<!DOCTYPE html>
<html lang="en">

<head>

<?php include"head.php" ?>


    <title>SCWALLET แก้ไขรายการ</title>


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
    if($_SESSION['userid'] == "007")
    {
        echo "!!! คุณไม่ได้รับสิทธิ์ให้เข้าถึงหน้านี้ !!!";
        exit();
    }

    if($_SESSION['userid'] == "008")
    {
        echo "!!! คุณไม่ได้รับสิทธิ์ให้เข้าถึงหน้านี้ !!!";
        exit();
    }

    if($_SESSION['userid'] == "009")
    {
        echo "!!! คุณไม่ได้รับสิทธิ์ให้เข้าถึงหน้านี้ !!!";
        exit();
    }

    if($_SESSION['userid'] == "010")
    {
        echo "!!! คุณไม่ได้รับสิทธิ์ให้เข้าถึงหน้านี้ !!!";
        exit();
    }

    if($_SESSION['userid'] == "011")
    {
        echo "!!! คุณไม่ได้รับสิทธิ์ให้เข้าถึงหน้านี้ !!!";
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
                    <h1 class="page-header">แก้ไขรายการ</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
              <div class="col-lg-12">
                <form name="formcheck" action="#" method="get">
               <input class="checkuser" type="text" name="sendget" id="sendget" value="">
               <button type="submi2" name="submit2" class="btn btn-warning"> ตรวจสอบ</button>
               </form>


                <?php
                mysql_connect($HOST_NAME,$USERNAME,$PASSWORD);
                mysql_select_db($DB_NAME);
                mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
                $strSQL = "SELECT * FROM scclub_data WHERE transactionid = '".$_GET['sendget']."' ";
                $objQuery = mysql_query($strSQL);
                $objResult = mysql_fetch_array($objQuery);
               if(!$objResult)
               {
                   echo "ไม่พบ รหัสธุรกรรมนี้ = ".$_GET["sendget"];
               }

               ?>
               <hr>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12">
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>เลขที่ธุรกรรม</th>
                <th>เวลา</th>
                <th>ชื่อ - สนามสกุล</th>
                <th>ฝาก</th>
                <th>ถอน</th>
                <th>โบนัส</th>
                <th>ผู้ทำรายการ</th>
                <th>แก้ไข</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $objResult["transactionid"];?></td>
                <td><?php echo $objResult["date_now"];?></td>
                <td><?php echo $objResult["surelastname"];?></td>
                <td><?php echo $objResult["deposit"];?></td>
                <td><?php echo $objResult["withdraw"];?></td>
                <td><?php echo $objResult["bonus"];?></td>
                <td><?php echo $objResult["tperson"];?></td>
                <td><a href="tsedit.php?transactionid=<?php echo $objResult["transactionid"];?>">แก้ไข</a></td>
            </tr>
        </tbody>
    </table>

              </div>
            </div>
            <!-- /.row -->


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
