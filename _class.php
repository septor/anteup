<?php
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

function currency_info($id, $type = 'symbol')
{
	$sql = e107::getDb();
	if($type == "symbol")
	{
		return $sql->retrieve('anteup_currency',  'symbol', 'id = '.intval($id));
	}
	elseif($type == "code")
	{
		return $sql->retrieve('anteup_currency',  'code', 'id = '.intval($id));
	}
	elseif($type == "desc")
	{
		return $sql->retrieve('anteup_currency',  'description', 'id = '.intval($id));
	}
	else
	{
		return "";
	}
}

function get_info($type)
{
	$sql = e107::getDb();
	$pref = e107::pref('anteup');
	
	$lastDue = strtotime($pref['anteup_lastdue']);
	$currDue = strtotime($pref['anteup_due']);
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

	if($type == "current"){		return $current; }
	elseif($type == "total"){	return $total; }
}	
