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
require_once("../../class2.php");

if (!getperms("P"))
{
	header("location:".e_BASE."index.php");
	exit ;
}

require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER.'userclass_class.php');

//require_once(e_HANDLER."news_class.php");
require_once(e_HANDLER."ren_help.php");
require_once(e_HANDLER."file_class.php");
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

global $sql, $rs, $ns, $pref, $tp, $pst, $e107;
$rs = new form;

$pageid = 'admin_menu_01';

//$e_sub_cat = 'news';
$e_wysiwyg = "data";
// define("e_WYSIWYG", TRUE);

if (isset($_POST['updatesettings'])) {

	$pref['rdtrack_currency'] = $_POST['rdtrack_currency'];
	$pref['rdtrack_goal']     = $_POST['rdtrack_goal'];
	$pref['rdtrack_current']  = $_POST['rdtrack_current'];
	$pref['rdtrack_due']      = $_POST['rdtrack_due'];
	$pref['rdtrack_total']    = $_POST['rdtrack_total'];
	$pref['rdtrack_spent']    = $_POST['rdtrack_spent'];
	$pref['rdtrack_showcurrent'] = $_POST['rdtrack_showcurrent'];
	$pref['rdtrack_showibalance']= $_POST['rdtrack_showibalance'];
	$pref['rdtrack_showleft']    = $_POST['rdtrack_showleft'];
	$pref['rdtrack_showgoal']    = $_POST['rdtrack_showgoal'];
	$pref['rdtrack_showdue']     = $_POST['rdtrack_showdue'];
	$pref['rdtrack_showtotal']   = $_POST['rdtrack_showtotal'];
	$pref['rdtrack_showspent']   = $_POST['rdtrack_showspent'];
	$pref['rdtrack_showlist']    = $_POST['rdtrack_showlist'];
	$pref['rdtrack_ibalance']    = $_POST['rdtrack_ibalance'];
	$pref['rdtrack_showbalance'] = $_POST['rdtrack_showbalance'];
	$pref['rdtrack_dformat']     = $_POST['rdtrack_dformat'];
        $pref['rdtrack_description'] = $tp -> toDB($_POST['data']);
	save_prefs();

	$message = "".LAN_TRACK_03."";
}
if(!isset($pref['rdtrack_description'])) {
   $pref['rdtrack_description'] = LAN_TRACK_17;
}
$_POST['data'] = $tp->toForm($pref['rdtrack_description']);
//$pref['rdtrack_ibalance'] = 0;
//$pref['rdtrack_showibalance']= 0;
if (isset($message)) {
  $ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

$text = $script."
<div style='text-align:center'>
<form method='post' action='".e_SELF."' id='tracker_form'>
<table style='width:95%' class='fborder'>
<tr>
<td class='forumheader' colspan='2'>".LAN_TRACK_12."</td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_02."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_12."</span></td>
<td style='width:40%' class='forumheader3'>".$pref['rdtrack_currency'] //debug help = show $pref['rdtrack_currency']
// change html entities by there real values. this file is UTF-8 encoded
."
<select class='tbox' name='rdtrack_currency'>
<option ".(($pref['rdtrack_currency'] == '¥')  ? " selected ='selected'" : "")." value='¥'>¥ - Japanese Yen</option>
<option ".(($pref['rdtrack_currency'] == 'C$') ? " selected ='selected'" : "")." value='C$'>C$ - Canadian Dollar</option>
<option ".(($pref['rdtrack_currency'] == '€')  ? " selected='selected'" : "")." value='€'>€ - Euro</option>
<option ".(($pref['rdtrack_currency'] == '$')  ? " selected  ='selected'" : "")." value='$'>$ - US Dollar</option>
<option ".(($pref['rdtrack_currency'] == '£')  ? " selected ='selected'" : "")." value='£'>£ - Great Britain Pound</option>
<option ".(($pref['rdtrack_currency'] == 'Kr')  ? " selected ='selected'" : "")." value='Kr'>Kr - Dansk Krone</option>
<option ".(($pref['rdtrack_currency'] == 'AU$')  ? " selected ='selected'" : "")." value='AU$'>AU$ - Australian Dollar</option>
<option ".(($pref['rdtrack_currency'] == 'Kc')  ? " selected ='selected'" : "")." value='Kc'>Kc - Czech Koruna</option>
<option ".(($pref['rdtrack_currency'] == 'Ft')  ? " selected ='selected'" : "")." value='Ft'>Ft - Hungarian Forint</option>
<option ".(($pref['rdtrack_currency'] == 'kr')  ? " selected ='selected'" : "")." value='kr'>kr - Norwegian Krone</option>
<option ".(($pref['rdtrack_currency'] == 'kr')  ? " selected ='selected'" : "")." value='kr'>kr - Swedish Krona</option>
<option ".(($pref['rdtrack_currency'] == 'Zl')  ? " selected ='selected'" : "")." value='Zl'>Zl - Polish Zloty</option>
</select>
</td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_07."</b><br />
 <br /><span class='smalltext'>".LAN_TRACK_CONFIG_17."</span></td>
<td style='width:40%' class='forumheader3'>
".$pref['rdtrack_currency']." <input  style='width:100px' class='tbox' type='text' name='rdtrack_goal' value='".$pref['rdtrack_goal']."' />
</td>
<td style='width:10%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showgoal'".($pref['rdtrack_showgoal'] ? " checked" : "")."></td>
</tr>

<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_29."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_30."</span></td>
<td style='width:40%' class='forumheader3'>
".$pref['rdtrack_currency']." <input  style='width:100px' class='tbox' type='text' name='rdtrack_ibalance' value='".$pref['rdtrack_ibalance']."' />
</td>
<td style='width:10%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showibalance'".($pref['rdtrack_showibalance'] ? " checked" : "")."></td>
</tr>

<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_31."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_32."</span></td>
<td style='width:40%' class='forumheader3'>
"
.r_userclass('rdtrack_showbalance',$pref['rdtrack_showbalance']).
"
</td>

</tr>

<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_08."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_18."</span></td>
<td style='width:40%' class='forumheader3'>
".$pref['rdtrack_currency']." <input  style='width:100px' class='tbox' type='text' name='rdtrack_current' value='".$pref['rdtrack_current']."' />
</td>
<td style='width:10%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showcurrent'".($pref['rdtrack_showcurrent'] ? " checked" : "")."></td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_09."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_19."</span></td>
<td style='width:40%' class='forumheader3'>".$rs -> form_text("date1", 15, $pref['rdtrack_due'], 15,"tbox","","","","date1")." <a href='#' id='f-calendar-trigger-1'><img style='border: 0px none ; vertical-align: middle;' src='../../e107_handlers/calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date1','button':'f-calendar-trigger-1'});</script>
 ".LAN_TRACK_CONFIG_34.": <select name='rdtrack_dformat' class='tbox'>
<option value='0' ".($pref['rdtrack_dformat']==0?"selected='selected'":"")." >dd/MM/YYYY</option>
<option value='1' ".($pref['rdtrack_dformat']==1?"selected='selected'":"")." >dd/MM</option>
<option value='2' ".($pref['rdtrack_dformat']==2?"selected='selected'":"")." >MM/dd</option>
<option value='3' ".($pref['rdtrack_dformat']==3?"selected='selected'":"")." >MM/dd/YYYY</option>
<option value='4' ".($pref['rdtrack_dformat']==4?"selected='selected'":"")." >YYYY/MM/dd</option>

<option value='5' ".($pref['rdtrack_dformat']==5?"selected='selected'":"")." >dd mmm YYYY</option>
<option value='6' ".($pref['rdtrack_dformat']==6?"selected='selected'":"")." >dd MMM YYYY</option>
<option value='7' ".($pref['rdtrack_dformat']==7?"selected='selected'":"")." >mmm dd YYYY</option>
<option value='8' ".($pref['rdtrack_dformat']==8?"selected='selected'":"")." >MMM dd YYYY</option>

<option value='9' ".($pref['rdtrack_dformat']==9?"selected='selected'":"")." >dth mmm YYYY</option>
<option value='10' ".($pref['rdtrack_dformat']==10?"selected='selected'":"")." >dth MMM YYYY</option>
<option value='11' ".($pref['rdtrack_dformat']==11?"selected='selected'":"")." >mmm dth YYYY</option>
<option value='12' ".($pref['rdtrack_dformat']==12?"selected='selected'":"")." >MMM dth YYYY</option>

<option value='13' ".($pref['rdtrack_dformat']==13?"selected='selected'":"")." >dd mmm </option>
<option value='14' ".($pref['rdtrack_dformat']==14?"selected='selected'":"")." >dd MMM </option>
<option value='15' ".($pref['rdtrack_dformat']==15?"selected='selected'":"")." >mmm dd </option>
<option value='16' ".($pref['rdtrack_dformat']==16?"selected='selected'":"")." >MMM dd </option>

<option value='17' ".($pref['rdtrack_dformat']==17?"selected='selected'":"")." >dth mmm </option>
<option value='18' ".($pref['rdtrack_dformat']==18?"selected='selected'":"")." >dth MMM </option>
<option value='19' ".($pref['rdtrack_dformat']==19?"selected='selected'":"")." >mmm dth </option>
<option value='20' ".($pref['rdtrack_dformat']==20?"selected='selected'":"")." >MMM dth </option>

<option value='21' ".($pref['rdtrack_dformat']==21?"selected='selected'":"")." >dd/MM/yy</option>
<option value='22' ".($pref['rdtrack_dformat']==22?"selected='selected'":"")." >yy/MM/dd</option>
<option value='23' ".($pref['rdtrack_dformat']==23?"selected='selected'":"")." >mm/dd/yy</option>

</select>

</td>
<td style='width:10%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showdue'".($pref['rdtrack_showdue'] ? " checked" : "")."></td>
</tr>

<tr>
<td colspan=2 style='width:100%' class='forumheader'>".LAN_TRACK_CONFIG_37."</td>
</tr>
<tr>
<td colspan=2 style='width:95%;margin-left:auto' class='forumheader3'>";

$insertjs = (!e_WYSIWYG) ? "rows='10' onselect='storeCaret(this);' onclick='storeCaret(this);' onkeyup='storeCaret(this);'": "rows='20' ";
//$_POST['data'] = $tp->toForm($_POST['data']);
$text .= "<textarea class='tbox' id='data' name='data' cols='80' style='width:100%' $insertjs>".(strstr($tp->post_toForm($_POST['data']), "[img]http") ? $tp->post_toForm($_POST['data']) : str_replace("[img]../", "[img]", $tp->post_toForm($_POST['data'])))."</textarea>";
$text .= display_help("helpb", 'news');

//Extended news form textarea
if(e_WYSIWYG){
   $ff_expand = "tinyMCE.execCommand('mceResetDesignMode')";
}
// Fixes Firefox issue with hidden wysiwyg textarea.
$text .= "
</td>
</tr>

<td colspan='2' style='text-align:center' class='forumheader' colspan='2'>
<input class='button' type='submit' name='updatesettings' value='".LAN_TRACK_04."' />
</td>
</tr>
<tr>
<td class='forumheader' colspan='2'>Visit the <a href='http://www.roofdog78.com/'>support forum</a></td>
</tr>
</table>
</form>
</div>
";
// <input  style='width:200px' class='tbox' type='text' name='rdtrack_due' value='".$pref['rdtrack_due']."' />
$ns->tablerender("".LAN_TRACK_00."", $text);
require_once(e_ADMIN."footer.php");
?>