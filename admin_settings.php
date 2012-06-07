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

// new language call method
include_lan(e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php");

$pageid = 'admin_menu_02';

if (isset($_POST['updatesettings'])) 
{
	$pref['rdtrack_mtitle']   = $_POST['rdtrack_mtitle'];
	$pref['rdtrack_full']     = str_replace("#","",$_POST['rdtrack_full']);
	$pref['rdtrack_empty']    = str_replace("#","",$_POST['rdtrack_empty']);
	$pref['rdtrack_border']   = str_replace("#","",$_POST['rdtrack_border']);
	$pref['rdtrack_height']   = $_POST['rdtrack_height'];
	$pref['rdtrack_showbar']  = $_POST['rdtrack_showbar'];
        $pref['rdtrack_showlist'] = $_POST['rdtrack_showlist'];
	$pref['rdtrack_showdate'] = $_POST['rdtrack_showdate'];
	$pref['rdtrack_showvalue']= $_POST['rdtrack_showvalue'];
	$pref['rdtrack_textbar']  = $_POST['rdtrack_textbar'];

	save_prefs();
	
	$message = "".LAN_TRACK_03."";
}

if (isset($message)) 
{
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

$text = "
<script language='JavaScript' src='".e_PLUGIN."rdonation_tracker/picker.js'></script>
<div style='text-align:center'>
<form method='post' action='".e_SELF."' name='menu_conf_form'>
<table style='width:95%' class='fborder'>
<tr>
<td class='forumheader' colspan='2'>".LAN_TRACK_15."</td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_01."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_11."</span></td>
<td style='width:40%' class='forumheader3'>
<input  style='width:200px' class='tbox' type='text' name='rdtrack_mtitle' value='".$pref['rdtrack_mtitle']."'>
</td>
</tr>

<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_21."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_22."</span></td>
<td style='width:40%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showbar'".($pref['rdtrack_showbar'] ? " checked" : "")."></td>
</tr>

<tr>
  <td class='forumheader3' style='width:60%;vertical-align:top'><b>".LAN_TRACK_CONFIG_33."</b><br />
    <br /><span class='smalltext'>".LAN_TRACK_CONFIG_20."</span>
  </td>
  <td class='forumheader3' style='width:40%'>
    <textarea class='tbox' style='width:200px; height:140px' cols='25' rows='5' name='rdtrack_textbar'>".$pref['rdtrack_textbar']."</textarea>
  </td>
</tr>

<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_35."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_36."</span></td>
<td style='width:40%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showlist'".($pref['rdtrack_showlist'] ? " checked" : "")."></td>
</tr>

<tr>
<td style='width:80%;vertical-align:top' class='forumheader3'><b>Display the donor's dates?</b><br />
			<br /><span class='smalltext'>Uncheck to not display the donation's dates.</span></td>
<td style='width:20%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showdate'".($pref['rdtrack_showdate'] ? " checked" : "")."></td>
</tr>

<tr>
<td style='width:80%;vertical-align:top' class='forumheader3'><b>Display the donor's values?</b><br />
			<br /><span class='smalltext'>Uncheck to not display the donation's values.</span></td>
<td style='width:20%' class='forumheader3'><input class='tbox' type='checkbox' name='rdtrack_showvalue'".($pref['rdtrack_showvalue'] ? " checked" : "")."></td>
</tr>

<tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_03."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_13."</span></td>
<td style='width:40%' class='forumheader3'>
# <input  style='width:100px' class='tbox' type='text' name='rdtrack_full' value='".$pref['rdtrack_full']."' /> <a href='javascript:TCP.popup(document.forms[\"menu_conf_form\"].elements[\"rdtrack_full\"])'><img width='15' height='13' border='0' alt='".LAN_TRACK_CONFIG_03."' src='".e_PLUGIN."rdonation_tracker/images/admin/sel.gif'></a>
</td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_04."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_14."</span></td>
<td style='width:40%' class='forumheader3'>
# <input  style='width:100px' class='tbox' type='text' name='rdtrack_empty' value='".$pref['rdtrack_empty']."' /> <a href='javascript:TCP.popup(document.forms[\"menu_conf_form\"].elements[\"rdtrack_empty\"])'><img width='15' height='13' border='0' alt='".LAN_TRACK_CONFIG_04."' src='".e_PLUGIN."rdonation_tracker/images/admin/sel.gif'></a>
</td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_05."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_15."</span></td>
<td style='width:40%' class='forumheader3'>
# <input  style='width:100px' class='tbox' type='text' name='rdtrack_border' value='".$pref['rdtrack_border']."' /> <a href='javascript:TCP.popup(document.forms[\"menu_conf_form\"].elements[\"rdtrack_border\"])'><img width='15' height='13' border='0' alt='".LAN_TRACK_CONFIG_05."' src='".e_PLUGIN."rdonation_tracker/images/admin/sel.gif'></a>
</td>
</tr>
<tr>
<td style='width:60%;vertical-align:top' class='forumheader3'><b>".LAN_TRACK_CONFIG_06."</b><br />
			<br /><span class='smalltext'>".LAN_TRACK_CONFIG_16."</span></td>
<td style='width:40%' class='forumheader3'>
<input  style='width:100px' class='tbox' type='text' name='rdtrack_height' value='".$pref['rdtrack_height']."' />
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

$ns->tablerender("".LAN_TRACK_00."", $text);
require_once(e_ADMIN."footer.php");
?>