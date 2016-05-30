<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if (!defined('e107_INIT')) { exit; }
if(check_class(e107::pref('anteup', 'anteup_menuviewclass')))
{
	require_once(e_PLUGIN."anteup/_class.php");
	e107::lan('anteup');
	$tp	= e107::getParser();
	$sc	= e107::getScBatch('anteup', true);
	$template = e107::getTemplate('anteup');
	$text = $tp->parseTemplate($template['menu'], false, $sc);

	$caption = e107::pref('anteup', 'anteup_mtitle');

	if($caption == "LAN_ANTEUP_MENU_TITLE")
	{
		$caption = LAN_ANTEUP_MENU_TITLE;
	}	
	else
	{
		$caption = $caption;
	}

	e107::getRender()->tablerender($caption, $text, 'anteup');
}