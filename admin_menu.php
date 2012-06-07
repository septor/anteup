<?php
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");

global $pageid;

$action = basename($_SERVER['PHP_SELF'], ".php");

$var['admin_menu_01']['text'] = "Configuration";
$var['admin_menu_01']['link'] = "admin_config.php";

$var['admin_menu_04']['text'] = ANTELAN_AMENU_04;
$var['admin_menu_04']['link'] = "admin_cash.php";

$var['admin_menu_05']['text'] = ANTELAN_AMENU_05;
$var['admin_menu_05']['link'] = "admin_readme.php";

show_admin_menu(LAN_TRACK_ADMENU_03, $pageid, $var);
?>