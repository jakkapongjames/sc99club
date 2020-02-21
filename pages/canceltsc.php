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

                        
            <form action="save-cfd.php?transactionid=<?php echo $_GET["transactionid"];?>" name="frmEdit" method="post">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6"><img src="http://amritarobotics.com/img/content/slider/rs-slider4-img12.gif" style="width: 100%"></div>
                    <div class="col-md-3"></div>
                    </div>
                
                <h1 class="text-center" style="color: #361754;">กำลังยกเลิกรายการกรุณารอสักครู่</h1>
                <div class="bar"></div>

            
 <?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
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
                <h2 style="text-align: center;">หมายเลขธุรกรรมที่กำลังดำเนินการ (<?php echo $objResult["transactionid"];?>)</h2>
               <div class="row">
                    <div class="col-md-6 hidden">
                            <input type="hidden" name="txttransactionid" class="form-control" value="<?php echo $objResult["transactionid"];?>"/>
                        <div class="form-group col-md-12"> Username
                            <input type="text" name="txtuser" class="form-control" value="<?php echo $objResult["user"];?>"disabled/>
                        </div>
                        <div class="form-group col-md-12"> ชื่อ - นามสกุล
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["surelastname"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6"> เบอร์โทรศัพท์
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["tel"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6"> ID LINE
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["idline"];?>" disabled/>
                        </div>



                        
                        <div class="form-group col-md-6">
                            จำนวนเงินฝาก
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["deposit"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6">
                            จำนวนถอน
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["withdraw"];?>" disabled/>
                        </div>

                        
                        <div class="form-group col-md-12">
                            โบนัส
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["bonus"];?>" disabled/>
                        </div>
                
                        <div class="form-group col-md-6"> เลขที่บัญชี
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["banknumber"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6"> ธนาคาร
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["bank"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="hidden" name="txtaperson" class="form-control" value="<?php echo $objResult2["username"];?>" />
                        </div>

                                                 <div class="form-group col-md-12">
                            <h4>สถานะการตรวจสอบธุรกรรม</h4>
                                                <select class="form-control" name="txtliststatus">
                        <option name="txtliststatus" value="unconfirm">ไม่ผ่าน</option>
                    </select>
                        </div>

                        
                            <div class="form-group col-md-12 ">
                            <h4>หมายเหตุ</h4>
                            <textarea name="txtnote" class="form-control" placeholder="Your Message *" style="width: 100%; height: 100%;"></textarea>
                            <h5 style="text-align: center;">ผู้ตรวจสอบ (<?php echo $objResult2["adminname"];?>)</h5>
                        </div>

<form>



                        

                        

                          

                        
                    </div>
                    <div class="col-md-6" style="margin-bottom: 400px;">
                                                  
                           

                           

<script>
    setTimeout(function(){
  $('#topupsuccess').modal('show')
}, 1000);

function refreshIframe() {
    var ifr = document.getElementsByName('checkcradit')[0];
    ifr.src = ifr.src;
}

</script>


<div class="modal" id="topupsuccess">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 50%;">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">แจ้งเตือนการทำรายการ</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">



<h1 class="text-center">คุณต้องการยกเลิกรายการใช่ไหม ?</h1>



        <!-- Modal

                                   <div id="ufa-cradit">
<div id="outerufa-cradit"> 

    <iframe name="checkcradit" id="innerufa-cradit" width="" height="" src="http://ag.ufabet.com/_Age/AccBal.aspx?role=ag&userName=uffq01&searchKey=<?php echo $objResult["user"];?>" scrolling="no" frameborder="0"></iframe>
    
</div>
</div>
 body -->

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
<button class="btn btn-danger btn-block btn-lg" id="checkcradit" onclick="refreshIframe();">ตกลง</button>        
      </div>

    </div>
  </div>
</div>
                           

                    </div>
                </div>
                <div class="row">


                    <input class="btn btn-success btn-lg btn-block hidden" type="submit" name="submit" value="submit">
                </div>
            </form>

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
