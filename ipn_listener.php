<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 * IPN listener to receive PayPal IPN messages.
 * based on code by LonaLore: https://github.com/lonalore/paypal_donation
 *
*/

if(!defined('e107_INIT'))
{
	require_once('../../class2.php');
}

if(!e107::isInstalled('anteup'))
{
	e107::redirect();
	exit;
}

e107::lan('anteup', false, true);

class ipn_listener
{
	private $plugPrefs = null;

	public function __construct()
	{
		// Get plugin preferences.
		$this->plugPrefs = e107::getPlugConfig('anteup')->getPref();

		$ipn = $this->readIPN();
		$valid = $this->validateIPN($ipn);

		if($valid === true)
		{
			$this->processIPN();
		}
	}

	/**
	 * Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
	 * Instead, read raw POST data from the input stream.
	 *
	 * @return string
	 */
	private function readIPN()
	{
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);

		$myPost = array();
		foreach($raw_post_array as $keyval)
		{
			$keyval = explode('=', $keyval);
			if(count($keyval) == 2)
			{
				$myPost[$keyval[0]] = urldecode($keyval[1]);
			}
		}

		// Read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'.
		$req = 'cmd=_notify-validate';

		if(function_exists('get_magic_quotes_gpc'))
		{
			$get_magic_quotes_exists = true;
		}
		else
		{
			$get_magic_quotes_exists = false;
		}

		foreach($myPost as $key => $value)
		{
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
			{
				$value = urlencode(stripslashes($value));
			}
			else
			{
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}

		return $req;	
	}

	/**
	 * POST IPN data back to PayPal to validate.
	 *
	 * @param string $req
	 * @return bool
	 */
	private function validateIPN($req = null)
	{
		if($req)
		{
			if((int) $this->plugPrefs['anteup_sandbox'] === 1)
			{
				$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			}
			else
			{
				$url = 'https://www.paypal.com/cgi-bin/webscr';
			}

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

			// In wamp-like environments that do not come bundled with root authority certificates,
			// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
			// the directory path of the certificate as shown below:
			// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
			if(!($res = curl_exec($ch)))
			{
				if($logging)
				{
					e107::getLog()->add('cURL error', curl_error($ch), E_LOG_WARNING, 'ANTEUP');
				}

				curl_close($ch);
				exit;
			}

			curl_close($ch);

			if(strcmp($res, "VERIFIED") == 0)
			{
				return true;
			}
			else
			{
				e107::getLog()->add('IPN not verified', "result: ".$res, E_LOG_WARNING, 'ANTEUP');
			}
		}

		return false;
	}

	/**
	 * Process IPN data:
	 * - Done: Check whether the payment_status is Completed.
	 * - Done: Check that txn_id has not been previously processed.
	 * - Done: Check that receiver_email is your Primary PayPal email.
	 * - Done: Check that the "custom" value is a valid menu item.
	 * - Done: Process the notification.
	 */
	private function processIPN()
	{
		$log = e107::getLog();
		$db = e107::getDb();
		$tp = e107::getParser();

		$logging = (bool) $this->plugPrefs['anteup_logging'];

		if($logging)
		{
			$log->add('Start IPN processing', $_POST, E_LOG_INFORMATIVE, 'ANTEUP');
		}

		// Check whether the payment_status is Completed.
		$payment_status = vartrue($_POST['payment_status']);

		if(strtoupper($payment_status) != 'COMPLETED')
		{
			// TODO NOTIFY
			if($logging)
			{
				$log->add('Donation not completed', $_POST, E_LOG_WARNING, 'ANTEUP');
			}
			exit;
		}

		// Check that txn_id has not been previously processed.
		$txn_id = vartrue($_POST['txn_id'], 0);
		$exists = $db->count('anteup_ipn', '(*)', 'txn_id = "' . $tp->toDB($txn_id) . '"');

		if($exists > 0)
		{
			if($logging)
			{
				$log->add('Existing TXN ID', $_POST, E_LOG_WARNING, 'ANTEUP');
			}
			exit;
		}

		// Prepare fields
		$userid			= vartrue($_POST['custom'], '');
		$mc_gross 		= vartrue($_POST['mc_gross'], 0);
		$mc_currency 	= vartrue($_POST['mc_currency'], '');
		$payment_date 	= vartrue($_POST['payment_date'], '');
		$buyer_email    = vartrue($_POST['payer_email'], '');

		// Process IPN
		$data = array(
			"item_name"    		=> $tp->toDB($_POST['item_name']),
			"payment_status"    => $tp->toDB($payment_status),
			"mc_gross"      	=> (float) $mc_gross,
			"mc_currency"   	=> $tp->toDB($mc_currency),
			"txn_id"			=> $tp->toDB($txn_id),
			"user_id"			=> (int) $userid,
			"buyer_email"		=> $tp->toDB($buyer_email),
			'payment_date'  	=> strtotime($payment_date),
			"comment"           => $tp->toDB($_POST['memo']),
		);

		// In sandbox mode, only acknowledge the donation in the logs but do not add to database
		if((int) $this->plugPrefs['anteup_sandbox'] === 1)
		{
			$log->add('Sandbox donation data', $data, E_LOG_INFORMATIVE, 'ANTEUP');
		}
		else
		{
			// Insert data in database
			$id = $db->insert('anteup_ipn', $data);

			// Check if insert was successful and trigger event if it was
			if($id)
			{
				$event = e107::getEvent();
				$event->trigger('anteup_new_donation', $data);
				exit;
			}
			// Some error occured during the insertion process. Log it. 
			else
			{
				if($logging)
				{
					$error = $db->getLastErrorText(); 
					$log->add('SQL Insert Error', "SQL error: ".$error, E_LOG_WARNING, 'ANTEUP');
				}
				exit;
			}
		}
	}
}

new ipn_listener();
exit;