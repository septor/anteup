<?php
require_once("../../class2.php");
require_once(e_ADMIN."auth.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");
require_once(e_HANDLER."user_select_class.php");
require_once(e_HANDLER."calendar/calendar_class.php");
require_once(e_PLUGIN."anteup/_class.php");
$gen = new convert();
$cal = new DHTML_Calendar(true);

/*
ALPHA TODO:
		1. Add new entry. Will utilize a jQuery slidedown division.
		2. Edit existing entry. Will retain current page, swapping out entry data for textboxes.
		3. Utilize a jQuery color selector instead of jsColor. No point in wasted space.
		
		
		NOTE FOR MOC: Not safe to translate yet. More hardcoded text to come, hold out a bit longer!
*/


if(e_QUERY){
	$tmp = explode('.', e_QUERY);
	$action = $tmp[0];
	$sub_action = $tmp[1];
	$id = $tmp[2];
	unset($tmp);
}

if(isset($_POST['main_delete'])){
	$delete_id = array_keys($_POST['main_delete']);
	$message = ($sql2->db_Delete("anteup_ipn", "ipn_id=".intval($delete_id[0]))) ? "Entry successfully deleted." : "Error deleting entry.";
}

if(isset($message)){
	$action = "";
	$ns->tablerender("", "<div style='text-align:center;'><b>".$message."</b></div>");
}
	
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

$total = 0;
$partial = 0;
if ($pref['anteup_ibalance'] != 0) {
   $partial = $pref['anteup_ibalance'];
   $total = $pref['anteup_ibalance'];
}
$sql -> db_Select("anteup_ipn", "*", "payment_date > '0' ORDER BY payment_date ASC, type ASC, ipn_id ASC");
while($row = $sql->db_Fetch()) {
	extract($row);
	if(empty($type) || $type==0){
		$total += ($mc_gross-$mc_fee);
		if($payment_date < $sd_ts){
			$partial += ($mc_gross-$mc_fee);
		}
	}else{
		$total -= ($mc_gross-$mc_fee);
		if ($payment_date < $sd_ts) {
			$partial -= ($mc_gross-$mc_fee);
		}
	}
}
$countl = 0;

$text .= $cal->load_files()."
<div style='text-align:center' class='fborder' >
<form method='post' action='".e_SELF."'>
<table style='width:100%;' class='fborder' cellspacing='0' cellpadding='0'>
	<tr>
		<td style='width:40%; font-size:1.4em;'>
			<b>Balance</b>: ".format_currency($total, $pref['anteup_currency'])."
			<span style='padding-left:10px;'><a href='".e_SELF."?cashnew.new'><img src='".e_PLUGIN."anteup/images/admin/money_add.png' title='Add New Entry' style='border: 0px;'></a></span>
		</td>
		<td style='width:25%; text-align:right;'>
			Start Date: <input type='text' class='tbox' name='sd' id='sd' value='".$sd."' /> <a href='#' id='f-calendar-trigger-1'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'sd','button':'f-calendar-trigger-1'});</script>
		</td>
		<td style='width:25%; text-align:right;'>
			End Date: <input type='text' class='tbox' name='ed' id='ed' value='".$ed."' /> <a href='#' id='f-calendar-trigger-2'>".CALENDAR_IMG."</a><script type='text/javascript'>Calendar.setup({'ifFormat':'%m/%d/%Y','daFormat':'%m/%d/%Y','inputField':'ed','button':'f-calendar-trigger-2'});</script>
		</td>
		<td style='width:10%; text-align:right;'>
			<input class='button' type='submit' name='setdates' value='Filter' />
		</td>
	</tr>
</table>
 
 
<table style='width:100%; border:1px;' class='fborder' cellspacing='0' cellpadding='0'>
	<tr>
		<td colspan=10 class='fcaption' style='text-align: center;'><b>Donation Invoice</b></td>
	</tr>
	<tr>
		<td style='width:5; text-align:center;' class='forumheader3'>ID</td>
		<td style='width:10%; text-align:center;' class='forumheader3'>Date</td>
		<td style='width:20%; text-align:left;' class='forumheader3'>Description</td>
		<td style='width:20%; text-align:left;' class='forumheader3'>Transaction ID</td>
		<td style='width:10%; text-align:center;' class='forumheader3'>Status</td>
		<td style='width:5%; text-align:center;' class='forumheader3'>Type</td>
		<td style='width:10%; text-align:right;' class='forumheader3'>Amount</td>
		<td style='width:10%; text-align:right;' class='forumheader3'>Fee</td>
		<td style='width:10%; text-align:right;' class='forumheader3'>Total</td>
		<td style='width:5%; text-align:center;' class='forumheader3'>&nbsp;</td>
	</tr>";
 
$countl += 5;
if($pref['anteup_ibalance'] != 0){
	$text .= "<tr>
		<td colspan='8' class='fcaption' style='text-align: center;'>Initial Balance</td>
		<td style='width:10%; text-align:right;' class='fcaption'>".format_currency($partial, $pref['anteup_currency'])."</td>
		<td class='fcaption'>&nbsp;</td>
	</tr>";
	$countl += 1;
}

$flag = 0;
$bgn = 1;

$sql -> db_Select("anteup_ipn", "*", "payment_date > '".$sd_ts."' AND payment_date < '".$ed_ts."' ORDER BY payment_date DESC");
while($row = $sql->db_Fetch()){
	extract($row);
	if(empty($type) || $type == 0){
		$partial += ($mc_gross-$mc_fee);
		$typex = "<span style='color:#009900;'>Credit</span>";
	}else{
		$partial -= ($mc_gross-$mc_fee);
		$typex = "<span style='color:#ff0000;'>Debit</span>";
	}
	
	$bgn = ($bgn == 1 ? 0 : 1);
	$bgc = ($bgn == 1 ? "#f2f2f2": "#fff");
	$ppc = ($partial < 0 ? "#009900" : "#000");
	
	$text .= "
	<tr>
		<td style='text-align:center; background-color: ".$bgc.";' class='forumheader'>".$ipn_id."</td>
		<td style='text-align:center; background-color: ".$bgc.";' class='forumheader'>".$gen->convert_date(strtotime($payment_date), $pref['anteup_dformat'])."</td>
		<td style='text-align:left; background-color: ".$bgc.";' class='forumheader'>".$item_name.($custom !=" "? "<br>".$custom:"")."</td>
		<td style='text-align:left; background-color: ".$bgc.";' class='forumheader'>".trim($comment." ".$txn_id)."</td>
		<td style='text-align:center; background-color: ".$bgc.";' class='forumheader'>".$payment_status."</td>
		<td style='text-align:center; background-color: ".$bgc.";' class='forumheader'>".$typex."</td>
		<td style='text-align:right; background-color: ".$bgc.";' class='forumheader'>".format_currency($mc_gross, $pref['anteup_currency'])."</td>
		<td style='text-align:right; background-color: ".$bgc.";' class='forumheader'>".format_currency($mc_fee, $pref['anteup_currency'])."</td>
		<td style='text-align:right; background-color: ".$bgc."; color: ".$ppc.";' class='forumheader'>".format_currency(($mc_gross-$mc_fee), $pref['anteup_currency'])."</td>
		<td style='text-align:center; background-color: ".$bgc.";  white-space: nowrap' class='forumheader'>
		<a href='".e_SELF."?edit.".$ipn_id.".".$sd_ts.".".$ed_ts."'>".ADMIN_EDIT_ICON."</a><input type='image' title='Edit' name='main_delete[".$ipn_id."]' src='".e_PLUGIN."anteup/images/admin/delete_16.png' onclick=\"return jsconfirm('Are you sure you want to delete this entry? [ID: ".$ipn_id." ]')\"/>
		</td>
	</tr>";

	$countl += 1;
	$flag++;
}
$text .= ($flag == 0  ? "<tr><td colspan='10' style='text-align:center;' class='forumheader'>There are no entries to display during the selected time periods.</td></tr>" : "")."
</table>
</form>
</div>";

$ns -> tablerender("Cash Manager", $text);
require_once(e_ADMIN."footer.php");

?>