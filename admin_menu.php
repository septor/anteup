<?php
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");

global $pageid;

$action = basename($_SERVER['PHP_SELF'], ".php");

$var['admin_menu_01']['text'] = ANTELAN_MMENU_01;
$var['admin_menu_01']['link'] = "admin_config.php";

$var['admin_menu_04']['text'] = ANTELAN_MMENU_02;
$var['admin_menu_04']['link'] = "admin_cash.php";

$var['admin_menu_05']['text'] = ANTELAN_MMENU_03;
$var['admin_menu_05']['link'] = "admin_readme.php";

show_admin_menu(ANTELAN_MMENU_00, $pageid, $var);
?>