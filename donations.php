<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By roofdog78 $ DelTree
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

require_once(HEADERF);

require_once(e_HANDLER."form_handler.php");

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");


require_once(e_HANDLER."calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
global $cal;
$script = "
   <script type=\"text/javascript\">
    function addtext_us(sc){
      document.getElementById('dataform').image.value = sc;
    }
   </script>\n";
$script .= $cal->load_files();

if (!function_exists('format_numbers')) {
function format_numbers($num=0, $cur='GBP', $dec=2) {
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
return number_format($num, $dec).$acur[$cur];
}
}

$rs = new form;

if (isset($_POST['setdates'])) {
   $date1x = $_POST['date1'];
   $date2x = $_POST['date2'];
   $action = "";
}

$mtitle = $pref['rdtrack_mtitle'];
$currency = $pref['rdtrack_currency'];
$goal = $pref['rdtrack_goal'];
$current = $pref['rdtrack_current'];
//$due = $pref['rdtrack_due'];
$total = $pref['rdtrack_total'];
$spent = $pref['rdtrack_spent'];
$donatelink = $pref['rdtrack_donatelink'];
$pal_currency_code = $pref['pal_currency_code'];
$pref['ipn_pal_ipn_file'] = $pref['pal_ipn_file'];
$mc_currency = $pref['rdtrack_currency'];
$pg = 1;
$sql1 = new db;

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

$caption = "Donations List";

$page_text = "";

if(USER || $pref['pal_no_protection']) {
  $paypal_item_name              = USERNAME;
  $paypal_donate_jscript         = "";
  $paypal_donate_jscript_onclick = "";
  $paypal_donate_action          = "https://www.paypal.com/cgi-bin/webscr";
  $paypal_donate_email           = $pref['pal_business'];
  $pref['pal_item_name'] = "".$paypal_item_name;
  $pref['pal_custom'] = USERID;
  if(USER) {
    if($sql -> db_Select("user_extended", "*", "user_extended_id=".USERID)) {
      $row2 = $sql -> db_Fetch();
      if(isset($row2['user_country'])) {
        $pref['pal_lc'] = $row2['user_country'];
      }
    }
    if($pref['pal_custom'] == '0') {
      $pref['pal_custom'] = USERID;
    }
  }

}else{
  $paypal_item_name      = "Your name here";
  $paypal_donate_email   = preg_split("#(?<=.)(?=.)#s",$pref['pal_business']);
  $paypal_donate_email   = "'".implode("'  +  '", $paypal_donate_email)."'";
  $paypal_donate_jscript = "
  <script type='text/javascript'>
  function paypal_donate_set()
  {
    document.forms.paypal_donate_form.paypal_donate_email.value=$paypal_donate_email;
    document.forms.paypal_donate_form.action='https://www.paypal.com/cgi-bin/webscr';
  }
  </script>";
  $paypal_donate_jscript_onclick = "onclick='paypal_donate_set()'";
  $paypal_donate_action          = e_PLUGIN."rdonation_tracker/";
  $paypal_donate_email           = "JAVASCRIPT_REQUIRED";
}

$text = $pref['rdtrack_description']."
<!-- BEGIN PAYPAL DONATION CODE - DARKFLARE@SOUNDREAM.ORG -->
<table width='75%'>
  <tr>
  <form action='$paypal_donate_action' id='paypal_donate_form' method='post'>

    <td width='30%'><font color='white'> Name: </font><br>
      <input name='item_name' type='text' id='item_name' value='".$paypal_item_name."' size='25%' maxlength='50' />

      <input type='hidden' name='cmd'      value='_xclick' />
      <input type='hidden' name='business' value='$paypal_donate_email' id='paypal_donate_email' />";
      if($pref['pal_no_shipping'])   { $text .="<input type='hidden' name='no_shipping'   value='$pref[pal_no_shipping]'   />"; }
      if($pref['pal_no_note'])       { $text .="<input type='hidden' name='no_note'       value='$pref[pal_no_note]'       />"; }
      if($pref['pal_cn'])            { $text .="<input type='hidden' name='cn'            value='$pref[pal_cn]'            />"; }
      if($pref['pal_return'])        { $text .="<input type='hidden' name='return'        value='$pref[pal_return]'        />"; }
      if($pref['pal_cancel_return']) { $text .="<input type='hidden' name='cancel_return' value='$pref[pal_cancel_return]' />"; }
      if($pref['pal_page_style'])    { $text .="<input type='hidden' name='page_style'    value='$pref[pal_page_style]'    />"; }
      if($pref['pal_lc'])            { $text .="<input type='hidden' name='lc'            value='$pref[pal_lc]'            />"; }
      if($pref['pal_item_number'])   { $text .="<input type='hidden' name='item_number'   value='$pref[pal_item_number]'   />"; }
      if($pref['pal_custom'])        { $text .="<input type='hidden' name='custom'        value='$pref[pal_custom]'        />"; }
      if($pref['pal_invoice'])       { $text .="<input type='hidden' name='invoice'       value='$pref[pal_invoice]'       />"; }
      if($pref['pal_amount'])        { $text .="<input type='hidden' name='amount'        value='$pref[pal_amount]'        />"; }
      if($pref['pal_tax'])           { $text .="<input type='hidden' name='tax'           value='$pref[pal_tax]'           />"; }
      if($pref['ipn_pal_ipn_file'])  { $text .="<input type='hidden' name='notify_url'    value='$pref[ipn_pal_ipn_file]'  />"; }

$image_path = e_PLUGIN."rdonation_tracker/images/$pref[pal_button_image]";
$image_path2= "https://www.paypal.com/images/x-click-but04.gif";
$alt = "Make payments with PayPal - it&#039;s fast, free and secure!";
$text .= "
    </td>
    <td width='25%'><font color='white'> Currency: </font><br>
      <SELECT name=currency_code>";

    foreach ($acur1 as $key => $color) {
      $key2 = $color[1];
      $text .= "<option ".(($mc_currency == $key) ? " selected ='selected'" : "")." value='".$key2."'>".$color[0]." ".$key."</option>";
    }

$text .= "
      </select>
    </td>

    <td width='20%'><font color='white'> Amount: </font><br>
      <SELECT name=amount>
        <OPTION value=0.00>-- Other --</option>
        <OPTION value=1.00>1.00</option>
        <OPTION value=5.00 selected>5.00</option>
        <OPTION value=10.00>10.00</option>
        <OPTION value=15.00>15.00</option>
        <OPTION value=20.00>20.00</option>
        <OPTION value=30.00>30.00</option>
        <OPTION value=40.00>40.00</option>
        <OPTION value=50.00>50.00</option>
        <OPTION value=100.00>100.00</option>
        <OPTION value=500.00>500.00</option>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan=3><br /><center><input $paypal_donate_jscript_onclick name='submit' type='image' src='$image_path' alt='$alt' title='$pref[pal_button_popup]' style='border:none' /></center></td>
  </form>
</tr>
</table>

<!-- END PAYPAL DONATION CODE - DARKFLARE@SOUNDREAM.ORG -->
<br><br>
<!-- *********************************************** -->

[center][size=14][color=#ff9900][b]&#8226; WHO HAS DONATED SO FAR &#8226;[/size][/color][/b][/center]
";
//.$page_text;

$caption = $tp->toHtml($caption,true,"");
$text = $tp->toHtml($text,true,"");

$due = $pref['rdtrack_due'];
if (strlen(trim($due))==0) {
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
$sql -> db_Select("ipn_info", "*","payment_date > '0' ORDER BY payment_date ASC, type ASC, ipn_id ASC");
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

$text .= $rs->form_open("post", e_SELF, "MyForm0", "", "");
$text .= $script."
<div style='text-align:center' width='75%'>
 <table width='100%' class='bbcode' cellspacing='0' cellpadding='0'>";
   if(check_class($pref['rdtrack_showbalance']) || ADMIN) {
     $text .= "
     <tr>
     <td colspan=3 class='bbcode'>
     <center><a href='../../e107_plugins/rdonation_tracker/balance.php' ><img src='../../e107_plugins/rdonation_tracker/images/admin/balanceSheet.gif' border='0' title='".LAN_TRACK_F_42."' /></a></center>
     </td>
     </tr>";
   }
   $text .= "
   <tr>
      <td colspan=3 class='bbcode' style='text-align:left; color: white;'><strong class='bbcode'><ul style='margin-left: 30%; margin-top: 0px; padding-left: 0px;'>
      ".LAN_TRACK_F_20.":<br>
      ".$rs -> form_text("date1", 12, $date1x, 12,"tbox","","","","date1")." <a href='#' id='f-calendar-trigger-1'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date1','button':'f-calendar-trigger-1'});</script>
      =>
      ".$rs -> form_text("date2", 12, $date2x, 12,"tbox","","","","date2")." <a href='#' id='f-calendar-trigger-2'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date2','button':'f-calendar-trigger-2'});</script></strong>
        <input class='button' type='submit' name='setdates' value='Submit' /></ul>
      </td>
   </tr>
   <tr>
     <td colspan=3 class='bbcode'>

 ";
$text .= $rs->form_close();

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

$sql = new db;
$sql -> db_Select("ipn_info", "*", "payment_date >= '".$date1."' AND payment_date <= '".$date2."' ORDER BY FROM_UNIXTIME(payment_date, '%Y%m') DESC, comment ASC, FROM_UNIXTIME(payment_date, '%d') ASC");
// YEAR(FROM_UNIXTIME(payment_date * 86400, '%Y-%m-%d')) ASC, MONTH(FROM_UNIXTIME(payment_date * 86400, '%Y-%m-%d')) ASC, CONCAT(comment,payment_date) ASC
$count = 0;
$pdate1 = "";
$group = "";
$text1 = "";
$sb = 0;
while($row = $sql->db_Fetch()) {
  extract($row);
  // Credit
  if($type=="" || $type==0){
    $count += 1;
    $partial += ($mc_gross-$mc_fee);
    $pdate2 = date('F', $payment_date) ." ". date('Y', $payment_date);
    //---------------------------------------------------------------------------------------------
    // Change Date
    if ($pdate1 != $pdate2){
       $pdate1 = $pdate2;
       if ($text1 != ""){
          $text .= $text1;
          if($group == "") {
            if($sb>0){
              $text .= "<hr size='1'><br><b>&nbsp;&nbsp;&nbsp;&nbsp;TOTAL&nbsp;&nbsp;==>>> ".number_format($sb,2).$pref['rdtrack_currency']." <<<==</b>";
              $sb = 0;
            }
            $text .= "</div></center>";
          }else{
            if($sb>0){
              $text .= "<br><font color='yellow'><b>TOTAL&nbsp;&nbsp;==>>> ".number_format($sb,2).$pref['rdtrack_currency']." <<<==</b></font>";
              $sb = 0;
            }
          }
          $text1 = "";
       }
       $stl = ($group == "") ? "" : "<br><br>";
       $xdv_cl = ($pdate1 != "") ? "</div>" : "";
       $text .= $xdv_cl."
    <div style='text-align: center;'>
      ".$stl."<hr size='1'>
      <span style='font-size: 18px; color: rgb(255, 153, 0);'><strong class='bbcode'>&raquo; ".$pdate1." &laquo;</span></strong>";
       $group = "";
    }
    //---------------------------------------------------------------------------------------------
    // Change Division
    if ($group != trim($comment)){
       if ($text1 != ""){
          $text .= $text1;
          if($group == ""){
            if($sb>0){
              $text .= "<hr size='1'><br><b>&nbsp;&nbsp;&nbsp;&nbsp;TOTAL&nbsp;&nbsp;==>>> ".number_format($sb,2).$pref['rdtrack_currency']." <<<==</b>";
              $sb = 0;
            }
            $text .= "</div>";
          }else{
            if($sb>0){
               $text .= "<br><font color='yellow'><b>TOTAL&nbsp;&nbsp;==>>> ".number_format($sb,2).$pref['rdtrack_currency']." <<<==</b></font>";
               $sb = 0;
            }
          }
          $text1 = "";
       }
       $group = $comment;
       $text .= "<br><br><span style='color: rgb(255, 153, 0);'><strong class='bbcode'>".$group."</strong></span><br>";
    }
    if($comment != "") {
      $p1 = (strlen($text1) > 1) ? " &#8226;&nbsp;" : "";
      $text1 .= $p1."<strong class='bbcode'>".$item_name."</strong>&nbsp;-&nbsp;".format_numbers($mc_gross,$mc_currency,2)."&nbsp;-&nbsp;".date('d/m',$payment_date);

    }else{
      $p1 = (strlen($text1) > 1) ? "" : "<center><div style='text-align:left; width: 30%;'>";
      $text1 .= $p1."<li><strong class='bbcode'>".$item_name."</strong>&nbsp;-&nbsp;".format_numbers($mc_gross,$mc_currency,2)."&nbsp;-&nbsp;".date('d/m',$payment_date)."</li>";
    }
    $sb += $mc_gross;
  }else{
    $partial -= $mc_gross;
  }

}
if ($text1 != ""){
  if($group == ""){
     if($sb>0){
       $text .= $text1."<hr size='1'><b>&nbsp;&nbsp;&nbsp;&nbsp;TOTAL&nbsp;&nbsp;==>>> ".number_format($sb,2).$pref['rdtrack_currency']." <<<==</b>";
       $sb = 0;
     }
     $text .= "</div>";
  }else{
     $text .= $text1;
     if($sb>0){
       $text .= "<br><font color='yellow'><b>TOTAL&nbsp;&nbsp;==>>> ".number_format($sb,2).$pref['rdtrack_currency']." <<<==</b></font>";
       $sb = 0;
     }
  }
  $text .= "<br><br><hr size='1'>";
}
if ($count > 0) {
  $text .= "</div>";
}
$text .= " </td></tr></table>
</div>";
$ns -> tablerender($caption, $text);
require_once(FOOTERF);

/*
http://img263.imageshack.us/img263/29/rdt1u.png
http://img88.imageshack.us/img88/7053/rdt2.png
http://img293.imageshack.us/img293/5052/rdt3.png
http://img199.imageshack.us/img199/3376/rdt4.png

*/
//------------
?>