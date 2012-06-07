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

require_once(e_ADMIN."auth.php");

if (!getperms("P")) {
	header("location:".e_BASE."index.php");
	exit;
}

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");

global $pageid;

$action = basename($_SERVER['PHP_SELF'], ".php");

$var['admin_menu_01']['text'] = LAN_TRACK_ADMENU_01;
$var['admin_menu_01']['link'] = "admin_config.php";

$var['admin_menu_02']['text'] = LAN_TRACK_ADMENU_02;
$var['admin_menu_02']['link'] = "admin_settings.php";

$var['admin_menu_03']['text'] = LAN_TRACK_ADMENU_03;
$var['admin_menu_03']['link'] = "admin_donate.php";

$var['admin_menu_04']['text'] = LAN_TRACK_ADMENU_04;
$var['admin_menu_04']['link'] = "admin_cash.php";

$var['admin_menu_05']['text'] = LAN_TRACK_ADMENU_05;
$var['admin_menu_05']['link'] = "admin_readme.php";

show_admin_menu(LAN_TRACK_ADMENU_03, $pageid, $var);
?>