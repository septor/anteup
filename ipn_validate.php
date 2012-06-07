<?php
require_once("../../class2.php");

$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$header = "
POST /cgi-bin/webscr HTTP/1.0\r\n
Content-Type: application/x-www-form-urlencoded\r\n
Content-Length: ".strlen($req)."\r\n\r\n
";

$pref['ipn_pal_sand'] = "1";
if($pref['ipn_pal_sand']=="0"){
	$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);
}else{
	$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
}

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$payment_status = $_POST['payment_status'];
$mc_gross = $_POST['mc_gross'];
$txn_id = $_POST['txn_id'];
$user_id = $_POST['custom'];
$receiver_email = $_POST['receiver_email'];
$buyer_email = $_POST['payer_email'];
$payment_date = $_POST['payment_date'];
$mc_fee = $_POST['mc_fee'];
$payment_fee = $_POST['payment_fee'];
$mc_currency = $_POST['mc_currency'];
$custom = $_POST['custom'];
$comment = "";
$type = 0;
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$custom .= $first_name. " ".$last_name;

if (strlen($item_name) < 1){
  $item_name = $first_name." ".$last_name;
}
//email address to which debug emails are sent to
$notify_email = $pref['pal_business'];
$pref['ipn_pal_ipn_notif'] = "";

if (!$fp) {
	// HTTP ERROR
}else{
	fputs($fp, $header . $req);
	while(!feof($fp)){
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) {
			$fecha = date("m/d/Y");
			$paymentDateTmp = strtotime($payment_date);
			$olddate = strftime('%Y-%m-%d %H:%M:%S',$paymentDateTmp);
			$dt = explode("-",substr($olddate,0,10));
			$tm = explode(":",substr($olddate,11,8));
			$newdate = mktime($tm[0],$tm[1],$tm[2],$dt[1],$dt[2],$dt[0]);
			//check if transaction ID has been processed before
			$nm = $sql->db_Count("anteup_ipn", "(txn_id)", "WHERE txn_id='".intval($txn_id)."'");
			if (!$nm){
				if($user_id){
					//Reads the actual user_name for the user
					$sql2->db_Select("user","*", "WHERE user_id='".intval($user_id)."'");
					$row = $sql2 -> db_Fetch();
					$username = $row['user_name'];
				}

				$sql->db_Insert("anteup_ipn", 
					array(
						"item_name" => $item_name,
						"payment_status" => $payment_status,
						"mc_gross" => $mc_gross,
						"mc_currency" => $mc_currency,
						"txn_id" => $txn_id,
						"user_id" => $user_id,
						"buyer_email" => $buyer_email,
						"payment_date" => $newdate,
						"mc_fee" => $mc_fee,
						"payment_fee" => $payment_fee,
						"type" => $type,
						"comment" => $comment,
						"custom" => $custom
					)
				);		

				echo "Verified";
				if($pref['ipn_pal_ipn_notif']){
					mail($notify_email, "VERIFIED IPN", $result);
				}
			}else{
				echo "Duplicate";
				if($pref['ipn_pal_ipn_notif']){
					mail($notify_email, "VERIFIED DUPLICATED TRANSACTION", $txn_id);
				}
			}
		}else if(strcmp ($res, "INVALID") == 0){
			// log for manual investigation
			echo "Invalid";
			if($pref['ipn_pal_ipn_notif']){
				mail($notify_email, "INVALID IPN", "$res\n $req");
			}
		}
	}
	fclose ($fp);
}
?>