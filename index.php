<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/istyle.css">

    <title>SCCLUB Wallet security and easycontrol</title>
  </head>
  <body>

<?php
  session_start();
  mysql_connect("changno1-userlog.cby79el4gfat.ap-southeast-1.rds.amazonaws.com","admin","admin1234");
  mysql_select_db("changno1_userlog");
  $strSQL = "SELECT * FROM administrator WHERE username = '".mysql_real_escape_string($_POST['txtUsername'])."'
  and password = '".mysql_real_escape_string($_POST['txtPassword'])."'";
  $objQuery = mysql_query($strSQL);
  $objResult = mysql_fetch_array($objQuery);
  if(!$objResult)
  {

  }
  else
  {
      $_SESSION["userid"] = $objResult["userid"];
      $_SESSION["adminlevel"] = $objResult["adminlevel"];
      $_SESSION["adminstatus"] = $objResult["adminstatus"];

      session_write_close();

      if($objResult["adminlevel"] == "1")
      if($objResult["adminstatus"] == "active")
      {
        header("location:/agent1");
      }

            if($objResult["adminposition"] == "agent1")
              if($objResult["adminstatus"] == "active")
      {
        header("location:/agent1/register.php");
      }

      else {
        echo '<h2 style="
    text-align: center;
    margin-top: 20px;
    color: white;
">คุณถูกห้ามให้เข้าสู่ระบบ</h2>';
      }

                  if($objResult["adminposition"] == "agent2")
              if($objResult["adminstatus"] == "active")
      {
        header("location:/agent2/register.php");
      }

      else {
        echo '<h2 style="
    text-align: center;
    margin-top: 20px;
    color: white;
">คุณถูกห้ามให้เข้าสู่ระบบ</h2>';
      }

                  if($objResult["adminposition"] == "reporter")
              if($objResult["adminstatus"] == "active")
      {
        header("location:/agent1/register.php");
      }

      else {
        echo '<h2 style="
    text-align: center;
    margin-top: 20px;
    color: white;
">คุณถูกห้ามให้เข้าสู่ระบบ</h2>';
      }

  }
  mysql_close();
?>

   <div class="login">
    <img src="img/logoblank2.png" class="img-fluid" style="margin-bottom: 20px;">
    <form name="login" method="post" action="index.php">
      <input type="text" name="txtUsername" placeholder="Username" required="required" id="txtUsername"/>
        <input type="password" name="txtPassword" placeholder="Password" required="required" id="txtPassword"/>
        <button type="submit" class="btn btn-primary btn-block btn-large" name="Submit" value="Login">เข้าสู่ระบบ</button>
    </form>
  </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
