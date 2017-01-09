<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

define("ANTEUP", e_PLUGIN."anteup/");
define("ANTEUP_ABS", SITEURLBASE.e_PLUGIN_ABS."anteup/");

function format_currency($input, $id, $commify = true)
{
	$sql = e107::getDb();
	$sql->select("anteup_currency", "*", "id='".intval($id)."'");
    while($row = $sql->fetch())
    {
		$symbol = $row['symbol'];
        $loc = $row['location'];
    }
	$input = (($commify) ? number_format($input, 2) : $input);
	return ($loc == "back" ? $input.$symbol : $symbol.$input);
}

function get_info($type)
{
	$sql = e107::getDb();
	$pref = e107::getPlugPref('anteup');

	$lastDue = $pref['anteup_lastdue'];
	$currDue = $pref['anteup_due'];
	$current = 0;
	$total = 0;

	$sql->select("anteup_ipn");

	while($row = $sql->fetch())
	{
		$payDate = $row['payment_date'];

		if($payDate > $lastDue && $payDate < $currDue)
		{
			$current += $row['mc_gross'];
		}
		$total += $row['mc_gross'];
	}

	if($type == "current")
	{		
		return $current; 
	}
	elseif($type == "total")
	{	
		return $total; 
	}
}