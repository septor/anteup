<?php
require_once("../../class2.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit; }
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER.'userclass_class.php');
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");
require_once(e_PLUGIN."anteup/_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
$gen = new convert();

$script = "<script type='text/javascript' src='".e_PLUGIN."anteup/js/jscolor.js'></script>
<script type=\"text/javascript\">
function addtext_us(sc){
	document.getElementById('dataform').image.value = sc;
}
</script>
<script type='text/javascript'>
function addtext(sc){
	document.forms.paypal_donate_form.pal_button_image.value=sc;
}
</script>".$cal->load_files();
	
$pageid = 'admin_menu_01';

if(isset($_POST['updatesettings'])){
	if(!empty($_POST['anteup_due']) && !empty($_POST['anteup_goal'])){
		$pref['anteup_currency'] = $_POST['anteup_currency'];
		$pref['anteup_goal'] = $_POST['anteup_goal'];
		$pref['anteup_due'] = $_POST['anteup_due'];
		$pref['anteup_lastdue'] = $_POST['anteup_lastdue'];
		$pref['anteup_showcurrent'] = $_POST['anteup_showcurrent'];
		$pref['anteup_showibalance'] = $_POST['anteup_showibalance'];
		$pref['anteup_showleft'] = $_POST['anteup_showleft'];
		$pref['anteup_showgoal'] = $_POST['anteup_showgoal'];
		$pref['anteup_showdue'] = $_POST['anteup_showdue'];
		$pref['anteup_showtotal']  = $_POST['anteup_showtotal'];
		$pref['anteup_dformat'] = $_POST['anteup_dformat'];
		$pref['anteup_description'] = $tp -> toDB($_POST['data']);
		$pref['anteup_mtitle']   = $_POST['anteup_mtitle'];
		$pref['anteup_full']     = str_replace("#","",$_POST['anteup_full']);
		$pref['anteup_empty']    = str_replace("#","",$_POST['anteup_empty']);
		$pref['anteup_border']   = str_replace("#","",$_POST['anteup_border']);
		$pref['anteup_height']   = $_POST['anteup_height'];
		$pref['anteup_showbar']  = $_POST['anteup_showbar'];
		$pref['anteup_textbar']  = $_POST['anteup_textbar'];
		$pref['pal_button_image']   = $_POST['pal_button_image'];
		$pref['pal_business']       = $_POST['pal_business'];
		$pref['pal_item_name']      = $_POST['pal_item_name'];
		$pref['pal_key_private']    = md5(rand(0,rand(100,100000)).time());
		$pref['pal_no_shipping']    = $_POST['pal_no_shipping'];
		$pref['pal_no_note']        = $_POST['pal_no_note'];
		$pref['pal_cn']             = $_POST['pal_cn'];
		$pref['pal_page_style']     = $_POST['pal_page_style'];
		$pref['pal_lc']             = $_POST['pal_lc'];
		$pref['pal_item_number']    = $_POST['pal_item_number'];
		$pref['pal_custom']         = $_POST['pal_custom'];
		$pref['pal_invoice']        = $_POST['pal_invoice'];
		$pref['pal_amount']         = $_POST['pal_amount'];
		$pref['pal_tax']            = $_POST['pal_tax'];
		save_prefs();
		$message = LAN_TRACK_03;
	}else{
		$message = "You are required to set a due date and a goal amount.";
	}
}

if(!isset($pref['anteup_description'])) {
   $pref['anteup_description'] = LAN_TRACK_17;
}
$_POST['data'] = $tp->toForm($pref['anteup_description']);

if(isset($message)){ $ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>"); }

$text = $script."
<div style='text-align:center'>
<form method='post' action='".e_SELF."' id='tracker_form'>";

$currency_dropbox = "<select class='tbox' name='anteup_currency'>";
$sql->db_Select("anteup_currency", "*");
while($row = $sql->db_Fetch()){
	$currency_dropbox .= "<option value='".$row['id']."'".($row['id'] == $pref['anteup_currency'] ? " selected" : "").">".$row['description']." (".$row['symbol'].")</option>";
}
$currency_dropbox .= "</select>";

$format_dropbox = "<select name='anteup_dformat' class='tbox'>";
foreach(array('long', 'short', 'forum') as $format){
	$format_dropbox .= "<option value='".$format."'".($format == $pref['anteup_dformat'] ? " selected" : "").">".$gen->convert_date(time(), $format)." (".$format.")</option>";
}
$format_dropbox .= "</select>";

$locale_dropbox = "<select name='pal_lc' class='tbox'>";
foreach(array("default", "AT", "AU", "BE", "C2", "CH", "CN", "DE", "ES", "FR", "GB", "GF", "GI", "GP", "IE", "IT", "JP", "MQ", "NL", "PL", "RE", "US") as $locale){
	$locale_dropbox .= "<option value='".$locale."'".($locale == $pref['pal_lc'] ? " selected" : "").">".$locale."</option>";
}
$locale_dropbox .= "</select>";

$donate_icon_div = "<div style='display:none'>";
foreach(glob(e_PLUGIN."anteup/images/icons/*.gif") as $icon){
	$icon = str_replace(e_PLUGIN."anteup/images/icons/", "", $icon);
	$donate_icon_div .= " <a href='javascript:addtext(\"$icon\")'><img src='".e_PLUGIN."anteup/images/icons/".$icon."' /></a>";
}
$donate_icon_div .= "</div>";

$text .= "<input class='button' type='submit' name='updatesettings' value='".LAN_TRACK_04."' />
<br />
<div onclick='expandit(\"config\");' class='fcaption' style='cursor: pointer;'>General Configuration</div>
<table style='width:85%; display:none;' class='fborder' id='config'>
	".config_block($currency_dropbox, LAN_TRACK_CONFIG_02, LAN_TRACK_CONFIG_12)."
	".config_block(format_currency("<input class='tbox' type='text' name='anteup_goal' value='".$pref['anteup_goal']."' />", $pref['anteup_currency'], false), "Goal Donation Amount:", "The amount of money you are requesting.")."
	".config_block("<a href='#' id='f-calendar-trigger-1'>".CALENDAR_IMG."</a> <input class='tbox' type='text' id='anteup_due' name='anteup_due' value='".$pref['anteup_due']."' />\n<script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'anteup_due','button':'f-calendar-trigger-1'});</script>", LAN_TRACK_CONFIG_09, LAN_TRACK_CONFIG_19)."
	".config_block($format_dropbox, "Date Format:", "Format you would like dates to be displayed on the plugin.")."
	".config_block("<textarea class='tbox' style='width:200px; height:140px' name='anteup_textbar'>".(strstr($tp->post_toForm($_POST['data']), "[img]http") ? $tp->post_toForm($_POST['data']) : str_replace("[img]../", "[img]", $tp->post_toForm($_POST['data'])))."</textarea>", "Donation Request Blurb:")."
</table>

<div onclick='expandit(\"showhide\");' class='fcaption' style='cursor: pointer;'>Item Display Configuration</div>
<table style='width:85%; display:none;' class='fborder' id='showhide'>
	".config_block("<input class='tbox' type='checkbox' name='anteup_showibalance'".($pref['anteup_showibalance'] ? " checked" : "").">", "Show initial balance?", "This will show your balance prior to the current due date.")."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showcurrent'".($pref['anteup_showcurrent'] ? " checked" : "").">", LAN_TRACK_CONFIG_08, LAN_TRACK_CONFIG_18)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showtotal'".($pref['anteup_showtotal'] ? " checked" : "").">", "Show total balance?", "Display your entire donation balance?")."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showgoal'".($pref['anteup_showgoal'] ? " checked" : "").">", "Show goal amount?")."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showdue'".($pref['anteup_showdue'] ? " checked" : "").">", "Show due date?", "Display the date in which you wish all donations to be in by.")."
</table>

<div onclick='expandit(\"menu\");' class='fcaption' style='cursor: pointer;'>Menu Configuration</div>
<table style='width:85%; display:none;' class='fborder' id='menu'>
	".config_block("<input class='tbox' type='text' name='anteup_mtitle' value='".$pref['anteup_mtitle']."'>", LAN_TRACK_CONFIG_01, LAN_TRACK_CONFIG_11)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showbar'".($pref['anteup_showbar'] ? " checked" : "").">", LAN_TRACK_CONFIG_21, LAN_TRACK_CONFIG_22)."
	".config_block("<textarea class='tbox' style='width:200px; height:140px' name='anteup_textbar'>".$pref['anteup_textbar']."</textarea>", LAN_TRACK_CONFIG_33, LAN_TRACK_CONFIG_20)."
	".config_block("#<input class='tbox jscolor' type='text' name='anteup_full' value='".$pref['anteup_full']."' />", LAN_TRACK_CONFIG_03, LAN_TRACK_CONFIG_13)."
	".config_block("#<input class='tbox jscolor' type='text' name='anteup_empty' value='".$pref['anteup_empty']."' />", LAN_TRACK_CONFIG_04, LAN_TRACK_CONFIG_14)."
	".config_block("#<input class='tbox jscolor' type='text' name='anteup_border' value='".$pref['anteup_border']."' />", LAN_TRACK_CONFIG_05, LAN_TRACK_CONFIG_15)."
	".config_block("<input class='tbox' type='text' name='anteup_height' value='".$pref['anteup_height']."' />", LAN_TRACK_CONFIG_06, LAN_TRACK_CONFIG_16)."
</table>

<div onclick='expandit(\"paypal\");' class='fcaption' style='cursor: pointer;'>PayPal Configutation</div>
<table style='width:85%; display:none;' class='fborder' id='paypal'>
<tr>
<td class='forumheader' colspan='2'>".LAN_TRACK_01."</td>
</tr>
	".config_block("<input class='tbox' style='width:200px' type='text' name='pal_button_image' value='".$pref['pal_button_image']."' /> <input class='button' type='button' value='".LAN_TRACK_PAL_05."' onclick='expandit(this)' />".$donate_icon_div , LAN_TRACK_PAL_03, LAN_TRACK_PAL_04)."
	".config_block("<input class='tbox' type='text' name='pal_business' value='".$pref['pal_business']."' />", LAN_TRACK_PAL_09, LAN_TRACK_PAL_10)."
	".config_block("<input class='tbox' type='text' name='pal_item_name' value='".$pref['pal_item_name']."' maxlength='127' />", LAN_TRACK_PAL_11, LAN_TRACK_PAL_12)."
<tr>
<td class='forumheader' colspan='2'>".LAN_TRACK_08."</td>
</tr>
	".config_block("<input class='tbox' type='checkbox' name='pal_no_shipping'".($pref['pal_no_shipping'] ? " checked" : "").">", LAN_TRACK_PAL_17, LAN_TRACK_PAL_18)."
	".config_block("<input class='tbox' type='checkbox' name='pal_no_note'".($pref['pal_no_note'] ? " checked" : "").">", LAN_TRACK_PAL_19, LAN_TRACK_PAL_20)."
	".config_block("<input class='tbox' type='text' name='pal_cn' value='".$pref['pal_cn']."' maxlength='30' />", LAN_TRACK_PAL_21, LAN_TRACK_PAL_22)."
	".config_block("<input class='tbox' type='text' name='pal_page_style' value='".$pref['pal_page_style']."' maxlength='127' />", LAN_TRACK_PAL_27, LAN_TRACK_PAL_28)."
<tr>
<td class='forumheader' colspan='2'>".LAN_TRACK_09."</td>
</tr>
	".config_block($locale_dropbox, LAN_TRACK_PAL_29, LAN_TRACK_PAL_30)."
	".config_block("<input class='tbox' type='text' name='pal_item_number' value='".$pref['pal_item_number']."' maxlength='127' />", LAN_TRACK_PAL_31, LAN_TRACK_PAL_32)."
	".config_block("<input class='tbox' type='text' name='pal_custom' value='".$pref['pal_custom']."' maxlength='127' />", LAN_TRACK_PAL_33, LAN_TRACK_PAL_34)."
	".config_block("<input class='tbox' type='text' name='pal_invoice' value='".$pref['pal_invoice']."' maxlength='127' />", LAN_TRACK_PAL_35, LAN_TRACK_PAL_36)."
	".config_block("<input class='tbox' type='text' name='pal_amount' value='".$pref['pal_amount']."' />", LAN_TRACK_PAL_37, LAN_TRACK_PAL_38)."
	".config_block("<input class='tbox' type='text' name='pal_tax' value='".$pref['pal_tax']."' />", LAN_TRACK_PAL_39, LAN_TRACK_PAL_40)."
</table>
<input class='button' type='submit' name='updatesettings' value='".LAN_TRACK_04."' />
<input type='hidden' value='".$pref['anteup_due']." name='anteup_lastdue' />
</form>
</div>
";

$ns->tablerender(LAN_TRACK_00, $text);
require_once(e_ADMIN."footer.php");
?>