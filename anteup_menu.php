<?php
/* 
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if (!defined('e107_INIT')) { exit; }
require_once(e_PLUGIN."anteup/_class.php");
e107::lan('anteup');

$pref		= e107::pref('anteup');
$sql		= e107::getDb();

$lastDue	= strtotime($pref['anteup_lastdue']);
$currDue	= strtotime($pref['anteup_due']);
$currency	= $pref['anteup_currency'];

$goal		= (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : 0);
$current	= 0;
$total		= 0;

$sql->select("anteup_ipn");

while($row = $sql->fetch())
{
	$payDate = $row['payment_date'];

	if($payDate > $lastDue && $payDate < $currDue)
		$current += $row['mc_gross'];

	$total += $row['mc_gross'];
}

$remaining = round($goal - $current, 2);
$percent = round(($current / $goal) * 100, 0);

$text = "
<div class='progress'>
	<div class='progress-bar' role='progressbar' aria-valuenow='".$percent."' aria-valuemin='0' aria-valuemax='100' style='width:".$percent."%'>
		<span class='sr-only'>".$percent."% donated</span>
	</div>
</div>
Remaining: ".format_currency($remaining, $currency)."<br />
Status (in ".currency_info($currency, "code")."): ".$current."/".$goal."<br />
Total Lifetime Donations: ".format_currency($total, $currency);

$ns->tablerender($pref['anteup_mtitle'], $text, 'anteup');
?>
