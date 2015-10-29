<?php
require_once("../../class2.php");
require_once(HEADERF);
e107::lan('anteup');
require_once(e_PLUGIN."anteup/_class.php");
$pref = e107::getPlugPref('anteup');

$text = "<form action='https://www.paypal.com/cgi-bin/webscr' id='paypal_donate_form' method='post'>
<table class='fborder' style='width: 100%;'>
<tr>";

if(USER)
{
	$text .= "<input type='hidden' name='item_name' value='".USERNAME."' />";
}
else
{
	$text .= "<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_01."</td><br />
	<td class='forumheader3'>
	<input name='item_name' type='text' class='tbox' id='item_name' value='' maxlength='50' />";
}


$text .= "<input type='hidden' name='cmd' value='_xclick' />
<input type='hidden' name='business' value='".$pref['pal_business']."' id='paypal_donate_email' />
<input type='hidden' name='notify_url' value='".ANTEUP_ABS."ipn.php' />
<input type='hidden' name='return' value='".ANTEUP_ABS."return.php?thanks' />
<input type='hidden' name='cancel_return' value='".ANTEUP_ABS."return.php?cancel' />
<input type='hidden' name='cancel_return' value='".ANTEUP_ABS."return.php?cancel' />
</tr>
<tr>
<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_02."</td>
<td class='forumheader3'><select class='tbox' name='currency_code'>";

$sql->db_Select("anteup_currency", "*");
while($row = $sql->db_Fetch())
{
	$text .= "<option value='".$row['code']."'".($row['id'] == $pref['anteup_currency'] ? " selected" : "").">".$row['description']." (".$row['symbol'].")</option>";
}

$text .= "</select>
</td>
</tr>
<tr>
<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_03."</td>
<td class='forumheader3'>
<select class='tbox' name='amount'>
<option value='0.00'>".ANTELAN_DONATE_04."</option>
<option value='1.00'>1.00</option>
<option value='5.00' selected>5.00</option>
<option value='10.00'>10.00</option>
<option value='15.00'>15.00</option>
<option value='20.00'>20.00</option>
<option value='30.00'>30.00</option>
<option value='40.00'>40.00</option>
<option value='50.00'>50.00</option>
<option value='100.00'>100.00</option>
<option value='500.00'>500.00</option>
</select>
</td>
</tr>
<tr>
<td class='forumheader3' style='text-align:center;' colspan='2'>
<input name='submit' type='image' src='".ANTEUP."images/icons/".$pref['pal_button_image']."' title='".$pref['pal_button_popup']."' style='border:none' />
</td>
</tr>
</table>
</form>";

$ns->tablerender(ANTELAN_DONATE_CAPTION00, $tp->toHTML($text, true));
require_once(FOOTERF);
?>
