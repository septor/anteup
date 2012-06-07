<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By DelTree
|
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|
|     For the e107 website system visit http://e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
*/

require_once("../../class2.php");

if(!getperms("P")) {
   header("location:".e_BASE."index.php");
   exit;
}

require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
$rs = new form;
//require_once(e_HANDLER."file_class.php");
require_once(e_HANDLER."user_select_class.php");

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");

$pageid = 'admin_menu_04';

require_once("../../e107_handlers/calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
global $cal;

$postx = "";
if (isset($_POST['main_delete'])){
  $postx = "Delete";
}elseif(isset($_POST['addcash'])){
  $postx = "Add Cash";
}elseif(isset($_POST['editcash'])){
  $postx = "Edit Cash";
}elseif(isset($_POST['cashnew'])){
  $postx = "New Register";
}

$script = "
   <script type=\"text/javascript\">
    function addtext_us(sc){
      document.getElementById('dataform').image.value = sc;
    }
   </script>\n";
$script .= $cal->load_files();

if (e_QUERY) {
   $tmp = explode('.', e_QUERY);
   $action = $tmp[0];
   $sub_action = $tmp[1];
   $id = $tmp[2];
   unset($tmp);
}

if (isset($_POST['main_delete'])) {
   $delete_id = array_keys($_POST['main_delete']);
   $sql2 = new db;
   $message = ($sql2->db_Delete("ipn_info", "ipn_id=".$delete_id[0])) ? LAN_TRACK_M5 : LAN_TRACK_M6;
}

if (isset($_POST['setdates'])) {
   $date1x = $_POST['date1'];
   $date2x = $_POST['date2'];
   if ($date1x > $date2x) {
     $date2x = $date1x;
   }
   $action = "";
}

// Define currencies Tables ------------------------
$acur1 = array();
$acur1['¥']  = array("Japanese Yen",       "JPY");
$acur1['C$']  = array("Canadian Dollar",    "CAD");
$acur1['€'] = array("Euro",               "EUR");
$acur1['$']   = array("US Dollar",          "USD");
$acur1['£']  = array("Great Britain Pound","GBP");
$acur1['Kr']  = array("Dansk Krone",        "DKK");
$acur1['AU$'] = array("Australian Dollar",  "AUD");
$acur1['Kc']  = array("Czech Koruna",       "CZK");
$acur1['Ft']  = array("Hungarian Forint",   "HUF");
$acur1['kr']  = array("Norwegian Krone",    "NOK");
$acur1['kr']  = array("Swedish Krona",      "SEK");
$acur1['Zl']  = array("Polish Zloty",       "PLN");
$acur2 = array();
$acur2['JPY']  = array("Japanese Yen",       "¥");
$acur2['CAD']  = array("Canadian Dollar",    "C$");
$acur2['EUR']  = array("Euro",               "€");
$acur2['USD']  = array("US Dollar",          "$");
$acur2['GBP']  = array("Great Britain Pound","£");
$acur2['DKK']  = array("Dansk Krone",        "Kr");
$acur2['AUD']  = array("Australian Dollar",  "AU$");
$acur2['CZK']  = array("Czech Koruna",       "Kc");
$acur2['HUF']  = array("Hungarian Forint",   "Ft");
$acur2['NOK']  = array("Norwegian Krone",    "kr");
$acur2['SEK']  = array("Swedish Krona",      "kr");
$acur2['PLN']  = array("Polish Zloty",       "Zl");

if(!function_exists('format_number')) {
  function format_number($num=0, $cur='GBP', $dec=2) {
    if ($cur == "" || $cur == $pref['rdtrack_currency']) {
      if ($pref['rdtrack_currency']!="") {
        $acur1 = array();
        $acur1['¥']  = "JPY";
        $acur1['C$']  = "CAD";
        $acur1['€'] = "EUR";
        $acur1['$']   = "USD";
        $acur1['£']  = "GBP";
        $acur1['Kr']  = "DKK";
        $acur1['AU$'] = "AUD";
        $acur1['Kc']  = "CZK";
        $acur1['Ft']  = "HUF";
        $acur1['kr']  = "NOK";
        $acur1['kr']  = "SEK";
        $acur1['Zl']  = "PLN";
        $cur = $acur1[$pref['rdtrack_currency']];
      }
    }
    $acur = array();
    $acur['JPY'] = "¥";
    $acur['CAD'] = "C$";
    $acur['EUR'] = "€";
    $acur['USD'] = "$";
    $acur['GBP'] = "£";
    $acur['DKK'] = "Kr";
    $acur['AUD'] = "AU$";
    $acur['CZK'] = "Kc";
    $acur['HUF'] = "Ft";
    $acur['NOK'] = "kr";
    $acur['SEK'] = "kr";
    $acur['PLN'] = "Zl";
  return number_format($num, $dec).$acur[$cur];}
}

//-----------------------------------------------------------------------------------------------------------+
// Save data on database
if (isset($_POST['addcash']) || isset($_POST['editcash'])) {
    $item_name = $_POST['item_name'];
    $payment_status = $_POST['payment_status'];
    $mc_gross = $_POST['mc_gross'];
    $mc_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $payment_fee = "";
    $custom =  $_POST['custom'];
    $us = new db;
    if ($us->db_Select("user","*", "user_name='".$item_name."'")) {
       $row = $us -> db_Fetch();
       $user_id = $row['user_id'];
       $buyer_email = $row['user_email'];
    } else {
       $user_id = "";
       $buyer_email = "";
    }
    $pdate = str_replace(".","/",$_POST['date1']);
    $pdate = str_replace("-","/",$pdate);
    $dt = explode("/",substr($pdate,0,10));
    $payment_date = mktime("01","00","00",$dt[1],$dt[0],$dt[2]);
    $mc_fee = $_POST['mc_fee'];
    $type = $_POST['type1'];
    $comment = $_POST['comment'];
    $mydb = new db;

    $validate  = (intval($payment_date) == 0 ) ? LAN_TRACK_F_2." ".LAN_TRACK_M7."<br>":"";
    $validate .= (intval($_POST['mc_gross']) == 0 ) ? LAN_TRACK_F_7." ".LAN_TRACK_M7."<br>":"";
    $validate .= ($item_name == "") ? LAN_TRACK_F_13." ".LAN_TRACK_M7."<br>":"";
    if(isset($_POST['addcash'])) {
      if($validate == "") {
         $message = (
         $mydb->db_Insert("ipn_info", array("item_name" => "$item_name","payment_status" => "$payment_status","mc_gross" => "$mc_gross","mc_currency" => "$mc_currency","txn_id" => "$txn_id","user_id" => "$user_id","buyer_email" => "$buyer_email",
         "payment_date" => "$payment_date","mc_fee" => "$mc_fee","payment_fee" => "$payment_fee","type" => "$type","comment" => "$comment","custom" => "$custom"))) ? LAN_TRACK_M1 :  LAN_TRACK_M2 ;
      }else{
        $message = strtoupper(LAN_TRACK_M2)."...<br>".$validate;
      }
    }else if(isset($_POST['editcash'])) {
      if($validate == "") {
         $message = ($mydb->db_Update("ipn_info","item_name ='".$item_name."', payment_status ='".$payment_status."', mc_gross ='".$mc_gross."', mc_currency ='".$mc_currency."', txn_id ='".$txn_id."', user_id ='".$user_id."', buyer_email ='".$buyer_email."',
         payment_date ='".$payment_date."', mc_fee ='".$mc_fee."', payment_fee ='".$payment_fee."', type ='".$type."', comment ='".$comment."',custom ='".$custom."' WHERE ipn_id=".$_POST['ipn_id']." LIMIT 1")) ? LAN_TRACK_M3 : LAN_TRACK_M4;
      }else{
        $message = strtoupper(LAN_TRACK_M4)."...<br>".$validate;
      }
    }
}
//--------------------------------------------------
if (isset($message)) {
   $action = "";
   $ns->tablerender("Message:", "<div style='text-align:center'><b>".$message."</b></div>");
}
//--------------------------------------------------
// Insert/Edit Form sheet
if ($sub_action=="edit" || $sub_action=="new") {
   $action = "cashnew";
   $us = new user_select;
   $typex = ($pm_prefs['dropdown'] == TRUE ? 'list' : 'popup');
   $query = "SELECT `ipn_id` FROM `e107_ipn_info` ORDER BY `ipn_id` DESC LIMIT 1";
   $result = mysql_query($query) or die(mysql_error());
   $row = mysql_fetch_array($result);
   $payment_date = date('d/m/Y');
   $type1 = 0;
   $txn_id = "";
   $mc_gross = 0;
   $mc_fee = 0;
   $mc_currency = $acur1[$pref['rdtrack_currency']][1];
   $payment_status = "";
   $payment_fee = "";
   $user_id = 0;
   $item_name = "";
   $comments = "";
   $title = LAN_TRACK_M_1;
   if ($sub_action=="edit") {
     $ipn_id = $id;
     $sql -> db_Select("ipn_info", "*", "ipn_id = ".$ipn_id);
     $row = $sql->db_Fetch();
     extract($row);
     $title = LAN_TRACK_M_2;
     $payment_date = date('d/m/Y', $payment_date);
     $type1 = $type;
   }else{
     $id = $row['ipn_id']+1;
   }

   $text = $script."

    <div style='text-align:center'>
    ".$rs -> form_open("post", e_SELF, "MyForm1", "", "")."
    <table style='width:100%' class='fborder' cellspacing='0' cellpadding='0'>

     <tr>
      <td colspan=6 class='fcaption'><center>".$title.LAN_TRACK_F_1.$id."</center></td>
     </tr>

     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_2."</td>
      <td style='width:22%' class='forumheader3'>".$rs -> form_text("date1", 15, $payment_date, 15,"tbox","","","","date1")." <a href='#' id='f-calendar-trigger-1'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date1','button':'f-calendar-trigger-1'});</script></td>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_3."</td>
      <td style='width:20%' class='forumheader3'>
        <select class='tbox' name='type1'>
           <option ".(($type1 == 0) ? " selected ='selected'" : "")." value=0> 0-".LAN_TRACK_F_4."</option>
           <option ".(($type1 == 1) ? " selected ='selected'" : "")." value=1> 1-".LAN_TRACK_F_5." </option>
        </select>
        <input type='hidden' name='ipn_id' value='$id'/>
      </td>
      <td style='width:15%' class='forumheader3'>".LAN_TRACK_F_6."</td>
      <td style='width:20%' class='forumheader3'>".$rs -> form_text("txn_id", 60, $txn_id, 100)."</td>
     </tr>

     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_7."</td>
      <td style='width:22%' class='forumheader3'>".$rs -> form_text("mc_gross", 15, $mc_gross, 15,"tbox","","","style='text-align:right'")."
        <select class='tbox' name='mc_currency'>";
    foreach ($acur1 as $key => $color) {
      $key2 = $acur1[$key][1];
      $text .= "<option ".(($mc_currency == $key2) ? " selected ='selected'" : "")." value='".$key2."'>".$acur1[$key][0]." ".$acur2[$key2][1]."</option>";
    }
    $text .= "
        </select>
      </td>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_8."</td>
      <td style='width:22%' class='forumheader3'>".$rs -> form_text("mc_fee", 15, $mc_fee, 15,"tbox","","","style='text-align:right'")."</td>
      <td style='width:15%' class='forumheader3'>".LAN_TRACK_F_9."</td>
      <td style='width:20%' class='forumheader3'>
        <select class='tbox' name='payment_status'>
           <option ".(($payment_status == "Completed") ? " selected ='selected'" : "")." value='Completed'>1-".LAN_TRACK_F_10."</option>
           <option ".(($payment_status == "Pending") ? " selected ='selected'" : "")."   value='Pending'  >2-".LAN_TRACK_F_11."</option>
           <option ".(($payment_status == "Denied") ? " selected ='selected'" : "")."    value='Denied'   >3-".LAN_TRACK_F_12."</option>
        </select>
      </td>
     </tr>
     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_13."</td>
      <td colspan=3 style='width:50%' class='forumheader3'>";
      $text .= "&nbsp;<img src='".e_IMAGE_ABS."generic/".IMODE."/user_select.png' style='width: 16px; height: 16px; vertical-align: top' alt='".US_LAN_4."...' title='".US_LAN_4."...' onclick=\"window.open('".e_HANDLER_ABS."user_select_class.php?item_name','user_search', 'toolbar=no,location=no,status=yes,scrollbars=yes,resizable=yes,width=300,height=200,left=100,top=100'); return false;\" />";
      //$text .= $us -> select_form("popup", "item_name", $item_name);
      $text .=" ".$rs -> form_text("item_name", 60, $item_name, 100)."</td>
      <td style='width:15%' class='forumheader3'>".LAN_TRACK_F_14."</td>
      <td style='width:20%' class='forumheader3'>".$rs -> form_text("comment", 60, $comment, 100)."</td>
     </tr>
     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_41."</td>
      <td colspan=5 style='width:80%' class='forumheader3'>".$rs -> form_text("custom", 150, $custom, 256)."</td>
     </tr>
     <tr style='vertical-align:top'>
       <td colspan=6 style='text-align:center' class='fcaption'>";
        if ($sub_action=="edit") {
          $text .= $rs -> form_button("submit", "editcash", LAN_TRACK_F_15, "", "", "")."  ".$rs -> form_button("button", "", LAN_TRACK_F_16, "onClick='history.go(-1);return true;'", "", "");
        }else{
          $text .= $rs -> form_button("submit", "addcash", LAN_TRACK_F_17, "", "", "")."  ".$rs -> form_button("button", "", LAN_TRACK_F_18, "onClick='history.go(-1);return true;'", "", "");
        }
    $text .= "
       </td>
      </tr>
    </table>
    ".$rs -> form_close()."
    </div>";
    $ns -> tablerender($title." REGISTER", $text);
    require_once(e_ADMIN."footer.php");
}

//-----------------------------------------------------------------------------------------------------------+
// Main manager page
if ($action == "cashmanage" || $action == "") {
    $due = $pref['rdtrack_due'];
    if (strlen(trim($due))<1) {
       $due = date('t/m/Y');
    }

    if (!isset($date1x)) {
       $date = date('t/m/Y 23:59:59');
       $dt = explode("/",substr($date,0,10));
       $date1 = mktime("00","00","00",$dt[1],"01",$dt[2]);
       $date1x = date('d/m/Y', $date1);
    }else{
       $dt = explode("/",$date1x);
       $date1 = mktime("00","00","00",$dt[1],$dt[0],$dt[2]);
    }
    if (!isset($date2x)) {
       $date = date('t/m/Y 23:59:59');
       $date2 = mktime("23","59","59",$dt[1],$dt[0],$dt[2]);
       $date2x = date('d/m/Y', $date2);
    }else{
       $dt = explode("/",$date2x);
       $date2 = mktime("23","59","59",$dt[1],$dt[0],$dt[2]);
    }

    $total = 0;
    $partial = 0;
    if ($pref['rdtrack_ibalance'] != 0) {
       $partial = $pref['rdtrack_ibalance'];
       $total = $pref['rdtrack_ibalance'];
    }
    $sql -> db_Select("ipn_info", "*", "payment_date > '0' ORDER BY payment_date ASC, type ASC, ipn_id ASC");
    while($row = $sql->db_Fetch()) {
      extract($row);
      if($type=="" || $type==0){
        $total += ($mc_gross-$mc_fee);
        if ($payment_date < $date1) {
           $partial += ($mc_gross-$mc_fee);
        }
      }else{
        $total -= ($mc_gross-$mc_fee);
        if ($payment_date < $date1) {
           $partial -= ($mc_gross-$mc_fee);
        }
      }
    }
    $countl = 0;
    $bg_line_n = $bg_line_n == 1? 0: 1;
    $bg_line_color = $bg_line_n == 1? "#F2F2F2": "#FFFFFF";
    $tt_clr = $total < 0 ? "red": "black";

    $text .= $script."
    <!-- <link rel='stylesheet' href='".e_PLUGIN."rdonation_tracker/style.css' type='text/css' /> -->
    <script language='JavaScript'>
    <!--
    function printx(elementId) {
    var prtContent = document.getElementById(elementId);
    var windowUrl = 'about:blank';
    var uniqueName = new Date();
    var windowName = 'Print' + uniqueName.getTime();
    var WinPrint = window.open(windowUrl, windowName, 'left=0,top=0,width=900,height=700,status=0,location=0,scrollbars=1');
     //WinPrint.document.write(\"<?xml version='1.0' encoding='utf-8' ?>\");
     WinPrint.document.write(\"<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>\");
     WinPrint.document.write(\"<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>\");
     WinPrint.document.write(\"<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>\");
     WinPrint.document.write(\"<html>\");
     WinPrint.document.write('<head>');
     WinPrint.document.write(\"<!-- <link media='screen' rel='stylesheet' type='text/css' href='".e_PLUGIN."rdonation_tracker/global.css' /> -->\");
     WinPrint.document.write(\"<link media='screen' rel='stylesheet' type='text/css' href='".e_PLUGIN."rdonation_tracker/style.css' />\");
     WinPrint.document.write(\"<link media='print'  rel='stylesheet' type='text/css' href='".e_PLUGIN."rdonation_tracker/style.css' />\");
     WinPrint.document.write(\"<!--  <link media='print'  rel='stylesheet' type='text/css' href='".e_PLUGIN."rdonation_tracker/print.css' /> -->\");
     WinPrint.document.write('<title>History - Balance</title>');
     WinPrint.document.write('</head>');
     WinPrint.document.write(\"<body style='background-color: #FFF;'>\");
     WinPrint.document.write(\"<div style='background-color: #FFF;'>\");
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</div>');
     WinPrint.document.write(\"<div id='printer' style='background-color: #FFF;' class='fborder'>\");
     WinPrint.document.write('<center>');
     WinPrint.document.write('<form>');
     WinPrint.document.write(\"<input type='button' id='prt1' value='Print this page' onClick='javascript:print();' >\");
     WinPrint.document.write('</form>');
     WinPrint.document.write('</center>');
     WinPrint.document.write('</div>');
     WinPrint.document.write('</body>');
     WinPrint.document.write('</html>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    //WinPrint.close();
    }

    function btnPrint_onclick(elementId)
    {
    document.getElementById('btn1').style.display='none';
    document.getElementById('btn2').style.display='none';
    printx(elementId);
    document.getElementById('btn1').style.display='block';
    document.getElementById('btn2').style.display='block';
    }

    function print(elementx)
    {
    document.getElementById('prt1').style.display='none';
    elementx.print();
    document.getElementById('prt1').style.display='block';
    }

    function printPreviewDiv(elementId)
    {
      var OLECMDID = 7;
     /* OLECMDID values:
     * 6 - print
     * 7 - print preview
     * 1 - open window
     * 4 - Save As
     */
     var WebBrowser = '';
     document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
     WebBrowser1.ExecWB(OLECMDID, PROMPT);
     WebBrowser1.outerHTML = '';
    }

    // -->
    </script>";

    $text .= "
    <div id='printDiv' style='text-align:center' class='fborder' >";
//    $text .= $rs->form_open("post", "admin_cash.php", "MyForm0", "", "");
    $text .= "
    <form method='post' action='".e_SELF."' name='MyForm0'>
    <table style='width:100%; border:1px;' class='fborder' cellspacing='0' cellpadding='0'>
    <tr>
     <td colspan=2 >
       <div style='text-align:center; border: 1px solid; background-color:#6E6E6E; MARGIN: 0px 0px 0px 0px;'><font color='white' size='+1'>".LAN_TRACK_F_19."</b></font></div>
       <div style='text-align:center; border: 1px solid; MARGIN: 0px 0px 0px 0px;'><font color='".$tt_clr."' size='+1'><b>".number_format($total,2).$pref['rdtrack_currency']."</b></font></div>
     </td>
     <td colspan=1 > </td>
     <td colspan=5 >
      ".LAN_TRACK_F_20.":<br>
      ".$rs -> form_text("date1", 15, $date1x, 15,"tbox","","","","date1")." <a href='#' id='f-calendar-trigger-1'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date1','button':'f-calendar-trigger-1'});</script>
      -
      ".$rs -> form_text("date2", 15, $date2x, 15,"tbox","","","","date2")." <a href='#' id='f-calendar-trigger-2'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date2','button':'f-calendar-trigger-2'});</script>
        <input class='button' type='submit' name='setdates' value='Submit' />
      </td>
      <td style='text-align:right;'>
        <div id='btn1'>
        <img id='printer' src='../../e107_plugins/rdonation_tracker/images/admin/print-button.png' width='45' height='33' value='Print' onclick='JavaScript:btnPrint_onclick(\"printDiv\");' title='Print' >
        </div>
      </td>
      <td style='text-align:center;'>
        <div id='btn2'>
        <a href='".e_SELF."?cashnew.new'><img src='../../e107_plugins/rdonation_tracker/images/admin/newcash.gif'alt='' title='".LAN_TRACK_F_21."' style='border: 0px none;'></a>
        </div>
      </td>
     </tr>";
//   <input type='image' src='../../e107_plugins/rdonation_tracker/images/admin/newcash.gif' name='cashnew' value='Submit' title='".LAN_TRACK_F_21."' />
     $bgclr1 = "#FAAC58";
     $bgclr2 = "#424242";
     $text .= "
     <tr>
        <td colspan=10 class='fcaption' style='text-align: center;'><b><font color='black'><center>".LAN_TRACK_F_22."</center></font></b></td>
     </tr>
     <tr>
       <td style='width:05; text-align:center;  ' class='forumheader3'>".LAN_TRACK_F_23."</td>
       <td style='width:10%; text-align:center; ' class='forumheader3'>".LAN_TRACK_F_24."</td>
       <td style='width:20%; text-align:left;   ' class='forumheader3'>".LAN_TRACK_F_25."</td>
       <td style='width:20%; text-align:left;   ' class='forumheader3'>".LAN_TRACK_F_26."</td>
       <td style='width:10%; text-align:center; ' class='forumheader3'>".LAN_TRACK_F_27."</td>
       <td style='width:05%; text-align:center; ' class='forumheader3'>".LAN_TRACK_F_28."</td>
       <td style='width:10%; text-align:right;  ' class='forumheader3'>".LAN_TRACK_F_29."</td>
       <td style='width:10%; text-align:right;  ' class='forumheader3'>".LAN_TRACK_F_30."</td>
       <td style='width:10%; text-align:right;  ' class='forumheader3'>".LAN_TRACK_F_31."</td>
       <td style='width:05%; text-align:center; ' class='forumheader3'>".LAN_TRACK_F_32."</td>
     </tr>";
    $countl += 5;
    if ($pref['rdtrack_ibalance'] != 0) {
       $text .= "
       <tr>
         <td colspan=8 class='fcaption' style='text-align: center;'><b><font color='black'><center>".LAN_TRACK_F_33."</center></font></b></td>
         <td style='width:10%; text-align:right;' class='fcaption'><b>".number_format($partial,2).$pref['rdtrack_currency']."</b></td>
         <td class='fcaption' style='text-align: center;'><b><font color='black'> </font></b></td>
       </tr>";
       $countl += 1;
    }

    $xflag1 = 0;
    $bg_line_n = 1;
    $sql -> db_Select("ipn_info", "*", "payment_date >= '".$date1."' AND payment_date <= '".$date2."' ORDER BY payment_date ASC, type ASC, ipn_id ASC");
    while($row = $sql->db_Fetch()) {
      extract($row);
      $typex = ($type == "" || $type == 0)? "<font color='green'>".LAN_TRACK_F_34."</font>":"<font color='red'>".LAN_TRACK_F_35."</font>";
      $flag++;
      if($type=="" || $type==0){
        $partial += ($mc_gross-$mc_fee);
      }else{
        $partial -= ($mc_gross-$mc_fee);
      }
      $bg_line_n = $bg_line_n == 1? 0: 1;

      $bg_line_color = $bg_line_n == 1? "#F2F2F2": "#FFFFFF";
      $part_clr = $partial < 0 ? "red": "black";
      $text .= "
      <tr>
            <td style='width:05%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".$ipn_id."</td>
            <td style='width:10%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".date('d.m.Y',$payment_date)."</td>
            <td style='width:20%; text-align:left;   background-color: ".$bg_line_color.";' class='forumheader'>".$item_name.($custom !=" "? "<br>".$custom:"")."</td>
            <td style='width:20%; text-align:left;   background-color: ".$bg_line_color.";' class='forumheader'>".trim($comment." ".$txn_id)."</td>
            <td style='width:10%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".$payment_status."</td>
            <td style='width:05%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".$typex."</td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color.";' class='forumheader'>".format_number($mc_gross,$mc_currency,2)."</td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color.";' class='forumheader'>".format_number($mc_fee,$mc_currency,2)."</td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color."; color: ".$part_clr.";' class='forumheader'>".number_format($partial,2).$pref['rdtrack_currency']."</td>
            <td style='width:05%; text-align:center; background-color: ".$bg_line_color.";  white-space: nowrap' class='forumheader'>";
      $text .= "<a href='".e_SELF."?cashnew.edit.{$ipn_id}'><img src='../../e107_plugins/rdonation_tracker/images/admin/edit_16.png' alt='' title='".LAN_TRACK_F_37."' style='border: 0px none; height: 16px; width: 16px;'></a><input type='image' title='".LAN_TRACK_F_38."' name='main_delete[".$ipn_id."]' src='../../e107_plugins/rdonation_tracker/images/admin/delete_16.png' onclick=\"return jsconfirm('".LAN_TRACK_F_36." [ID: {$ipn_id} ]')\"/>";
      $text .= "
            </td>
      </tr>";
      $countl += 1;
      if($countl >= 60) {
        $countl = 0;
        $text .= "
        <hr style='width:0px;height:0px;page-break-after:always;'>";
      }
   }
   if($flag == 0){
      $text .= "
       <tr>
           <td colspan=10 style='width:05%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".LAN_TRACK_F_39."</td>
       </tr>";
   }
   $text .= "
    <tr>
     <td colspan=8 class='fcaption' style='text-align: center; color: black;'><strong>".LAN_TRACK_F_40."</strong></td>
     <td style='width:10%; text-align:right; color: ".$part_clr.";' class='fcaption'><b>".number_format($partial,2).$pref['rdtrack_currency']."</b></td>
     <td style='width:4%; text-align:right;' class='fcaption'></td>
    </tr>
   </table>
   </form>
   </div>";
   //$text .= $rs->form_close();
   $ns -> tablerender(LAN_TRACK_F_0, $text);
   require_once(e_ADMIN."footer.php");
}

//-----------------------------------------------------------------------------------------------------------+
?>
