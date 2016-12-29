<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 * Based on PayPal IPN Listener
 * by Micah Carrick.
 * https://github.com/Quixotix/PHP-PayPal-IPN
*/

require_once("../../class2.php");
$pref = e107::pref('anteup');

 // tell PHP to log errors to ipn_errors.log in this directory
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

// instantiate the IpnListener class
include('ipnlistener.php');
$listener = new IpnListener();

// Check for sandbox mode 
$sandbox = e107::pref('anteup', 'anteup_sandbox'); 
if(vartrue($sandbox))
{
    $listener->use_sandbox = true;
}

// try to process the IPN POST
try
{
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
}
catch (Exception $e)
{
    error_log($e->getMessage());
    exit(0);
}

/*
The processIpn() method returned true if the IPN was "VERIFIED" and false if it
was "INVALID".
*/
if($verified)
{
    $errmsg = '';   // stores errors from fraud checks

    // 1. Make sure the payment status is "Completed"
    if ($_POST['payment_status'] != 'Completed')
        // simply ignore any IPN that is not completed
        exit(0);

    // 2. Make sure seller email matches your primary account email.
    if ($_POST['receiver_email'] != $pref['anteup_paypal'])
    {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }

    /* As AnteUp is a donation plugin, it doesn't really matter what amount and in what currency it is donated.
    These checks might be included at a later stage.

    / 3. Make sure the amount(s) paid match
    if ($_POST['mc_gross'] != '9.99') {
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $_POST['mc_gross']."\n";
    }

    // 4. Make sure the currency code matches
    if ($_POST['mc_currency'] != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }
    */

    if(!empty($errmsg))
    {
        // manually investigate errors from the fraud checking

        // TODO NOTIFY
        //$body = "IPN failed fraud checks: \n$errmsg\n\n";
        //$body .= $listener->getTextReport();
        //mail('YOUR@EMAIL.COM', 'IPN Fraud Warning', $body);
        exit;

    }
    else
    {

       //check if transaction ID has been processed before
        $txn_id = $_POST['txn_id'];
        $nm = $sql->count("anteup_ipn", "(txn_id)", "WHERE txn_id='".intval($txn_id)."'");

        if(!$nm)
        {
            if($user_id)
            {
                //Reads the actual user_name for the user
                $username - $sql->retrieve("user","*", "WHERE user_id='".$user_id."'");
            }
            else
            {
                $user_id = 0;
            }

            $payment_date = strtotime($_POST['payment_date']);

            $sql->insert("anteup_ipn",
                array(
                    "item_name"         => $_POST['item_name'],
                    "payment_status"    => $_POST['payment_status'],
                    "mc_gross"          => $_POST['mc_gross'],
                    "mc_currency"       => $_POST['mc_currency'],
                    "txn_id"            => $_POST['txn_id'],
                    "user_id"           => $user_id,
                    "buyer_email"       => $_POST['payer_email'],
					"payment_date"      => $payment_date,
                    "comment"           => $_POST['memo']
                )
			);
            // TODO - Notify succesfull donation
            //$body .= $listener->getTextReport();
			e107::getEvent()->trigger('anteup_trigger', $listener->getTextReport());
            //mail('YOUR@EMAIL.COM', 'VERIFIED TRANSACTION', $body);
        }
        else
        {
            // TODO - Notify duplicate transaction
            //mail("YOUR@EMAIL.COM", "VERIFIED DUPLICATED TRANSACTION", $txn_id);
        }
    }
}
else
{
    // manually investigate the invalid IPN

    // TODO - Notify
    //$body .= $listener->getTextReport();
    //mail('YOUR@EMAIL.COM', 'INVALID IPN', $body);
}
