<!DOCTYPE html>


<head>

<?php include"head.php" ?>

    <title>เปิดบัญชีสมาชิกใหม่</title>



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


    <script src="http://ag.ufabet.com/JS/AccountSetting2.js?v220190912" type="text/javascript"></script>


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
                     $strSQL = "SELECT * FROM scclub_data2 WHERE category='สมัครสมาชิก' ORDER BY transactionid DESC";
                     if(empty($_GET)) {
                                 $strSQL = "SELECT * FROM scclub_data2 WHERE user='uffq00000' ";
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
                     $strSQL = "SELECT * FROM scclub_data2 WHERE transactionid = '".$_GET["transactionid"]."' ";
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
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKMTM5NzM2MzUxNQ8WiAEeBk1heEdCSgcAAAAAAADwPx4LTWluU2hhcmVSdW4HAAAAAAAAAAAeBk1pbkc3QgcAAAAAAADwPx4ITWluU2hhcmUHAAAAAAAAAAAeC01pblNoYXJlUGFzBwAAAAAAAAAAHgtNaW5TaGFyZVBhcgcAAAAAAAAAAB4ObWF4Q29tbWlzc2lvbkgFATAeCk1pblNoYXJlM0QHAAAAAAAAAAAeCk1pblNoYXJlMkQHAAAAAAAAAAAeCk1pblNoYXJlMUQHAAAAAAAAAAAeDm1heENvbW1pc3Npb25DBQEwHgpNaW5aT3RoZXJzBwAAAAAAAPA/HgZNYXhHU0IHAAAAAAAA8D8eBk1pblpSTAcAAAAAAADwPx4LbWF4UGVyY2VudEYCyAEeBk1heEc3QgcAAAAAAADwPx4LTWluU2hhcmVYMTIHAAAAAAAAAAAeDm1heENvbW1pc3Npb25CBQEwHgZNYXhHVEgHAAAAAAAA8D8eBk1pbkdCQQcAAAAAAADwPx4GTWluR1JMBwAAAAAAAPA/HgZNYXhHM0MHAAAAAAAA8D8eCElzQWRkTmV3Zx4LTWluU2hhcmU0RFNmHgZNaW5HQkoHAAAAAAAA8D8eBk1pbkdUSAcAAAAAAADwPx4LTWluU2hhcmVSQkwHAAAAAAAAAAAeDm1heENvbW1pc3Npb25GBQEwHgttYXhQZXJjZW50MwJkHgttYXhQZXJjZW50RwLIAR4LTWluU2hhcmVSQVMHAAAAAAAAAAAeC01pblNoYXJlUkFSBwAAAAAAAAAAHgtNaW5TaGFyZVJBVQcAAAAAAAAAAB4LTWluU2hhcmVSQVQHAAAAAAAAAAAeC21heFBlcmNlbnRCAmQeC21heFBlcmNlbnRBAmQeC01pblNoYXJlUkJHBwAAAAAAAAAAHgtNaW5TaGFyZVJCRgcAAAAAAAAAAB4LTWluU2hhcmVSQkkHAAAAAAAAAAAeC01pblNoYXJlUkJIBwAAAAAAAAAAHg5NaW5TaGFyZVJ1blgxMgcAAAAAAAAAAB4LbWF4UGVyY2VudEoCkAMeC21heFBlcmNlbnRJApADHgttYXhQZXJjZW50SAKQAx4FTWF4RUcHAAAAAABq+EAeDm1heENvbW1pc3Npb25HBQEwHg5tYXhDb21taXNzaW9uQQUB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ZAICDw8WAh9EBRHguIjguLPguIHguLHguJQgRGRkAgQPDxYCH0QFAzI1JWRkAgUPEGQPFvUDZgIBAgICAwIEAgUCBgIHAggCCQIKAgsCDAINAg4CDwIQAhECEgITAhQCFQIWAhcCGAIZAhoCGwIcAh0CHgIfAiACIQIiAiMCJAIlAiYCJwIoAikCKgIrAiwCLQIuAi8CMAIxAjICMwI0AjUCNgI3AjgCOQI6AjsCPAI9Aj4CPwJAAkECQgJDAkQCRQJGAkcCSAJJAkoCSwJMAk0CTgJPAlACUQJSAlMCVAJVAlYCVwJYAlkCWgJbAlwCXQJeAl8CYAJhAmICYwJkAmUCZgJnAmgCaQJqAmsCbAJtAm4CbwJwAnECcgJzAnQCdQJ2AncCeAJ5AnoCewJ8An0CfgJ/AoABAoEBAoIBAoMBAoQBAoUBAoYBAocBAogBAokBAooBAosBAowBAo0BAo4BAo8BApABApEBApIBApMBApQBApUBApYBApcBApgBApkBApoBApsBApwBAp0BAp4BAp8BAqABAqEBAqIBAqMBAqQBAqUBAqYBAqcBAqgBAqkBAqoBAqsBAqwBAq0BAq4BAq8BArABArEBArIBArMBArQBArUBArYBArcBArgBArkBAroBArsBArwBAr0BAr4BAr8BAsABAsEBAsIBAsMBAsQBAsUBAsYBAscBAsgBAskBAsoBAssBAswBAs0BAs4BAs8BAtABAtEBAtIBAtMBAtQBAtUBAtYBAtcBAtgBAtkBAtoBAtsBAtwBAt0BAt4BAt8BAuABAuEBAuIBAuMBAuQBAuUBAuYBAucBAugBAukBAuoBAusBAuwBAu0BAu4BAu8BAvABAvEBAvIBAvMBAvQBAvUBAvYBAvcBAvgBAvkBAvoBAvsBAvwBAv0BAv4BAv8BAoACAoECAoICAoMCAoQCAoUCAoYCAocCAogCAokCAooCAosCAowCAo0CAo4CAo8CApACApECApICApMCApQCApUCApYCApcCApgCApkCApoCApsCApwCAp0CAp4CAp8CAqACAqECAqICAqMCAqQCAqUCAqYCAqcCAqgCAqkCAqoCAqsCAqwCAq0CAq4CAq8CArACArECArICArMCArQCArUCArYCArcCArgCArkCAroCArsCArwCAr0CAr4CAr8CAsACAsECAsICAsMCAsQC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MS42ZxAFBTEuNjUlBQQxLjY1ZxAFBDEuNyUFAzEuN2cQBQUxLjc1JQUEMS43NWcQBQQxLjglBQMxLjhnEAUFMS44NSUFBDEuODVnEAUEMS45JQUDMS45ZxAFBTEuOTUlBQQxLjk1ZxAFAjIlBQEyZxAFBTIuMDUlBQQyLjA1ZxAFBDIuMSUFAzIuMWcQBQUyLjE1JQUEMi4xNWcQBQQyLjIlBQMyLjJnEAUFMi4yNSUFBDIuMjVnEAUEMi4zJQUDMi4zZxAFBTIuMzUlBQQyLjM1ZxAFBDIuNCUFAzIuNGcQBQUyLjQ1JQUEMi40NWcQBQQyLjUlBQMyLjVnEAUFMi41NSUFBDIuNTVnEAUEMi42JQUDMi42ZxAFBTIuNjUlBQQyLjY1ZxAFBDIuNyUFAzIuN2cQBQUyLjc1JQUEMi43NWcQBQQyLjglBQMyLjhnEAUFMi44NSUFBDIuODVnEAUEMi45JQUDMi45ZxAFBTIuOTUlBQQyLjk1ZxAFAjMlBQEzZxAFBTMuMDUlBQQzLjA1ZxAFBDMuMSUFAzMuMWcQBQUzLjE1JQUEMy4xNWcQBQQzLjIlBQMzLjJnEAUFMy4yNSUFBDMuMjVnEAUEMy4zJQUDMy4zZxAFBTMuMzUlBQQzLjM1ZxAFBDMuNCUFAzMuNGcQBQUzLjQ1JQUEMy40NWcQBQQzLjUlBQMzLjVnEAUFMy41NSUFBDMuNTVnEAUEMy42JQUDMy42ZxAFBTMuNjUlBQQzLjY1ZxAFBDMuNyUFAzMuN2cQBQUzLjc1JQUEMy43NWcQBQQzLjglBQMzLjhnEAUFMy44NSUFBDMuODVnEAUEMy45JQUDMy45ZxAFBTMuOTUlBQQzLjk1ZxAFAjQlBQE0ZxAFBTQuMDUlBQQ0LjA1ZxAFBDQuMSUFAzQuMWcQBQU0LjE1JQUENC4xNWcQBQQ0LjIlBQM0LjJnEAUFNC4yNSUFBDQuMjVnEAUENC4zJQUDNC4zZxAFBTQuMzUlBQQ0LjM1ZxAFBDQuNCUFAzQuNGcQBQU0LjQ1JQUENC40NWcQBQQ0LjUlBQM0LjVnEAUFNC41NSUFBDQuNTVnEAUENC42JQUDNC42ZxAFBTQuNjUlBQQ0LjY1ZxAFBDQuNyUFAzQuN2cQBQU0Ljc1JQUENC43NWcQBQQ0LjglBQM0LjhnEAUFNC44NSUFBDQuODVnEAUENC45JQUDNC45ZxAFBTQuOTUlBQQ0Ljk1ZxAFAjUlBQE1ZxAFBTUuMDUlBQQ1LjA1ZxAFBDUuMSUFAzUuMWcQBQU1LjE1JQUENS4xNWcQBQQ1LjIlBQM1LjJnEAUFNS4yNSUFBDUuMjVnEAUENS4zJQUDNS4zZxAFBTUuMzUlBQQ1LjM1ZxAFBDUuNCUFAzUuNGcQBQU1LjQ1JQUENS40NWcQBQQ1LjUlBQM1LjVnEAUFNS41NSUFBDUuNTVnEAUENS42JQUDNS42ZxAFBTUuNjUlBQQ1LjY1ZxAFBDUuNyUFAzUuN2cQBQU1Ljc1JQUENS43NWcQBQQ1LjglBQM1LjhnEAUFNS44NSUFBDUuODVnEAUENS45JQUDNS45ZxAFBTUuOTUlBQQ1Ljk1ZxAFAjYlBQE2ZxAFBTYuMDUlBQQ2LjA1ZxAFBDYuMSUFAzYuMWcQBQU2LjE1JQUENi4xNWcQBQQ2LjIlBQM2LjJnEAUFNi4yNSUFBDYuMjVnEAUENi4zJQUDNi4zZxAFBTYuMzUlBQQ2LjM1ZxAFBDYuNCUFAzYuNGcQBQU2LjQ1JQUENi40NWcQBQQ2LjUlBQM2LjVnEAUFNi41NSUFBDYuNTVnEAUENi42JQUDNi42ZxAFBTYuNjUlBQQ2LjY1ZxAFBDYuNyUFAzYuN2cQBQU2Ljc1JQUENi43NWcQBQQ2LjglBQM2LjhnEAUFNi44NSUFBDYuODVnEAUENi45JQUDNi45ZxAFBTYuOTUlBQQ2Ljk1ZxAFAjclBQE3ZxAFBTcuMDUlBQQ3LjA1ZxAFBDcuMSUFAzcuMWcQBQU3LjE1JQUENy4xNWcQBQQ3LjIlBQM3LjJnEAUFNy4yNSUFBDcuMjVnEAUENy4zJQUDNy4zZxAFBTcuMzUlBQQ3LjM1ZxAFBDcuNCUFAzcuNGcQBQU3LjQ1JQUENy40NWcQBQQ3LjUlBQM3LjVnEAUFNy41NSUFBDcuNTVnEAUENy42JQUDNy42ZxAFBTcuNjUlBQQ3LjY1ZxAFBDcuNyUFAzcuN2cQBQU3Ljc1JQUENy43NWcQBQQ3LjglBQM3LjhnEAUFNy44NSUFBDcuODVnEAUENy45JQUDNy45ZxAFBTcuOTUlBQQ3Ljk1ZxAFAjglBQE4ZxAFBTguMDUlBQQ4LjA1ZxAFBDguMSUFAzguMWcQBQU4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DWJ0blN1c3BlbmRZZXMFDGJ0blN1c3BlbmRObwUPYnRuTG9naW5UeXBlWWVzBQ5idG5Mb2dpblR5cGVObwUOYnRuTG9naW5UeXBlTm8FDWJ0blJBTURpc2FibGUFDWJ0blJBTURpc2FibGUFDGJ0blJBTUVuYWJsZQUOb3B0UkFNUHJvZmlsZTEFDm9wdFJBTVByb2ZpbGUyBQ5vcHRSQU1Qcm9maWxlMwUOb3B0UkFNUHJvZmlsZTQFDm9wdFJBTVByb2ZpbGU1BQ5vcHRSQU1Qcm9maWxlNgUNYnRuUkFSRGlzYWJsZQUNYnRuUkFSRGlzYWJsZQUMYnRuUkFSRW5hYmxlBQ5vcHRSQVJQcm9maWxlMQUOb3B0UkFSUHJvZmlsZTIFDm9wdFJBUlByb2ZpbGUzBQ5vcHRSQVJQcm9maWxlNAUOb3B0UkFSUHJvZmlsZTUFDm9wdFJBUlByb2ZpbGU2BQ1idG5SQVNEaXNhYmxlBQ1idG5SQVNEaXNhYmxlBQxidG5SQVNFbmFibGUFDm9wdFJBU1Byb2ZpbGUxBQ5vcHRSQVNQcm9maWxlMgUOb3B0UkFTUHJvZmlsZTMFDm9wdFJBU1Byb2ZpbGU0BQ5vcHRSQVNQcm9maWxlNQUOb3B0UkFTUHJvZmlsZTYFDWJ0blJBVURpc2FibGUFDWJ0blJBVURpc2FibGUFDGJ0blJBVUVuYWJsZQUNYnRuUkJGRGlzYWJsZQUNYnRuUkJGRGlzYWJsZQUMYnRuUkJGRW5hYmxlBQ5vcHRSQkZQcm9maWxlMQUOb3B0UkJGUHJvZmlsZTIFDm9wdFJCRlByb2ZpbGUzBQ5vcHRSQkZQcm9maWxlNAUOb3B0UkJHUHJvZmlsZTEFDm9wdFJCR1Byb2ZpbGUyBQ5vcHRSQkdQcm9maWxlMwUOb3B0UkJHUHJvZmlsZTQFDWJ0blJCSERpc2FibGUFDGJ0blJCSEVuYWJsZQUMYnRuUkJIRW5hYmxlBQ5vcHRSQklQcm9maWxlMQUOb3B0UkJJUHJvZmlsZTIFDm9wdFJCSVByb2ZpbGUzBQ5vcHRSQklQcm9maWxlNAUNYnRuUkJJRGlzYWJsZQUMYnRuUkJJRW5hYmxlBQxidG5SQklFbmFibGUFDWJ0blJCTERpc2FibGUFDWJ0blJCTERpc2FibGUFDGJ0blJCTEVuYWJsZfC4yKobqeGg1Zu/t5wO+0VGbRYq" />
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
                                                             <span id="lblAgent">uffqa</span>
                                                         </td>
                                                         <td>
                                                             <input name="txtUserName" type="text" maxlength="16" id="txtUserName" class="TextBox" style="width:100%;" value="<?php echo substr($registeruser,5);?>" />
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
