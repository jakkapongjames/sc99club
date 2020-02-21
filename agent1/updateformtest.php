<html>
<head>
  <?php include"head.php" ?>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
</head>
<body>
  <?php include'nav.php'?>
<div class="container contact-form">
            <div class="contact-image">
                <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact"/>
            </div>
            <form method="post">
                <h3>Drop Us a Message</h3>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Your Name *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtEmail" class="form-control" placeholder="Your Email *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtPhone" class="form-control" placeholder="Your Phone Number *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btnSubmit" class="btnContact" value="Send Message" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div name="txtnote" class="form-group">
                            <textarea name="txtnote" class="form-control" placeholder="Your Message *" style="width: 100%; height: 150px;"></textarea>
                        </div>
                    </div>
                </div>
            </form>


<form action="testsave.php?CusID=<?php echo $_GET["transactionid"];?>" name="frmEdit" method="post">
<?php
$objConnect = mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","root","z1c3q7e9") or die("Error Connect to Database");
$objDB = mysql_select_db("userlogs");
$strSQL = "SELECT * FROM userlogs WHERE transactionid = '".$_GET["transactionid"]."' ";
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult)
{
	echo "Not found transactionid=".$_GET["transactionid"];
}
else
{
?>

<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">CustomerID </div></th>
    <th width="160"> <div align="center">Name </div></th>
  </tr>
  <tr>
    <td><div align="center"><input type="text" name="txttransactionid" size="5" value="<?php echo $objResult["transactionid"];?>"></div></td>
    <td><input type="text" name="txtname" size="20" value="<?php echo $objResult["name"];?>"></td>
  </tr>
  </table>
  <input type="submit" name="submit" value="submit">
  <?php
  }
  mysql_close($objConnect);
  ?>
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
</body>
</html>