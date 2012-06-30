<?php
if (!defined('e107_INIT')) { exit; }
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");
require_once(e_PLUGIN."anteup/_class.php");
$gen = new convert();

$cd = explode("/", $pref['anteup_due']);
if(!empty($pref['anteup_lastdue'])){
	$ld = explode("/", $pref['anteup_lastdue']);
}else{
	// if the lastdue date isn't set, make it the first day of last month
	$ld = explode("/", date("m/d/Y", strtotime("first day of last month")));
}
$due_ts = mktime(0, 0, 0, $cd[0], $cd[1], $cd[2]);
$due = date('m/d/Y', $due_ts);
$lastdue_ts = mktime(0, 0, 0, $ld[0], $ld[1], $ld[2]);
$due = date('m/d/Y', $lastdue_ts);

$currency = $pref['anteup_currency'];
$goal = (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : "0");
$current = 0;
$total = 0;

$sql->db_Select("anteup_ipn", "*");
while($row = $sql->db_Fetch()){
	if($row['payment_date'] > $lastdue_ts && $row['payment_date'] < $due_ts){
		$current += ($row['mc_gross'] - $row['mc_fee']);
	}
	$total += ($row['mc_gross'] - $row['mc_fee']);
}


$amt_left = round($goal - $current, 2);
$pct_left = round(($current / $goal) * 100, 0);


if(varsettrue($pref['anteup_showbar'])){
	if($pct_left < 100){
		$showbar = $pct_left."% ".ANTELAN_MENU_01."<br />
		<script type='text/javascript'>
			function DoNav(theUrl) {
			document.location.href = theUrl;}
		</script>
		<table cellspacing='0' cellpadding='0' style='border:#".$pref['anteup_border']." 1px solid; width:100%;'>
		  <tr onclick=\"DoNav('".e_PLUGIN."anteup/donations.php');\" title='".ANTELAN_MENU_02."'>
			<td style='width:".$pct_left."%; height: ".$pref['anteup_height']."px; background-color:#".$pref['anteup_full'].";'></td>
			<td style='width:".(100 - $pct_left)."%; height: ".$pref['anteup_height']."; background-color:#".$pref['anteup_empty'].";'></td>
		  </tr>
		</table>
		<br />";
	}else{
		$showbar = ANTELAN_MENU_03."<br /><br />";
	}
}else{
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
<a href='".e_PLUGIN."anteup/donate.php'><img src='".e_PLUGIN."anteup/images/icons/".$pref['pal_button_image']."' title='".$pref['pal_button_popup']."' style='border:none' /></a>
</div>";

if(ADMIN){ $text .= "<br /><a href='".e_PLUGIN."anteup/admin_config.php'>".ANTELAN_MENU_09."</a>"; }

$ns -> tablerender($pref['anteup_mtitle'],  "<div style='text-align:center;'>\n".$text."\n</div>", 'anteup');

?>