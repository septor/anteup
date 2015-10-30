<?php
// TODO: Restylize the menu display. It's.. ugly?

if (!defined('e107_INIT')) { exit; }
e107::lan('anteup');
require_once(e_PLUGIN."anteup/_class.php");
$gen = new convert();

$pref = e107::getPlugPref('anteup');

$cd = explode("/", $pref['anteup_due']);

if (!empty($pref['anteup_lastdue']))
{
	$ld = explode("/", $pref['anteup_lastdue']);
}
else
{
	$ld = explode("/", date("m/d/Y", strtotime("first day of last month")));
}

$due_ts = mktime(0, 0, 0, $cd[0], $cd[1], $cd[2]);
$due = date('m/d/Y', $due_ts);
$lastdue_ts = mktime(0, 0, 0, $ld[0], $ld[1], $ld[2]);
$lastdue = date('m/d/Y', $lastdue_ts);

$currency = $pref['anteup_currency'];
$goal = (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : 0);
$current = 0;
$total = 0;

$sql->db_Select("anteup_ipn", "*");

while ($row = $sql->db_Fetch())
{
	if ($row['payment_date'] > $lastdue_ts && $row['payment_date'] < $due_ts)
	{
		$current += $row['mc_gross'];
	}
	$total += $row['mc_gross'];
}

$amt_left = round($goal - $current, 2);
$pct_left = round(($current / $goal) * 100, 0);

if (varsettrue($pref['anteup_showbar']))
{
	if ($pct_left < 100)
	{
		$showbar = $pct_left."% ".ANTELAN_MENU_01."<br />
		<a href='".e_PLUGIN."anteup/donations.php' title='".ANTELAN_MENU_02."'><progress value='".$pct_left."' max='100'></progress></a>
		<br />";
	}
	else
	{
		$showbar = "<a href='".e_PLUGIN."anteup/donations.php' title='".ANTELAN_MENU_02."'>".ANTELAN_MENU_03."</a><br /><br />";
	}
}
else
{
	$showbar = "";
}

$showcurrent = (varsettrue($pref['anteup_showcurrent']) ? ANTELAN_MENU_04." ".format_currency($current, $currency)."<br />" : "");
$showleft = (varsettrue($pref['anteup_showleft']) ? ANTELAN_MENU_05." ".format_currency($amt_left, $currency)."<br />" : "");
$showgoal = (varsettrue($pref['anteup_showgoal']) ? ANTELAN_MENU_06." ".format_currency($goal, $currency)."<br />" : "");
$showtotal = (varsettrue($pref['anteup_showtotal']) ? ANTELAN_MENU_07." ".format_currency($total, $currency)."<br />" : "");
$showdue = (varsettrue($pref['anteup_showdue']) ? ANTELAN_MENU_08." ".$gen->convert_date(strtotime($due), $pref['anteup_dformat'])."<br />" : "");
$textbar = (varsettrue($pref['anteup_textbar']) ? $pref['anteup_textbar']."<br /></br />" : "");

$text = $showbar.$textbar.$showcurrent.$showleft.$showgoal.$showtotal.$showdue."
<div style='padding-top:5px'>
<a href='".e_PLUGIN."anteup/donate.php'><img src='".e_PLUGIN."anteup/images/icons/".$pref['pal_button_image']."' style='border:none' /></a>
</div>";

if(ADMIN && varsettrue($pref['anteup_showconfiglink'])){ $text .= "<br /><a href='".e_PLUGIN."anteup/admin_config.php'>".ANTELAN_MENU_09."</a>"; }

$ns->tablerender($pref['anteup_mtitle'],  "<div style='text-align:center;'>\n".$text."\n</div>", 'anteup');

?>
