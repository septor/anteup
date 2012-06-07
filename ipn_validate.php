<?php
  /*---------------------------------------------------------------------------------------------------------\
  |                                                                                                          |
  |	                                  IPN DONATE PLUGIN FOR e107                                         |
  |                                                                                                          |
  |	                     + Lolo Irie     ( http://www.etalkers.org   )                                   |
  |                          + Cameron       ( http://www.e107coders.org )                                   |
  |                          + Barry Keal    ( http://www.keal.me.uk     )                                   |
  |                          + Richard Perry ( http://www.greycube.com   )                                   |
  |                          + Klutsh        ( http://www.x-projects.org )                                   |
  |                          + DelTree       ( http://www.lmsystema.com  )                                   |
  |                                                                                                          |
  |	    Released under the terms and conditions of the GNU General Public License (http://gnu.org)       |
  |                                                                                                          |
  \---------------------------------------------------------------------------------------------------------*/

require_once"../../class2.php";

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
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
} else {
   fputs ($fp, $header . $req);
   while (!feof($fp)) {
     $res = fgets ($fp, 1024);
     if (strcmp ($res, "VERIFIED") == 0) {
	//create MySQL connection
	$mydb = new db();
	$mydb->db_Connect($mySQLserver, $mySQLuser, $mySQLpassword, $mySQLdefaultdb);
	$fecha = date("m")."/".date("d")."/".date("Y");
	$fecha = date("Y").date("m").date("d");
	$paymentDateTmp=strtotime($payment_date);
	$olddate = strftime('%Y-%m-%d %H:%M:%S',$paymentDateTmp);
        $dt = explode("-",substr($olddate,0,10));
        $tm = explode(":",substr($olddate,11,8));
        $newdate = mktime($tm[0],$tm[1],$tm[2],$dt[1],$dt[2],$dt[0]);
	//check if transaction ID has been processed before
	$nm = $mydb->db_Count("ipn_info", "(txn_id)", "WHERE txn_id='".$txn_id."'");
	if (!$nm){
	   /* Example Code: Set's user class, Generates a Dummy Serial Number and incerts it to a user_extended table. */
           //Check if user_id has been passed

	   if($user_id){
	      //Sets the userclass_id to use
	      //$user_class = "2";
	      //Updates the users Record :: TODO: Check if Class already set
	      //$mydb->db_Update("user", "user_class='$user_class' WHERE user_id=".$user_id);
	      //Reads the actual user_name for the user
	      $mydb = new db;
	      $mydb->db_Select("user","*", "WHERE user_id=".$user_id);
	      $row = $mydb -> db_Fetch();
	      $username = $row['user_name'];
	      /*
	      //Create a Dummy Serial Number
	      $serial = md5(strtolower($username) . strtolower($txn_id));
	      //Incert Dummy Serial Number into the user_extended Table
	      // $result2 = $mydb->db_Insert("user_extended", array("user_extended_id" => "$user_id", "user_paypalid" => "$serial"));
	      // Insert on clan_user
	      $xdt = date("d.m.Y", time());
              $mydb = new db;
      	      $mydb->db_Select("clan_info","*");
     	      $row = $mydb -> db_Fetch();
     	      $xsqds = explode(",","        ,".$row['claninfo_cs_sqname']);
              $mydb = new db;
	      $mydb->db_Select("clan_roster","*", "WHERE clan_roster_id=".$user_id);
     	      $row = $mydb -> db_Fetch();
              $sqds = explode(",",$row['clan_roster_squads']);
              $mydb = new db;
	      $result2 = $mydb->db_Insert("clan_user", "NULL,".$user_id." , '".$xdt."', 'Donation', ".intval($mc_gross).", '".ucwords(strtolower($xsqds[$sqds[0]]))."'");
              $custom .= "|".$sqds[0];
              $comment .= "* ".ucwords(strtolower($xsqds[$sqds[0]]));
              */
	   }

           // Incert IPN info to the ipn_info Table
           $mydb = new db;
           $result = $mydb->db_Insert("ipn_info", array("item_name" => "$item_name", "payment_status" => "$payment_status", "mc_gross" => "$mc_gross", "mc_currency" => "$mc_currency",
           "txn_id" => "$txn_id", "user_id" => "$user_id", "buyer_email" => "$buyer_email", "payment_date" => "$newdate", "mc_fee" => "$mc_fee", "payment_fee" => "$payment_fee", "type" => "$type", "comment" => "$comment", "custom" => "$custom"));

	   /* End of Example Code */
	   echo "Verified";
	   if($pref['ipn_pal_ipn_notif']){
	     // send an email
	     mail($notify_email, "VERIFIED IPN", "$result");
	   }
	} else {
	   echo "Duplicate";
	   /* Example Code Only - Do NOT use
	   //create MySQL connection
	   $mydb = new db();
	   $mydb->db_Connect($mySQLserver, $mySQLuser, $mySQLpassword, $mySQLdefaultdb);
	   // Note the "payment_status" => "DUPLICATE"
	   $result = $mydb->db_Insert("ipn_info", array("item_name" => "$item_name", "payment_status" => "DUPLICATE", "mc_gross" => "$mc_gross",
	   "txn_id" => "$txn_id", "user_id" => "$user_id", "buyer_email" => "$buyer_email", "payment_date" => "$payment_date"));
	   // End of Example Code */
	   if($pref['ipn_pal_ipn_notif']){
	     // send an email
	     mail($notify_email, "VERIFIED DUPLICATED TRANSACTION", "$txn_id");
	   }
        }
     } else if (strcmp ($res, "INVALID") == 0) {
        // log for manual investigation
        echo "Invalid";
        /* Example Code Only - Do NOT use
        //create MySQL connection
        $mydb = new db();
        $mydb->db_Connect($mySQLserver, $mySQLuser, $mySQLpassword, $mySQLdefaultdb);
        // Note the "payment_status" => "INVALID"
        $result = $mydb->db_Insert("ipn_info", array("item_name" => "$item_name", "payment_status" => "INVALID", "mc_gross" => "$mc_gross",
        "txn_id" => "$txn_id", "user_id" => "$user_id", "buyer_email" => "$buyer_email", "payment_date" => "$payment_date"));
        // End of Example Code */
        if($pref['ipn_pal_ipn_notif']){
          // send an email
          mail($notify_email, "INVALID IPN", "$res\n $req");
        }
     }
  }
  fclose ($fp);
}
?>
