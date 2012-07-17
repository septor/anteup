<?php
require_once("../../class2.php");
require_once(HEADERF);
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");
require_once(e_PLUGIN."anteup/_class.php");

if(USER){
	$paypal_donate_jscript = "";
	$paypal_donate_jscript_onclick = "";
	$paypal_donate_action = "https://www.paypal.com/cgi-bin/webscr";
	$paypal_donate_email = $pref['pal_business'];
	$pref['pal_item_name'] = $paypal_item_name;
	$pref['pal_custom'] = USERID;
	if($sql -> db_Select("user_extended", "*", "user_extended_id=".intval(USERID))){
		$row = $sql -> db_Fetch();
		if(isset($row['user_country'])) {
			$pref['pal_lc'] = $row['user_country'];
		}
	}
	if($pref['pal_custom'] == '0') {
		$pref['pal_custom'] = USERID;
	}
}else{
	$paypal_donate_email   = preg_split("#(?<=.)(?=.)#s",$pref['pal_business']);
	$paypal_donate_email   = "'".implode("'  +  '", $paypal_donate_email)."'";
	$paypal_donate_jscript = "
	<script type='text/javascript'>
	function paypal_donate_set(){
		document.forms.paypal_donate_form.paypal_donate_email.value=".$paypal_donate_email.";
		document.forms.paypal_donate_form.action='https://www.paypal.com/cgi-bin/webscr';
	}
	</script>";
	$paypal_donate_jscript_onclick = "onclick='paypal_donate_set()'";
	$paypal_donate_action = ANTEUP;
}

$text = "<div style='text-align:center;'>".$pref['anteup_description']."</div>
<form action='".$paypal_donate_action."' id='paypal_donate_form' method='post'>
<table class='fborder' style='width: 100%;'>
<tr>
";
if(USER){
	$text .= "<input type='hidden' name='item_name' value='".USERNAME."' />";
}else{
	$text .= "<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_01."</td><br />
	<td class='forumheader3'><input name='item_name' type='text' class='tbox' id='item_name' value='' maxlength='50' />";
}

$text .= "<input type='hidden' name='cmd' value='_xclick' />\n
<input type='hidden' name='business' value='".$paypal_donate_email."' id='paypal_donate_email' />\n
<input type='hidden' name='notify_url' value='".ANTEUP_ABS."ipn_validate.php' />\n
<input type='hidden' name='return' value='".ANTEUP_ABS."return.php?thanks' />\n
<input type='hidden' name='cancel_return' value='".ANTEUP_ABS."return.php?cancel' />\n
".(($pref['pal_no_shipping']) ? "<input type='hidden' name='no_shipping' value='".$pref['pal_no_shipping']."' />\n" : "")."
".(($pref['pal_no_note']) ? "<input type='hidden' name='no_note' value='".$pref['pal_no_note']."' />\n" : "")."
".(($pref['pal_cn']) ? "<input type='hidden' name='cn' value='".$pref['pal_cn']."' />" : "")."
".(($pref['pal_page_style']) ? "<input type='hidden' name='page_style' value='".$pref['pal_page_style']."' />\n" : "")."
".(($pref['pal_lc']) ? "<input type='hidden' name='lc' value='".$pref['pal_lc']."' />\n" : "")."
".(($pref['pal_item_number']) ? "<input type='hidden' name='item_number' value='".$pref['pal_item_number']."' />\n" : "")."
".(($pref['pal_custom']) ? "<input type='hidden' name='custom' value='".$pref['pal_custom']."' />\n" : "")."
".(($pref['pal_invoice']) ? "<input type='hidden' name='invoice' value='".$pref['pal_invoice']."' />\n" : "")."
".(($pref['pal_amount']) ? "<input type='hidden' name='amount' value='".$pref['pal_amount']."' />\n" : "")."
".(($pref['pal_tax']) ? "<input type='hidden' name='tax' value='".$pref['pal_tax']."' />\n" : "")."
</td>
</tr>
<tr>
<td class='forumheader3' style='width:50%; text-align:right;'>".ANTELAN_DONATE_02."</td>
<td class='forumheader3'><select class='tbox' name='currency_code'>";
$sql->db_Select("anteup_currency", "*");
while($row = $sql->db_Fetch()){
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
<input ".$paypal_donate_jscript_onclick." name='submit' type='image' src='".ANTEUP."images/icons/".$pref['pal_button_image']."' title='".$pref['pal_button_popup']."' style='border:none' />
</td>
</tr>
</table>
</form>";

$ns->tablerender(ANTELAN_DONATE_CAPTION00, $tp->toHTML($text, true));
require_once(FOOTERF);
?>