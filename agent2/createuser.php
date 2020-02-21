<!DOCTYPE html>


<head>

<?php include"head.php" ?>

    <title>SB Admin 2 - Bootstrap Admin Theme</title>



    <link href="../css/bootstrap-datepicker.css" rel="stylesheet">

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
    $strSQL = "SELECT * FROM administrator WHERE userid = '".$_SESSION['userid']."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
?>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include'nav.php'?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="page-header">สร้างบัญชีสมาชิกใหม่</h1>
                </div>
               <div class="col-lg-4" style="margin-top: 70px;">
            <!--   <div class="input-group input-daterange">
    <input type="text" class="form-control" value="2012-04-05">
    <div class="input-group-addon">ถึง</div>
    <input type="text" class="form-control" value="2012-04-19">
</div> Navigation -->
</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            ข้อมูลการสมัครสมาชิก
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th aria-sort="ascending">รหัสธุรกรรม</th>
                                        <th>ประเภทธุรกรรม</th>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th>รหัสสมาชิก</th>
                                        <th>ชื่อสมาชิก</th>
                                        <th>เลขที่บัญชี</th>
                                        <th>ธนาคาร</th>
                                        <th>จำนวนฝาก</th>
                                        <th>โบนัสฝาก</th>
                                        <th>ผู้ทำรายการ</th>
                                        <th>อนุมัติ/ไม่อนุมัติ</th>

                                    </tr>
                                </thead>
                                <tbody>
<?php
        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

        $sql = "SELECT category,transactionid,user,date_now,surelastname,banknumber,bank,tel,deposit,bonus,withdraw,tperson,aperson,liststatus,note,ip
                FROM scclub_data2 WHERE (category = 'สมัครสมาชิก'  AND liststatus ='')
                ORDER BY transactionid DESC"; // ASC เรียงน้อยไปมาก หรือ DESC เรียง มากไปน้อย
        $query = $db->query($sql);

        while($row = $query->fetch()) {

            echo '
                                    <tr>
                                        <td>'.$row['transactionid'].'</td>
                                        <td>'.$row['category'].'</td>
                                        <td>'.date('d/m/Y',strtotime($row['date_now'])).'</td>
                                        <td>'.date('H:i:s',strtotime($row['date_now'])).'</td>
                                        <td>'.$row['user'].'</td>
                                        <td>'.$row['surelastname'].'</td>
                                        <td>'.$row['banknumber'].'</td>
                                        <td>'.$row['bank'].'</td>
                                        <td>'.$row['deposit'].'</td>
                                        <td>'.$row['bonus'].'</td>
                                        <td>'.$row['tperson'].'</td>
                                        <td align="center"><a href="cfcreateuser.php?transactionid='.$row['transactionid'].'">Edit</a></td>
                                    </tr>
                                    '
                                     ;
        }
?>






                                </tbody>
                            </table>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>




    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../js/bootstrap-datepicker.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            searching: false,
            "order": [[ 3, "desc" ]]
        });
    });

    $('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});






    </script>

</body>

</html>
