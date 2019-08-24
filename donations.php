<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if(!defined('e107_INIT'))
{
	require_once('../../class2.php');
}
e107::lan('anteup');
define('PAGE_NAME', LAN_ANTEUP_DONATIONS_TITLE);

require_once(HEADERF);
require_once(e_PLUGIN."anteup/_class.php");

$pref = e107::getPlugPref('anteup');
$mes = e107::getMessage(); 

if(check_class($pref['anteup_pageviewclass']))
{
	if(isset($_POST['filterDates']))
	{
		$startDate 	= (int) $_POST['startDate'];
		$endDate 	= (int) $_POST['endDate'];
	}
	else
	{
		$startDate 	= $pref['anteup_lastdue'];
		$endDate 	= $pref['anteup_due'];
	}

	$sql = e107::getDb();
	$tp = e107::getParser();
	$sc = e107::getScBatch('anteup', true);
	$frm = e107::getForm();
	$template = e107::getTemplate('anteup');
	$template = array_change_key_case($template);

	$sc->setVars(array($startDate, $endDate));
	$text = $tp->parseTemplate($template['donations']['filter'], false, $sc);


	$entries = $sql->retrieve('anteup_ipn', '*', 'payment_date > '.$startDate.' AND payment_date < '.$endDate, true);
	
	if($entries)
	{
		$text .= $tp->parseTemplate($template['donations']['start'], false, $sc);
		foreach($entries as $entry)
		{
			$sc->setVars($entry);
			$text .= $tp->parseTemplate($template['donations']['entry'], false, $sc);
		}
		$text .= $tp->parseTemplate($template['donations']['end'], false, $sc);
	}
	else
	{
		$mes->addInfo(LAN_ANTEUP_DONATIONS_07);
	}
}
else
{
	$mes->addWarning(LAN_ANTEUP_DONATIONS_08); 
}

e107::getRender()->tablerender(LAN_ANTEUP_DONATIONS_TITLE, $mes->render().$text);
require_once(FOOTERF);