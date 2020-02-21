<html>
<head>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
</head>
<body>
<?php
$objConnect = mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","admin","admin1234") or die("Error Connect to Database");
$objDB = mysql_select_db("changno1_userlog");
$strSQL = "UPDATE scclub_data SET ";
$strSQL .="transactionid = '".$_POST["txttransactionid"]."' ";
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