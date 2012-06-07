<?php
require_once("../../class2.php");
require_once(HEADERF);
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");
require_once(e_PLUGIN."anteup/_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
$cal = new DHTML_Calendar(true);
$gen = new convert();

if(isset($_POST['setdates'])){
	$sdt = explode("/", $_POST['sd']);
	$edt = explode("/", $_POST['ed']);
}else{
	$sdt = explode("/", date("m/d/Y", strtotime("first day of last month")));
	$edt = explode("/", date("m/d/Y", strtotime("last day of this month")));
}

$sd_ts = mktime(0, 0, 0, $sdt[0], $sdt[1], $sdt[2]);
$sd = date('m/d/Y', $sd_ts);
$ed_ts = mktime(23, 59, 59, $edt[0], $edt[1], $edt[2]);
$ed = date('m/d/Y', $ed_ts);

$script = "
<script type=\"text/javascript\">
function addtext_us(sc){
  document.getElementById('dataform').image.value = sc;
}
</script>\n".
$cal->load_files();

$text .= "<form action='".e_SELF."' method='post'>
".$script."

<div align='center'>
Start Date: <td style='text-align:center;'><input type='text' class='tbox' name='sd' id='sd' value='".$sd."' /> <a href='#' id='f-calendar-trigger-1'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'sd','button':'f-calendar-trigger-1'});</script>
 - End Date: <input type='text' class='tbox' name='ed' id='ed' value='".$ed."' /> <a href='#' id='f-calendar-trigger-2'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'ed','button':'f-calendar-trigger-2'});</script>
<input class='button' type='submit' name='setdates' value='Filter' />

</form>

<table style='width:90%' class='fborder'>
<tr>
<td class='fcaption' style='text-align:center; width:25%;'>Donator</td>
<td class='fcaption' style='text-align:center; width:25%;'>Message</td>
<td class='fcaption' style='text-align:center; width:25%;'>Date Donated</td>
<td class='fcaption' style='text-align:center; width:25%;'>Amount</td>
</tr>
";

$total = 0;
$donations = 0;

$sql -> db_Select("anteup_ipn", "*", "payment_date > '".$sd_ts."' AND payment_date < '".$ed_ts."' ORDER BY payment_date DESC");
while($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td class='forumheader3' style='text-align:center;'>".$row['item_name']."</td>
	<td class='forumheader3' style='text-align:center;'>".$row['comment']."</td>
	<td class='forumheader3' style='text-align:center;'>".$gen->convert_date($row['payment_date'], $pref['anteup_dformat'])."</td>
	<td class='forumheader3' style='text-align:center;'>".format_currency($row['mc_gross'], $pref['anteup_currency'])."</td>
	</tr>";
	$total += $row['mc_gross'];
	$donations++;
}

if($donations == 0){
	$text .= "<tr>
	<td colspan='4' class='forumheader3' style='text-align:center;'>No donations found during that time period.</td>
	</tr>";
}else{
	$text .= "
	<tr>
	<td colspan='4'>&nbsp;</td>
	</tr>
	<tr>
	<td colspan='3'>&nbsp;</td>
	<td class='forumheader3' style='text-align:center;'>Total: <b>".format_currency($total, $pref['anteup_currency'])."</b></td>
	</tr>";
}

$text .= "</table>
<br /><br />
Want to be a part of this elite club of donators? Guess what! You can be! <a href='".ANTEUP."donate.php'>Click here</a> to send us a very welcome donation!
</div>";

$ns -> tablerender("Donations", $text);
require_once(FOOTERF);
?>