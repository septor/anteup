<?php
/*
* AnteUp - A Donation Tracking Plugin for e107
*
* Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
* For additional information refer to the README.mkd file.
*
*/
require_once("../../class2.php");
e107::lan('anteup');
define('PAGE_NAME', LAN_ANTEUP_DONATE_TITLE);

require_once(HEADERF);
require_once(e_PLUGIN."anteup/_class.php");


$pref = e107::getPlugPref('anteup');
$mes = e107::getMessage();

$sandbox_mode = false; 

// Check for sandbox mode 
if(e107::getPlugPref('anteup', 'anteup_sandbox'))
{
	$sandbox_mode = true; 
	$mes->addWarning(LAN_ANTEUP_SANDBOX_ON);
}

$url = ($sandbox_mode ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr"); 

if(!empty($pref['anteup_paypal']) && $pref['anteup_paypal'] != "yourpaypal@email.com")
{
	$frm = e107::getForm();
	$tp	= e107::getParser();
	$sc	= e107::getScBatch('anteup', true);
	$template = e107::getTemplate('anteup');

	$text = $frm->open('donate_form', 'post', $url);

	$text .= $tp->parseTemplate($template['donate'], true, $sc);
		
	$text .= $frm->hidden('cmd', '_donations');
	$text .= $frm->hidden('business', $pref['anteup_paypal']);
	$text .= $frm->hidden('notify_url', ANTEUP_ABS.'ipn_listener.php');
	$text .= $frm->hidden('return', ANTEUP_ABS.'return.php?thanks');
	$text .= $frm->hidden('cancel_return', ANTEUP_ABS.'return.php?cancel');

	if(USER)
	{
		$text .= $frm->hidden('custom', USERID);
	}	
	else
	{
		$text .= $frm->hidden('custom', "0");
	}

	$text .= $frm->close();
}
else
{
	$mes->addError(LAN_ANTEUP_DONATE_04);
}

e107::getRender()->tablerender(LAN_ANTEUP_DONATE_TITLE, $mes->render().$text);
require_once(FOOTERF);