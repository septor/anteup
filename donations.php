<?php
// TODO: Restylize the date selection area. It feels crammed together and could be semi-confusing on a smaller width theme.

require_once("../../class2.php");
require_once(HEADERF);
e107::lan('anteup');
require_once(e_PLUGIN."anteup/_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
$gen = new convert();

if (isset($_POST['setdates']))
{
	$sdt = explode("/", $_POST['sd']);
	$edt = explode("/", $_POST['ed']);
}
else
{
	$sdt = explode("/", date("m/d/Y", strtotime("first day of last month")));
	$edt = explode("/", date("m/d/Y", strtotime("last day of this month")));
}

$sd_ts = mktime(0, 0, 0, $sdt[0], $sdt[1], $sdt[2]);
$sd = date('m/d/Y', $sd_ts);
$ed_ts = mktime(23, 59, 59, $edt[0], $edt[1], $edt[2]);
$ed = date('m/d/Y', $ed_ts);

$text .= "<form action='".e_SELF."' method='post'>
".$cal->load_files()."

".ANTELAN_DONATIONS_01." <td style='text-align:center;'><input type='text' class='tbox' name='sd' id='sd' value='".$sd."' /> <a href='#' id='f-calendar-trigger-1'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'sd','button':'f-calendar-trigger-1'});</script>
 - ".ANTELAN_DONATIONS_02." <input type='text' class='tbox' name='ed' id='ed' value='".$ed."' /> <a href='#' id='f-calendar-trigger-2'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'ed','button':'f-calendar-trigger-2'});</script>
<input class='button' type='submit' name='setdates' value='Filter' />

</form>

<table style='width:100%' class='fborder'>
<tr>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_03."</td>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_04."</td>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_05."</td>
<td class='fcaption' style='text-align:center; width:25%;'>".ANTELAN_DONATIONS_06."</td>
</tr>
";

$total = 0;
$donations = 0;

$sql -> db_Select("anteup_ipn", "*", "payment_date > '".$sd_ts."' AND payment_date < '".$ed_ts."' ORDER BY payment_date DESC");
while ($row = $sql->db_Fetch())
{
	$text .= "<tr>
	<td class='forumheader3' style='text-align:center;'>".$row['item_name']."</td>
	<td class='forumheader3' style='text-align:center;'>".$row['comment']."</td>
	<td class='forumheader3' style='text-align:center;'>".$gen->convert_date($row['payment_date'], $pref['anteup_dformat'])."</td>
	<td class='forumheader3' style='text-align:center;'>".format_currency($row['mc_gross'], $pref['anteup_currency'])."</td>
	</tr>";
	$total += $row['mc_gross'];
	$donations++;
}

if ($donations == 0)
{
	$text .= "<tr>
	<td colspan='4' class='forumheader3' style='text-align:center;'>".ANTELAN_DONATIONS_07."</td>
	</tr>";
}
else
{
	$text .= "
	<tr>
	<td colspan='4'>&nbsp;</td>
	</tr>
	<tr>
	<td colspan='3'>&nbsp;</td>
	<td class='forumheader3' style='text-align:center;'>".ANTELAN_DONATIONS_08." <b>".format_currency($total, $pref['anteup_currency'])."</b></td>
	</tr>";
}

$text .= "</table>
<br /><br />
".ANTELAN_DONATIONS_09;

$ns -> tablerender(ANTELAN_DONATIONS_CAPTION00, $text);
require_once(FOOTERF);
?>
