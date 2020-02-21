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
</style>

</head>

<?php
date_default_timezone_set("Asia/Bangkok");
$connection = mysql_connect($HOST_NAME, $USERNAME, $PASSWORD); // Establishing Connection with Server
$db = mysql_select_db($DB_NAME, $connection);
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
$date_now = date('Y-m-d H:i:s', strtotime($_POST['date_now']));

if($name !=''||$deposit !=''){
//Insert Query of SQL
$query = mysql_query("insert into scclub_data(category, user,agent, date_now, surelastname, bank, banknumber, tel, idline, deposit, bonus, tperson, clubpoint) values ('$category', '$user', '$agent', '$date_now', '$surelastname', '$bank', '$banknumber', '$tel', '$idline', '$deposit', '$bonus', '$tperson' ,'$clubpoint')");
echo "<br/><br/><span>Data Inserted successfully...!!</span>";
}
else{
echo "<p style='color: red;'>ทำรายการไม่สำเร็จ <br> กรุณากรอกข้อมูลให้ครบถ้วน!!</p>";
}
}
mysql_close($connection); // Closing Connection with Server

?>



<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <form name="formcheck" action="#" method="get">
<input class="checkuser" type="text" name="sendget" id="sendget" value=""> .
<button type="submi2" name="submit2" class="btn btn-success"> ตรวจสอบ</button>
</form>


 <?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
$strSQL = "SELECT * FROM scclub_data WHERE category='สมัครสมาชิก' AND user = '".$_GET["sendget"]."' ";
if(empty($_GET)) {
            $strSQL = "SELECT * FROM scclub_data WHERE user='uffq00000' ";
        }
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult)
{
    echo "ไม่พบ Username = ".$_GET["sendget"];
}

?>
<hr>
 <form name="formsend" action="#" method="POST">
                                            <input type="text" class="form-control" placeholder="Username" name="user" value="<?php echo $objResult["user"];?>"><br>
                                            <select class="form-control" name="category">
                                                <option>เลือกประเภทการฝากเงิน</option>
                                                <option value="สมัครสมาชิก">สมัครสมาชิก</option>
                                                <option value="เติมเงิน">เติมเงิน</option>
                                                <option value="เติมโบนัส">เติมโบนัส</option>>
                                            </select><br>
                                            <input type="hidden" class="form-control" name="tperson" value="<?php echo $objResult2["username"];?>">
                                   
                                            <input type="" class="form-control" name="date_now" value="<?php echo date('Y-m-d H:i:s') ?>">
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
                                        <input class="form-control" placeholder="จำนวนฝาก" type="text" name="deposit" value=""required><br>
                                        <input class="form-control" placeholder="โบนัส" type="text" name="bonus" value=""><br>
                                        <input class="form-control" placeholder="แต้มสะสม" type="hidden" name="clubpoint" value=""><br>
                                        <button type="submit" name="submit" value="Insert" class="btn btn-success btn-block">ส่งข้อมูล</button>
                                    </form>
  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
</div>
 



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