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
Due on: {ANTEUP_DUE}<br />
<a href='".e_PLUGIN."anteup/donations.php'>{ANTEUP_BAR}</a>
Status (in {ANTEUP_CODE}): {ANTEUP_CURRENT}/{ANTEUP_GOAL}<br />
Remaining: {ANTEUP_REMAINING: format}<br />
Lifetime Donation Total: {ANTEUP_TOTAL: format}<br />
{ANTEUP_ADMIN}
";

$ANTEUP_TEMPLATE['donate'] = "
<table class='fborder' style='width: 100%;'>
<tr>
<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_01."</td>
<td class='forumheader3'>
{ANTEUP_DONATOR: class=tbox}
</td>
</tr>
<tr>
<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_02."</td>
<td class='forumheader3'>
{ANTEUP_CURRENCYSELECTOR: class=tbox}
</td>
</tr>
<tr>
<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_03."</td>
<td class='forumheader3'>
{ANTEUP_AMOUNTSELECTOR: class=tbox}
</td>
</tr>
<tr>
<td class='forumheader3' style='text-align:center;' colspan='2'>
{ANTEUP_SUBMITDONATION}
</td>
</tr>
</table>
";


$ANTEUP_TEMPLATE['donations']['start'] = "
<table style='width:100%' class='fborder'>
<tr>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_03."</td>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_04."</td>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_05."</td>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_06."</td>
</tr>
";

$ANTEUP_TEMPLATE['donations']['entry'] = "
<tr>
<td class='forumheader3' style='text-align:center;'>{ANTEUP_DONATION_NAME}</td>
<td class='forumheader3' style='text-align:center;'>{ANTEUP_DONATION_COMMENT}</td>
<td class='forumheader3' style='text-align:center;'>{ANTEUP_DONATION_DATE}</td>
<td class='forumheader3' style='text-align:center;'>{ANTEUP_DONATION_AMOUNT}</td>
</tr>";

$ANTEUP_TEMPLATE['donations']['end'] = "</table>";

?>
