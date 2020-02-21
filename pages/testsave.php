<html>
<head>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
</head>
<body>
<?php
$objConnect = mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","root","z1c3q7e9") or die("Error Connect to Database");
$objDB = mysql_select_db("userlogs");
$strSQL = "UPDATE userlogs SET ";
$strSQL .="transactionid = '".$_POST["txttransactionid"]."' ";
$strSQL .=",bonus = '".$_POST["txtbonus"]."' ";
$strSQL .=",liststatus = '".$_POST["txtliststatus"]."' ";
$strSQL .=",note = '".$_POST["txtnote"]."' ";
$strSQL .=",aperson = '".$_POST["txtaperson"]."' ";
$strSQL .="WHERE transactionid = '".$_GET["transactionid"]."' ";
$objQuery = mysql_query($strSQL);
if($objQuery)
{
	echo "Save Done.";
}
else
{
	echo "Error Save [".$strSQL."]";
}
mysql_close($objConnect);
?>

<?
 header( "location: appdeposit.php" );
 exit(0);
?>
</body>
</html>