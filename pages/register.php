<!DOCTYPE html>
<html lang="en">

<head>
<base target="_parent">
<?php include"head.php" ?>

    <title>ระบบฝากเงิน</title>


    <link href="../css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="../dist/css/administyle.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--><style>
.vl {
    border-left: 6px solid #5cb85c;
    height: 500px;
}
</style>

</head>

<body>

  <div id="wrapper">

        <!-- Navigation -->
       <?php include'nav.php'?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ทำรายการฝากเงิน</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">  
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            สรุปข้อมูลการเงิน
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                           

                            <div class="row">
                                <div class="col-lg-4">

<iframe src="formregister1.php" height="900" width="100%" scrolling="no" frameBorder="0";></iframe>

                                </div>

                                <div class="col-lg-8 vl">
                        <div class="panel panel-green">
                           
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">


<iframe src="https://pulsesms.app/thread/538352187222730" height="800" width="100%" scrolling="yes";></iframe>
                             
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                

            </div>

            

       
       <!--   

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>รหัสธุรกรรม</th>
                                        <th>เวลา</th>
                                        <th>ยูสเซอร์</th>
                                        <th>ชื่อ</th>
                                        <th>เลขที่บัญชี</th>
                                        <th>ธนาคาร</th>
                                        <th>จำนวนฝาก</th>
                                        <th>โบนัส</th>
                                        <th>ผู้ตรวจสอบ</th>
                                        <th>สถานะ</th>
                                        <th>หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>



<?php
        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

        
    
        $sql = "SELECT category,transactionid,user,date_now,surelastname,banknumber,bank,tel,idline,deposit,bonus,withdraw,tperson,aperson,note,liststatus,ip
                FROM scclub_data WHERE  (aperson != '' AND withdraw ='')
                ORDER BY transactionid DESC LIMIT 100"; 
                

        $query = $db->query($sql);
    
        while($row = $query->fetch()) {        

            echo '
                                    <tr>
                                        <td>'.$row['transactionid'].'</td>
                                        <td>'.date('H:i:s',strtotime($row['date_now'])).'</td>
                                        <td>'.$row['user'].'</td>
                                        <td>'.$row['surelastname'].'</td>
                                        <td>'.$row['banknumber'].'</td>
                                        <td>'.$row['bank'].'</td>
                                        <td>'.$row['deposit'].'</td>
                                        <td>'.$row['bonus'].'</td>
                                        <td>'.$row['aperson'].'</td>
                                        <td>'.$row['liststatus'].'</td>
                                        <td>'.$row['note'].'</td>
                                    </tr>'
                                     ;

  }
        
?> 

                                
                                    
                         
                                </tbody>
                            </table>

                            /.panel --> 
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
            "aaSorting" : [[0, "desc"]],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData[11] == "unconfirm" )
                    {
                        $('td', nRow).css('background-color', 'Red');
                    }
                    else if ( aData[11] == "confirm" )
                    {
                        $('td', nRow).css('background-color', 'Green');
                    } 
                }

        });
    });

    $('.input-daterange input').each(function() {
    $(this).datepicker('clearDates');
});
    </script>

</body>

</html>
