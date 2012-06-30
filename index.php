<?php
require_once("../../class2.php");
require_once(HEADERF);
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");

$cap_number_one  = rand(1,5);
$cap_number_two  = rand(1,5);
$cap_number_sum  = $cap_number_one + $cap_number_two;

$pal_key_private = $pref['pal_key_private'];
$pal_key_public  = md5($pal_key_private.$cap_number_sum.$pal_key_private.$_SERVER['REMOTE_ADDR']);
$pal_key_check   = md5($pal_key_private.$_POST['cap_answer'].$pal_key_private.$_SERVER['REMOTE_ADDR']);
  
if(!USER && $pal_key_check != $_POST['cap_key'] && !$pref['pal_no_protection']){
    $text = "<form method='post' action='".e_SELF."'>
	<div style='text-align:center'>
	<br />
	<br />
	".ANTELAN_INDEX_01." ".$cap_number_one." + ".$cap_number_two." =
	<input class='tbox' type='text' name='cap_answer' value='' size='5' maxlength='5' />
	<input class='tbox' type='submit' name='submit' value='".ANTELAN_INDEX_02."' />
	<input type='hidden' name='cap_key' value='".$pal_key_public."' />
	</div>
    </form>";
}else{
	$text = "<div style='text-align:center'><br />".ANTELAN_INDEX_03."<br /><br /></div>
	<form method='post' action='https://www.paypal.com/cgi-bin/webscr' id='paypal_donate_form'>
	<div style='width:100%; margin-left:auto; margin-right:auto; text-align:center;'>
	<input type='hidden' name='cmd' value='_xclick' />
	<input type='hidden' name='business' value='".$pref['pal_business']."' id='paypal_donate_email' />
	<input type='hidden' name='notify_url' value='".e_PLUGIN."anteup/ipn_validate.php' />
	<input type='hidden' name='return' value='".e_PLUGIN."anteup/return.php?thanks' />
	<input type='hidden' name='cancel_return' value='".e_PLUGIN."anteup/return.php?cancel' />
	".(($pref['pal_no_shipping']) ? "<input type='hidden' name='no_shipping' value='".$pref['pal_no_shipping']."' />" : "")."
	".(($pref['pal_no_note']) ? "<input type='hidden' name='no_note' value='".$pref['pal_no_note']."' />" : "")."
	".(($pref['pal_cn']) ? "<input type='hidden' name='cn' value='".$pref['pal_cn']."' />" : "")."
	".(($pref['pal_page_style']) ? "<input type='hidden' name='page_style' value='".$pref['pal_page_style']."' />" : "")."
	".(($pref['pal_lc']) ? "<input type='hidden' name='lc' value='".$pref['pal_lc']."' />" : "")."
	".(($pref['pal_item_number']) ? "<input type='hidden' name='item_number' value='".$pref['pal_item_number']."' />" : "")."
	".(($pref['pal_custom']) ? "<input type='hidden' name='custom' value='".$pref['pal_custom']."' />" : "")."
	".(($pref['pal_invoice']) ? "<input type='hidden' name='invoice' value='".$pref['pal_invoice']."' />" : "")."
	".(($pref['pal_amount']) ? "<input type='hidden' name='amount' value='".$pref['pal_amount']."' />" : "")."
	".(($pref['pal_tax']) ? "<input type='hidden' name='tax' value='".$pref['pal_tax']."' />" : "")."
	<div style='padding-top:5px'>
	<input name='submit' type='image' src='".e_PLUGIN."anteup/images/icons/".$pref['pal_button_image']."' alt='$image_text' title='$pref[pal_button_popup]' style='border:none' />
	</div>
	</div>
	</form>";
}
$ns -> tablerender(ANTELAN_INDEX_CAPTION00, "<div style='text-align:center;'>".$text."</div>", 'anteup');
require_once(FOOTERF);
?>
