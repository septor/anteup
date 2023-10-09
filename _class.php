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
	$curr = e107::getDb()->retrieve("anteup_currency", "*", "id='".intval($id)."'");
	$input = (($commify) ? number_format($input, 2) : $input);

	return ($curr['location'] == "back" ? $input.$curr['symbol'] : $curr['symbol'].$input);
}

function get_info($type, $campaign = 1)
{
	$sql = e107::getDb();

	$campaignInfo 	= $sql->retrieve("anteup_campaign", "*", "id='".$campaign."'");
	$donations 		= $sql->retrieve("anteup_ipn", "*", "payment_status='Completed' AND campaign='".$campaign."'", true);

	$current = 0;
	$total	 = 0;

	if($campaignInfo['goal_date'])
	{
		foreach($donations as $donation)
		{
			if($donation['payment_date'] < $campaignInfo['goal_date'])
			{
				$current += $donation['mc_gross'];
			}
			$total += $donation['mc_gross'];
		}
	}
	else
	{
		foreach($donations as $donation)
		{
			$current += $donation['mc_gross'];
			$total = $current;
		}
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