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
$strSQL .=",tel = '".$_POST["txttel"]."' ";
$strSQL .=",idline = '".$_POST["txtidline"]."' ";
$strSQL .=",banknumber = '".$_POST["txtbanknumber"]."' ";
$strSQL .=",bank = '".$_POST["txtbank"]."' ";
$strSQL .=",avatar = '".$_POST["txtavatar"]."' ";
$strSQL .=",note = '".$_POST["txtnote"]."' ";
$strSQL .=",smsname = '".$_POST["txtsmsname"]."' ";
$strSQL .=",qrcodepay = '".$_POST["txtqrcodepay"]."' ";
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
 header( "location: userlist.php" );
 exit(0);
?>


</body>
</html>
