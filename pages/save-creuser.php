<html>
<head>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
<?php include"head.php" ?>
</head>
<body>
<?php
$objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
$objDB = mysql_select_db($DB_NAME);
$strSQL = "UPDATE scclub_data SET ";
$strSQL .="transactionid = '".$_POST["txttransactionid"]."' ";
$strSQL .=",bonus = '".$_POST["txtbonus"]."' ";
$strSQL .=",liststatus = '".$_POST["txtliststatus"]."' ";
$strSQL .=",note = '".$_POST["txtnote"]."' ";
$strSQL .=",aperson = '".$_POST["txtaperson"]."' ";
$strSQL .=",user = '".$_POST["txtuser"]."' ";
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
 header( "location: createuser.php" );
 exit(0);
?>
</body>
</html>