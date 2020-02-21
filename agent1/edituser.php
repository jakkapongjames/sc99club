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

<style>


#ufa-cradit { width:300px; height:70px; margin:auto; }

#outerufa-cradit {
width:220px;
height:47px;
overflow:hidden;
position:relative;
}
#innerufa-cradit {
position:absolute;
top:-95px;
left:-600px;
width:1280px;
height:1200px;
}


.bar {
  width: 100%;
  height: 20px;
  border: 1px solid #361754;
  border-radius: 3px;
  background-image:
    repeating-linear-gradient(
      -45deg,
      #361754,
      #56208a 11px,
      #eee 10px,
      #eee 20px /* determines size */
    );
  background-size: 28px 28px;
  animation: move .5s linear infinite;
}

@keyframes move {
  0% {
    background-position: 0 0;
  }
  100% {
    background-position: 28px 0;
  }
}


</style>
</head>

<body>

    <script>
        window.onload = function(){
  var elm = document.querySelector('#progress');
  setInterval(function(){
    if(!elm.innerHTML.match(/100%/gi)){
      elm.innerHTML = (parseInt(elm.innerHTML) + 1) + '%';
    } else {
      clearInterval();
    }
  }, 18)
}
    </script>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include'nav.php'?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container contact-form ">


            <form action="saveedituser.php?transactionid=<?php echo $_GET["transactionid"];?>" name="frmEdit" method="post">


 <?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
$strSQL = "SELECT * FROM scclub_data WHERE transactionid = '".$_GET["transactionid"]."' ";
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult)
{
    echo "Not found transactionid=".$_GET["transactionid"];
}
else
{

$topup =  $objResult["deposit"]+$objResult["bonus"];
?>
                <h2 style="text-align: center;">แกไขข้อมูลพื้นฐานของ USER : (<?php echo $objResult["user"];?>)</h2>
                <hr>
               <div class="row">
                    <div class="col-md-6">
                    <input type="hidden" name="transactionid" class="form-control" value="<?php echo $objResult["transactionid"];?>"/>

                            <div class="form-group col-md-12">
                            <center><img src="<?php echo $objResult["avatar"];?>" style="width: 100px; height: 100px; border-radius: 50%;"></center>
                        </div>

                        <div class="form-group col-md-12"> Username
                            <input type="text" name="txtuser" class="form-control" value="<?php echo $objResult["user"];?>"/>
                        </div>
                        <div class="form-group col-md-12"> ชื่อ - นามสกุล
                            <input type="text" name="txtsurelastname" class="form-control" value="<?php echo $objResult["surelastname"];?>" />
                        </div>

                        <div class="form-group col-md-6"> เบอร์โทรศัพท์
                            <input type="text" name="txttel" class="form-control" value="<?php echo $objResult["tel"];?>" />
                        </div>

                        <div class="form-group col-md-6"> ID LINE
                            <input type="text" name="txtidline" class="form-control" value="<?php echo $objResult["idline"];?>" />
                        </div>

                        <div class="form-group col-md-6"> เลขที่บัญชี
                            <input type="text" name="txtbanknumber" class="form-control" value="<?php echo $objResult["banknumber"];?>" />
                        </div>

                        <div class="form-group col-md-6"> ธนาคาร
                            <input type="text" name="txtbank" class="form-control" value="<?php echo $objResult["bank"];?>" />
                        </div>

                        <div class="form-group col-md-6"> รูปภาพ
                            <input type="text" name="txtavatar" class="form-control" value="<?php echo $objResult["avatar"];?>"/>
                        </div>

                        <div class="form-group col-md-6"> smsname
                            <input type="text" name="txtsmsname" class="form-control" value="<?php echo $objResult["smsname"];?>"/>
                        </div>

                        <div class="form-group col-md-6"> qrcodepay
                            <input type="text" name="txtqrcodepay" class="form-control" value="<?php echo $objResult["qrcodepay"];?>"/>
                        </div>

                            <div class="form-group col-md-12 ">
                            <h4>หมายเหตุ</h4>
                            <textarea name="txtnote" class="form-control" placeholder="Your Message *" style="width: 100%; height: 100%;"></textarea>
                            <h5 style="text-align: center;">ผู้ตรวจสอบ (<?php echo $objResult2["adminname"];?>)</h5>


                        </div>



                    <input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="submit">

<form>









            <?php
  }
  mysql_close($objConnect);
  ?>

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


</body>

</html>
