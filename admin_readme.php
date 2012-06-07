<?php
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");

$pageid = 'admin_menu_05';

$text = "<pre>\n".file_get_contents(e_PLUGIN."anteup/README.mkd")."</pre>";

$ns->tablerender(LAN_TRACK_13, $text);
require_once(e_ADMIN."footer.php");
?>