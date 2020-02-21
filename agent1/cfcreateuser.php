<!DOCTYPE html>


<head>

<?php include"head.php" ?>

    <title>SB Admin 2 - Bootstrap Admin Theme</title>



    <link href="../css/bootstrap-datepicker.css" rel="stylesheet">

    <script language="javascript">
        /**
        * Used to trim certain string.
        */
        function fTrim(s) {
            s = s + ""; //this is used to convert to string, where numeic not support length function for funrther processing
            while ((s.substring(0, 1) == ' ') || (s.substring(0, 1) == '\n') || (s.substring(0, 1) == '\r')) {
                s = s.substring(1, s.length);
            } //end while

            // Remove trailing spaces and carriage returns
            while ((s.substring(s.length - 1, s.length) == ' ') || (s.substring(s.length - 1, s.length) == '\n') || (s.substring(s.length - 1, s.length) == '\r')) {
                s = s.substring(0, s.length - 1);
            } //end while
            return s;
        } //end fTrim
        /**
        * Used to convert from text to other text
        */
        function fConvertTo(input, fromText, toText) {
            for (var i = input.indexOf(fromText); i != -1; i = input.indexOf(fromText, i + toText.length + 1)) {
                input = input.substring(0, i) + toText + input.substring(i + fromText.length);
            } //end for
            return input;
        } //end fConvertTo
        /**B
        *  Convert the text into number, return 0 if empty
        */
        function fParseFloat(value) {
            if (value == "") return 0;
            value = fConvertTo(value, ",", "");
            return parseFloat(value);
        }
        /**
        * Used to format decimal value such as #,##0.00.
        */
        function fFormatDecimal(total, DecimalPlaces) {
            if (fTrim(total) == "")
                return "";
            total = total.toString().replace(/\$|\,/g, '');
            var isNegative = false;
            // First verify incoming value is a number
            if (isNaN(total)) {
                var returnValue = "0";
                if (DecimalPlaces > 0)
                    returnValue += ".";
                for (var i = 0; i < DecimalPlaces; i++)
                    returnValue += "0";
                return returnValue;
            }
            if (total < 0) {
                isNegative = true;
                total = total * -1;
            }
            // Second round incoming value to correct number of decimal places
            var RoundedTotal = total * Math.pow(10, DecimalPlaces);
            RoundedTotal = Math.round(RoundedTotal);
            RoundedTotal = RoundedTotal / Math.pow(10, DecimalPlaces);

            // Third pad with 0's if necessary the number to a string
            var Totalstring = RoundedTotal.toString(); // Convert to a string
            var DecimalPoint = Totalstring.indexOf("."); // Look for decimal point
            if (DecimalPoint == -1) {
                // No decimal so we need to pad all decimal places with 0's - if any
                currentDecimals = 0;
                // Add a decimal point if DecimalPlaces is GT 0
                Totalstring += DecimalPlaces > 0 ? "." : "";
            }
            else {
                // There is already a decimal so we only need to pad remaining decimal places with 0's
                currentDecimals = Totalstring.length - DecimalPoint - 1;
            }
            // Determine how many decimal places need to be padded with 0's
            var Pad = DecimalPlaces - currentDecimals;
            if (Pad > 0) {
                for (var count = 1; count <= Pad; count++)
                    Totalstring += "0";
            }

            var num = null;
            if (Totalstring.indexOf(".") != -1) {
                num = Totalstring.substring(0, Totalstring.indexOf("."));
            } else {
                num = Totalstring;
            }

            for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
            if (Totalstring.indexOf(".") != -1) {
                Totalstring = num + Totalstring.substring(Totalstring.indexOf("."));
            } else {
                Totalstring = num;
            }

            if (isNegative)
                Totalstring = "-" + Totalstring;
            return Totalstring;
        }

        function showPanPok() {
            document.getElementById("panPok").style.display = "";
        }

        function hidePanPok() {

            var maxPok = parseFloat(document.getElementById("hidMaxPok").value);
            SelectOptMaxPok(maxPok);

            document.getElementById("panPok").style.display = "none";

        }

        function changeMaxPok() {
            var maxPok = 0;

            for (var i = 0; i < 10; i++) {
                var ctr = document.getElementById("opt" + i);
                if (ctr != null) {
                    if (ctr.checked) {
                        maxPok = parseFloat(ctr.value);
                        break;
                    }
                }
            }

            document.getElementById("hidMaxPok").value = maxPok;
            document.getElementById("lblMaxStake").innerHTML = GetOptMaxPokText(maxPok);
            hidePanPok();
        }

        function SelectOptMaxPok(maxPok) {
            for (var i = 0; i < 10; i++) {
                var ctr = document.getElementById("opt" + i);
                var ctrImg = document.getElementById("imgMaxPok" + i);

                if (ctr != null) {
                    if (parseFloat(ctr.value) == maxPok)
                        ctr.checked = true;
                    else
                        ctr.checked = false;
                }

                if (parseFloat(ctr.value) > maxPok) {
                    ctrImg.src = "../Images/small_close.png";
                }
                else {
                    ctrImg.src = "../Images/small_tick.png";
                }
            }
        }

        function GetOptMaxPokText(maxPok) {
            var text = "";

            if (maxPok == 10000)
                text = "High [5000/10000]";
            else if (maxPok == 4000)
                text = "High [2000/4000]";
            else if (maxPok == 2000)
                text = "High [1000/2000]";
            else if (maxPok == 1000)
                text = "Medium [500/1000]";
            else if (maxPok == 400)
                text = "Medium [200/400]";
            else if (maxPok == 200)
                text = "Medium [100/200]";
            else if (maxPok == 100)
                text = "Low [50/100]";
            else if (maxPok == 50)
                text = "Low [25/50]";
            else if (maxPok == 20)
                text = "Low [10/20]";
            else if (maxPok == 0)
                text = "Play for fun";

            return text;
        }

        function SetLDBWinLimit(obj) {
            if (obj.id == 'btnLDBWinLimitEnable') {
                document.getElementById('txtLDBWinLimit').value = "";
                document.getElementById('txtLDBWinLimit').readOnly = false;
                document.getElementById('txtLDBWinLimit').focus();
            }
            else if (obj.id == 'btnLDBWinLimitDisable') {
                document.getElementById('txtLDBWinLimit').value = "0";
                document.getElementById('txtLDBWinLimit').readOnly = true;
            }
        }

        function SetETHLoseLimit(obj) {
            if (obj.id == 'btnETHLoseLimitEnable') {
                document.getElementById('txtETHLoseLimit').value = "";
                document.getElementById('txtETHLoseLimit').readOnly = false;
                document.getElementById('txtETHLoseLimit').focus();
            }
            else if (obj.id == 'btnETHLoseLimitDisable') {
                document.getElementById('txtETHLoseLimit').value = "0";
                document.getElementById('txtETHLoseLimit').readOnly = true;
            }
        }

        function SetLDWinLimit(obj) {
            if (obj.id == 'btnLDWinLimitEnable') {
                document.getElementById('txtLDWinLimit').value = "";
                document.getElementById('txtLDWinLimit').readOnly = false;
                document.getElementById('txtLDWinLimit').focus();
            }
            else if (obj.id == 'btnLDWinLimitDisable') {
                document.getElementById('txtLDWinLimit').value = "0";
                document.getElementById('txtLDWinLimit').readOnly = true;
            }
        }

        function popUpMsg(msg) {
            alert(msg);
        }

        function isWeekly(rId, chkId) {
            var rdList = document.getElementById(rId);
            var rdListCount = rdList.getElementsByTagName("input");
            var chkList = document.getElementById(chkId);
            var chkListCount = chkList.getElementsByTagName("input");
            var cnt = 0;
            for (var i = 0; i < rdListCount.length; i++) {
                if (i == 2 && rdListCount[i].checked == true) {
                    for (var j = 0; j < chkListCount.length; j++) {
                        if (chkListCount[j].checked == true) {
                            cnt = cnt + 1;
                        }
                    }
                }

                if (i == 2 && rdListCount[i].checked == true) {
                    if (cnt == 0) {
                        alert("Payment option: Since you have been selected weekly, please select one of the days.");
                        return false;
                    }
                }

                if (cnt > 6) {
                    alert("Payment option: The maximum 6 days allowed to select!");
                    return false;
                }
            }
            return true;
        }

        function unCheckedChk(rId, chkId, hostIsNormalPayment) {
            var rdList = document.getElementById(rId);
            var rdListCount = rdList.getElementsByTagName("input");
            var chkList = document.getElementById(chkId);
            var chkListCount = chkList.getElementsByTagName("input");
            var cnt = 0;
            var isNormalPayment = parseInt(hostIsNormalPayment.toString());
            if (isNormalPayment >= 255) {
                for (var i = 0; i < rdListCount.length; i++) {
                    if (i == 0 && rdListCount[i].checked == true) {
                        for (var j = 0; j < chkListCount.length; j++) {
                            if (chkListCount[j].checked == true) {
                                chkListCount[j].checked = false;
                            }
                            chkListCount[j].disabled = true;
                        }
                    } else if (i == 1 && rdListCount[i].checked == true) {
                        for (var j = 0; j < chkListCount.length; j++) {
                            chkListCount[j].disabled = false;
                        }
                    }
                }
            } else {
                for (var j = 0; j < chkListCount.length; j++) {
                    chkListCount[j].disabled = true;
                }
            }
        }

        function SetLDCWinLimit(obj) {
            if (obj.id == 'btnLDCWinLimitEnable') {
                document.getElementById('txtLDCWinLimit').value = "";
                document.getElementById('txtLDCWinLimit').readOnly = false;
                document.getElementById('txtLDCWinLimit').focus();
            }
            else if (obj.id == 'btnLDCWinLimitDisable') {
                document.getElementById('txtLDCWinLimit').value = "0";
                document.getElementById('txtLDCWinLimit').readOnly = true;
            }
        }

        function SetLDCLoseLimit(obj) {
            if (obj.id == 'btnLDCLoseLimitEnable') {
                document.getElementById('txtLDCLoseLimit').value = "";
                document.getElementById('txtLDCLoseLimit').readOnly = false;
                document.getElementById('txtLDCLoseLimit').focus();
            }
            else if (obj.id == 'btnLDCLoseLimitDisable') {
                document.getElementById('txtLDCLoseLimit').value = "0";
                document.getElementById('txtLDCLoseLimit').readOnly = true;
            }
        }

        function PopupCenter(pageURL, title, w, h) {
            var left = (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2);
            var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        }

        function SelectOptProfile(type, profile) {
            var profileCount = GetProfileCount(type);
            for (var i = 1; i < profileCount; i++) {
                var ctr = document.getElementById("opt" + type + "Profile" + i);
                var ctrImg = document.getElementById("img" + type + "Profile" + i);

                if (ctr != null) {
                    if (parseInt(ctr.value) == profile)
                        ctr.checked = true;
                    else
                        ctr.checked = false;
                }

                if (parseInt(ctr.value) > profile) {
                    ctrImg.src = "../Images/small_close.png";
                }
                else {
                    ctrImg.src = "../Images/small_tick.png";
                }
            }
        }

        function GetProfileCount(type) {
            var profileCount = 7;

            if (type == "RBF" || type == "RBG")
                profileCount = 6;
            else if (type == "RBI")
                profileCount = 5;

            return profileCount;
        }
    </script>


    <script src="http://ag.ufabet.com/JS/AccountSetting2.js?v220190726" type="text/javascript"></script>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include'nav.php'?>

        <div id="page-wrapper">
            <div class="row">



                <div class="col-lg-12">
                    <div class="container contact-form">

                      <?php
                     $objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
                     $objDB = mysql_select_db($DB_NAME);
                     mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
                     $strSQL = "SELECT * FROM scclub_data WHERE category='สมัครสมาชิก' ORDER BY transactionid DESC";
                     if(empty($_GET)) {
                                 $strSQL = "SELECT * FROM scclub_data WHERE user='uffq00000' ";
                             }
                     $objQuery = mysql_query($strSQL);
                     $objResult = mysql_fetch_array($objQuery);
                     if(!$objResult)
                     {
                         echo "ไม่พบ Username = ".$_GET["sendget"];
                     }

                     ?>
                     <?php
                     $registeruser = $objResult["user"]
                     ?>


                      <?php
                     $objConnect = mysql_connect($HOST_NAME,$USERNAME,$PASSWORD) or die("Error Connect to Database");
                     $objDB = mysql_select_db($DB_NAME);
                     mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client='utf8'");
mysql_query("SET character_set_connection='utf8'");
mysql_query("collation_connection = utf8_unicode_ci");
mysql_query("collation_database = utf8_unicode_ci");
mysql_query("collation_server = utf8_unicode_ci");
                     $strSQL = "SELECT * FROM scclub_data WHERE transactionid = '".$_GET["transactionid"]."' ";
                     $objQuery = mysql_query($strSQL);
                     $objResult = mysql_fetch_array($objQuery);
                     if(!$objResult)
                     {
                         echo "Not found transactionid=".$_GET["transactionid"];
                     }
                     else
                     {
                     ?>

                     <?php
                     $totalcradit = $objResult["deposit"]+$objResult["bonus"];
                     ?>


<br>
<a id="btnSave" class="btnSet btn btn-primary btn-block" href="#" target="_blank" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSave&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, true))" >เปิดชื่อผู้ใช้งาน</a>
                     <form name="form1" class="hidden" method="post" action="http://ag.ufabet.com/_Age1/MemberSet.aspx" onsubmit="javascript:return WebForm_OnSubmit();" id="form1">
                 <div>
                   <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="" />
                   <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="" />
                   <input type="hidden" name="__LASTFOCUS" id="__LASTFOCUS" value="" />
                   <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKMTM5NzM2MzUxNQ8WiAEeBk1heEdCSgcAAAAAAADwPx4LTWluU2hhcmVSdW4HAAAAAAAAAAAeBk1pbkc3QgcAAAAAAADwPx4ITWluU2hhcmUHAAAAAAAAAAAeC01pblNoYXJlUGFzBwAAAAAAAAAAHgtNaW5TaGFyZVBhcgcAAAAAAAAAAB4ObWF4Q29tbWlzc2lvbkgFATAeCk1pblNoYXJlM0QHAAAAAAAAAAAeCk1pblNoYXJlMkQHAAAAAAAAAAAeCk1pblNoYXJlMUQHAAAAAAAAAAAeDm1heENvbW1pc3Npb25DBQEwHgpNaW5aT3RoZXJzBwAAAAAAAPA/HgZNYXhHU0IHAAAAAAAA8D8eBk1pblpSTAcAAAAAAADwPx4LbWF4UGVyY2VudEYCyAEeBk1heEc3QgcAAAAAAADwPx4LTWluU2hhcmVYMTIHAAAAAAAAAAAeDm1heENvbW1pc3Npb25CBQEwHgZNYXhHVEgHAAAAAAAA8D8eBk1pbkdCQQcAAAAAAADwPx4GTWluR1JMBwAAAAAAAPA/HgZNYXhHM0MHAAAAAAAA8D8eCElzQWRkTmV3Zx4LTWluU2hhcmU0RFNmHgZNaW5HQkoHAAAAAAAA8D8eBk1pbkdUSAcAAAAAAADwPx4LTWluU2hhcmVSQkwHAAAAAAAAAAAeDm1heENvbW1pc3Npb25GBQEwHgttYXhQZXJjZW50MwJkHgttYXhQZXJjZW50RwLIAR4LTWluU2hhcmVSQVMHAAAAAAAAAAAeC01pblNoYXJlUkFSBwAAAAAAAAAAHgtNaW5TaGFyZVJBVQcAAAAAAAAAAB4LTWluU2hhcmVSQVQHAAAAAAAAAAAeC21heFBlcmNlbnRCAmQeC21heFBlcmNlbnRBAmQeC01pblNoYXJlUkJHBwAAAAAAAAAAHgtNaW5TaGFyZVJCRgcAAAAAAAAAAB4LTWluU2hhcmVSQkkHAAAAAAAAAAAeC01pblNoYXJlUkJIBwAAAAAAAAAAHg5NaW5TaGFyZVJ1blgxMgcAAAAAAAAAAB4LbWF4UGVyY2VudEoCkAMeC21heFBlcmNlbnRJApADHgttYXhQZXJjZW50SAKQAx4FTWF4RUcHAAAAAABq+EAeDm1heENvbW1pc3Npb25HBQEwHg5tYXhDb21taXNzaW9uQQUB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WWVzBQxidG5TdXNwZW5kTm8FD2J0bkxvZ2luVHlwZVllcwUOYnRuTG9naW5UeXBlTm8FDmJ0bkxvZ2luVHlwZU5vBQ1idG5SQU1EaXNhYmxlBQ1idG5SQU1EaXNhYmxlBQxidG5SQU1FbmFibGUFDm9wdFJBTVByb2ZpbGUxBQ5vcHRSQU1Qcm9maWxlMgUOb3B0UkFNUHJvZmlsZTMFDm9wdFJBTVByb2ZpbGU0BQ5vcHRSQU1Qcm9maWxlNQUOb3B0UkFNUHJvZmlsZTYFDWJ0blJBUkRpc2FibGUFDWJ0blJBUkRpc2FibGUFDGJ0blJBUkVuYWJsZQUOb3B0UkFSUHJvZmlsZTEFDm9wdFJBUlByb2ZpbGUyBQ5vcHRSQVJQcm9maWxlMwUOb3B0UkFSUHJvZmlsZTQFDm9wdFJBUlByb2ZpbGU1BQ5vcHRSQVJQcm9maWxlNgUNYnRuUkFTRGlzYWJsZQUNYnRuUkFTRGlzYWJsZQUMYnRuUkFTRW5hYmxlBQ5vcHRSQVNQcm9maWxlMQUOb3B0UkFTUHJvZmlsZTIFDm9wdFJBU1Byb2ZpbGUzBQ5vcHRSQVNQcm9maWxlNAUOb3B0UkFTUHJvZmlsZTUFDm9wdFJBU1Byb2ZpbGU2BQ1idG5SQVVEaXNhYmxlBQ1idG5SQVVEaXNhYmxlBQxidG5SQVVFbmFibGUFDWJ0blJCRkRpc2FibGUFDWJ0blJCRkRpc2FibGUFDGJ0blJCRkVuYWJsZQUOb3B0UkJGUHJvZmlsZTEFDm9wdFJCRlByb2ZpbGUyBQ5vcHRSQkZQcm9maWxlMwUOb3B0UkJGUHJvZmlsZTQFDm9wdFJCR1Byb2ZpbGUxBQ5vcHRSQkdQcm9maWxlMgUOb3B0UkJHUHJvZmlsZTMFDm9wdFJCR1Byb2ZpbGU0BQ1idG5SQkhEaXNhYmxlBQxidG5SQkhFbmFibGUFDGJ0blJCSEVuYWJsZQUOb3B0UkJJUHJvZmlsZTEFDWJ0blJCSURpc2FibGUFDGJ0blJCSUVuYWJsZQUMYnRuUkJJRW5hYmxlBQ1idG5SQkxEaXNhYmxlBQ1idG5SQkxEaXNhYmxlBQxidG5SQkxFbmFibGVphqYLwf0hpIHp0fX2TN8v6uSOeA==" />
                   </div>

  <script type="text/javascript">
  //<![CDATA[
  var theForm = document.forms['form1'];
  if (!theForm) {
      theForm = document.form1;
  }
  function __doPostBack(eventTarget, eventArgument) {
      if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
          theForm.__EVENTTARGET.value = eventTarget;
          theForm.__EVENTARGUMENT.value = eventArgument;
          theForm.submit();
      }
  }
  //]]>
  </script>



                 <script src="http://ag.ufabet.com/_Age1/WebResource.axd?d=ndlrlMXvzaWk53sH4dqvCeEc3W6aB9o5LAYzPueJeceuQO8VzJgxvc0vdL1IqLqQC7HiW43tOwOSvXU3YGQhbbTXWjY1&amp;t=636765751264470882" type="text/javascript"></script>


                 <script src="http://ag.ufabet.com/_Age1/WebResource.axd?d=X7KWeXzae1qFZoYH_K5NjKkSERJCeFrNfMccoR-3A2dQLkheHRx12r-ffpl6ZEzqn1n2tHx2DUK5yqG5euI_qz2lTh28s5BqRGXEIbMw_k6FPK270&amp;t=636765751264470882" type="text/javascript"></script>
                 <script type="text/javascript">
                 //<![CDATA[
                 function WebForm_OnSubmit() {
                 if (typeof(ValidatorOnSubmit) == "function" && ValidatorOnSubmit() == false) return false;
                 return true;
                 }
                 //]]>
                 </script>

                 <div>

                   <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="9D28CE29" />
                 	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="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" />
                 </div>

                     <div id="page_main">

                     <table cellspacing="0" cellpadding="0" width="901">
                         <tr>
                             <td height="5"></td>
                         </tr>


                         <tr><td>&nbsp;</td></tr>

                         <tr><td align="left">
                             <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr align="center">
                                     <td align="left">
                                         <table height="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tr id="trBtnSave">
                 	<td class="btnSetL"></td>
                 	<td class="btnSetC">
                                                     &nbsp;<a id="btnSave" class="btnSet btn btn-primary btn-block" href="#" target="_blank" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;btnSave&quot;, &quot;&quot;, true, &quot;&quot;, &quot;&quot;, false, true))" >เปิดชื่อผู้ใช้งาน</a>&nbsp;

                                                 </td>
                 	<td class="btnSetR"></td>
                 </tr>

                                         </table>
                                     </td>
                                     <td align="right">
                                         <table height="100%" border="0" cellspacing="0" cellpadding="0">

                                         </table>
                                     </td>
                                 </tr>
                             </table>
                         </td></tr>

                         <tr><td>&nbsp;</td></tr>

                         <tr>
                 			<td align="center"><span id="lblStatus"></span></td>
                 		</tr>

                         <tr><td>&nbsp;</td></tr>

                         <tr><td>
                         <!--------------------------------------------------------------------------- General Information --------------------------------------------------------------------------->
                         <table width="100%" height="100%" cellspacing="0" cellpadding="5">

                             <tr class="SetGridItem">
                                 <td width="17%" align="right" class="SetBorderL SetBorderB">
                                     User Name
                                 </td>
                                 <td width="33%" align="left" class="SetBorderL SetBorderB">
                                     <table cellpadding="0" cellspacing="0" width="100%">
                                         <tr>
                                             <td width="145px">
                                                 <table cellpadding="0" cellspacing="0" width="145px">
                                                     <tr>
                                                         <td>
                                                             <span id="lblAgent">uffq01</span>
                                                         </td>
                                                         <td>
                                                             <input name="txtUserName" type="text" maxlength="16" id="txtUserName" class="TextBox" style="width:100%;" value="<?php echo substr($registeruser,6);?>" />
                                                         </td>
                                                     </tr>
                                                 </table>
                                             </td>
                                             <td width="7px">&nbsp;</td>
                                             <td align="left">
                                                 <a id="btnCheck" class="btnAgent" href="javascript:__doPostBack('btnCheck','')" style="display:inline-block;width:100px;">Check Availability</a>
                                             </td>
                                         </tr>
                                     </table>
                                     <span id="rgvUserName" class="Error" style="color:Red;display:none;"><span class='ENG'>User Name must not be blank.</span></span>
                                 </td>
                                 <td width="17%" align="right" class="SetBorderL SetBorderB">
                                     Password
                                 </td>
                                 <td width="33%" align="left" class="SetBorderL SetBorderB SetBorderR" colspan="3">
                                     <input name="txtPassword" type="text" maxlength="16" id="txtPassword" class="TextBox" style="width:145px;" value="sc<?php echo $objResult["tel"];?>"/>
                                     <br />
                                     <span id="rgvPassword" style="color:Red;display:none;"><span class='ENG'>Password must not be blank.</span></span>
                                 </td>
                             </tr>
                             <tr class="SetGridAltItem">
                                 <td align="right" class="SetBorderL SetBorderB">
                                     Credit Limit
                                 </td>
                                 <td align="left" class="SetBorderL SetBorderB">
                                     <input name="txtTotalLimit" type="text" id="txtTotalLimit" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:144px;" value="<?php echo $totalcradit;?>"/>

                                     <br />
                                     <span id="rqvTotalRequired" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                     <span id="rgvTotalLimit" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                 </td>

                                 <td align="right" class="SetBorderL SetBorderB">
                                     Contact
                                 </td>
                                 <td align="left" class="SetBorderL SetBorderB SetBorderR" colspan="3">
                                     <input name="txtContact" type="text" id="txtContact" class="TextBox" style="width:144px;" value="<?php echo $objResult["surelastname"];?> / <?php echo $objResult["banknumber"];?> <?php echo $objResult["bank"];?>" />
                                 </td>

                             </tr>
                             <tr class="SetGridItem" style="display:none;">
                                 <td align="right" class="SetBorderL SetBorderB">
                                     Status
                                 </td>
                                 <td align="left" class="SetBorderL SetBorderB">
                                     <input id="btnUsaYes" type="radio" name="Usa" value="btnUsaYes" checked="checked" /><label for="btnUsaYes">Open</label>
                                     <input id="btnUsaNo" type="radio" name="Usa" value="btnUsaNo" /><label for="btnUsaNo">Lock</label>
                                 </td>
                                 <td align="right" class="SetBorderL SetBorderB">
                                     Suspend
                                 </td>
                                 <td align="left" class="SetBorderL SetBorderB SetBorderR" colspan="3">
                                     <input id="btnSuspendYes" type="radio" name="Suspend" value="btnSuspendYes" /><label for="btnSuspendYes">Yes</label>
                                     <input id="btnSuspendNo" type="radio" name="Suspend" value="btnSuspendNo" checked="checked" /><label for="btnSuspendNo">No</label>
                                 </td>
                             </tr>

                             <tr class="SetGridAltItem" style="display:none;" >
                                 <td align="right" class="SetBorderL SetBorderB">
                                     User Normal Login
                                 </td>
                                 <td align="left" class="SetBorderL SetBorderB">
                                     <input id="btnLoginTypeYes" type="radio" name="LoginType" value="btnLoginTypeYes" checked="checked" /><label for="btnLoginTypeYes">Yes</label>&nbsp;
                                     <span title='User without device restricted login.'>
                 		                <img id="Image1" src="../Images/question_mark.gif" style="height:11px;width:11px;border-width:0px;" />
                 		            </span>
                                 </td>
                                 <td align="right" class="SetBorderL SetBorderB" style="display:none;">
                                     User Device Login
                                 </td>
                                 <td align="left" class="SetBorderL SetBorderB SetBorderR">
                                     <input id="btnLoginTypeNo" type="radio" name="LoginType" value="btnLoginTypeNo" /><label for="btnLoginTypeNo">Yes</label>&nbsp;
                                     <span title='User only allowed to use mobile phone, tablet device login.'>
                 		                <img id="Image2" src="../Images/question_mark.gif" style="height:11px;width:11px;border-width:0px;" />
                 		            </span>
                                 </td>
                             </tr>
                         </table>
                         <!--------------------------------------------------------------------------- General Information END --------------------------------------------------------------------------->
                         </td></tr>

                         <tr><td>&nbsp;</td></tr>

                         <tr><td>
                         <!--------------------------------------------------------------------------- SPORTSBOOK --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table id="tbSports" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trSports',this)">
                                 <tr>
                                     <td align="left">SPORTSBOOK</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trSports" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                                     <!------------------------------------- Commission Setting / Limit Setting ------------------------------------->
                                     <tr><td>
                                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                             <tr class="SetGridHeader">
                                                 <td colspan="2" align="center" width="40%">COMMISSION SETTING</td>
                                                 <td colspan="3" align="center" width="60%">LIMIT SETTING</td>
                                             </tr>
                                             <tr class="SetGridItem" align="center">
                                                 <td width="16%" align="left" class="SetBorderL SetBorderB">&nbsp;</td>
                 	                            <td width="24%" class="SetBorderL SetBorderB SetBackgroundT">Comm For Member</td>
                 	                            <td width="18%" align="left" class="SetBorderL SetBorderB">&nbsp;</td>
                 	                            <td width="21%" class="SetBorderL SetBorderB SetBackgroundT">Max Bet</td>
                 	                            <td width="21%" class="SetBorderL SetBorderB SetBorderR SetBackgroundT">Max Per Match</td>
                                             </tr>
                                             <tr class="SetGridAltItem" align="center">
                                                 <td align="left" class="SetBorderL SetBorderB">
                 	                                HDP/OU/OE
                 	                                &nbsp;(<span id="lblCommission">0%</span>)&nbsp;
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB">
                 	                                <select name="lstCommissionType" onchange="javascript:setTimeout('__doPostBack(\'lstCommissionType\',\'\')', 0)" id="lstCommissionType" style="width:120px;">
                 	<option selected="selected" value="A">A (Best Spread 4%)</option>
                 	<option value="B">B (Best Spread 5%)</option>
                 	<option value="C">C (Best Spread 6%)</option>
                 	<option value="D">D (Best Spread 7%)</option>
                 	<option value="E">E (Best Spread 8%)</option>
                 	<option value="F">F (Best Spread 9%)</option>
                 	<option value="G">G (Best Spread 10%)</option>
                 	<option value="H">H (Best Spread 12%)</option>
                 	<option value="I">I (Best Spread 15%)</option>
                 	<option value="J">J (Best Spread 20%)</option>

                 </select>


                 						            <select name="lstCommission" id="lstCommission" style="width:55px;">
                 	<option selected="selected" value="0">0%</option>
                 	<option value="0.05">0.05%</option>
                 	<option value="0.1">0.1%</option>
                 	<option value="0.15">0.15%</option>
                 	<option value="0.2">0.2%</option>
                 	<option value="0.25">0.25%</option>
                 	<option value="0.3">0.3%</option>
                 	<option value="0.35">0.35%</option>
                 	<option value="0.4">0.4%</option>
                 	<option value="0.45">0.45%</option>
                 	<option value="0.5">0.5%</option>
                 	<option value="0.55">0.55%</option>
                 	<option value="0.6">0.6%</option>
                 	<option value="0.65">0.65%</option>
                 	<option value="0.7">0.7%</option>
                 	<option value="0.75">0.75%</option>
                 	<option value="0.8">0.8%</option>
                 	<option value="0.85">0.85%</option>
                 	<option value="0.9">0.9%</option>
                 	<option value="0.95">0.95%</option>
                 	<option value="1">1%</option>

                 </select>
                 	                            </td>
                 	                            <td align="left" class="SetBorderL SetBorderB">
                 	                                HDP/OU/OE
                 	                                <span title='Handicap, Over/Under, Odd/Even, 4D Specials'>
                 						                <img id="ImageHDP_OU_OE" src="../Images/question_mark.gif" style="height:11px;width:11px;border-width:0px;" />
                 						            </span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB" align="left">
                 	                                <input name="txtTransLimit" type="text" value="1,500,000" id="txtTransLimit" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblTransLimit">Max = <SPAN class='Positive'>1,500,000</SPAN></span><br />
                                                     <span id="rqvTransRequired" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvTransLimit" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB SetBorderR" align="left">
                 	                                <input name="txtBeforeRun" type="text" value="3,000,000" id="txtBeforeRun" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblBeforeRun">Max = <SPAN class='Positive'>3,000,000</SPAN></span><br />
                                                     <span id="rgvBeforeRun" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvBeforeRunLimit" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                                             </tr>

                                             <tr class="SetGridItem" align="center">
                                                 <td align="left" class="SetBorderL SetBorderB">
                 	                                1X2/Outright/DC
                 	                                &nbsp;(<span id="lblCommissionX12">0%</span>)&nbsp;
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB">
                 	                                <select name="lstCommissionX12" id="lstCommissionX12" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>
                 	<option value="0.05">0.05%</option>
                 	<option value="0.1">0.1%</option>
                 	<option value="0.15">0.15%</option>
                 	<option value="0.2">0.2%</option>
                 	<option value="0.25">0.25%</option>
                 	<option value="0.3">0.3%</option>
                 	<option value="0.35">0.35%</option>
                 	<option value="0.4">0.4%</option>
                 	<option value="0.45">0.45%</option>
                 	<option value="0.5">0.5%</option>
                 	<option value="0.55">0.55%</option>
                 	<option value="0.6">0.6%</option>
                 	<option value="0.65">0.65%</option>
                 	<option value="0.7">0.7%</option>
                 	<option value="0.75">0.75%</option>
                 	<option value="0.8">0.8%</option>
                 	<option value="0.85">0.85%</option>
                 	<option value="0.9">0.9%</option>
                 	<option value="0.95">0.95%</option>
                 	<option value="1">1%</option>

                 </select>
                 	                            </td>
                 	                            <td align="left" class="SetBorderL SetBorderB">1X2/Outright/DC</td>
                 	                            <td class="SetBorderL SetBorderB" align="left">
                 	                                <input name="txtMaxX12" type="text" value="150,000" id="txtMaxX12" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMaxX12">Max = <SPAN class='Positive'>150,000</SPAN></span><br />
                                                     <span id="rqvMaxX12Required" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMaxX12" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB SetBorderR" align="left">
                 	                                <input name="txtMatchLimitX12" type="text" value="500,000" id="txtMatchLimitX12" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMatchLimitX12">Max = <SPAN class='Positive'>500,000</SPAN></span><br />
                                                     <span id="rgvMatchLimitX12" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMatchLimitX12Limit" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                                             </tr>
                                             <tr class="SetGridAltItem" align="center">
                                                 <td align="left" class="SetBorderL SetBorderB">
                 	                                Parlay Comm
                 	                                &nbsp;(<span id="lblCommissionParlay">0%</span>)&nbsp;
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB">
                 	                                <select name="lstCommissionPar" id="lstCommissionPar" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>
                 	<option value="0.05">0.05%</option>
                 	<option value="0.1">0.1%</option>
                 	<option value="0.15">0.15%</option>
                 	<option value="0.2">0.2%</option>
                 	<option value="0.25">0.25%</option>
                 	<option value="0.3">0.3%</option>
                 	<option value="0.35">0.35%</option>
                 	<option value="0.4">0.4%</option>
                 	<option value="0.45">0.45%</option>
                 	<option value="0.5">0.5%</option>
                 	<option value="0.55">0.55%</option>
                 	<option value="0.6">0.6%</option>
                 	<option value="0.65">0.65%</option>
                 	<option value="0.7">0.7%</option>
                 	<option value="0.75">0.75%</option>
                 	<option value="0.8">0.8%</option>
                 	<option value="0.85">0.85%</option>
                 	<option value="0.9">0.9%</option>
                 	<option value="0.95">0.95%</option>
                 	<option value="1">1%</option>
                 	<option value="1.05">1.05%</option>
                 	<option value="1.1">1.1%</option>
                 	<option value="1.15">1.15%</option>
                 	<option value="1.2">1.2%</option>
                 	<option value="1.25">1.25%</option>
                 	<option value="1.3">1.3%</option>
                 	<option value="1.35">1.35%</option>
                 	<option value="1.4">1.4%</option>
                 	<option value="1.45">1.45%</option>
                 	<option value="1.5">1.5%</option>
                 	<option value="1.55">1.55%</option>
                 	<option value="1.6">1.6%</option>
                 	<option value="1.65">1.65%</option>
                 	<option value="1.7">1.7%</option>
                 	<option value="1.75">1.75%</option>
                 	<option value="1.8">1.8%</option>
                 	<option value="1.85">1.85%</option>
                 	<option value="1.9">1.9%</option>
                 	<option value="1.95">1.95%</option>
                 	<option value="2">2%</option>
                 	<option value="2.05">2.05%</option>
                 	<option value="2.1">2.1%</option>
                 	<option value="2.15">2.15%</option>
                 	<option value="2.2">2.2%</option>
                 	<option value="2.25">2.25%</option>
                 	<option value="2.3">2.3%</option>
                 	<option value="2.35">2.35%</option>
                 	<option value="2.4">2.4%</option>
                 	<option value="2.45">2.45%</option>
                 	<option value="2.5">2.5%</option>
                 	<option value="2.55">2.55%</option>
                 	<option value="2.6">2.6%</option>
                 	<option value="2.65">2.65%</option>
                 	<option value="2.7">2.7%</option>
                 	<option value="2.75">2.75%</option>
                 	<option value="2.8">2.8%</option>
                 	<option value="2.85">2.85%</option>
                 	<option value="2.9">2.9%</option>
                 	<option value="2.95">2.95%</option>
                 	<option value="3">3%</option>
                 	<option value="3.05">3.05%</option>
                 	<option value="3.1">3.1%</option>
                 	<option value="3.15">3.15%</option>
                 	<option value="3.2">3.2%</option>
                 	<option value="3.25">3.25%</option>
                 	<option value="3.3">3.3%</option>
                 	<option value="3.35">3.35%</option>
                 	<option value="3.4">3.4%</option>
                 	<option value="3.45">3.45%</option>
                 	<option value="3.5">3.5%</option>
                 	<option value="3.55">3.55%</option>
                 	<option value="3.6">3.6%</option>
                 	<option value="3.65">3.65%</option>
                 	<option value="3.7">3.7%</option>
                 	<option value="3.75">3.75%</option>
                 	<option value="3.8">3.8%</option>
                 	<option value="3.85">3.85%</option>
                 	<option value="3.9">3.9%</option>
                 	<option value="3.95">3.95%</option>
                 	<option value="4">4%</option>
                 	<option value="4.05">4.05%</option>
                 	<option value="4.1">4.1%</option>
                 	<option value="4.15">4.15%</option>
                 	<option value="4.2">4.2%</option>
                 	<option value="4.25">4.25%</option>
                 	<option value="4.3">4.3%</option>
                 	<option value="4.35">4.35%</option>
                 	<option value="4.4">4.4%</option>
                 	<option value="4.45">4.45%</option>
                 	<option value="4.5">4.5%</option>
                 	<option value="4.55">4.55%</option>
                 	<option value="4.6">4.6%</option>
                 	<option value="4.65">4.65%</option>
                 	<option value="4.7">4.7%</option>
                 	<option value="4.75">4.75%</option>
                 	<option value="4.8">4.8%</option>
                 	<option value="4.85">4.85%</option>
                 	<option value="4.9">4.9%</option>
                 	<option value="4.95">4.95%</option>
                 	<option value="5">5%</option>

                 </select>
                 	                            </td>
                 	                            <td align="left" class="SetBorderL SetBorderB">Mix Parlay</td>
                 	                            <td class="SetBorderL SetBorderB" align="left">
                 	                                <input name="txtMaxPar" type="text" value="150,000" id="txtMaxPar" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMaxPar">Max = <SPAN class='Positive'>150,000</SPAN></span><br />
                                                     <span id="rqvMaxParRequired" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMaxPar" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB SetBorderR" align="left">
                 	                                <input name="txtPar" type="text" value="500,000" id="txtPar" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblPar">Max = <SPAN class='Positive'>500,000</SPAN></span>
                                                     <span title='Max Bet Limit per Combination'>
                                                         <img id="Image5" src="../Images/question_mark.gif" style="height:11px;width:11px;border-width:0px;" /></span><br />
                                                     <span id="rgvPar" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvParLimit" class="Error" style="color:Red;display:none;"><span class='ENG'>Invalid amount!</span></span>
                 	                            </td>
                                             </tr>
                                             <tr class="SetGridItem" align="center">
                                                 <td align="left" class="SetBorderL SetBorderB">
                 	                                Others Comm
                 	                                &nbsp;(<span id="lblCommissionOther">0%</span>)&nbsp;
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB">
                 	                                <select name="lstCommissionOther" id="lstCommissionOther" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>
                 	<option value="0.05">0.05%</option>
                 	<option value="0.1">0.1%</option>
                 	<option value="0.15">0.15%</option>
                 	<option value="0.2">0.2%</option>
                 	<option value="0.25">0.25%</option>
                 	<option value="0.3">0.3%</option>
                 	<option value="0.35">0.35%</option>
                 	<option value="0.4">0.4%</option>
                 	<option value="0.45">0.45%</option>
                 	<option value="0.5">0.5%</option>
                 	<option value="0.55">0.55%</option>
                 	<option value="0.6">0.6%</option>
                 	<option value="0.65">0.65%</option>
                 	<option value="0.7">0.7%</option>
                 	<option value="0.75">0.75%</option>
                 	<option value="0.8">0.8%</option>
                 	<option value="0.85">0.85%</option>
                 	<option value="0.9">0.9%</option>
                 	<option value="0.95">0.95%</option>
                 	<option value="1">1%</option>
                 	<option value="1.05">1.05%</option>
                 	<option value="1.1">1.1%</option>
                 	<option value="1.15">1.15%</option>
                 	<option value="1.2">1.2%</option>
                 	<option value="1.25">1.25%</option>
                 	<option value="1.3">1.3%</option>
                 	<option value="1.35">1.35%</option>
                 	<option value="1.4">1.4%</option>
                 	<option value="1.45">1.45%</option>
                 	<option value="1.5">1.5%</option>
                 	<option value="1.55">1.55%</option>
                 	<option value="1.6">1.6%</option>
                 	<option value="1.65">1.65%</option>
                 	<option value="1.7">1.7%</option>
                 	<option value="1.75">1.75%</option>
                 	<option value="1.8">1.8%</option>
                 	<option value="1.85">1.85%</option>
                 	<option value="1.9">1.9%</option>
                 	<option value="1.95">1.95%</option>
                 	<option value="2">2%</option>

                 </select>
                 	                            </td>
                 	                            <td align="left" class="SetBorderL SetBorderB">CS/TG/HT.FT/FG.LG</td>
                 	                            <td class="SetBorderL SetBorderB" align="left">
                 	                                <input name="txtMaxOther" type="text" value="150,000" id="txtMaxOther" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMaxOther">Max = <SPAN class='Positive'>150,000</SPAN></span><br />
                                                     <span id="rqvMaxOtherRequired" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMaxOther" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB SetBorderR" align="left">
                 	                                <input name="txtMatchLimitOther" type="text" value="500,000" id="txtMatchLimitOther" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMatchLimitOther">Max = <SPAN class='Positive'>500,000</SPAN></span><br />
                                                     <span id="rgvMatchLimitOther" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMatchLimitOtherLimit" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                                             </tr>
                                             <tr class="SetGridAltItem" align="center">
                                                 <!-- Myanmar Set Start -->

                                                 <div id="panSports_LimitSet_MM_Empty">

                                                     <td align="left" class="SetBorderL SetBorderB">&nbsp;</td>
                 	                                <td class="SetBorderL SetBorderB">&nbsp;</td>

                 </div>

                                                 <!-- Myanmar Set End -->
                 	                            <td align="left" class="SetBorderL SetBorderB">
                 	                                Other Sports HDP,OU,OE
                 	                                <span title='Basketball, Baseball, Tennis, US Football, Ice Hockey, Volleyball'>
                                                         <img id="ImageOS" src="../Images/question_mark.gif" style="height:11px;width:11px;border-width:0px;" /></span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB" align="left">
                 	                                <input name="txtMaxOS" type="text" value="150,000" id="txtMaxOS" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMaxOS">Max = <SPAN class='Positive'>150,000</SPAN></span><br />
                                                     <span id="rqvMaxOSRequired" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMaxOS" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                 	                            <td class="SetBorderL SetBorderB SetBorderR" align="left">
                 	                                <input name="txtMatchLimitOS" type="text" value="500,000" id="txtMatchLimitOS" class="TextBox" onKeyUp="this.value=fFormatDecimal(fParseFloat(this.value),0);" onKeypress="keyP(event);" style="width:80px;" />
                                                     <span id="lblMatchLimitOS">Max = <SPAN class='Positive'>500,000</SPAN></span>
                                                     <br />
                                                     <span id="rgvMatchLimitOS" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                                                     <span id="rgvMatchLimitOSLimit" class="Error" style="color:Red;display:none;"><span class='ENG'>Please enter amount.</span></span>
                 	                            </td>
                 	                        </tr>


                                         </table>
                                     </td></tr>
                                     <!------------------------------------- Position Taking ------------------------------------->
                                     <tr><td>
                                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" >
                                             <tr class="SetGridHeader">
                 	                            <td align="center">POSITION TAKING</td>
                                             </tr>
                                             <tr><td>
                                                 <table width="100%" cellspacing="0" cellpadding="0" align="left">
                                                 <tr><td>
                                                     <table width="100%" height="100%" cellspacing="0" cellpadding="5">
                                                         <tr align="center">
                                                             <td width="40%" class="SetPosBg2 SetBorderL SetBorderB">
                                                                 Share&nbsp;(<span id="lblShares">0% - 0%</span>)
                                                             </td>
                                                             <td align="right" width="35%" class="SetPosBg2 SetBorderL SetBorderB">
                                                                 HDP/OU/OE
                                                             </td>
                                                             <td align="left" width="25%" class="SetPosBg2 SetBorderB SetBorderR">
                                                                 <select name="lstShares" id="lstShares" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>

                 </select>
                                                             </td>
                                                         </tr>
                                                         <tr align="center">
                                                             <td class="SetPosBg2 SetBorderL SetBorderB">
                                                                 Share&nbsp;(<span id="lblSharesRun">0% - 0%</span>)
                                                             </td>
                                                             <td align="right" class="SetPosBg2 SetBorderL SetBorderB">
                                                                 LIVE HDP/OU
                                                             </td>
                                                             <td align="left" class="SetPosBg2 SetBorderB SetBorderR">
                                                                 <select name="lstSharesRun" id="lstSharesRun" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>

                 </select>
                                                             </td>
                                                         </tr>
                                                         <tr align="center">
                                                             <td class="SetPosBg2 SetBorderL SetBorderB">
                                                                 Share&nbsp;(<span id="lblSharesX12">0% - 0%</span>)
                                                             </td>
                                                             <td align="right" class="SetPosBg2 SetBorderL SetBorderB">
                                                                 1X2/Outright/DC
                                                             </td>
                                                             <td align="left" class="SetPosBg2 SetBorderB SetBorderR">
                                                                 <select name="lstSharesX12" id="lstSharesX12" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>

                 </select>
                                                             </td>
                                                         </tr>
                                                         <tr align="center">
                                                             <td class="SetPosBg2 SetBorderL SetBorderB">
                                                                 Share&nbsp;(<span id="lblSharesRunX12">0% - 0%</span>)
                                                             </td>
                                                             <td align="right" class="SetPosBg2 SetBorderL SetBorderB">
                                                                 LIVE 1X2
                                                             </td>
                                                             <td align="left" class="SetPosBg2 SetBorderB SetBorderR">
                                                                 <select name="lstSharesRunX12" id="lstSharesRunX12" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>

                 </select>
                                                             </td>
                                                         </tr>

                                                         <tr align="center">
                                                             <td class="SetPosBg2 SetBorderL SetBorderB">
                                                                 Share&nbsp;(<span id="lblSharesPar">0% - 0%</span>)
                                                             </td>
                                                             <td align="right" class="SetPosBg2 SetBorderL SetBorderB">
                                                                 Parlay/CS/TG/HT.FT/FG.LG
                                                             </td>
                                                             <td align="left" class="SetPosBg2 SetBorderB SetBorderR">
                                                                 <select name="lstSharesPar" id="lstSharesPar" style="width:65px;">
                 	<option selected="selected" value="0">0%</option>

                 </select>
                                                             </td>
                                                         </tr>
                                                     </table>
                                                 </td></tr>
                                                 </table>
                                             </td></tr>
                                         </table>
                                     </td></tr>
                                     <!------------------------------------- Position Taking END ------------------------------------->
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- SPORTSBOOK END --------------------------------------------------------------------------->
                         </td></tr>







                         <div id="panRAM">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- GD CASINO --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRAM',this)">
                                 <tr>
                                     <td align="left">GD CASINO</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRAM" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td width="33%" align="center">COMMISSION SETTING</td>
                                         <td width="33%" align="center">LIMIT SETTING</td>
                                         <td width="34%" align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             GD LIVE
                                             &nbsp;(<span id="lblCommissionRAM">0%</span>)&nbsp;
                                             <select name="lstCommissionRAM" id="lstCommissionRAM" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td class="SetBorderL SetBorderB SetBorderR">
                                             Profile =  <span id="lblRAMProfile">Limit F</span>
                 					        <input name="hidRAMProfile" type="hidden" id="hidRAMProfile" value="6" />
                                         </td>
                                         <td class="SetPosBg2 SetBorderB SetBorderR" colspan="2" align="center">
                                             GD Casino
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRAMDisable" type="radio" name="RAM" value="btnRAMDisable" /><label for="btnRAMDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRAMEnable" type="radio" name="RAM" value="btnRAMEnable" checked="checked" /><label for="btnRAMEnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                         <td nowrap="nowrap" align="left" class="SetBorderL SetBorderB SetBorderR" rowspan="3">
                                             <table class="Bold FontColor" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                                                 <tr><td width="20px"><input value="1" name="optRAMProfile" type="radio" id="optRAMProfile1" onclick="SelectOptProfile('RAM',1)" checked="checked" /></td><td width="50px">Limit A</td><td width="140px"><span id="lblRAMProfile1">Min = 30 Max = 3000</span></td><td><img src="../Images/small_tick.png" id="imgRAMProfile1" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ram&curId=23&profileId=1&r=1120970050', 'RAM_Profile_A', 880, 550);" /></td></tr>
                                                 <tr><td><input value="2" name="optRAMProfile" type="radio" id="optRAMProfile2" onclick="SelectOptProfile('RAM',2)" /></td><td>Limit B</td><td><span id="lblRAMProfile2">Min = 50 Max = 8000</span></td><td><img src="../Images/small_tick.png" id="imgRAMProfile2" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ram&curId=23&profileId=2&r=1120970050', 'RAM_Profile_B', 880, 550);" /></td></tr>
                                                 <tr><td><input value="3" name="optRAMProfile" type="radio" id="optRAMProfile3" onclick="SelectOptProfile('RAM',3)" /></td><td>Limit C</td><td><span id="lblRAMProfile3">Min = 100 Max = 15000</span></td><td><img src="../Images/small_tick.png" id="imgRAMProfile3" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ram&curId=23&profileId=3&r=1120970050', 'RAM_Profile_C', 880, 550);" /></td></tr>
                                                 <tr><td><input value="4" name="optRAMProfile" type="radio" id="optRAMProfile4" onclick="SelectOptProfile('RAM',4)" /></td><td>Limit D</td><td><span id="lblRAMProfile4">Min = 300 Max = 30000</span></td><td><img src="../Images/small_tick.png" id="imgRAMProfile4" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ram&curId=23&profileId=4&r=1120970050', 'RAM_Profile_D', 880, 550);" /></td></tr>
                                                 <tr><td><input value="5" name="optRAMProfile" type="radio" id="optRAMProfile5" onclick="SelectOptProfile('RAM',5)" /></td><td>Limit E</td><td><span id="lblRAMProfile5">Min = 500 Max = 50000</span></td><td><img src="../Images/small_tick.png" id="imgRAMProfile5" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ram&curId=23&profileId=5&r=1120970050', 'RAM_Profile_E', 880, 550);" /></td></tr>
                                                 <tr><td><input value="6" name="optRAMProfile" type="radio" id="optRAMProfile6" onclick="SelectOptProfile('RAM',6)"  /></td><td>Limit F</td><td><span id="lblRAMProfile6">Min = 2000 Max = 150000</span></td><td><img src="../Images/small_tick.png" id="imgRAMProfile6" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ram&curId=23&profileId=6&r=1120970050', 'RAM_Profile_F', 880, 550);" /></td></tr>
                                             </table>
                                         </td>
                                         <td width="17%" class="SetPosBg2 SetBorderB" align="center" valign="top" rowspan="3">Share&nbsp;(<span id="lblSharesRAM">0% - 0%</span>)</td>
                                         <td width="17%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRAM" id="lstSharesRAM" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" rowspan="2">&nbsp;</td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- GD CASINO END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRAR">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- SA GAMING --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRAR',this)">
                                 <tr>
                                     <td align="left">SA GAMING</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRAR" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td width="33%" align="center">COMMISSION SETTING</td>
                                         <td width="33%" align="center">LIMIT SETTING</td>
                                         <td width="34%" align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             SA LIVE
                                             &nbsp;(<span id="lblCommissionRAR">0%</span>)&nbsp;
                                             <select name="lstCommissionRAR" id="lstCommissionRAR" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td class="SetBorderL SetBorderB SetBorderR">
                                             Profile =  <span id="lblRARProfile">Limit F</span>
                 					        <input name="hidRARProfile" type="hidden" id="hidRARProfile" value="6" />
                                         </td>
                                         <td class="SetPosBg2 SetBorderB SetBorderR" colspan="2" align="center">
                                             SA Gaming
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRARDisable" type="radio" name="RAR" value="btnRARDisable" /><label for="btnRARDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRAREnable" type="radio" name="RAR" value="btnRAREnable" checked="checked" /><label for="btnRAREnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                         <td nowrap="nowrap" align="left" class="SetBorderL SetBorderB SetBorderR" rowspan="3">
                                             <table class="Bold FontColor" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                                                 <tr><td width="20px"><input value="1" name="optRARProfile" type="radio" id="optRARProfile1" onclick="SelectOptProfile('RAR',1)" checked="checked" /></td><td width="50px">Limit A</td><td width="140px"><span id="lblRARProfile1">Min = 20 Max = 1000</span></td><td><img src="../Images/small_tick.png" id="imgRARProfile1" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rar&curId=23&profileId=1&r=1120970050', 'RAR_Profile_A', 880, 550);" /></td></tr>
                                                 <tr><td><input value="2" name="optRARProfile" type="radio" id="optRARProfile2" onclick="SelectOptProfile('RAR',2)" /></td><td>Limit B</td><td><span id="lblRARProfile2">Min = 50 Max = 5000</span></td><td><img src="../Images/small_tick.png" id="imgRARProfile2" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rar&curId=23&profileId=2&r=1120970050', 'RAR_Profile_B', 880, 550);" /></td></tr>
                                                 <tr><td><input value="3" name="optRARProfile" type="radio" id="optRARProfile3" onclick="SelectOptProfile('RAR',3)" /></td><td>Limit C</td><td><span id="lblRARProfile3">Min = 100 Max = 10000</span></td><td><img src="../Images/small_tick.png" id="imgRARProfile3" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rar&curId=23&profileId=3&r=1120970050', 'RAR_Profile_C', 880, 550);" /></td></tr>
                                                 <tr><td><input value="4" name="optRARProfile" type="radio" id="optRARProfile4" onclick="SelectOptProfile('RAR',4)" /></td><td>Limit D</td><td><span id="lblRARProfile4">Min = 300 Max = 30000</span></td><td><img src="../Images/small_tick.png" id="imgRARProfile4" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rar&curId=23&profileId=4&r=1120970050', 'RAR_Profile_D', 880, 550);" /></td></tr>
                                                 <tr><td><input value="5" name="optRARProfile" type="radio" id="optRARProfile5" onclick="SelectOptProfile('RAR',5)" /></td><td>Limit E</td><td><span id="lblRARProfile5">Min = 500 Max = 50000</span></td><td><img src="../Images/small_tick.png" id="imgRARProfile5" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rar&curId=23&profileId=5&r=1120970050', 'RAR_Profile_E', 880, 550);" /></td></tr>
                                                 <tr><td><input value="6" name="optRARProfile" type="radio" id="optRARProfile6" onclick="SelectOptProfile('RAR',6)"  /></td><td>Limit F</td><td><span id="lblRARProfile6">Min = 10000 Max = 200000</span></td><td><img src="../Images/small_tick.png" id="imgRARProfile6" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rar&curId=23&profileId=6&r=1120970050', 'RAR_Profile_F', 880, 550);" /></td></tr>
                                             </table>
                                         </td>
                                         <td width="17%" class="SetPosBg2 SetBorderB" align="center" valign="top" rowspan="3">Share&nbsp;(<span id="lblSharesRAR">0% - 0%</span>)</td>
                                         <td width="17%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRAR" id="lstSharesRAR" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" rowspan="2">&nbsp;</td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- SA GAMING END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRAS">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- W88 CASINO --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRAS',this)">
                                 <tr>
                                     <td align="left">W88 CASINO</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRAS" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td width="33%" align="center">COMMISSION SETTING</td>
                                         <td width="33%" align="center">LIMIT SETTING</td>
                                         <td width="34%" align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             W88 LIVE
                                             &nbsp;(<span id="lblCommissionRAS">0%</span>)&nbsp;
                                             <select name="lstCommissionRAS" id="lstCommissionRAS" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td class="SetBorderL SetBorderB SetBorderR">
                                             Profile =  <span id="lblRASProfile">Limit F</span>
                 					        <input name="hidRASProfile" type="hidden" id="hidRASProfile" value="6" />
                                         </td>
                                         <td class="SetPosBg2 SetBorderB SetBorderR" colspan="2" align="center">
                                             W88 Casino
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRASDisable" type="radio" name="RAS" value="btnRASDisable" /><label for="btnRASDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRASEnable" type="radio" name="RAS" value="btnRASEnable" checked="checked" /><label for="btnRASEnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                         <td nowrap="nowrap" align="left" class="SetBorderL SetBorderB SetBorderR" rowspan="3">
                                             <table class="Bold FontColor" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                                                 <tr><td width="20px"><input value="1" name="optRASProfile" type="radio" id="optRASProfile1" onclick="SelectOptProfile('RAS',1)" checked="checked" /></td><td width="50px">Limit A</td><td width="140px"><span id="lblRASProfile1">Min = 50 Max = 5000</span></td><td><img src="../Images/small_tick.png" id="imgRASProfile1" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ras&curId=23&profileId=1&r=1120970050', 'RAS_Profile_A', 880, 550);" /></td></tr>
                                                 <tr><td><input value="2" name="optRASProfile" type="radio" id="optRASProfile2" onclick="SelectOptProfile('RAS',2)" /></td><td>Limit B</td><td><span id="lblRASProfile2">Min = 200 Max = 20000</span></td><td><img src="../Images/small_tick.png" id="imgRASProfile2" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ras&curId=23&profileId=2&r=1120970050', 'RAS_Profile_B', 880, 550);" /></td></tr>
                                                 <tr><td><input value="3" name="optRASProfile" type="radio" id="optRASProfile3" onclick="SelectOptProfile('RAS',3)" /></td><td>Limit C</td><td><span id="lblRASProfile3">Min = 500 Max = 50000</span></td><td><img src="../Images/small_tick.png" id="imgRASProfile3" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ras&curId=23&profileId=3&r=1120970050', 'RAS_Profile_C', 880, 550);" /></td></tr>
                                                 <tr><td><input value="4" name="optRASProfile" type="radio" id="optRASProfile4" onclick="SelectOptProfile('RAS',4)" /></td><td>Limit D</td><td><span id="lblRASProfile4">Min = 1000 Max = 100000</span></td><td><img src="../Images/small_tick.png" id="imgRASProfile4" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ras&curId=23&profileId=4&r=1120970050', 'RAS_Profile_D', 880, 550);" /></td></tr>
                                                 <tr><td><input value="5" name="optRASProfile" type="radio" id="optRASProfile5" onclick="SelectOptProfile('RAS',5)" /></td><td>Limit E</td><td><span id="lblRASProfile5">Min = 2000 Max = 150000</span></td><td><img src="../Images/small_tick.png" id="imgRASProfile5" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ras&curId=23&profileId=5&r=1120970050', 'RAS_Profile_E', 880, 550);" /></td></tr>
                                                 <tr><td><input value="6" name="optRASProfile" type="radio" id="optRASProfile6" onclick="SelectOptProfile('RAS',6)"  /></td><td>Limit F</td><td><span id="lblRASProfile6">Min = 3000 Max = 200000</span></td><td><img src="../Images/small_tick.png" id="imgRASProfile6" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=ras&curId=23&profileId=6&r=1120970050', 'RAS_Profile_F', 880, 550);" /></td></tr>
                                             </table>
                                         </td>
                                         <td width="17%" class="SetPosBg2 SetBorderB" align="center" valign="top" rowspan="3">Share&nbsp;(<span id="lblSharesRAS">0% - 0%</span>)</td>
                                         <td width="17%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRAS" id="lstSharesRAS" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" rowspan="2">&nbsp;</td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- W88 CASINO END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>



                         <div id="panRAU">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- JOKER --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRAU',this)">
                                 <tr>
                                     <td align="left">JOKER</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRAU" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td width="50%" nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRAUDisable" type="radio" name="RAU" value="btnRAUDisable" /><label for="btnRAUDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRAUEnable" type="radio" name="RAU" value="btnRAUEnable" checked="checked" /><label for="btnRAUEnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                         <td width="50%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" colspan="2" align="center">
                                             Joker
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td class="SetPosBg2 SetBorderL SetBorderB" align="center">Share&nbsp;(<span id="lblSharesRAU">0% - 0%</span>)</td>
                                         <td class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRAU" id="lstSharesRAU" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- JOKER END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRBF">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- GAME HALL CASINO --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRBF',this)">
                                 <tr>
                                     <td align="left">GAME HALL CASINO</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRBF" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td width="33%" align="center">COMMISSION SETTING</td>
                                         <td width="33%" align="center">LIMIT SETTING</td>
                                         <td width="34%" align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             GH Casino
                                             &nbsp;(<span id="lblCommissionRBF">0%</span>)&nbsp;
                                             <select name="lstCommissionRBF" id="lstCommissionRBF" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td class="SetBorderL SetBorderB SetBorderR">
                                             Profile =  <span id="lblRBFProfile">Limit D</span>
                 					        <input name="hidRBFProfile" type="hidden" id="hidRBFProfile" value="4" />
                                         </td>
                                         <td class="SetPosBg2 SetBorderB SetBorderR" colspan="2" align="center">
                                             GH Casino
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRBFDisable" type="radio" name="RBF" value="btnRBFDisable" /><label for="btnRBFDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRBFEnable" type="radio" name="RBF" value="btnRBFEnable" checked="checked" /><label for="btnRBFEnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                         <td nowrap="nowrap" align="left" class="SetBorderL SetBorderB SetBorderR" rowspan="3">
                                             <table class="Bold FontColor" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                                                 <tr><td width="20px"><input value="1" name="optRBFProfile" type="radio" id="optRBFProfile1" onclick="SelectOptProfile('RBF',1)" checked="checked" /></td><td width="50px">Limit A</td><td width="140px"><span id="lblRBFProfile1">Min = 20 Max = 5000</span></td><td><img src="../Images/small_tick.png" id="imgRBFProfile1" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbf&curId=23&profileId=1&r=1120970050', 'RBF_Profile_A', 880, 550);" /></td></tr>
                                                 <tr><td><input value="2" name="optRBFProfile" type="radio" id="optRBFProfile2" onclick="SelectOptProfile('RBF',2)" /></td><td>Limit B</td><td><span id="lblRBFProfile2">Min = 100 Max = 10000</span></td><td><img src="../Images/small_tick.png" id="imgRBFProfile2" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbf&curId=23&profileId=2&r=1120970050', 'RBF_Profile_B', 880, 550);" /></td></tr>
                                                 <tr><td><input value="3" name="optRBFProfile" type="radio" id="optRBFProfile3" onclick="SelectOptProfile('RBF',3)" /></td><td>Limit C</td><td><span id="lblRBFProfile3">Min = 200 Max = 25000</span></td><td><img src="../Images/small_tick.png" id="imgRBFProfile3" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbf&curId=23&profileId=3&r=1120970050', 'RBF_Profile_C', 880, 550);" /></td></tr>
                                                 <tr><td><input value="4" name="optRBFProfile" type="radio" id="optRBFProfile4" onclick="SelectOptProfile('RBF',4)"  /></td><td>Limit D</td><td><span id="lblRBFProfile4">Min = 500 Max = 50000</span></td><td><img src="../Images/small_tick.png" id="imgRBFProfile4" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbf&curId=23&profileId=4&r=1120970050', 'RBF_Profile_D', 880, 550);" /></td></tr>
                                             </table>
                                         </td>
                                         <td width="17%" class="SetPosBg2 SetBorderB" align="center" valign="top" rowspan="3">Share&nbsp;(<span id="lblSharesRBF">0% - 0%</span>)</td>
                                         <td width="17%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRBF" id="lstSharesRBF" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" rowspan="2">&nbsp;</td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- GAME HALL CASINO END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRBG">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- GAME HALL COCKFT --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRBG',this)">
                                 <tr>
                                     <td align="left">GAME HALL COCKFT</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRBG" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td width="33%" align="center">COMMISSION SETTING</td>
                                         <td width="33%" align="center">LIMIT SETTING</td>
                                         <td width="34%" align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             GH CockFT
                                             &nbsp;(<span id="lblCommissionRBG">0%</span>)&nbsp;
                                             <select name="lstCommissionRBG" id="lstCommissionRBG" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td class="SetBorderL SetBorderB SetBorderR">
                                             Profile =  <span id="lblRBGProfile">Limit D</span>
                 					        <input name="hidRBGProfile" type="hidden" id="hidRBGProfile" value="4" />
                                         </td>
                                         <td class="SetPosBg2 SetBorderB SetBorderR" colspan="2" align="center">
                                             GH CockFT
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td nowrap="nowrap" class="SetBorderL SetBorderB" align="center">&nbsp;</td>
                                         <td nowrap="nowrap" align="left" class="SetBorderL SetBorderB SetBorderR" rowspan="3">
                                             <table class="Bold FontColor" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                                                 <tr><td width="20px"><input value="1" name="optRBGProfile" type="radio" id="optRBGProfile1" onclick="SelectOptProfile('RBG',1)" checked="checked" /></td><td width="50px">Limit A</td><td width="140px"><span id="lblRBGProfile1">Min = 20 Max = 5000</span></td><td><img src="../Images/small_tick.png" id="imgRBGProfile1" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbg&curId=23&profileId=1&r=1120970050', 'RBG_Profile_A', 880, 550);" /></td></tr>
                                                 <tr><td><input value="2" name="optRBGProfile" type="radio" id="optRBGProfile2" onclick="SelectOptProfile('RBG',2)" /></td><td>Limit B</td><td><span id="lblRBGProfile2">Min = 100 Max = 10000</span></td><td><img src="../Images/small_tick.png" id="imgRBGProfile2" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbg&curId=23&profileId=2&r=1120970050', 'RBG_Profile_B', 880, 550);" /></td></tr>
                                                 <tr><td><input value="3" name="optRBGProfile" type="radio" id="optRBGProfile3" onclick="SelectOptProfile('RBG',3)" /></td><td>Limit C</td><td><span id="lblRBGProfile3">Min = 200 Max = 20000</span></td><td><img src="../Images/small_tick.png" id="imgRBGProfile3" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbg&curId=23&profileId=3&r=1120970050', 'RBG_Profile_C', 880, 550);" /></td></tr>
                                                 <tr><td><input value="4" name="optRBGProfile" type="radio" id="optRBGProfile4" onclick="SelectOptProfile('RBG',4)"  /></td><td>Limit D</td><td><span id="lblRBGProfile4">Min = 300 Max = 30000</span></td><td><img src="../Images/small_tick.png" id="imgRBGProfile4" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbg&curId=23&profileId=4&r=1120970050', 'RBG_Profile_D', 880, 550);" /></td></tr>
                                             </table>
                                         </td>
                                         <td width="17%" class="SetPosBg2 SetBorderB" align="center" valign="top" rowspan="3">Share&nbsp;(<span id="lblSharesRBG">0% - 0%</span>)</td>
                                         <td width="17%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRBG" id="lstSharesRBG" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" rowspan="2">&nbsp;</td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- GAME HALL COCKFT END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRBH">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- GAME HALL SLOT --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRBH',this)">
                                 <tr>
                                     <td align="left">GAME HALL SLOT</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRBH" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td width="50%" nowrap="nowrap" class="SetPosBg2 SetBorderL SetBorderB" align="center">
                                             <span style="display:none;"><input id="btnRBHDisable" type="radio" name="RBH" value="btnRBHDisable" checked="checked" /><label for="btnRBHDisable"><span class='Disable'>Disable</span></label></span>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <span style="display:none;"><input id="btnRBHEnable" type="radio" name="RBH" value="btnRBHEnable" /><label for="btnRBHEnable"><span class='Enable'>Enable</span></label></span>
                                         </td>
                                         <td width="50%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" colspan="2" align="center">
                                             GH Slot
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td class="SetPosBg2 SetBorderL SetBorderB" align="center">Share&nbsp;(<span id="lblSharesRBH">0% - 0%</span>)</td>
                                         <td class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRBH" id="lstSharesRBH" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- GAME HALL SLOT END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRBI">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- SIAM LOTTO --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRBI',this)">
                                 <tr>
                                     <td align="left">SIAM LOTTO</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRBI" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td width="33%" align="center">COMMISSION SETTING</td>
                                         <td width="33%" align="center">LIMIT SETTING</td>
                                         <td width="34%" align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             Siam Lotto 1D
                                             &nbsp;(<span id="lblCommissionRBI">0%</span>)&nbsp;
                                             <select name="lstCommissionRBI" id="lstCommissionRBI" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td class="SetBorderL SetBorderB SetBorderR">
                                             Profile =  <span id="lblRBIProfile">Limit A</span>
                 					        <input name="hidRBIProfile" type="hidden" id="hidRBIProfile" value="1" />
                                         </td>
                                         <td class="SetPosBg2 SetBorderB SetBorderR" colspan="2" align="center">
                                             Siam Lotto
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             Siam Lotto 2D
                                             &nbsp;(<span id="lblCommissionRBJ">0%</span>)&nbsp;
                                             <select name="lstCommissionRBJ" id="lstCommissionRBJ" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                         <td nowrap="nowrap" align="left" class="SetBorderL SetBorderB SetBorderR" rowspan="3">
                                             <table class="Bold FontColor" cellspacing="0" cellpadding="0" width="100%" align="center" border="0">
                                                 <tr><td width="20px"><input value="1" name="optRBIProfile" type="radio" id="optRBIProfile1" onclick="SelectOptProfile('RBI',1)" checked="checked" /></td><td width="50px">Limit A</td><td width="140px"><span id="lblRBIProfile1">Min = 10 Max = 10000</span></td><td><img src="../Images/small_tick.png" id="imgRBIProfile1" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbi&curId=23&profileId=1&r=1120970050', 'RBI_Profile_A', 880, 550);" /></td></tr>
                                                 <tr><td><input value="2" name="optRBIProfile" type="radio" id="optRBIProfile2" onclick="SelectOptProfile('RBI',2)" disabled="disabled" /></td><td>Limit B</td><td><span id="lblRBIProfile2">Min = 30 Max = 20000</span></td><td><img src="../Images/small_close.png" id="imgRBIProfile2" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbi&curId=23&profileId=2&r=1120970050', 'RBI_Profile_B', 880, 550);" /></td></tr>
                                                 <tr><td><input value="3" name="optRBIProfile" type="radio" id="optRBIProfile3" onclick="SelectOptProfile('RBI',3)" disabled="disabled" /></td><td>Limit C</td><td><span id="lblRBIProfile3">Min = 50 Max = 30000</span></td><td><img src="../Images/small_close.png" id="imgRBIProfile3" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbi&curId=23&profileId=3&r=1120970050', 'RBI_Profile_C', 880, 550);" /></td></tr>
                                                 <tr><td><input value="4" name="optRBIProfile" type="radio" id="optRBIProfile4" onclick="SelectOptProfile('RBI',4)" disabled="disabled" /></td><td>Limit D</td><td><span id="lblRBIProfile4">Min = 100 Max = 40000</span></td><td><img src="../Images/small_close.png" id="imgRBIProfile4" />&nbsp;<img alt="" src="../Images/question_mark.gif" style="cursor:pointer;" onclick="PopupCenter('../CasinoProfile.aspx?type=rbi&curId=23&profileId=4&r=1120970050', 'RBI_Profile_D', 880, 550);" /></td></tr>
                                             </table>
                                         </td>
                                         <td width="17%" class="SetPosBg2 SetBorderB" align="center" valign="top" rowspan="3">Share&nbsp;(<span id="lblSharesRBI">0% - 0%</span>)</td>
                                         <td width="17%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRBI" id="lstSharesRBI" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td class="SetBorderL SetBorderB" align="center">
                                             Siam Lotto 3D
                                             &nbsp;(<span id="lblCommissionRBK">0%</span>)&nbsp;
                                             <select name="lstCommissionRBK" id="lstCommissionRBK" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRBIDisable" type="radio" name="RBI" value="btnRBIDisable" checked="checked" /><label for="btnRBIDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRBIEnable" type="radio" name="RBI" value="btnRBIEnable" /><label for="btnRBIEnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- SIAM LOTTO END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>

                         <div id="panRBL">

                         <tr><td>&nbsp;</td></tr>
                         <tr><td>
                         <!--------------------------------------------------------------------------- UFA SLOT --------------------------------------------------------------------------->
                         <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                             <tr><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="accordion" onclick="toggleSetting('trRBL',this)">
                                 <tr>
                                     <td align="left">UFA SLOT</td>
                                 </tr>
                                 </table>
                             </td></tr>
                             <tr id="trRBL" style="display:none;"><td>
                                 <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
                                     <!------------------------------------- Commission Setting ------------------------------------->
                                     <tr class="SetGridHeader">
                                         <td align="center" colspan="2">POSITION TAKING</td>
                                     </tr>
                                     <tr class="SetGridItem">
                                         <td width="50%" nowrap="nowrap" class="SetPosBg3 SetBorderL SetBorderB" align="center">
                                             <input id="btnRBLDisable" type="radio" name="RBL" value="btnRBLDisable" /><label for="btnRBLDisable"><span class='Disable'>Disable</span></label>
                                             &nbsp;&nbsp;&nbsp;&nbsp;
                                             <input id="btnRBLEnable" type="radio" name="RBL" value="btnRBLEnable" checked="checked" /><label for="btnRBLEnable"><span class='Enable'>Enable</span></label>
                                         </td>
                                         <td width="50%" class="SetPosBg2 SetBorderL SetBorderB SetBorderR" colspan="2" align="center">
                                             UFA Slot
                                         </td>
                                     </tr>
                                     <tr class="SetGridAltItem">
                                         <td class="SetPosBg2 SetBorderL SetBorderB" align="center">Share&nbsp;(<span id="lblSharesRBL">0% - 0%</span>)</td>
                                         <td class="SetPosBg2 SetBorderL SetBorderB SetBorderR" align="center" valign="top" rowspan="3">
                                             <select name="lstSharesRBL" id="lstSharesRBL" style="width:65px;">
                 		<option selected="selected" value="0">0%</option>

                 	</select>
                                         </td>
                                     </tr>
                                 </table>
                             </td></tr>
                         </table>
                         <!--------------------------------------------------------------------------- UFA SLOT END --------------------------------------------------------------------------->
                         </td></tr>

                 </div>



                         <tr><td>&nbsp;</td></tr>




                 <!------------------------------------------- delete this line when done ---------------------------------------------------------------------->
                     </table>

                     </div>

                 <script type="text/javascript">
                 //<![CDATA[
                 var Page_Validators =  new Array(document.getElementById("rgvUserName"), document.getElementById("rgvPassword"), document.getElementById("rqvTotalRequired"), document.getElementById("rgvTotalLimit"), document.getElementById("rqvTransRequired"), document.getElementById("rgvTransLimit"), document.getElementById("rgvBeforeRun"), document.getElementById("rgvBeforeRunLimit"), document.getElementById("rqvMaxX12Required"), document.getElementById("rgvMaxX12"), document.getElementById("rgvMatchLimitX12"), document.getElementById("rgvMatchLimitX12Limit"), document.getElementById("rqvMaxParRequired"), document.getElementById("rgvMaxPar"), document.getElementById("rgvPar"), document.getElementById("rgvParLimit"), document.getElementById("rqvMaxOtherRequired"), document.getElementById("rgvMaxOther"), document.getElementById("rgvMatchLimitOther"), document.getElementById("rgvMatchLimitOtherLimit"), document.getElementById("rqvMaxOSRequired"), document.getElementById("rgvMaxOS"), document.getElementById("rgvMatchLimitOS"), document.getElementById("rgvMatchLimitOSLimit"));
                 //]]>
                 </script>

                 <script type="text/javascript">
                 //<![CDATA[
                 var rgvUserName = document.all ? document.all["rgvUserName"] : document.getElementById("rgvUserName");
                 rgvUserName.controltovalidate = "txtUserName";
                 rgvUserName.errormessage = "User Name must not be blank.";
                 rgvUserName.display = "Dynamic";
                 rgvUserName.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvUserName.initialvalue = "";
                 var rgvPassword = document.all ? document.all["rgvPassword"] : document.getElementById("rgvPassword");
                 rgvPassword.controltovalidate = "txtPassword";
                 rgvPassword.errormessage = "Password must not be blank.";
                 rgvPassword.display = "Dynamic";
                 rgvPassword.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvPassword.initialvalue = "";
                 var rqvTotalRequired = document.all ? document.all["rqvTotalRequired"] : document.getElementById("rqvTotalRequired");
                 rqvTotalRequired.controltovalidate = "txtTotalLimit";
                 rqvTotalRequired.errormessage = "Please enter amount.";
                 rqvTotalRequired.display = "Dynamic";
                 rqvTotalRequired.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rqvTotalRequired.initialvalue = "";
                 var rgvTotalLimit = document.all ? document.all["rgvTotalLimit"] : document.getElementById("rgvTotalLimit");
                 rgvTotalLimit.controltovalidate = "txtTotalLimit";
                 rgvTotalLimit.errormessage = "Invalid amount!";
                 rgvTotalLimit.display = "Dynamic";
                 rgvTotalLimit.type = "Currency";
                 rgvTotalLimit.decimalchar = ".";
                 rgvTotalLimit.groupchar = ",";
                 rgvTotalLimit.digits = "2";
                 rgvTotalLimit.groupsize = "3";
                 rgvTotalLimit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvTotalLimit.maximumvalue = "999999999999";
                 rgvTotalLimit.minimumvalue = "0";
                 var rqvTransRequired = document.all ? document.all["rqvTransRequired"] : document.getElementById("rqvTransRequired");
                 rqvTransRequired.controltovalidate = "txtTransLimit";
                 rqvTransRequired.errormessage = "Please enter amount.";
                 rqvTransRequired.display = "Dynamic";
                 rqvTransRequired.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rqvTransRequired.initialvalue = "";
                 var rgvTransLimit = document.all ? document.all["rgvTransLimit"] : document.getElementById("rgvTransLimit");
                 rgvTransLimit.controltovalidate = "txtTransLimit";
                 rgvTransLimit.errormessage = "Invalid amount!";
                 rgvTransLimit.display = "Dynamic";
                 rgvTransLimit.type = "Currency";
                 rgvTransLimit.decimalchar = ".";
                 rgvTransLimit.groupchar = ",";
                 rgvTransLimit.digits = "2";
                 rgvTransLimit.groupsize = "3";
                 rgvTransLimit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvTransLimit.maximumvalue = "999999999999";
                 rgvTransLimit.minimumvalue = "0";
                 var rgvBeforeRun = document.all ? document.all["rgvBeforeRun"] : document.getElementById("rgvBeforeRun");
                 rgvBeforeRun.controltovalidate = "txtBeforeRun";
                 rgvBeforeRun.errormessage = "Please enter amount.";
                 rgvBeforeRun.display = "Dynamic";
                 rgvBeforeRun.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvBeforeRun.initialvalue = "";
                 var rgvBeforeRunLimit = document.all ? document.all["rgvBeforeRunLimit"] : document.getElementById("rgvBeforeRunLimit");
                 rgvBeforeRunLimit.controltovalidate = "txtBeforeRun";
                 rgvBeforeRunLimit.errormessage = "Invalid amount!";
                 rgvBeforeRunLimit.display = "Dynamic";
                 rgvBeforeRunLimit.type = "Currency";
                 rgvBeforeRunLimit.decimalchar = ".";
                 rgvBeforeRunLimit.groupchar = ",";
                 rgvBeforeRunLimit.digits = "2";
                 rgvBeforeRunLimit.groupsize = "3";
                 rgvBeforeRunLimit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvBeforeRunLimit.maximumvalue = "999999999999";
                 rgvBeforeRunLimit.minimumvalue = "0";
                 var rqvMaxX12Required = document.all ? document.all["rqvMaxX12Required"] : document.getElementById("rqvMaxX12Required");
                 rqvMaxX12Required.controltovalidate = "txtMaxX12";
                 rqvMaxX12Required.errormessage = "Please enter amount.";
                 rqvMaxX12Required.display = "Dynamic";
                 rqvMaxX12Required.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rqvMaxX12Required.initialvalue = "";
                 var rgvMaxX12 = document.all ? document.all["rgvMaxX12"] : document.getElementById("rgvMaxX12");
                 rgvMaxX12.controltovalidate = "txtMaxX12";
                 rgvMaxX12.errormessage = "Invalid amount!";
                 rgvMaxX12.display = "Dynamic";
                 rgvMaxX12.type = "Currency";
                 rgvMaxX12.decimalchar = ".";
                 rgvMaxX12.groupchar = ",";
                 rgvMaxX12.digits = "2";
                 rgvMaxX12.groupsize = "3";
                 rgvMaxX12.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMaxX12.maximumvalue = "999999999999";
                 rgvMaxX12.minimumvalue = "0";
                 var rgvMatchLimitX12 = document.all ? document.all["rgvMatchLimitX12"] : document.getElementById("rgvMatchLimitX12");
                 rgvMatchLimitX12.controltovalidate = "txtMatchLimitX12";
                 rgvMatchLimitX12.errormessage = "Please enter amount.";
                 rgvMatchLimitX12.display = "Dynamic";
                 rgvMatchLimitX12.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvMatchLimitX12.initialvalue = "";
                 var rgvMatchLimitX12Limit = document.all ? document.all["rgvMatchLimitX12Limit"] : document.getElementById("rgvMatchLimitX12Limit");
                 rgvMatchLimitX12Limit.controltovalidate = "txtMatchLimitX12";
                 rgvMatchLimitX12Limit.errormessage = "Invalid amount!";
                 rgvMatchLimitX12Limit.display = "Dynamic";
                 rgvMatchLimitX12Limit.type = "Currency";
                 rgvMatchLimitX12Limit.decimalchar = ".";
                 rgvMatchLimitX12Limit.groupchar = ",";
                 rgvMatchLimitX12Limit.digits = "2";
                 rgvMatchLimitX12Limit.groupsize = "3";
                 rgvMatchLimitX12Limit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMatchLimitX12Limit.maximumvalue = "999999999999";
                 rgvMatchLimitX12Limit.minimumvalue = "0";
                 var rqvMaxParRequired = document.all ? document.all["rqvMaxParRequired"] : document.getElementById("rqvMaxParRequired");
                 rqvMaxParRequired.controltovalidate = "txtMaxPar";
                 rqvMaxParRequired.errormessage = "Please enter amount.";
                 rqvMaxParRequired.display = "Dynamic";
                 rqvMaxParRequired.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rqvMaxParRequired.initialvalue = "";
                 var rgvMaxPar = document.all ? document.all["rgvMaxPar"] : document.getElementById("rgvMaxPar");
                 rgvMaxPar.controltovalidate = "txtMaxPar";
                 rgvMaxPar.errormessage = "Invalid amount!";
                 rgvMaxPar.display = "Dynamic";
                 rgvMaxPar.type = "Currency";
                 rgvMaxPar.decimalchar = ".";
                 rgvMaxPar.groupchar = ",";
                 rgvMaxPar.digits = "2";
                 rgvMaxPar.groupsize = "3";
                 rgvMaxPar.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMaxPar.maximumvalue = "999999999999";
                 rgvMaxPar.minimumvalue = "0";
                 var rgvPar = document.all ? document.all["rgvPar"] : document.getElementById("rgvPar");
                 rgvPar.controltovalidate = "txtPar";
                 rgvPar.errormessage = "Please enter amount.";
                 rgvPar.display = "Dynamic";
                 rgvPar.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvPar.initialvalue = "";
                 var rgvParLimit = document.all ? document.all["rgvParLimit"] : document.getElementById("rgvParLimit");
                 rgvParLimit.controltovalidate = "txtPar";
                 rgvParLimit.errormessage = "Invalid amount!";
                 rgvParLimit.display = "Dynamic";
                 rgvParLimit.type = "Currency";
                 rgvParLimit.decimalchar = ".";
                 rgvParLimit.groupchar = ",";
                 rgvParLimit.digits = "2";
                 rgvParLimit.groupsize = "3";
                 rgvParLimit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvParLimit.maximumvalue = "999999999999";
                 rgvParLimit.minimumvalue = "0";
                 var rqvMaxOtherRequired = document.all ? document.all["rqvMaxOtherRequired"] : document.getElementById("rqvMaxOtherRequired");
                 rqvMaxOtherRequired.controltovalidate = "txtMaxOther";
                 rqvMaxOtherRequired.errormessage = "Please enter amount.";
                 rqvMaxOtherRequired.display = "Dynamic";
                 rqvMaxOtherRequired.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rqvMaxOtherRequired.initialvalue = "";
                 var rgvMaxOther = document.all ? document.all["rgvMaxOther"] : document.getElementById("rgvMaxOther");
                 rgvMaxOther.controltovalidate = "txtMaxOther";
                 rgvMaxOther.errormessage = "Invalid amount!";
                 rgvMaxOther.display = "Dynamic";
                 rgvMaxOther.type = "Currency";
                 rgvMaxOther.decimalchar = ".";
                 rgvMaxOther.groupchar = ",";
                 rgvMaxOther.digits = "2";
                 rgvMaxOther.groupsize = "3";
                 rgvMaxOther.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMaxOther.maximumvalue = "999999999999";
                 rgvMaxOther.minimumvalue = "0";
                 var rgvMatchLimitOther = document.all ? document.all["rgvMatchLimitOther"] : document.getElementById("rgvMatchLimitOther");
                 rgvMatchLimitOther.controltovalidate = "txtMatchLimitOther";
                 rgvMatchLimitOther.errormessage = "Please enter amount.";
                 rgvMatchLimitOther.display = "Dynamic";
                 rgvMatchLimitOther.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvMatchLimitOther.initialvalue = "";
                 var rgvMatchLimitOtherLimit = document.all ? document.all["rgvMatchLimitOtherLimit"] : document.getElementById("rgvMatchLimitOtherLimit");
                 rgvMatchLimitOtherLimit.controltovalidate = "txtMatchLimitOther";
                 rgvMatchLimitOtherLimit.errormessage = "Invalid amount!";
                 rgvMatchLimitOtherLimit.display = "Dynamic";
                 rgvMatchLimitOtherLimit.type = "Currency";
                 rgvMatchLimitOtherLimit.decimalchar = ".";
                 rgvMatchLimitOtherLimit.groupchar = ",";
                 rgvMatchLimitOtherLimit.digits = "2";
                 rgvMatchLimitOtherLimit.groupsize = "3";
                 rgvMatchLimitOtherLimit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMatchLimitOtherLimit.maximumvalue = "999999999999";
                 rgvMatchLimitOtherLimit.minimumvalue = "0";
                 var rqvMaxOSRequired = document.all ? document.all["rqvMaxOSRequired"] : document.getElementById("rqvMaxOSRequired");
                 rqvMaxOSRequired.controltovalidate = "txtMaxOS";
                 rqvMaxOSRequired.errormessage = "Please enter amount.";
                 rqvMaxOSRequired.display = "Dynamic";
                 rqvMaxOSRequired.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rqvMaxOSRequired.initialvalue = "";
                 var rgvMaxOS = document.all ? document.all["rgvMaxOS"] : document.getElementById("rgvMaxOS");
                 rgvMaxOS.controltovalidate = "txtMaxOS";
                 rgvMaxOS.errormessage = "Invalid amount!";
                 rgvMaxOS.display = "Dynamic";
                 rgvMaxOS.type = "Currency";
                 rgvMaxOS.decimalchar = ".";
                 rgvMaxOS.groupchar = ",";
                 rgvMaxOS.digits = "2";
                 rgvMaxOS.groupsize = "3";
                 rgvMaxOS.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMaxOS.maximumvalue = "999999999999";
                 rgvMaxOS.minimumvalue = "0";
                 var rgvMatchLimitOS = document.all ? document.all["rgvMatchLimitOS"] : document.getElementById("rgvMatchLimitOS");
                 rgvMatchLimitOS.controltovalidate = "txtMatchLimitOS";
                 rgvMatchLimitOS.errormessage = "Please enter amount.";
                 rgvMatchLimitOS.display = "Dynamic";
                 rgvMatchLimitOS.evaluationfunction = "RequiredFieldValidatorEvaluateIsValid";
                 rgvMatchLimitOS.initialvalue = "";
                 var rgvMatchLimitOSLimit = document.all ? document.all["rgvMatchLimitOSLimit"] : document.getElementById("rgvMatchLimitOSLimit");
                 rgvMatchLimitOSLimit.controltovalidate = "txtMatchLimitOS";
                 rgvMatchLimitOSLimit.errormessage = "Invalid amount!";
                 rgvMatchLimitOSLimit.display = "Dynamic";
                 rgvMatchLimitOSLimit.type = "Currency";
                 rgvMatchLimitOSLimit.decimalchar = ".";
                 rgvMatchLimitOSLimit.groupchar = ",";
                 rgvMatchLimitOSLimit.digits = "2";
                 rgvMatchLimitOSLimit.groupsize = "3";
                 rgvMatchLimitOSLimit.evaluationfunction = "RangeValidatorEvaluateIsValid";
                 rgvMatchLimitOSLimit.maximumvalue = "999999999999";
                 rgvMatchLimitOSLimit.minimumvalue = "0";
                 //]]>
                 </script>


                 <script type="text/javascript">
                 //<![CDATA[

                 var Page_ValidationActive = false;
                 if (typeof(ValidatorOnLoad) == "function") {
                     ValidatorOnLoad();
                 }

                 function ValidatorOnSubmit() {
                     if (Page_ValidationActive) {
                         return ValidatorCommonOnSubmit();
                     }
                     else {
                         return true;
                     }
                 }
                         //]]>
                 </script>
                 </form>

            <form action="save-creuser.php?transactionid=<?php echo $_GET["transactionid"];?>" name="frmEdit" method="post">

                <h2 style="text-align: center;">สร้างบัญชีเดิมพัน ของธุรกรรมที่ (<?php echo $objResult["transactionid"];?>)</h2>
               <div class="row">
                    <div class="col-md-6">
                            <input type="hidden" name="txttransactionid" class="form-control" value="<?php echo $objResult["transactionid"];?>"/>
                        <div class="form-group col-md-12"> ชื่อ - นามสกุล
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["surelastname"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6"> เบอร์โทรศัพท์
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["tel"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6"> ID LINE
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["idline"];?>" disabled/>
                        </div>




                        <div class="form-group col-md-6">
                            จำนวนเงินฝาก
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["deposit"];?>" disabled/>
                        </div>


                        <div class="form-group col-md-6">
                            โบนัส
                            <input type="text" name="txtbonus" class="form-control" value="<?php echo $objResult["bonus"];?>" />
                        </div>

                        <div class="form-group col-md-6"> เลขที่บัญชี
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["banknumber"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-6"> ธนาคาร
                            <input type="text" name="" class="form-control" value="<?php echo $objResult["bank"];?>" disabled/>
                        </div>

                        <div class="form-group col-md-12"> Username
                            <input type="text" name="txtuser" class="form-control" value="<?php echo $objResult["user"];?>"/>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="hidden" name="txtaperson" class="form-control" value="<?php echo $objResult2["username"];?>" />
                        </div>

                                                                         <div class="form-group col-md-12">
                            <h4>สถานะการตรวจสอบธุรกรรม</h4>
                                                <select class="form-control" name="txtliststatus">
                        <option name="txtliststatus" value="confirm">ผ่าน</option>
                        <option name="txtliststatus" value="unconfirm">ไม่ผ่าน</option>
                    </select>
                        </div>



                            <div class="form-group col-md-12">
                            <h5 style="text-align: center;">ผู้สร้างบัญชี (<?php echo $objResult2["adminname"];?>)</h5>
                        </div>












                    </div>
                    <div class="col-md-6" style="margin-bottom: 50px;">
                        <h1 style="text-align: right;">ส่งยูสเซอร์และรหัสผ่าน</h1>
                         <!-- <h1 style="text-align: center; color: red;">ทำรายการฝากเงินเวลา <?php echo date('H:i:s',strtotime($objResult['date_now'])) ;?> </h1> close -->

<button type="button" id="copy-button" class="btn btn-success btn-lg btn-block">คัดลอกข้อมูลให้ลูกค้า</button><br>
<textarea id="inputsave" style="width:1px; height:1px;">
SCCLUB99
-------------
ชื่อผู้ใช้ : <?php echo $objResult["user"];?>

รหัสผ่าน : sc<?php echo $objResult["tel"];?>

-------------
ทางเข้า 1 : www.scclub99.com
ทางเข้า 2 : www.ufabet.com
----------
วิธีเข้าเล่น
วิธีเล่น https://jwp.io/s/l21ZZx4E
</textarea>





                    </div>
                </div>
                <div class="row">

                    <input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="submit">
                </div>
            </form>

            <?php
  }
  mysql_close($objConnect);
  ?>

                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>

    <script>
        var input  = document.getElementById("inputsave");
        var button = document.getElementById("copy-button");

        button.addEventListener("click", function (event) {
            event.preventDefault();
            input.select();
            document.execCommand("copy");
        });
    </script>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../js/bootstrap-datepicker.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->


</body>

</html>
