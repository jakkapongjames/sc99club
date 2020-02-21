    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../css/adminstyle.css" rel="stylesheet">

    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <link href="../css/backofficestyle.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

     <?php

    $HOST_NAME = "changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com";
    $DB_NAME = "changno1_userlog";
    $CHAR_SET = "charset=utf8"; // เช็ตให้อ่านภาษาไทยได้

    $USERNAME = "changno1_userlog";     // ตั้งค่าตามการใช้งานจริง
    $PASSWORD = "z1c3q7e9";  // ตั้งค่าตามการใช้งานจริง?>

   <?php date_default_timezone_set("Asia/Bangkok"); ?>

   <?php session_start();?>
<?php

if (!$_SESSION["userid"]){  //check session

      Header("Location: ../index.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form

}?>

       <?php
    mysql_connect($HOST_NAME,$USERNAME,$PASSWORD);
    mysql_set_charset($CHAR_SET);
    mysql_select_db($DB_NAME);
    $strSQL = "SELECT * FROM administrator WHERE userid = '".$_SESSION['userid']."' ";
    $objQuery = mysql_query($strSQL);
    $objResult2 = mysql_fetch_array($objQuery);
?>
