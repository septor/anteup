<?php
/* 
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

// TODO: Date selection.

require_once("../../class2.php");
require_once(HEADERF);
require_once(e_PLUGIN."anteup/_class.php");
e107::lan('anteup');
$pref = e107::pref('anteup');

$sql = e107::getDb();
$tp = e107::getParser();
$sc = e107::getScBatch('anteup', true);
$template = e107::getTemplate('anteup');
$template = array_change_key_case($template);

$startDate = strtotime($pref['anteup_lastdue']);
$endDate = strtotime($pref['anteup_due']);

$entries = $sql->retrieve('anteup_ipn', '*', 'payment_date > '.$startDate.' AND payment_date < '.$endDate, true);

if($entries)
{
	$text = $tp->parseTemplate($template['donations']['start'], false, $sc);
	foreach($entries as $entry)
	{
		$sc->setVars($entry);
		$text .= $tp->parseTemplate($template['donations']['entry'], false, $sc);
	}
	$text .= $tp->parseTemplate($template['donations']['end'], false, $sc);
}
else
{
	$text = "There were no donations made in that time frame.";
}

e107::getRender()->tablerender("Donations", $text);
require_once(FOOTERF);
?>
