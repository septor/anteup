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
	
$pageid = "admin_menu_01";

if(isset($_POST['updatesettings'])){
	if(!empty($_POST['anteup_due']) && !empty($_POST['anteup_goal'])){
		$pref['anteup_currency'] 		= $_POST['anteup_currency'];
		$pref['anteup_goal'] 			= $_POST['anteup_goal'];
		$pref['anteup_due'] 			= $_POST['anteup_due'];
		$pref['anteup_lastdue'] 		= $_POST['anteup_lastdue'];
		$pref['anteup_showcurrent'] 	= $_POST['anteup_showcurrent'];
		$pref['anteup_showibalance']	= $_POST['anteup_showibalance'];
		$pref['anteup_showleft'] 		= $_POST['anteup_showleft'];
		$pref['anteup_showgoal'] 		= $_POST['anteup_showgoal'];
		$pref['anteup_showdue'] 		= $_POST['anteup_showdue'];
		$pref['anteup_showtotal']  		= $_POST['anteup_showtotal'];
		$pref['anteup_dformat'] 		= $_POST['anteup_dformat'];
		$pref['anteup_description'] 	= $tp->toDB($_POST['anteup_description']);
		$pref['anteup_mtitle']   		= $_POST['anteup_mtitle'];
		$pref['anteup_full']     		= str_replace("#","",$_POST['anteup_full']);
		$pref['anteup_empty']    		= str_replace("#","",$_POST['anteup_empty']);
		$pref['anteup_border']   		= str_replace("#","",$_POST['anteup_border']);
		$pref['anteup_height']   		= $_POST['anteup_height'];
		$pref['anteup_showbar']  		= $_POST['anteup_showbar'];
		$pref['anteup_textbar']  		= $_POST['anteup_textbar'];
		$pref['pal_button_image']   	= $_POST['pal_button_image'];
		$pref['pal_business']       	= $_POST['pal_business'];
		$pref['pal_item_name']      	= $_POST['pal_item_name'];
		$pref['pal_key_private']    	= md5(rand(0,rand(100,100000)).time());
		$pref['pal_no_shipping']    	= $_POST['pal_no_shipping'];
		$pref['pal_no_note']        	= $_POST['pal_no_note'];
		$pref['pal_cn']             	= $_POST['pal_cn'];
		$pref['pal_page_style']     	= $_POST['pal_page_style'];
		$pref['pal_lc']            		= $_POST['pal_lc'];
		$pref['pal_item_number']    	= $_POST['pal_item_number'];
		$pref['pal_custom']         	= $_POST['pal_custom'];
		$pref['pal_invoice']        	= $_POST['pal_invoice'];
		$pref['pal_amount']         	= $_POST['pal_amount'];
		$pref['pal_tax']            	= $_POST['pal_tax'];
			save_prefs();
		$message = ANTELAN_CONFIG_02;
	}else{
		$message = ANTELAN_CONFIG_03;
	}
}

if(!isset($pref['anteup_description'])) {
   $pref['anteup_description'] = LAN_TRACK_17;
}
$_POST['data'] = $tp->toForm($pref['anteup_description']);

if(isset($message)){ $ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>"); }

$text = $cal->load_files()."
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

$donate_icon_div = "<select class='tbox' name='icon'>";
foreach(glob(e_PLUGIN."anteup/images/icons/*.gif") as $icon){
	$icon = str_replace(e_PLUGIN."anteup/images/icons/", "", $icon);
	$donate_icon_div .= "<option value='".$icon."'>".$icon."</option>";
}
$donate_icon_div .= "</select>";

$donate_icon_div = "<select class='tbox' name='icon'>";
foreach(glob(e_PLUGIN."anteup/images/icons/*.gif") as $icon){
	$icon = str_replace(e_PLUGIN."anteup/images/icons/", "", $icon);
	$donate_icon_div .= "<option value='".$icon."'".($icon == $pref['pal_button_image'] ? " selected" : "").">".$icon."</option>";
}
$donate_icon_div .= "</select>";


$text .= "<input class='button' type='submit' name='updatesettings' value='".ANTELAN_CONFIG_01."' />
<br />
<div onclick='expandit(\"config\");' class='fcaption' style='cursor: pointer;'>".ANTELAN_CONFIG_CAPTION01."</div>
<table style='width:85%; display:none;' class='fborder' id='config'>
	".config_block($currency_dropbox, ANTELAN_CONFIG_G_01, ANTELAN_CONFIG_G_02)."
	".config_block(format_currency("<input class='tbox' type='text' name='anteup_goal' value='".$pref['anteup_goal']."' />", $pref['anteup_currency'], false), ANTELAN_CONFIG_G_03, ANTELAN_CONFIG_G_04)."
	".config_block("<a href='#' id='f-calendar-trigger-1'>".CALENDAR_IMG."</a> <input class='tbox' type='text' id='anteup_due' name='anteup_due' value='".$pref['anteup_due']."' />\n<script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'anteup_due','button':'f-calendar-trigger-1'});</script>", ANTELAN_CONFIG_G_05, ANTELAN_CONFIG_G_06)."
	".config_block($format_dropbox, ANTELAN_CONFIG_G_07, ANTELAN_CONFIG_G_08)."
	".config_block("<textarea class='tbox' style='width:200px; height:140px' name='anteup_description'>".(strstr($tp->post_toForm($pref['anteup_description']), "[img]http") ? $tp->post_toForm($pref['anteup_description']) : str_replace("[img]../", "[img]", $tp->post_toForm($pref['anteup_description'])))."</textarea>", ANTELAN_CONFIG_G_09, ANTELAN_CONFIG_G_10)."
</table>
<br />
<div onclick='expandit(\"showhide\");' class='fcaption' style='cursor: pointer;'>".ANTELAN_CONFIG_CAPTION02."</div>
<table style='width:85%; display:none;' class='fborder' id='showhide'>
	".config_block("<input class='tbox' type='checkbox' name='anteup_showibalance'".($pref['anteup_showibalance'] ? " checked" : "").">", ANTELAN_CONFIG_I_01, ANTELAN_CONFIG_I_02)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showcurrent'".($pref['anteup_showcurrent'] ? " checked" : "").">", ANTELAN_CONFIG_I_03, ANTELAN_CONFIG_I_04)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showtotal'".($pref['anteup_showtotal'] ? " checked" : "").">", ANTELAN_CONFIG_I_05, ANTELAN_CONFIG_I_06)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showgoal'".($pref['anteup_showgoal'] ? " checked" : "").">", ANTELAN_CONFIG_I_07, ANTELAN_CONFIG_I_08)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showdue'".($pref['anteup_showdue'] ? " checked" : "").">", ANTELAN_CONFIG_I_09, ANTELAN_CONFIG_I_10)."
</table>
<br />
<div onclick='expandit(\"menu\");' class='fcaption' style='cursor: pointer;'>".ANTELAN_CONFIG_CAPTION03."</div>
<table style='width:85%; display:none;' class='fborder' id='menu'>
	".config_block("<input class='tbox' type='text' name='anteup_mtitle' value='".$pref['anteup_mtitle']."'>", ANTELAN_CONFIG_M_01, ANTELAN_CONFIG_M_02)."
	".config_block("<input class='tbox' type='checkbox' name='anteup_showbar'".($pref['anteup_showbar'] ? " checked" : "").">", ANTELAN_CONFIG_M_03, ANTELAN_CONFIG_M_04)."
	".config_block("<textarea class='tbox' style='width:200px; height:140px' name='anteup_textbar'>".$pref['anteup_textbar']."</textarea>", ANTELAN_CONFIG_M_05, ANTELAN_CONFIG_M_06)."
	".config_block("#<input class='tbox jscolor' type='text' name='anteup_full' value='".$pref['anteup_full']."' />", ANTELAN_CONFIG_M_07, ANTELAN_CONFIG_M_08)."
	".config_block("#<input class='tbox jscolor' type='text' name='anteup_empty' value='".$pref['anteup_empty']."' />", ANTELAN_CONFIG_M_09, ANTELAN_CONFIG_M_10)."
	".config_block("#<input class='tbox jscolor' type='text' name='anteup_border' value='".$pref['anteup_border']."' />", ANTELAN_CONFIG_M_11, ANTELAN_CONFIG_M_12)."
	".config_block("<input class='tbox' type='text' name='anteup_height' value='".$pref['anteup_height']."' />", ANTELAN_CONFIG_M_13, ANTELAN_CONFIG_M_14)."
</table>
<br />
<div onclick='expandit(\"paypal\");' class='fcaption' style='cursor: pointer;'>".ANTELAN_CONFIG_CAPTION04."</div>
<table style='width:85%; display:none;' class='fborder' id='paypal'>
<tr>
<td class='forumheader' colspan='2'>".ANTELAN_CONFIG_P_C_01."</td>
</tr>
	".config_block($donate_icon_div , ANTELAN_CONFIG_P_01, ANTELAN_CONFIG_P_02)."
	".config_block("<input class='tbox' type='text' name='pal_business' value='".$pref['pal_business']."' />", ANTELAN_CONFIG_P_03, ANTELAN_CONFIG_P_04)."
	".config_block("<input class='tbox' type='text' name='pal_item_name' value='".$pref['pal_item_name']."' maxlength='127' />", ANTELAN_CONFIG_P_05, ANTELAN_CONFIG_P_06)."
<tr>
<td class='forumheader' colspan='2'>".ANTELAN_CONFIG_P_C_02."</td>
</tr>
	".config_block("<input class='tbox' type='checkbox' name='pal_no_shipping'".($pref['pal_no_shipping'] ? " checked" : "").">",ANTELAN_CONFIG_P_07, ANTELAN_CONFIG_P_08)."
	".config_block("<input class='tbox' type='checkbox' name='pal_no_note'".($pref['pal_no_note'] ? " checked" : "").">", ANTELAN_CONFIG_P_09, ANTELAN_CONFIG_P_10)."
	".config_block("<input class='tbox' type='text' name='pal_cn' value='".$pref['pal_cn']."' maxlength='30' />", ANTELAN_CONFIG_P_11, ANTELAN_CONFIG_P_12)."
	".config_block("<input class='tbox' type='text' name='pal_page_style' value='".$pref['pal_page_style']."' maxlength='127' />", ANTELAN_CONFIG_P_13, ANTELAN_CONFIG_P_14)."
<tr>
<td class='forumheader' colspan='2'>".ANTELAN_CONFIG_P_C_03."</td>
</tr>
	".config_block($locale_dropbox, ANTELAN_CONFIG_P_15, ANTELAN_CONFIG_P_16)."
	".config_block("<input class='tbox' type='text' name='pal_item_number' value='".$pref['pal_item_number']."' maxlength='127' />", ANTELAN_CONFIG_P_17, ANTELAN_CONFIG_P_18)."
	".config_block("<input class='tbox' type='text' name='pal_custom' value='".$pref['pal_custom']."' maxlength='127' />", ANTELAN_CONFIG_P_19, ANTELAN_CONFIG_P_20)."
	".config_block("<input class='tbox' type='text' name='pal_invoice' value='".$pref['pal_invoice']."' maxlength='127' />", ANTELAN_CONFIG_P_21, ANTELAN_CONFIG_P_22)."
	".config_block("<input class='tbox' type='text' name='pal_amount' value='".$pref['pal_amount']."' />", ANTELAN_CONFIG_P_23, ANTELAN_CONFIG_P_24)."
	".config_block("<input class='tbox' type='text' name='pal_tax' value='".$pref['pal_tax']."' />", ANTELAN_CONFIG_P_25, ANTELAN_CONFIG_P_26)."
</table>
<input class='button' type='submit' name='updatesettings' value='".ANTELAN_CONFIG_01."' />
<input type='hidden' value='".$pref['anteup_due']." name='anteup_lastdue' />
</form>
</div>
";

$ns->tablerender(ANTELAN_CONFIG_CAPTION00, $text);
require_once(e_ADMIN."footer.php");
?>