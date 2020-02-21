<!DOCTYPE html>


<head>

<?php include"head.php" ?>

    <title>ตรวจสอบรายการฝากถอน</title>



    <link href="../css/bootstrap-datepicker.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



    <style>


#ufa-cradit { width:300px; height:70px; margin:auto; }

#outerufa-cradit {
width:235px;
height:47px;
overflow:hidden;
position:relative;
}
#innerufa-cradit {
position:absolute;
top:-95px;
left:-660px;
width:1280px;
height:1200px;
}

 </style>


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


    mysql_connect($HOST_NAME, $USERNAME,$PASSWORD);
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
                    <h1 class="page-header">อนุมัติการฝาก/ถอน</h1>
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
                            <h4>ข้อมูลการทำรายการฝาก</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>

                                        <th>รูปโปรไฟล์</th>
                                        <th aria-sort="ascending">#NO</th>
                                        <th>ประเภท</th>
                                        <th>เวลา</th>
                                        <th>รหัสสมาชิก</th>
                                        <th>ชื่อสมาชิก</th>
                                        <th>จำนวนฝาก</th>
                                        <th>ยกเลิก</th>
                                        <th>อนุมัติ</th>


                                    </tr>
                                </thead>
                                <tbody>
<?php
        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

        $sql = "SELECT category,transactionid,user,date_now,surelastname,banknumber,bank,tel,deposit,bonus,withdraw,tperson,aperson,liststatus,note,ip,avatar,smsname
                FROM scclub_data2 WHERE (liststatus = '') AND (category = 'เติมเงิน')
                ORDER BY transactionid ASC"; // ASC เรียงน้อยไปมาก หรือ DESC เรียง มากไปน้อย
        $query = $db->query($sql);

        while($row = $query->fetch()) {

            echo '

            <script type="text/javascript">
                var input  = document.getElementById("'.$row['transactionid'].'");
                var button = document.getElementById("'.$row['transactionid'].'");

                button.addEventListener("click", function (event) {
                    event.preventDefault();
                    input.select();
                    document.execCommand("copy");
                });
            </script>
                                    <tr>


                                        <td><center><img src="'.$row['avatar'].'"style="border-radius: 50%; width:50px; height:50px;"></center></td>
                                        <td><h4>'.$row['transactionid'].'</h4></td>
                                        <td><h4>'.$row['category'].'</h4></td>
                                        <td><h4>'.date('H:i',strtotime($row['date_now'])).'</h4></td>
                                        <td><h4>'.$row['user'].'</h4></td>
                                        <td><h4>'.$row['surelastname'].'</h4></td>
                                        <td><h4>จำนวน : '.$row['deposit'].' | โบนัส : '.$row['bonus'].'</h4>
                                        <br><button type="button" id="'.$row['transactionid'].'" class="btn btn-success">คัดลอก</button><br>
 <textarea id="'.$row['transactionid'].'" style="width:0px; height:0px;"> ระบบได้เติมเครดิตให้ : '.$row['user'].'
จำนวน : '.$row['deposit'].' |
โบนัส : '.$row['bonus'].'
เวลา : '.date('H:i',strtotime($row['date_now'])).'
เรียบร้อยแล้วค่ะ ขอให้สนุกกับการเดิมพันนะคะ</textarea>


                                       </td>

                                        <td align="center">
                                        <a href="canceltsc.php?transactionid='.$row['transactionid'].'"><img src="https://cdn0.iconfinder.com/data/icons/round-ui-icons/512/close_red.png"style="border-radius: 50%; width:50px; height:50px;"></a>
                                        </td>

                                        <td align="center">
                                        <a href="cfdeposit.php?transactionid='.$row['transactionid'].'"><img src="http://assets.stickpng.com/thumbs/5aa78e3e7603fc558cffbf1e.png"style="border-radius: 50%; width:50px; height:50px;"></a>
                                        </td>

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



                <div class="col-lg-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4>ข้อมูลการทำรายการถอน</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>

                                        <th aria-sort="ascending">#NO</th>
                                        <th>ประเภท</th>
                                        <th>เวลา</th>
                                        <th>รหัสสมาชิก</th>
                                        <th>ข้อมูลการโอนเงิน</th>
                                        <th>QR CODE</th>
                                        <th>จำนวนถอน</th>
                                        <th>โน๊ต</th>
                                        <th>ยกเลิก</th>
                                        <th>อนุมัติ</th>


                                    </tr>
                                </thead>
                                <tbody>


<?php
        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

        $sql = "SELECT category,transactionid,user,date_now,surelastname,banknumber,bank,tel,deposit,bonus,withdraw,tperson,aperson,liststatus,note,ip,avatar,smsname,qrcodepay
                FROM scclub_data2 WHERE (liststatus = '') AND (category = 'ถอนเงิน')
                ORDER BY transactionid DESC"; // ASC เรียงน้อยไปมาก หรือ DESC เรียง มากไปน้อย
        $query = $db->query($sql);

        while($row = $query->fetch()

          ) {

            $test = $row['note']-$row['withdraw'];

            echo '
                                    <tr>







                                        <td><h4>'.$row['transactionid'].'</h4></td>
                                        <td><h4>'.$row['category'].'</h4></td>
                                        <td><h4>'.date('H:i',strtotime($row['date_now'])).'</h4></td>
                                        <td><center><h2 style="
    margin-top: 10%;
">'.$row['user'].'</h4>
<img src="'.$row['avatar'].'"style="border-radius: 50%; width:50px; height:50px;">
</center></td>
                                        <td style="background-image: url(../img/'.$row['bank'].'.png);"><center>
                                        <img src="../img/'.$row['bank'].'.jpg"><br>
                                        <h3 style="color:white;">'.$row['banknumber'].'</h3><span style="color:white;">'.$row['surelastname'].'</span></center>
                                        </td>
                                        <td><center><img src="https://promptpay.io/'.$row['qrcodepay'].'/'.$row['withdraw'].'.png" style="width: 100px;
    height: 100px;
"></center></td>
                                        <td><center><h2 style="
    margin-top: 30%;
">'.number_format($row['withdraw']).'</h2></center></td>
                                        <td><button type="button" id="copy-button2" class="btn btn-success">คัดลอก</button><br>
<textarea id="">
แจ้งถอนโดย '.$row['user'].'
ยอดก่อนถอน '.number_format($row['note']).'
แจ้งถอน '.number_format($row['withdraw']).'
ยอดคงเหลือ '.number_format($test).'
---------------
*** ห้ามทำการโยกเครดิตเข้าคาสิโนเด็ดขาด<br>จนกว่าจะทำรายการถอนเสร็จสิ้น
มิเช่นนั้นทางเราจะไม่โอนเงินให้ และระงับบัญชีของคุณทันที ***

                                         </textarea></td>
                                        <td align="center">

                                        <a href="canceltsc.php?transactionid='.$row['transactionid'].'"><img src="https://cdn0.iconfinder.com/data/icons/round-ui-icons/512/close_red.png"style="border-radius: 50%; width:50px; height:50px;"></a>
                                        </td>

                                        <td align="center">
                                        <a href="cfwithdraw.php?transactionid='.$row['transactionid'].'"><img src="http://assets.stickpng.com/thumbs/5aa78e3e7603fc558cffbf1e.png"style="border-radius: 50%; width:50px; height:50px;"></a>


                                        </td>

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

</body>

</html>
