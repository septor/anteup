<?php
/*
* AnteUp - A Donation Tracking Plugin for e107
*
* Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
* For additional information refer to the README.mkd file.
*
*/
if(!defined('e107_INIT')){ exit; }

$ANTEUP_TEMPLATE = array();

$ANTEUP_TEMPLATE['menu']['body'] = "
<div style='text-align:center;'>
	{ANTEUP_CAMPAIGN_DESCRIPTION}
	<br><br>
	{LAN=LAN_ANTEUP_MENU_01}: {ANTEUP_GOALDATE}<br />
	<a href='".e_PLUGIN_ABS."anteup/donations.php'>{ANTEUP_BAR}</a>
	{LAN=LAN_ANTEUP_MENU_02} ({ANTEUP_CURRENCY: code}): {ANTEUP_CURRENT: format}/{ANTEUP_GOAL: format}<br />
	{LAN=LAN_ANTEUP_MENU_03}: {ANTEUP_REMAINING: format}<br />
	{LAN=LAN_ANTEUP_DONATIONS_06}: {ANTEUP_TOTAL: format}<br />
	<br	/>
	{ANTEUP_DONATELINK}
	<br /><br />
	{LAN=LAN_ANTEUP_MENU_04}: {ANTEUP_MOSTRECENT}
	<br /><br />
	{ANTEUP_ADMIN}
</div>
";

$ANTEUP_TEMPLATE['menu']['caption'] = "{ANTEUP_MENUCAPTION} - {ANTEUP_CAMPAIGN_NAME}";

$ANTEUP_TEMPLATE['donate'] = "
	{ANTEUP_PAGETEXT}
	<br />
	<table class='table table-bordered table-hover'>
		<tbody>
			<tr>
				<td>{LAN=LAN_ANTEUP_DONATE_01}:</td>
				<td>{ANTEUP_CAMPAIGNSELECTOR}</td>
			</tr>
			<tr>
				<td>{LAN=LAN_ANTEUP_DONATE_02}:</td>
				<td>{ANTEUP_CURRENCYSELECTOR}</td>
			</tr>
			<tr>
				<td>{LAN=LAN_ANTEUP_DONATE_03}:</td>
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
				<th>{LAN=LAN_ANTEUP_DONATIONS_01}</th>
				<th>{LAN=LAN_ANTEUP_DONATIONS_02}</th>
				<th>{LAN=LAN_ANTEUP_DONATIONS_03}</th>
				<th>{LAN=LAN_ANTEUP_DONATIONS_04}</th>
				<th>{LAN=LAN_ANTEUP_DONATIONS_05}</th>
			</tr>
		</thead>
		<tbody>
";

$ANTEUP_TEMPLATE['donations']['entry'] = "
			<tr>
				<td>{ANTEUP_DONATION_DONATOR}</td>
				<td>{ANTEUP_CAMPAIGN_NAME}</td>
				<td>{ANTEUP_DONATION_DATE: format=relative}</td>
				<td>{ANTEUP_DONATION_AMOUNT: format}</td>
				<td>{ANTEUP_DONATION_STATUS}</td>
			</tr>
";

$ANTEUP_TEMPLATE['donations']['end'] = "
			<tr>
				<td style='text-align:right;' colspan='5'>{LAN=LAN_ANTEUP_DONATIONS_06}: {ANTEUP_TOTAL: format}</td>
			</tr>
		</tbody>
	</table>
";