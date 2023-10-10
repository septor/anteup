<?php
/*
* AnteUp - A Donation Tracking Plugin for e107
*
* Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
* For additional information refer to the README.mkd file.
*
*/
if(!defined('e107_INIT')){ exit; }

$ANTEUP_MENU_TEMPLATE = array();

$ANTEUP_MENU_TEMPLATE['default']['body'] = "
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

$ANTEUP_MENU_TEMPLATE['default']['caption'] = "{ANTEUP_MENUCAPTION} - {ANTEUP_CAMPAIGN_NAME}";


$ANTEUP_MENU_TEMPLATE['unlimited']['body'] = "
<div style='text-align:center;'>
	{ANTEUP_CAMPAIGN_DESCRIPTION}
	<br><br>
	{LAN=LAN_ANTEUP_DONATIONS_06}: {ANTEUP_TOTAL: format}<br />
	<br	/>
	{ANTEUP_DONATELINK}
	<br /><br />
	{LAN=LAN_ANTEUP_MENU_04}: {ANTEUP_MOSTRECENT}
	<br /><br />
	{ANTEUP_ADMIN}
</div>
";

$ANTEUP_MENU_TEMPLATE['unlimited']['caption'] = "{ANTEUP_MENUCAPTION} - {ANTEUP_CAMPAIGN_NAME}";