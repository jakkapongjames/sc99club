
<table>
	<thead>
		<tr>
		  <th>รหัสธุรกรรม</th>
          <th>วันที่</th>
          <th>เวลา</th>
          <th>รหัสสมาชิก</th>
          <th>ชื่อสมาชิก</th>
          <th>เลขที่บัญชี</th>
          <th>ธนาคาร</th>
          <th>จำนวนฝาก</th>
          <th>โบนัสฝาก</th>
          <th>ผู้ทำรายการ</th>
          <th>หมายเหตุ</th>
        <tr>
	</thead>

<tbody>
	<tr>
		<td></td>

	</tr>
</tbody>


</table>


    <?php
    mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","root","z1c3q7e9");
    mysql_select_db("userlogs");
    $strSQL = "SELECT * FROM userlogs WHERE aperson != '' ";
    $objQuery = mysql_query($strSQL);
   // $objResult1 = mysql_fetch_array($objQuery);


  while ($row = mysql_fetch_array($objQuery)) {

echo $row['aperson'];


}
?>
