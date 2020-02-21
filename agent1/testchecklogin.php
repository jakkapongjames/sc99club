<?php
	session_start();
	mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","root","z1c3q7e9");
	mysql_select_db("userlogs");
	$strSQL = "SELECT * FROM administrator WHERE username = '".mysql_real_escape_string($_POST['txtUsername'])."' 
	and password = '".mysql_real_escape_string($_POST['txtPassword'])."'";
	$objQuery = mysql_query($strSQL);
	$objResult = mysql_fetch_array($objQuery);
	if(!$objResult)
	{
			echo "Username and Password Incorrect!";
	}
	else
	{
			$_SESSION["userid"] = $objResult["userid"];
			$_SESSION["adminstatus"] = $objResult["adminstatus"];

			session_write_close();
			
			if($objResult["adminstatus"] == "active")
			{
				header("location:admin_page.php");
			}
			else
			{
				header("location:user_page.php");
			}
	}
	mysql_close();
?>