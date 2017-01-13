<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if (!defined('e107_INIT')) { exit; }

$pref = e107::getPlugPref('anteup');

if(check_class($pref['anteup_menuviewclass']))
{
	require_once(e_PLUGIN."anteup/_class.php");
	e107::lan('anteup');
	$sc	= e107::getScBatch('anteup', true);
	$template = e107::getTemplate('anteup');
	$text = e107::getParser()->parseTemplate($template['menu'], false, $sc);

	e107::getRender()->tablerender($pref['anteup_mtitle'], $text, 'anteup');
}