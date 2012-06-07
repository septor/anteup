<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By roofdog78 & DelTree
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

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");

$caption = "".LAN_TRACK_THANKS_01."";
$img1 = e_PLUGIN."rdonation_tracker/images/admin/thankyou.gif";

$text = "
<center>
<table height='338' width='380' border='0' cellspacing='1' cellpadding='0'>
 <tr>
   <td height='338' width='380' background='".$img1."'>
   ".LAN_TRACK_THANKS_02."
   </td>
 </tr>
</table><br>
</center>";

$caption = $tp->toHtml($caption);
$text = $tp->toHtml($text);

$ns -> tablerender($caption, $text);
require_once(FOOTERF);
?>