<?php
/* 
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
require_once("../../class2.php");
require_once(HEADERF);
require_once(e_PLUGIN."anteup/_class.php");
e107::lan('anteup');
$pref = e107::pref('anteup');

if(check_class($pref['anteup_pageviewclass']))
{
	if(isset($_POST['filterDates']))
	{
		$startDate = strtotime($_POST['startDate']);
		$endDate = strtotime($_POST['endDate']);
	}
	else
	{
		$startDate = strtotime($pref['anteup_lastdue']);
		$endDate = strtotime($pref['anteup_due']);
	}

	$sql = e107::getDb();
	$tp = e107::getParser();
	$sc = e107::getScBatch('anteup', true);
	$frm = e107::getForm();
	$template = e107::getTemplate('anteup');
	$template = array_change_key_case($template);

	$entries = $sql->retrieve('anteup_ipn', '*', 'payment_date > '.$startDate.' AND payment_date < '.$endDate, true);

	$sc->setVars(array($startDate, $endDate));
	$text = $tp->parseTemplate($template['donations']['filter'], false, $sc);

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
		$text .= "<div style='text-align:center;'>There were no donations made in that time frame.</div>";
	}
}
else
{
	$text = "<div style='text-align:center;'>Sorry, friend, but you can't view this page based on your userclass.</div>";
}

e107::getRender()->tablerender("Donations", $text);
require_once(FOOTERF);
?>
