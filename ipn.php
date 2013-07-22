<?php
/**
 *  Based on PayPal IPN Listener
 *  by Micah Carrick. 
 *  https://github.com/Quixotix/PHP-PayPal-IPN
 *
 */

require_once("../../class2.php");


 // tell PHP to log errors to ipn_errors.log in this directory
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');


// instantiate the IpnListener class
include('ipnlistener.php');
$listener = new IpnListener();


// test mode enabled
$listener->use_sandbox = true;

// try to process the IPN POST
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
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
    if ($_POST['payment_status'] != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
    }

    // 2. Make sure seller email matches your primary account email.
    if ($_POST['receiver_email'] != $pref['pal_business']) {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }
    
    /* As Ante Up! is a donation plugin, it doesn't really matter what amount and in what currency it is donated. 
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
    
    if (!empty($errmsg)) {
    
        // manually investigate errors from the fraud checking

        // TODO NOTIFY
        //$body = "IPN failed fraud checks: \n$errmsg\n\n";
        //$body .= $listener->getTextReport();
        //mail('YOUR@EMAIL.COM', 'IPN Fraud Warning', $body);
        exit;
        
    } else {
    
       //check if transaction ID has been processed before
            $txn_id = $_POST['txn_id'];
            $nm = $sql->db_Count("anteup_ipn", "(txn_id)", "WHERE txn_id='".intval($txn_id)."'");
            if (!$nm){
                $user_id = $_POST['custom'];
                if($user_id){
                    //Reads the actual user_name for the user
                    $sql2->db_Select("user","*", "WHERE user_id='".$user_id."'");
                    $row = $sql2 -> db_Fetch();
                    $username = $row['user_name'];
                }
                $payment_date = strtotime($_POST['payment_date']);

                $sql->db_Insert("anteup_ipn", 
                    array(
                        "item_name"         => $_POST['item_name'],
                        "payment_status"    => $_POST['payment_status'],
                        "mc_gross"          => $_POST['mc_gross'],
                        "mc_currency"       => $_POST['mc_currency'],
                        "txn_id"            => $_POST['txn_id'],
                        "user_id"           => $user_id,
                        "buyer_email"       => $_POST['payer_email'],
                        "payment_date"      => $payment_date,
                        "mc_fee"            => $_POST['mc_fee'],
                        "payment_fee"       => $_POST['payment_fee'],
                        "type"              => $_POST['type'],
                        "comment"           => $_POST['memo'],
                        "custom"            => $_POST['custom']
                    )
                );      
                // TODO - Notify 
                //$body .= $listener->getTextReport();
                //mail('YOUR@EMAIL.COM', 'IPN', $body);
            }else{
                // TODO - Notify 
                //mail("YOUR@EMAIL.COM", "VERIFIED DUPLICATED TRANSACTION", $txn_id);
            }
    }
    
} else {
    // manually investigate the invalid IPN

    // TODO - Notify 
    //$body .= $listener->getTextReport();
    //mail('YOUR@EMAIL.COM', 'IPN', $body);
}
?>
