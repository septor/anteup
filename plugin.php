<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By roofdog78 & DelTree
|    
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|     Plugin support at http://www.roofdog78.com
|     
|     For the e107 website system visit http://e107.org     
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");


// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name        = "Roofdog Donation Tracker";
$eplug_version     = "2.7";
$eplug_author      = "DelTree, roofdog78, Cameron, Barry, Richard, Klutsh";
$eplug_url         = "http://www.roofdog78.com/";
$eplug_email       = "e107@roofdog78.com";
$eplug_description = "Displays a donation meter, allows admin to manually input a list of donators. Full PayPal integration with IPN and Financial Cash Control. 12 currencies supported.";
$eplug_compatible  = "e107v0.7+";
$eplug_readme      = "readme.txt";
$eplug_compliant   = TRUE;
$eplug_module      = FALSE;


// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = "rdonation_tracker";

// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = "rdtrack";

// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = "admin_config.php";

// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon = "$eplug_folder/logo_32.png";
$eplug_icon_small = "$eplug_folder/logo_16.png";
$eplug_caption = LAN_TRACK_00;

// List of preferences -----------------------------------------------------------------------------------------------
$eplug_prefs = array(
    "rdtrack_currency"  => '£',
    "rdtrack_full"      => 'ff902f',
    "rdtrack_empty"     => 'c0c0c0',
    "rdtrack_border"    => '000000',
    "rdtrack_height"    => '12px',
    "rdtrack_goal"      => '0',
    "rdtrack_current"   => '0',
    "rdtrack_ibalance"  => '0',
    "rdtrack_description"  => LAN_TRACK_17,    
    "rdtrack_dformat"      => "0",
    "rdtrack_ibalance"     => "0",
    "rdtrack_showibalance" => "0",
    "rdtrack_showbalance"  => "255",
    "rdtrack_showlist"     => "1",
    "rdtrack_showdate"     => "1",
    "rdtrack_showvalue"    => "1",

    "pal_menu_caption"  => "Month Donations",
    "pal_text"          => "",
    "pal_button_image"  => "donate.gif",
    "pal_button_popup"  => LAN_TRACK_PAL_08,
    "pal_business"      => "",
    "pal_item_name"     => "",
    "pal_currency_code" => "GBP",
    "pal_no_protection" => "",
    "pal_key_private"   => "abc123",

    "pal_no_shipping"   => "1",
    "pal_no_note"       => "",
    "pal_cn"            => "",
    "pal_ipn_file"      => SITEURL."e107_plugins/$eplug_folder/ipn_validate.php",
    "pal_return"        => SITEURL."e107_plugins/$eplug_folder/thank_you.php",
    "pal_cancel_return" => SITEURL."e107_plugins/$eplug_folder/cancel_return.php",
    "pal_page_style"    => "",

    "pal_lc"            => "GB",
    "pal_item_number"   => "",
    "pal_custom"        => "",
    "pal_invoice"       => "",
    "pal_amount"        => "",
    "pal_tax"           => "" 
);
	
//MYSQL TABLES TO BE CREATED---------------------------------------------------------------------------------+
$eplug_table_names = array("ipn_info");

//MYSQL TABLE STRUCTURE--------------------------------------------------------------------------------------+
$eplug_tables = array("
	CREATE TABLE ".MPREFIX."ipn_info (
		ipn_id            int(11)      unsigned NOT NULL auto_increment,
	  	item_name         varchar(255) default NULL,
  		payment_status    varchar(15)  NOT NULL default '',
		mc_gross          varchar(10)  NOT NULL default '',
		mc_currency       varchar(15)  NOT NULL default '',
		txn_id            varchar(30)  NOT NULL default '',
		user_id           varchar(100) NOT NULL default '',
		buyer_email       varchar(100) NOT NULL default '',
		payment_date      varchar(15)  NOT NULL default '',
		mc_fee            varchar(6)   NOT NULL default '',
		payment_fee       varchar(6)   NOT NULL default '',
		type              tinyint(1)   NOT NULL default '0',
		comment           text,
		custom            varchar(50)  NOT NULL default '',
		PRIMARY KEY  (ipn_id)
		) TYPE=MyISAM;"
);


// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = TRUE;
$eplug_link_name = LAN_TRACK_M_0;
$eplug_link_url = e_PLUGIN.$eplug_folder."/donations.php";

// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = LAN_TRACK_10."<br>".LAN_TRACK_16;

// Same as above but only when choosing upgrade  -------------------------------------------------------------------
$upgrade_add_prefs = array(
  "pal_button_popup"     => "",
  "pal_no_protection"    => "",
  "pal_key_private"      => "abc123",
  "pal_ipn_file"         => SITEURL."e107_plugins/$eplug_folder/ipn_validate.php",
  "pal_return"           => SITEURL."e107_plugins/$eplug_folder/thank_you.php",
  "pal_cancel_return"    => SITEURL."e107_plugins/$eplug_folder/cancel_return.php",
  "rdtrack_description"  => LAN_TRACK_17,
  "rdtrack_showlist"     => "1",
  "rdtrack_showdate"     => "1",
  "rdtrack_showvalue"    => "1",
  "rdtrack_dformat"      => "0",
  "rdtrack_ibalance"     => "0",
  "rdtrack_showibalance" => "0",
  "rdtrack_showbalance"  => "255"
  );

  $upgrade_remove_prefs = "";
  $eplug_upgrade_done   = LAN_TRACK_11."<br>".LAN_TRACK_16;

?>
