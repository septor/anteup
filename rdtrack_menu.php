<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By roofdog78 & DelTree
|
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|     Plugin support at http://www.roofdog78.com
|
|     For the e107 website system visit http://e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

$due = $pref['rdtrack_due'];
if (strlen(trim($due))<1) {
   $date = date('t/m/Y 23:59:50');
   $due = date('t/m/Y');
   $dt = explode("/",substr($date,0,10));
   $tm = explode(":",substr($date,11,8));
} else {
   $date = str_replace("-","/",$due);
   $date = str_replace(".","/",$date);
   $time = "00:00:00";
   $dt = explode("/",$date);
   $tm = explode(":",$time);
}
$date1 = mktime("00","00","00",$dt[1],"01",$dt[2]);
$date2 = mktime("23","59","59",$dt[1],$dt[0],$dt[2]);

$tt1 = 0;
$sql1 = new db;
$sql1 -> db_Select("ipn_info", "*", "payment_date >= '".$date1."' AND payment_date <= '".$date2."' ORDER BY payment_date ASC");
$donors = array();
while($row = $sql1-> db_Fetch()) {
  $date = explode("/",date("d/m/Y", $row['payment_date']));
  $type = $row['type'];
  if ($type==0) {
     $donors[] = array($row['item_name'], $row['mc_gross'], implode("-",$date), $row['mc_currency']);
     $tt1 += $row['mc_gross'];
  }
}

// new language call method
include_lan(e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php");

$mtitle = $pref['rdtrack_mtitle'];
$currency = $pref['rdtrack_currency'];
$goal = $pref['rdtrack_goal'];
$current = $pref['rdtrack_current'];
//$due = $pref['rdtrack_due'];
$total = $pref['rdtrack_total'];
$spent = $pref['rdtrack_spent'];
$donatelink = $pref['rdtrack_donatelink'];
$pal_currency_code = $pref['pal_currency_code'];

$current += $tt1;

if ($total == 0 || $total == "") {
  $total = $current;
}
$total = number_format($total,2);
$simbol = $currency;
$amt_left = round($goal - $current, 2);
$pct_left = round(($current / $goal) * 100, 0);

$eplug_folder = "rdonation_tracker";
$pref['ipn_pal_ipn_file'] = SITEURL."e107_plugins/$eplug_folder/ipn_validate.php";
if (USER || $pref['pal_no_protection']) {
    $paypal_item_name              = USERNAME;
    $paypal_donate_jscript         = "";
    $paypal_donate_jscript_onclick = "";
    $paypal_donate_action          = "https://www.paypal.com/cgi-bin/webscr";
    $paypal_donate_email           = $pref['pal_business'];
    $pref['pal_item_name'] = "".$paypal_item_name;
    $pref['pal_custom'] = USERID;
    if(USER) {
      $sql -> db_Select("user_extended", "*", "user_extended_id=".USERID);
      $row2 = $sql -> db_Fetch();
      $pref['pal_lc'] = $row2['user_country'];
      if($pref['pal_custom'] == '0') {
        $pref['pal_custom'] = USERID;
      }
    }
}else{
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

if (varsettrue($pref['rdtrack_showbar'])) {
  $showbar = $pct_left."% ".LAN_TRACK_MENU_01."<br />
<script type='text/javascript'>
  function DoNav(theUrl) {
  document.location.href = theUrl;}
</script>
<table cellspacing='0' cellpadding='0' style='border:#".$pref['rdtrack_border']." 1px solid; width:100%;'>
  <tr onclick=\"DoNav('".e_PLUGIN."rdonation_tracker/donations.php');\" title='VIEW WHO HAS DONATED?'>
    <td style='width:".$pct_left."%; height: ".$pref['rdtrack_height']."px; background-color:#".$pref['rdtrack_full'].";'></td>
    <td style='width:".(100 - $pct_left)."%; height: ".$pref['rdtrack_height']."; background-color:#".$pref['rdtrack_empty'].";'></td>
  </tr>
</table>
<br />";
}else{
  $showbar = '';
}

if (varsettrue($pref['rdtrack_showcurrent'])) {
  $showcurrent = "<b>".LAN_TRACK_MENU_02."</b> ".$currency."&nbsp;".intval($current)."<br />";
}else{
  $showcurrent = '';
}

if (varsettrue($pref['rdtrack_showleft'])) {
  $showleft = "<b>".LAN_TRACK_MENU_03."</b> ".$currency."&nbsp;".$amt_left."<br />";
}else{
  $showleft = '';
}

if (varsettrue($pref['rdtrack_showgoal'])) {
  $showgoal = "<b>".LAN_TRACK_MENU_04."</b> ".$currency."&nbsp;".$goal."<br />";
}else{
  $showgoal = '';
}

if (varsettrue($pref['rdtrack_showdue'])) {
  $datepart = explode("/", $due);
  $datex = mktime(0, 0, 0, $datepart[1], $datepart[0], $datepart[2]);
  $day_d = $datepart[0];
  $day_m = $datepart[1];
  $day_y = $datepart[2];
  $DAY_months = explode(',', DAY_LAN_MONTHS);
  $DAY_monthl = explode(',', DAY_LAN_MONTHL);
  $DAY_suffix = explode(',', DAY_LAN_MONTHSUFFIX);
  switch ($pref['rdtrack_dformat']) {
    case 1:
        // d/M
        $day_out = $day_d . "/" . $day_m;
        break;
    case 2:
        // M/d
        $day_out = $day_m . "/" . $day_d;
        break;
    case 3:
        // m/d/Y
        $day_out = $day_m ."/". $day_d ."/". $day_y;
        break;
    case 4:
        // Y/m/d
        $day_out = $day_y . "/" . $day_m ."/". $day_d;
        break;
    case 5:
        // d mmm Y
        $day_out = $day_d . " " . $DAY_months[intval($day_m)] ." ". $day_y;
        break;
    case 6:
        // d MMM Y
        $day_out = $day_d . " " . $DAY_monthl[intval($day_m)] . " ". $day_y;
        break;
    case 7:
        // mmm d Y
        $day_out = $DAY_months[intval($day_m)] . " " . $day_d ." ". $day_y;
        break;
    case 8:
        // MMM d Y
        $day_out = $DAY_monthl[intval($day_m)] . " " . $day_d ." ". $day_y;
        break;

    case 9:
        // d mmm Y
        $day_out = intval($day_d) . $DAY_suffix[intval($day_d)] . " " . $DAY_months[intval($day_m)] ." ". $day_y;
        break;
    case 10:
        // d MMM Y
        $day_out = intval($day_d) . $DAY_suffix[intval($day_d)] . " " . $DAY_monthl[intval($day_m)] ." ". $day_y;
        break;
    case 11:
        // mmm d Y
        $day_out = $DAY_months[intval($day_m)] . " " . intval($day_d) . $DAY_suffix[intval($day_d)] ." ". $day_y;
        break;
    case 12:
        // MMM d Y
        $day_out = $DAY_monthl[intval($day_m)] . " " . intval($day_d) . $DAY_suffix[intval($day_d)] ." ". $day_y;
        break;

    case 13:
        // d mmm Y
        $day_out = $day_d . " " . $DAY_months[intval($day_m)];
        break;
    case 14:
        // d MMM Y
        $day_out = $day_d . " " . $DAY_monthl[intval($day_m)] ;
        break;
    case 15:
        // mmm d Y
        $day_out = $DAY_months[intval($day_m)] . " " . $day_d ;
        break;
    case 16:
        // MMM d Y
        $day_out = $DAY_monthl[intval($day_m)] . " " . $day_d ;
        break;

    case 17:
        // d mmm Y
        $day_out = intval($day_d) . $DAY_suffix[intval($day_d)] . " " . $DAY_months[intval($day_m)];
        break;
    case 18:
        // d MMM Y
        $day_out = intval($day_d) . $DAY_suffix[intval($day_d)] . " " . $DAY_monthl[intval($day_m)] ;
        break;
    case 19:
        // mmm d Y
        $day_out = $DAY_months[intval($day_m)] . " " . intval($day_d) . $DAY_suffix[intval($day_d)] ;
        break;
    case 20:
        // MMM d Y
        $day_out = $DAY_monthl[intval($bday_m)] . " " . intval($day_d) . $DAY_suffix[intval($day_d)] ;
        break;
    case 21:
        // m/d/Y
        $day_out = $day_d ."/". $day_m ."/". substr($day_y,2);
        break;
    case 22:
        // m/d/Y
        $day_out = substr($day_y,2) ."/". $day_m ."/". $day_d;
        break;
    case 22:
        // m/d/Y
        $day_out = $day_m ."/". $day_d ."/". substr($day_y,2);
        break;

    default :
        // d/m/Y
        $day_out = $day_d ."/". $day_m ."/". $day_y;
  }

  $showdue = "<b>".LAN_TRACK_MENU_05."</b> ".$day_out."<br />";
}else{
  $showdue = '';
}

if (varsettrue($pref['rdtrack_showlist']))  {
  $xadd = $current > 0? "<br><hr size=1>": "";
  $showlist = "<b>".LAN_TRACK_MENU_06."</b>".$xadd;
}else{
  $showlist = '';
}
$textb = strlen($pref['rdtrack_textbar']) > 0 ? "<b>".$pref['rdtrack_textbar']."</b><br>": "";
$text = $showbar.$textb.$showcurrent.$showleft.$showgoal.$showdue."<br />".$showlist;
if (varsettrue($pref['rdtrack_showlist']))  {
  $mleft = '15px';
  $listitems ="<ul style='margin-left: ".$mleft."; margin-top: 0px; padding-left: 0px;'><div style='text-align:center; width:85%;'>";
  $listitems .= "
   <table cellspacing='0' cellpadding='0' style='border:0pt none; width:90%; color:white;'>";
  
  $diff  = !varsettrue($pref['rdtrack_showdate'])  ?  9: 0;
  $diff += !varsettrue($pref['rdtrack_showvalue']) ? 14: 0;
  for ($i=0; $i<count($donors); $i++) {
     if (strlen($donors[$i][0]) > 0) {
        $listitems .= "
        <tr>";
        if(varsettrue($pref['rdtrack_showdate'])) {
          $listitems .= "
          <td style='color: white; width:10%; text-align: center;'>&nbsp;&nbsp;".substr($donors[$i][2],0,2)."/".substr($donors[$i][2],3,2)."&nbsp;</td>";
        }else{
          $listitems .= "
          <td style='color: white; width:1%; text-align: center;'>&nbsp;</td>";
        }
        //--------------------------------------------------------------------------------
        $listitems .= "
          <td style='color: white; width:".(75+$diff)."%; text-align: left;'>&nbsp;".($diff >0 ? "&bull;&nbsp;": "").$donors[$i][0]."</td>";
        //--------------------------------------------------------------------------------
        if(varsettrue($pref['rdtrack_showvalue'])) {
          $listitems .= "
          <td style='color: white; width:15%; text-align: right;'>&nbsp;".format_mumber($donors[$i][1],$donors[$i][3],0)."&nbsp;</td>";
        }else{
          $listitems .= "
          <td style='color: white; width:1%; text-align: center;'>&nbsp;</td>";
        }
        $listitems .= "
        </tr>";
     }
  }
  if($current > 0 && varsettrue($pref['rdtrack_showvalue'])) {
    $listitems .= "
    </table>
    </div></ul>
    <hr size=1>
    <ul style='margin-left: ".$mleft."; margin-top: 0px; padding-left: 0px;'><div style='text-align:center; width:85%;'>
     <table cellspacing='0' cellpadding='0' style='border:0pt none; width:90%; color:white;'>
      <tr>
       <td colspan='2' valign='top' style='color: white; text-align: center;'><font color='#".$pref['rdtrack_full']."'><b> ***  TOTAL  *** </b></font></td>
       <td valign='top' style='color: white; width:10%; text-align: right;'><b>".format_mumber($current,$pref['pal_currency_code'],0)."&nbsp;</b></td>
      </tr>";
  }else{
    if(varsettrue($pref['rdtrack_showvalue'])) {
      $listitems .= "
      </table>
      </div></ul>
      <hr size=1>
      <ul style='margin-left: ".$mleft."; margin-top: 0px; padding-left: 0px;'><div style='text-align:center; width:85%;'>
       <table cellspacing='0' cellpadding='0' style='border:0pt none; width:90%; color:white;'>
        <tr>
         <td colspan='3' valign='top' style='color:#".$pref['rdtrack_empty']."; width:100%; text-align: center;'>*** NONE ***</td>
        </tr>";
    }
  }
  $listitems .= "
    </table>
  </div></ul>
  <hr size=1>";
}

//$listitems .= "<hr size=1 width=100%></div>";

if (strlen($listitems) > 0) {
   $text .= $listitems;
}

$text .="
<div style='width:100%; margin-left:auto; margin-right:auto; text-align:center;'>
  <form method='post' action='$paypal_donate_action' id='paypal_donate_form'>

      <input type='hidden' name='cmd'      value='_xclick' />
      <input type='hidden' name='business' value='$paypal_donate_email' id='paypal_donate_email' />";

if($pref['pal_item_name'])     { $text .="<input type='hidden' name='item_name'     value='$pref[pal_item_name]'     />"; }
if($pref['pal_currency_code']) { $text .="<input type='hidden' name='currency_code' value='$pref[pal_currency_code]' />"; }
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

$text .= "

      <div>
      $pref[pal_text]<br />
      </div>

      <div style='padding-top:5px'>
        <input $paypal_donate_jscript_onclick name='submit' type='image' src='$image_path' alt='$image_text' title='$pref[pal_button_popup]' style='border:none' />
      </div>
 </form>
</div>";

if(ADMIN){
  $text .= "<a href='".e_PLUGIN_ABS."rdonation_tracker/admin_config.php'><br />".LAN_TRACK_MENU_07."</a>";
}
$ns -> tablerender("$mtitle",  "<div style='text-align:center;'>\n".$text."\n</div>", 'rdtrack');

function format_mumber($num=0, $cur='GBP', $dec=2) {
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

function in_string($needle, $haystack) {
  if (is_array($needle)) {
    foreach ($needle as $n) {
      if(strpos($haystack, $n) !== false){
        return true;
      }
    }
    return false;
  }else{
    if (strpos($haystack, $needle) !== false) {
       return true;
    }
    return false;
  }
}

?>