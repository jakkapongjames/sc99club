<html>
<head>
<title>ThaiCreate.Com PHP & MySQL Tutorial</title>
</head>
<body>
<?php
$objConnect = mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","root","z1c3q7e9") or die("Error Connect to Database");
$objDB = mysql_select_db("userlogs");
$strSQL = "SELECT * FROM userlogs";
$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
?>
<table width="600" border="1">
  <tr>
    <th width="91"> <div align="center">CustomerID </div></th>
    <th width="98"> <div align="center">Name </div></th>
    <th width="198"> <div align="center">Email </div></th>
    <th width="97"> <div align="center">CountryCode </div></th>
    <th width="59"> <div align="center">Budget </div></th>
    <th width="71"> <div align="center">Used </div></th>
    <th width="30"> <div align="center">Edit </div></th>
  </tr>
<?php
while($objResult = mysql_fetch_array($objQuery))
{
?>
  <tr>
    <td><div align="center"><?php echo $objResult["CustomerID"];?></div></td>
    <td><?php echo $objResult["Name"];?></td>
    <td><?php echo $objResult["Email"];?></td>
    <td><div align="center"><?php echo $objResult["CountryCode"];?></div></td>
    <td align="right"><?php echo $objResult["Budget"];?></td>
    <td align="right"><?php echo $objResult["Used"];?></td>
    <td align="center"><a href="phpMySQLEditRecordForm.php?CusID=<?php echo $objResult["CustomerID"];?>">Edit</a></td>
  </tr>
<?php
}
?>
</table>
<?php
mysql_close($objConnect);
?>
</body>
</html>
