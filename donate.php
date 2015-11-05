<?php
/* 
* AnteUp - A Donation Tracking Plugin for e107
*
* Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
* For additional information refer to the README.mkd file.
*
*/
require_once("../../class2.php");
require_once(HEADERF);
require_once(e_PLUGIN."anteup/_class.php");
e107::lan('anteup');

$pref = e107::pref('anteup');

if(!empty($pref['anteup_paypal']) || $pref['anteup_paypal'] != "youremail@email.com")
{
	$frm = e107::getForm();
	$tp	= e107::getParser();
	$sc	= e107::getScBatch('anteup', true);
	$template = e107::getTemplate('anteup');

	$text = $frm->open('donate_form', 'post', 'https://www.paypal.com/cgi-bin/webscr');

	$text .= $tp->parseTemplate($template['donate'], false, $sc);

	$text .= $frm->hidden('cmd', '_xclick');
	$text .= $frm->hidden('business', $pref['anteup_paypal']);
	$text .= $frm->hidden('notify_url', ANTEUP_ABS.'ipn.php');
	$text .= $frm->hidden('return', ANTEUP_ABS.'return.php?thanks');
	$text .= $frm->hidden('cancel_return', ANTEUP_ABS.'return.php?cancel');
	$text .= $frm->close();
}
else
{
	$text = "<div class='center'>".LAN_ANTEUP_DONATE_05."</div>";
}

e107::getRender()->tablerender(LAN_ANTEUP_DONATE_TITLE, $text);
require_once(FOOTERF);
?>
