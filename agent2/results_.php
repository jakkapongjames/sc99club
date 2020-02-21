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
                <div class="col-lg-6">
                    <h1 class="page-header">สรุปผลกำไร / ขาดทุน</h1>
                </div>
                <div class="col-lg-6" style="margin-top: 70px;">
                <form method="post">
                    <div class="input-group f-r input-daterange">
                        <input type="text" name="date_from" class="box2" value="<?php echo date('Y-m-d') ?>">
                        <p class="box2">ถึง</p>
                        <input type="text" name="date_to" class="box2" value="<?php echo date('Y-m-d') ?>">
                        <button class="box2" type="submit">ค้นหา</button>
                    </div>

                </form>


</div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            ข้อมูลการฝากเงิน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>รหัสธุรกรรม</th>
                                        <th>ประเภทธุรกรรม</th>
                                        <th>ประเภทบัญชี</th>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th>รหัสสมาชิก</th>
                                        <th>ชื่อสมาชิก</th>
                                        <th>เลขที่บัญชี</th>
                                        <th>ธนาคาร</th>
                                        <th>จำนวนฝาก</th>
                                        <th>โบนัสฝาก</th>
                                        <th>จำนวนถอน</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

        

        $sql = "SELECT category,transactionid,user,date_now,surelastname,banknumber,bank,tel,idline,deposit,withdraw,bonus,withdraw,tperson,aperson,note,liststatus,ip
                FROM scclub_data2 WHERE (liststatus = 'confirm')
                ORDER BY transactionid DESC"; // ASC เรียงน้อยไปมาก หรือ DESC เรียง มากไปน้อย

        if(!empty($_POST['date_from']) && !empty($_POST['date_to'])){
            $date_from = date('Y-m-d',strtotime($_POST['date_from']));
            $date_to = date('Y-m-d',strtotime($_POST['date_to']));
            $sql = "SELECT category,transactionid,user,date_now,surelastname,banknumber,bank,tel,idline,deposit,withdraw,bonus,withdraw,tperson,aperson,note,liststatus,ip
                    FROM scclub_data2 WHERE (liststatus = 'confirm' AND date_now BETWEEN '$date_from' AND '$date_to')
                    ORDER BY transactionid DESC";
        }

        $query = $db->query($sql);

        while($row = $query->fetch()) {

            echo '
                                    <tr>
                                        <td>'.$row['transactionid'].'</td>
                                        <td>'.$row['category'].'</td>
                                        <td>'.$row['agent'].'</td>
                                        <td>'.date('d/m/Y',strtotime($row['date_now'])).'</td>
                                        <td>'.date('H:i:s',strtotime($row['date_now'])).'</td>
                                        <td>'.$row['user'].'</td>
                                        <td>'.$row['surelastname'].'</td>
                                        <td>'.$row['banknumber'].'</td>
                                        <td>'.$row['bank'].'</td>
                                        <td>'.$row['deposit'].'</td>
                                        <td>'.$row['bonus'].'</td>
                                        <td>'.$row['withdraw'].'</td>
                                    </tr>'
                                     ;
        }


?>
                                </tbody>
                                        <tfoot>
            <tr>
                <th colspan="9" style="text-align:right">รวม:</th>
                <th></th>
                <th ></th>
                <th></th>
            </tr>
        </tfoot>
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

<div class="fixmargin"> </div>

    </div>

                        <div class="panel panel-green fixbt">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">1,275,000</div>
                                    <div>รวมยอดกำไร/ขาดทุน</div>
                                </div>
                            </div>
                        </div>
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
    $('#dataTables-example').DataTable( {
        responsive: true,
             searching: true,
                         "iDisplayLength": 100,
                "bFilter": false,
                "aaSorting" : [[4, "desc"]],




        "footerCallback": function ( row, data, start, end, display ) {



            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            $(".huge").html(formatMoney(total)+" บาท");
            // Total over this page
            pageTotal = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 9 ).footer() ).html(
                (formatMoney(pageTotal)+" บาท")
            );
            pageTotal1 = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            $( api.column( 10 ).footer() ).html(
                (formatMoney(pageTotal1)+" บาท")
            );
            pageTotal2 = api
                .column( 11, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            $( api.column( 11 ).footer() ).html(
                (formatMoney(pageTotal2)+" บาท")
            );
            var Totalall = 0;
            Totalall = parseInt(pageTotal)-(parseInt(pageTotal1)+parseInt(pageTotal2));
            $(".huge").html(formatMoney(Totalall)+" บาท");
            if(Totalall < 0){
                $(".panel-green > .panel-heading").css("background", "red");
            }
        }

                   "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData[2] == "ถอนเงิน" )
                    {
                        $('td', nRow).css('background-color', 'Red');
                    }
                    else if ( aData[2] == "เติมเงิน" )
                    {
                        $('td', nRow).css('background-color', 'Green');
                    }
                }

    } );

    $('.input-daterange input').each(function() {
        $(this).datepicker({
            format: 'yyyy/mm/dd'
        });
    });


});

function formatMoney(n, c, d, t) {
  var c = isNaN(c = Math.abs(c)) ? 0 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
    </script>

</body>

</html>
