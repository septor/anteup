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

$pageid = 'admin_menu_05';

$filename = LAN_TRACK_13;
$text = file_get_contents(strtolower($filename));
$text = $tp->toHTML($text, TRUE);

$caption = LAN_TRACK_13;
$ns->tablerender($caption, $text);
require_once(e_ADMIN."footer.php");

?>