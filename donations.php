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
	$sql = e107::getDb();
	$tp = e107::getParser();
	$sc = e107::getScBatch('anteup', true);
	$frm = e107::getForm();
	$template = e107::getTemplate('anteup');
	$template = array_change_key_case($template);

	// Check if filter has been set 
	$where_query = "payment_status = 'COMPLETED'";

	if(isset($_POST['filterDonations']))
	{
		if(isset($_POST['campaign']))
		{
			$campaign = (int) $_POST['campaign'];

			// if $campaign = 0, it means 'all campaigns' is selected. So do not filter!
			if($campaign !== 0)
			{
				$where_query .= " AND campaign = ".$campaign; 
			}
		}

		if(isset($_POST['startDate']))
		{
			$startDate = (int) $_POST['startDate']; 
			$where_query .= " AND payment_date > ".$startDate;
		}

		
		if(isset($_POST['endDate']))
		{
			$endDate = (int) $_POST['endDate']; 
			$where_query .= " AND payment_date < ".$endDate;
		}
	}
	// No filters set, just get everything
	else
	{
		$endDate = time();
		$startDate = '';
		$campaign = '';
	}

	//print_a($where_query);
	//$entries = $sql->retrieve('anteup_ipn', '*', 'payment_date > '.$startDate.' AND payment_date < '.$endDate, true);

	$entries = $sql->retrieve('anteup_ipn', '*', $where_query, true);

	$sc->setVars(array($startDate, $endDate, $campaign));
	$text = $tp->parseTemplate($template['donations']['filter'], true, $sc); // TODO also add campaign filter?
	
	if($entries)
	{
		$text .= $tp->parseTemplate($template['donations']['start'], true, $sc);
		foreach($entries as $entry)
		{
			$sc->setVars($entry);
			$text .= $tp->parseTemplate($template['donations']['entry'], true, $sc);
		}
		$text .= $tp->parseTemplate($template['donations']['end'], true, $sc);
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