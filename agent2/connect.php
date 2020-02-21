<?php

	$HOST_NAME = "changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com";
	$DB_NAME = "baanboo3_userlog";
	$CHAR_SET = "charset=utf8"; // เช็ตให้อ่านภาษาไทยได้

	$USERNAME = "baanboo3_userlog";     // ตั้งค่าตามการใช้งานจริง
	$PASSWORD = "z1c3q7e9";  // ตั้งค่าตามการใช้งานจริง


	try {

		$db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

		//echo "เชื่อมต่อฐานข้อมูลสำเร็จ";

		// คำสั่ง SQL
		$sql = "SELECT category,transactionid
				FROM userlogs
				ORDER BY transactionid ASC"; // ASC เรียงน้อยไปมาก หรือ DESC เรียง มากไปน้อย
		$query = $db->query($sql);

		while($row = $query->fetch()) {
			echo "ชื่อหนังสือ : ".$row['category']." ราคา : ".$row['transactionid']."<br>";
		}


	} catch (PDOException $e) {

		echo "ไม่สามารถเชื่อมต่อฐานข้อมูลได้ : ".$e->getMessage();

	}


?>
