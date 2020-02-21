<html>
<head>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
</head>
<body>
<?php
$objConnect = mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","admin","admin1234") or die("Error Connect to Database");
$objDB = mysql_select_db("changno1_userlog");
$strSQL = "UPDATE scclub_data2 SET ";
$strSQL .="user = '".$_POST["txtuser"]."' ";
$strSQL .=",surelastname = '".$_POST["txtsurelastname"]."' ";
$strSQL .=",deposit = '".$_POST["txtdeposit"]."' ";
$strSQL .=",withdraw = '".$_POST["txtwithdraw"]."' ";
$strSQL .=",bonus = '".$_POST["txtbonus"]."' ";
$strSQL .=",liststatus = '".$_POST["txtliststatus"]."' ";
$strSQL .=",tperson = '".$_POST["txttperson"]."' ";
$strSQL .=",note = '".$_POST["txtnote"]."' ";
$strSQL .=",date_now = '".$_POST["txtdate_now"]."' ";
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
 header( "location: searchedit.php" );
 exit(0);
?>


</body>
</html>
