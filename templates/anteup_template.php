<?php
/*
* AnteUp - A Donation Tracking Plugin for e107
*
* Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
* For additional information refer to the README.mkd file.
*
*/
if(!defined('e107_INIT')){ exit; }

$ANTEUP_TEMPLATE['menu'] = "
<div style='text-align:center;'>
	{ANTEUP_MENUTEXT}
	<br />
	Due on: {ANTEUP_DUE}<br />
	<a href='".e_PLUGIN."anteup/donations.php'>{ANTEUP_BAR}</a>
	Status (in {ANTEUP_CODE}): {ANTEUP_CURRENT}/{ANTEUP_GOAL}<br />
	Remaining: {ANTEUP_REMAINING: format}<br />
	Lifetime Donation Total: {ANTEUP_TOTAL: format}<br />
	<br	/>
	{ANTEUP_DONATELINK}
	<br /><br />
	{ANTEUP_ADMIN}
</div>
";

$ANTEUP_TEMPLATE['donate'] = "
	{ANTEUP_PAGETEXT}
	<br />
	<table class='table table-bordered table-hover'>
		<tbody>
			<tr>
				<td>".LAN_ANTEUP_DONATE_01.":</td>
				<td>{ANTEUP_REASONSELECTOR}</td>
			</tr>
			<tr>
				<td>".LAN_ANTEUP_DONATE_02.":</td>
				<td>{ANTEUP_CURRENCYSELECTOR}</td>
			</tr>
			<tr>
				<td>".LAN_ANTEUP_DONATE_03.":</td>
				<td>{ANTEUP_AMOUNTSELECTOR}</td>
			</tr>
			<tr>
				<td class='center' colspan='2'>{ANTEUP_SUBMITDONATION}</td>
			</tr>
		</tbody>
	</table>
";

$ANTEUP_TEMPLATE['donations']['filter'] = "
	{ANTEUP_DONATION_FILTER}
";

$ANTEUP_TEMPLATE['donations']['start'] = "
	<table class='table table-bordered table-hover'>
		<thead>
			<tr>
				<th>".LAN_ANTEUP_DONATIONS_01."</th>
				<th>".LAN_ANTEUP_DONATIONS_02."</th>
				<th>".LAN_ANTEUP_DONATIONS_03."</th>
				<th>".LAN_ANTEUP_DONATIONS_04."</th>
				<th>".LAN_ANTEUP_DONATIONS_05."</th>
			</tr>
		</thead>
		<tbody>
";

$ANTEUP_TEMPLATE['donations']['entry'] = "
			<tr>
				<td>{ANTEUP_DONATION_DONATOR}</td>
				<td>{ANTEUP_DONATION_REASON}</td>
				<td>{ANTEUP_DONATION_DATE: format=relative}</td>
				<td>{ANTEUP_DONATION_AMOUNT: format}</td>
				<td>{ANTEUP_DONATION_STATUS}</td>
			</tr>
";

$ANTEUP_TEMPLATE['donations']['end'] = "
			<tr>
				<td style='text-align:right;' colspan='5'>".LAN_ANTEUP_DONATIONS_06." {ANTEUP_TOTAL: format}</td>
			</tr>
		</tbody>
	</table>
";

?>
