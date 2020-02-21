<?php include"head.php" ?>




<?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
$strSQL = "SELECT * FROM scclub_data WHERE category='สมัครสมาชิก' ORDER BY transactionid DESC";
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult)
{
   echo "ไม่พบ Username = ".$_GET["sendget"];
}

?>
<?php
$registeruser = $objResult["user"]
?>

<?php echo $registeruser ?>
