<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <button type="button" class="btn btn-success btn-block" onclick="window.location.href='formregister1.php'"><i class="far fa-money-bill-alt"></i>

 ฝากเงิน / โบนัส</button>
        </div>
        <div class="col-xs-6">
            <button type="button" class="btn btn-primary btn-block"onclick="window.location.href='formregister2.php'"><i class="fas fa-user"></i>

 สมัครสมาชิก</button>
        </div>
    </div>
</div>


<br>


<head>

<?php include"head.php" ?>

    <title>ลงทะเบียน</title>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


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

<?php
date_default_timezone_set("Asia/Bangkok");
$connection = mysql_connect($HOST_NAME, $USERNAME, $PASSWORD); // Establishing Connection with Server
$db = mysql_select_db($DB_NAME, $connection);
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
 // Selecting Database from Server
if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
$category = $_POST['category'];
$user = $_POST['user'];
$agent = $_POST['agent'];
$surelastname = $_POST['surelastname'];
$bank = $_POST['bank'];
$banknumber = $_POST['banknumber'];
$tel = $_POST['tel'];
$idline = $_POST['idline'];
$deposit = $_POST['deposit'];
$bonus = $_POST['bonus'];
$tperson = $_POST['tperson'];
$clubpoint = $_POST['clubpoint'];
$avatar = $_POST['avatar'];
$smsname = $_POST['smsname'];
$date_now = date('Y-m-d H:i:s', strtotime($_POST['date_now']));

if($name !=''||$deposit !=''){
//Insert Query of SQL
$query = mysql_query("insert into scclub_data(category, user,agent, date_now, surelastname, bank, banknumber, tel, idline, deposit, bonus, tperson, clubpoint, avatar, smsname) values ('$category', '$user', '$agent', '$date_now', '$surelastname', '$bank', '$banknumber', '$tel', '$idline', '$deposit', '$bonus', '$tperson' ,'$clubpoint','$avatar' ,'$smsname')");
echo "<br/><br/><span><h4 style='color: green;text-align: center;'>บันทึกการฝากเสร็จสิ้น....</h4></span>";
}
else{
echo "<p style='color: red;'>ทำรายการไม่สำเร็จ <br> กรุณากรอกข้อมูลให้ครบถ้วน!!</p>";
}
}
mysql_close($connection); // Closing Connection with Server

?>


<br>
 <form name="formcheck" action="#" method="get">
<input class="checkuser" type="text" name="sendget" id="sendget" value=""> 
<button type="submi2" name="submit2" class="btn btn-warning"> ตรวจสอบ</button>
</form>


 <?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
$strSQL = "SELECT * FROM scclub_data WHERE category='สมัครสมาชิก' AND user = '".$_GET["sendget"]."' or smsname = '".$_GET["sendget"]."' ";
if(empty($_GET)) {
            $strSQL = "SELECT * FROM scclub_data WHERE smsname or user ='SCCLUB99' ";
        }
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult)
{
    echo "ไม่พบ Username = ".$_GET["sendget"];
}

?>
<hr>
<div class="hidden">
 <form name="formsend" action="#"  method="POST">
                                            <input type="text" class="form-control" placeholder="Username" name="user" value="<?php echo $objResult["user"];?>"><br>
                                            <select class="form-control" name="category">
                                                <option value="เติมเงิน">เติมเงิน</option>
                                            </select><br>
                                            <input type="hidden" class="form-control" name="tperson" value="<?php echo $objResult2["username"];?>">
                                            <input type="hidden" class="form-control" name="avatar" value="<?php echo $objResult["avatar"];?>">
                                   
                                            
                                            <br>
                                        <input type="text" class="form-control" placeholder="ชื่อ นามสกุล" name="surelastname" value="<?php echo $objResult["surelastname"];?>"><br>
                                        <select class="form-control" name="bank">
                                                <option value="<?php echo $objResult["bank"];?>"><?php echo $objResult["bank"];?></option>
                                                <option value="BBL">ธนาคารกรุงเทพ</option>
                                                <option value="KBANK">ธนาคารกสิกรไทย</option>
                                                <option value="SCB">ธนาคารไทยพาณิชย์</option>
                                                <option value="KTB">ธนาคารกรุงไทย</option>
                                                <option value="TMB">ธนาคารทหารไทย</option>
                                                <option value="BAY">ธนาคารกรุงศรีอยุธยา</option>
                                            </select><br>
                                        <input class="form-control" placeholder="เลขบัญชีธนาคาร" type="text" name="banknumber" id="banknumber" value="<?php echo $objResult["banknumber"];?>"required><br>
                                        <input class="form-control" placeholder="เบอร์โทรศัพท์" type="text" name="tel"  value="<?php echo $objResult["tel"];?>"required><br>
                                        <input class="form-control" placeholder="ID LINE" type="text" name="idline" value="<?php echo $objResult["idline"];?>"><br>
                                        <input class="form-control" placeholder="แต้มสะสม" type="hidden" name="clubpoint" value=""><br>
                                        </div>
<div class="text-center">
<h1 style="color:#8f22f9;"><?php echo $objResult["user"];?></h1>
<h3>


<img src="<?php echo $objResult["avatar"];?>" style="width: 100px; height: 100px; border-radius: 50%;"><br>
<hr>
<?php echo $objResult["surelastname"];?><br>
<?php echo $objResult["banknumber"];?><br>
<?php echo $objResult["bank"];?><br><br>
</h3>

</div>
<input type="" class="form-control" name="date_now" value="<?php echo date('H:i') ?>"><br>
<input class="form-control" placeholder="จำนวนฝาก" type="text" name="deposit" value=""required><br>
<input class="form-control" placeholder="โบนัส" type="text" name="bonus" value=""><br>

</script>
<button type="submit" name="submit" value="Insert" class="btn btn-success btn-block btn-lg">ส่งข้อมูล</button>
</form>



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