<?php
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."user_select_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
require_once(e_PLUGIN."anteup/_class.php");
$gen = new convert();
$cal = new DHTML_Calendar(true);
$rs = new form;

$pageid = 'admin_menu_04';


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
   $message = ($sql2->db_Delete("anteup_ipn", "ipn_id=".intval($delete_id[0]))) ? LAN_TRACK_M5 : LAN_TRACK_M6;
}

if (isset($_POST['setdates'])) {
   $date1x = $_POST['date1'];
   $date2x = $_POST['date2'];
   if ($date1x > $date2x) {
     $date2x = $date1x;
   }
   $action = "";
}

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

    $validate  = (intval($payment_date) == 0 ) ? LAN_TRACK_F_2." ".LAN_TRACK_M7."<br>":"";
    $validate .= (intval($_POST['mc_gross']) == 0 ) ? LAN_TRACK_F_7." ".LAN_TRACK_M7."<br>":"";
    $validate .= ($item_name == "") ? LAN_TRACK_F_13." ".LAN_TRACK_M7."<br>":"";
    if(isset($_POST['addcash'])) {
      if($validate == "") {
         $message = (
         $sql->db_Insert("anteup_ipn",
		 array(
			"item_name" => $item_name,
			"payment_status" => $payment_status,
			"mc_gross" => $mc_gross,
			"mc_currency" => $mc_currency,
			"txn_id" => $txn_id,
			"user_id" => $user_id,
			"buyer_email" => $buyer_email,
			"payment_date" => $payment_date,
			"mc_fee" => $mc_fee,
			"payment_fee" => $payment_fee,
			"type" => $type,
			"comment" => $comment,
			"custom" => $custom))) ? LAN_TRACK_M1 :  LAN_TRACK_M2;
      }else{
        $message = strtoupper(LAN_TRACK_M2)."...<br>".$validate;
      }
    }else if(isset($_POST['editcash'])) {
      if($validate == "") {
         $message = ($sql->db_Update("anteup_ipn","item_name ='".$item_name."', payment_status ='".$payment_status."', mc_gross ='".$mc_gross."', mc_currency ='".$mc_currency."', txn_id ='".$txn_id."', user_id ='".intval($user_id)."', buyer_email ='".$buyer_email."',
         payment_date ='".$payment_date."', mc_fee ='".$mc_fee."', payment_fee ='".$payment_fee."', type ='".$type."', comment ='".$comment."',custom ='".$custom."' WHERE ipn_id=".$_POST['ipn_id']." LIMIT 1")) ? LAN_TRACK_M3 : LAN_TRACK_M4;
      }else{
        $message = strtoupper(LAN_TRACK_M4)."...<br>".$validate;
      }
    }
}
if (isset($message)) {
   $action = "";
   $ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}
// Insert/Edit Form sheet
if ($sub_action == "edit" || $sub_action == "new") {
   $action = "cashnew";
   $us = new user_select;
   $typex = ($pm_prefs['dropdown'] == TRUE ? 'list' : 'popup');
   $sql->db_Select("anteup_ipn", "*", "ORDER BY ipn_id DESC LIMIT 1", "no-where");
   $row = $sql->db_Fetch();
   $payment_date = date('m/d/Y');
   $type1 = 0;
   $txn_id = "";
   $mc_gross = 0;
   $mc_fee = 0;
   $mc_currency = get_currency_code($pref['anteup_currency']);
   $payment_status = "";
   $payment_fee = "";
   $user_id = 0;
   $item_name = "";
   $comments = "";
   $title = LAN_TRACK_M_1;
   if ($sub_action=="edit") {
     $ipn_id = $id;
     $sql->db_Select("anteup_ipn", "*", "ipn_id='".intval($ipn_id)."'");
     $row = $sql->db_Fetch();
     $title = LAN_TRACK_M_2;
     $payment_date = date('m/d/Y', $payment_date);
     $type1 = $type;
   }else{
     $id = $row['ipn_id']+1;
   }

   $text = $script."
    <div style='text-align:center'>
	<form method='post' action='".e_SELF."' name='MyForm1'>
    <table style='width:100%' class='fborder' cellspacing='0' cellpadding='0'>
     <tr>
      <td colspan=6 class='fcaption'><center>".$title.LAN_TRACK_F_1.$id."</center></td>
     </tr>

     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_2."</td>
      <td style='width:22%' class='forumheader3'>".$rs -> form_text("date1", 15, $payment_date, 15,"tbox","","","","date1")." <a href='#' id='f-calendar-trigger-1'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'date1','button':'f-calendar-trigger-1'});</script></td>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_3."</td>
      <td style='width:20%' class='forumheader3'>
        <select class='tbox' name='type1'>
           <option ".(($type1 == 0) ? " selected ='selected'" : "")." value=0> 0-".LAN_TRACK_F_4."</option>
           <option ".(($type1 == 1) ? " selected ='selected'" : "")." value=1> 1-".LAN_TRACK_F_5." </option>
        </select>
        <input type='hidden' name='ipn_id' value='".$id."'/>
      </td>
      <td style='width:15%' class='forumheader3'>".LAN_TRACK_F_6."</td>
      <td style='width:20%' class='forumheader3'><input type='text' name='txn_id' class='tbox' /></td>
     </tr>

     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_7."</td>
      <td style='width:22%' class='forumheader3'>".$rs -> form_text("mc_gross", 15, $mc_gross, 15,"tbox","","","style='text-align:right'")."
        <select class='tbox' name='mc_currency'>";
		$sql->db_Select("anteup_currency", "*");
		while($row = $sql->db_Fetch()){
			$text .= "<option value='".$row['id']."'".($row['id'] == $pref['anteup_currency'] ? " selected" : "").">".$row['description']." (".$row['symbol'].")</option>";
		}
		$text .= "</select>
      </td>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_8."</td>
      <td style='width:22%' class='forumheader3'>".$rs -> form_text("mc_fee", 15, $mc_fee, 15,"tbox","","","style='text-align:right'")."</td>
      <td style='width:15%' class='forumheader3'>".LAN_TRACK_F_9."</td>
      <td style='width:20%' class='forumheader3'>
        <select class='tbox' name='payment_status'>
           <option".(($payment_status == "Completed") ? " selected ='selected'" : "")." value='Completed'>".LAN_TRACK_F_10."</option>
           <option".(($payment_status == "Pending") ? " selected ='selected'" : "")." value='Pending'>".LAN_TRACK_F_11."</option>
           <option".(($payment_status == "Denied") ? " selected ='selected'" : "")." value='Denied'>".LAN_TRACK_F_12."</option>
        </select>
      </td>
     </tr>
     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_13."</td>
      <td colspan=3 style='width:50%' class='forumheader3'>";
      $text .= "&nbsp;<img src='".e_IMAGE_ABS."generic/".IMODE."/user_select.png' style='width: 16px; height: 16px; vertical-align: top' alt='".US_LAN_4."...' title='".US_LAN_4."...' onclick=\"window.open('".e_HANDLER_ABS."user_select_class.php?item_name','user_search', 'toolbar=no,location=no,status=yes,scrollbars=yes,resizable=yes,width=300,height=200,left=100,top=100'); return false;\" />";
      $text .=" ".$rs -> form_text("item_name", 60, $item_name, 100)."</td>
      <td style='width:15%' class='forumheader3'>".LAN_TRACK_F_14."</td>
      <td style='width:20%' class='forumheader3'>".$rs -> form_text("comment", 60, $comment, 100)."</td>
     </tr>
     <tr>
      <td style='width:10%' class='forumheader3'>".LAN_TRACK_F_41."</td>
      <td colspan='5' style='width:80%' class='forumheader3'>".$rs -> form_text("custom", 150, $custom, 256)."</td>
     </tr>
     <tr style='vertical-align:top'>
       <td colspan='6' style='text-align:center' class='fcaption'>";
        if($sub_action == "edit"){
		$text .= "<input type='submit' name='editcash' value='".LAN_TRACK_F_15."' />";
          $text .= "<input type='submit' name='editcash' value='".LAN_TRACK_F_15."' />  ".$rs -> form_button("button", "", LAN_TRACK_F_16, "onClick='history.go(-1);return true;'", "", "");
        }else{
          $text .= "<input type='submit' name='addcash' value='".LAN_TRACK_F_17."' />  ".$rs -> form_button("button", "", LAN_TRACK_F_18, "onClick='history.go(-1);return true;'", "", "");
        }
    $text .= "
       </td>
      </tr>
    </table>
    </form>
    </div>";
    $ns -> tablerender($title." REGISTER", $text);
    require_once(e_ADMIN."footer.php");
}

if ($action == "cashmanage" || $action == "") {
	
	if(isset($_POST['setdates'])){
		$sdt = explode("/", $_POST['sd']);
		$edt = explode("/", $_POST['ed']);
	}else{
		$sdt = explode("/", date("m/d/Y", strtotime("first day of last month")));
		$edt = explode("/", date("m/d/Y", strtotime("last day of this month")));
	}

	$sd_ts = mktime(0, 0, 0, $sdt[0], $sdt[1], $sdt[2]);
	$sd = date('m/d/Y', $sd_ts);
	$ed_ts = mktime(23, 59, 59, $edt[0], $edt[1], $edt[2]);
	$ed = date('m/d/Y', $ed_ts);

    $total = 0;
    $partial = 0;
    if ($pref['anteup_ibalance'] != 0) {
       $partial = $pref['anteup_ibalance'];
       $total = $pref['anteup_ibalance'];
    }
    $sql -> db_Select("anteup_ipn", "*", "payment_date > '0' ORDER BY payment_date ASC, type ASC, ipn_id ASC");
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
     WinPrint.document.write('<title>History - Balance</title>');
     WinPrint.document.write('</head>');
     WinPrint.document.write(\"<body style='background-color: #fff;'>\");
     WinPrint.document.write(\"<div style='background-color: #fff;'>\");
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
     var WebBrowser = '';
     document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
     WebBrowser1.ExecWB(OLECMDID, PROMPT);
     WebBrowser1.outerHTML = '';
    }

    // -->
    </script>";

    $text .= "
    <div id='printDiv' style='text-align:center' class='fborder' >
    <form method='post' action='".e_SELF."' name='MyForm0'>
    <table style='width:100%; border:1px;' class='fborder' cellspacing='0' cellpadding='0'>
    <tr>
     <td colspan='2' style='margin-bottom: 4px;'>
       <div class='fcaption'>".LAN_TRACK_F_19."</div>
       <div class='forumheader3'><span style='color:#".$tt_clr.";'><b>".format_currency($total, $pref['anteup_currency'])."</span></div>
     </td>
     <td colspan=1 > </td>
     <td colspan=5 >
      Start Date: <td style='text-align:center;'><input type='text' class='tbox' name='sd' id='sd' value='".$sd."' /> <a href='#' id='f-calendar-trigger-1'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'sd','button':'f-calendar-trigger-1'});</script>
		 - End Date: <input type='text' class='tbox' name='ed' id='ed' value='".$ed."' /> <a href='#' id='f-calendar-trigger-2'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'ed','button':'f-calendar-trigger-2'});</script>
		<input class='button' type='submit' name='setdates' value='Filter' />
      </td>
      <td style='text-align:right;'>
        <div id='btn1'>
        <img id='printer' src='".e_PLUGIN."anteup/images/admin/printer.png' value='Print' onclick='JavaScript:btnPrint_onclick(\"printDiv\");' title='Print' >
        </div>
      </td>
      <td style='text-align:center;'>
        <div id='btn2'>
        <a href='".e_SELF."?cashnew.new'><img src='".e_PLUGIN."anteup/images/admin/money_add.png' title='".LAN_TRACK_F_21."' style='border: 0px;'></a>
        </div>
      </td>
     </tr>
     <tr>
        <td colspan=10 class='fcaption' style='text-align: center;'><b>".LAN_TRACK_F_22."</b></td>
     </tr>
     <tr>
       <td style='width:05; text-align:center;' class='forumheader3'>".LAN_TRACK_F_23."</td>
       <td style='width:10%; text-align:center;' class='forumheader3'>".LAN_TRACK_F_24."</td>
       <td style='width:20%; text-align:left;' class='forumheader3'>".LAN_TRACK_F_25."</td>
       <td style='width:20%; text-align:left;' class='forumheader3'>".LAN_TRACK_F_26."</td>
       <td style='width:10%; text-align:center;' class='forumheader3'>".LAN_TRACK_F_27."</td>
       <td style='width:05%; text-align:center;' class='forumheader3'>".LAN_TRACK_F_28."</td>
       <td style='width:10%; text-align:right;' class='forumheader3'>".LAN_TRACK_F_29."</td>
       <td style='width:10%; text-align:right;' class='forumheader3'>".LAN_TRACK_F_30."</td>
       <td style='width:10%; text-align:right;' class='forumheader3'>".LAN_TRACK_F_31."</td>
       <td style='width:05%; text-align:center;' class='forumheader3'>".LAN_TRACK_F_32."</td>
     </tr>";
    $countl += 5;
    if($pref['anteup_ibalance'] != 0){
       $text .= "<tr>
         <td colspan='8' class='fcaption' style='text-align: center;'>".LAN_TRACK_F_33."</td>
         <td style='width:10%; text-align:right;' class='fcaption'>".format_currency($partial, $pref['anteup_currency'])."</td>
         <td class='fcaption'>&nbsp;</td>
       </tr>";
       $countl += 1;
    }

    $xflag1 = 0;
    $bg_line_n = 1;
    $sql -> db_Select("anteup_ipn", "*", "payment_date > '".$sd_ts."' AND payment_date < '".$ed_ts."' ORDER BY payment_date DESC");
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
            <td style='width:10%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".$gen->convert_date(strtotime($payment_date), $pref['anteup_dformat'])."</td>
            <td style='width:20%; text-align:left;   background-color: ".$bg_line_color.";' class='forumheader'>".$item_name.($custom !=" "? "<br>".$custom:"")."</td>
            <td style='width:20%; text-align:left;   background-color: ".$bg_line_color.";' class='forumheader'>".trim($comment." ".$txn_id)."</td>
            <td style='width:10%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".$payment_status."</td>
            <td style='width:05%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".$typex."</td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color.";' class='forumheader'>".format_currency($mc_gross, $pref['anteup_currency'])."</td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color.";' class='forumheader'>".format_currency($mc_fee, $pref['anteup_currency'])."</td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color."; color: ".$part_clr.";' class='forumheader'>".format_currency(($mc_gross-$mc_fee), $pref['anteup_currency'])."</td>
            <td style='width:05%; text-align:center; background-color: ".$bg_line_color.";  white-space: nowrap' class='forumheader'>";
      $text .= "<a href='".e_SELF."?cashnew.edit.{$ipn_id}'>".ADMIN_EDIT_ICON."</a><input type='image' title='".LAN_TRACK_F_38."' name='main_delete[".$ipn_id."]' src='".e_PLUGIN."anteup/images/admin/delete_16.png' onclick=\"return jsconfirm('".LAN_TRACK_F_36." [ID: {$ipn_id} ]')\"/>";
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
     <td style='width:10%; text-align:right; color: ".$part_clr.";' class='fcaption'><b>".format_currency($partial, $pref['anteup_currency'])."</b></td>
     <td style='width:4%; text-align:right;' class='fcaption'></td>
    </tr>
   </table>
   </form>
   </div>";
   $ns -> tablerender(LAN_TRACK_F_0, $text);
   require_once(e_ADMIN."footer.php");
}
?>
