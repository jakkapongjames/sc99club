<!DOCTYPE html>
<html lang="en">

<head>

<?php include"head.php" ?>

    <title>ลงทะเบียน</title>


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


#ufa-cradit { width:100%; height:70px; margin:auto; }

#outerufa-cradit {
    width:100%;
height:47px;
overflow:hidden;
position:relative;
}
#innerufa-cradit {
position:absolute;
top:-95px;
height:1080px;
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
                <div class="col-lg-12">
                    <h1 class="page-header">ทำรายการถอนเงิน</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            ถอนเงิน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">


<?php
date_default_timezone_set("Asia/Bangkok");
$connection = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD); // Establishing Connection with Server
$db = mysql_select_db($DB_NAME, $connection);
 // Selecting Database from Server
if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
$category = $_POST['category'];
$agent = $_POST['agent'];
$surelastname = $_POST['surelastname'];
$bank = $_POST['bank'];
$banknumber = $_POST['banknumber'];
$user = $_POST['user'];
$withdraw = $_POST['withdraw'];
$deposit = $_POST['deposit'];
$bonus = $_POST['bonus'];
$tperson = $_POST['tperson'];
$avatar = $_POST['avatar'];
$note = $_POST['note'];
$qrcodepay = $_POST['qrcodepay'];
$date_now = date('Y-m-d H:i:s', strtotime($_POST['date_now']));

if($surelastname !=''||$deposit !=''){
//Insert Query of SQL
$query = mysql_query("insert into scclub_data2(category, agent, date_now, surelastname, bank, banknumber, user, withdraw, deposit, bonus, tperson, avatar, note, qrcodepay) values ('$category', '$agent', '$date_now', '$surelastname', '$bank', '$banknumber', '$user', '$withdraw', '$deposit', '$bonus', '$tperson', '$avatar', '$note', '$qrcodepay')");
echo "<br/><br/><span>Data Inserted successfully...!!</span>";
}
else{
echo "<p>Insertion Failed <br/> Some Fields are Blank....!!</p>";
}
}
mysql_close($connection); // Closing Connection with Server

?>

<form name="formcheck" action="#" method="get">
<input class="checkuser col-lg-8" type="text" name="sendget" id="sendget" value=""> .
<button type="submi2" name="submit2" class="btn btn-success"> ตรวจสอบ</button>
</form>


 <?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
$strSQL = "SELECT * FROM scclub_data2 WHERE category='สมัครสมาชิก' AND user = '".$_GET["sendget"]."' ";
if(empty($_GET)) {
            $strSQL = "SELECT * FROM scclub_data2 WHERE user='uffq00000' ";
        }
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult)
{
    echo "ไม่พบ Username = ".$_GET["sendget"];
}

?>
<hr>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="
    width: 80%;
">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">เข็คยอดเครดิต</h4>
      </div>
      <div class="modal-body">
        <div id="ufa-cradit">
<div id="outerufa-cradit">

    <iframe name="checkcradit" id="innerufa-cradit" width="100%" height="" src="http://ag.ufabet.com/_Age/AccBal.aspx?role=ag&userName=uffqa&searchKey=<?php echo $objResult["user"];?>" scrolling="no" frameborder="0"></iframe>

</div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<center>
   <img src="<?php echo $objResult["avatar"];?>" style="border-radius: 50%; width: 100px; height: 100px;">
   <h2 style="color:#7422c3; "><?php echo $objResult["user"];?></h2>
   <hr>
<h2>
    <?php echo $objResult["surelastname"];?><br>
    <?php echo $objResult["banknumber"];?><br>
    <?php echo $objResult["bank"];?><br><br>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">ตรวจสอบเครดิต</button>


</h2>
</center>

                                        <form name="formsend" action="rewithdraw.php" method="post">
                                            <input type="hidden" class="form-control" name="category" value="ถอนเงิน">
                                         <input class="form-control hidden" placeholder="Username" type="text" name="user"value="<?php echo $objResult["user"];?>"><br>

                                            <input type="hidden" class="form-control" name="tperson" value="<?php echo $objResult2["username"];?>">

                                            <input type="hidden" class="form-control" name="avatar" value="<?php echo $objResult["avatar"];?>">

                                            <input type="" class="form-control hidden" name="date_now" value="<?php echo date('H:i') ?>">
                                            <br>
                                        <input type="text" class="form-control hidden" placeholder="ชื่อ นามสกุล" name="surelastname" value="<?php echo $objResult["surelastname"];?>"><br>
                                        <select class="form-control hidden" name="bank">
                                                <option value="<?php echo $objResult["bank"];?>"><?php echo $objResult["bank"];?></option>
                                                <option value="BBL">ธนาคารกรุงเทพ</option>
                                                <option value="KBANK">ธนาคารกสิกรไทย</option>
                                                <option value="SCB">ธนาคารไทยพาณิชย์</option>
                                                <option value="KTB">ธนาคารกรุงไทย</option>
                                                <option value="TMB">ธนาคารทหารไทย</option>
                                                <option value="BAY">ธนาคารกรุงศรีอยุธยา</option>
                                                <option value="GSB">ธนาคารออมสิน</option>
                                            </select><br>
                                        <input class="form-control hidden" placeholder="เลขบัญชีธนาคาร" type="text" name="banknumber" id="banknumber" value="<?php echo $objResult["banknumber"];?>"><br>
                                        <input class="form-control" placeholder="ยอดก่อนถอน" type="text" name="note" value=""><br>
                                        <input class="form-control" placeholder="จำนวนถอนเงิน" type="text" name="withdraw" value=""><br>
                                        <input class="form-control" placeholder="จำนวนถอนเงิน" type="hidden" name="qrcodepay" value="<?php echo $objResult["qrcodepay"];?>"><br>
                                        <button type="submit" name="submit" value="Insert" class="btn btn-success btn-block btn-lg">ส่งข้อมูล</button>
                                    </form>

                                </div>

                                <div class="col-lg-8 vl">
                        <div class="panel panel-red">
                        <div class="panel-heading">
                            การทำรายการล่าสุด
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

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
            "aaSorting" : [[0, "desc"]],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData[9] == "unconfirm" )
                    {
                        $('td', nRow).css('background-color', 'Red');
                    }
                    else if ( aData[9] == "confirm" )
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
