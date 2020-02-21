    <?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        echo "Please Login!";
        exit();
    }

    if($_SESSION['adminlevel'] != "1","3")
    {
        echo "This page for Admin only!";
        exit();
    }   
    
    mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","baanboo3_userlog","z1c3q7e9");
    mysql_select_db("baanboo3_userlog");
    $strSQL = "SELECT * FROM administrator WHERE userid = '".$_SESSION['userid']."' ";
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_array($objQuery);
?>