<?php
include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");

// -- [ PLUGIN INFO ]  //TODO LANGUAGE?
$eplug_name			= "Ante Up!";
$eplug_version		= "1.0.0";
$eplug_author		= "Patrick Weaver";
$eplug_url			= "http://painswitch.com/";
$eplug_email		= "patrickweaver@gmail.com";
$eplug_description	= "An extensive Donation Tracker with PayPal integration.";
$eplug_compatible	= "e107 v1.0+";
$eplug_readme		= "admin_readme.php";
$eplug_compliant	= TRUE;
$eplug_folder		= "anteup";
$eplug_menu_name	= "anteup";
$eplug_conffile		= "admin_config.php";
$eplug_icon			= $eplug_folder."/images/icon.png";
$eplug_icon_small	= $eplug_icon;
$eplug_caption		= ANTELAN_CONFIG_CAPTION00; 

// -- [ DEFAULT PREFERENCES ]
$eplug_prefs = array(
    "anteup_currency" => '20',
    "anteup_full" => '63f578',
    "anteup_empty" => '888888',
    "anteup_border" => '000000',
    "anteup_height" => '12px',
    "anteup_goal" => '0',
    "anteup_lastdue" => date("m/d/Y"),
	"anteup_due" => date("m/d/Y", strtotime("last day of this month")),
    "anteup_description"  => LAN_TRACK_17, //TODO LANGUAGE?  
    "anteup_dformat" => "short",
    "anteup_showibalance" => "0",
    "anteup_showtotal" => "0",
	
    "pal_button_image" => "donate.gif",
    "pal_business" => "",
    "pal_item_name" => "",
    "pal_key_private" => md5(rand(0,rand(100,100000)).time()),
    "pal_no_shipping" => "1",
    "pal_no_note" => "",
    "pal_cn" => "",
    "pal_page_style" => "",
    "pal_lc" => "default",
    "pal_item_number" => "",
    "pal_custom" => "",
    "pal_invoice" => "",
    "pal_amount" => "",
    "pal_tax" => "" 
);
	
// -- [ MYSQL TABLES ]

$anteup_cur = array(
	array('&#36;AU','AUD', 'Australian Dollar', 'front'),
	array('C&#36;', 'CAD', 'Canadian Dollar', 'front'),
	array('SFr.', 'CHF', 'Swiss Franc', 'front'),
	array('K&#196;', 'CZK', 'Czech Koruna', 'front'),
	array('Dkr.', 'DKK', 'Danish Krone', 'front'),
	array('&#8364;', 'EUR', 'Euro', 'front'),
	array('&#163;', 'GBP', 'Pound Sterling', 'front'),
	array('HK&#36;', 'HKD', 'Hong Kong Dollar', 'front'),
	array('Ft', 'HUF', 'Hungarian Forint', 'front'),
	array('&#165;', 'JPY', 'Japanese Yen', 'front'),
	array('Mex&#36;', 'MXN', 'Mexican Peso', 'front'),
	array('Nkr.', 'NOK', 'Norwegian Krone', 'front'),
	array('NZ&#36;', 'NZD', 'New Zealand Dollar', 'front'),
	array('&#8369;', 'PHP', 'Philippine Peso', 'back'),
	array('P&#142;', 'PLN', 'Polish Zloty', 'front'),
	array('Skr.', 'SEK', 'Swedish Krona', 'front'),
	array('S&#36;', 'SGD', 'Singapore Dollar', 'front'),
	array('&#3647;', 'THB', 'Thai Baht', 'front'),
	array('T&#36;', 'TWD', 'Taiwan New Dollar', 'back'),
	array('&#36;', 'USD', 'U.S. Dollar', 'front')
);

$eplug_table_names = array("anteup_ipn", "anteup_currency");

$eplug_tables = array(
	"CREATE TABLE ".MPREFIX."anteup_ipn (
		ipn_id int(10) unsigned NOT NULL auto_increment,
		item_name varchar(255) default NULL,
		payment_status varchar(15) NOT NULL default '',
		mc_gross varchar(250) NOT NULL default '',
		mc_currency varchar(250) NOT NULL default '',
		txn_id varchar(250)  NOT NULL default '',
		user_id varchar(250) NOT NULL default '',
		buyer_email varchar(250) NOT NULL default '',
		payment_date varchar(250)  NOT NULL default '',
		mc_fee varchar(250)   NOT NULL default '',
		payment_fee varchar(250)   NOT NULL default '',
		type tinyint(1) NOT NULL default '0',
		comment text,
		custom varchar(50) NOT NULL default '',
		PRIMARY KEY (ipn_id)
	) ENGINE=MyISAM;",
	
	"CREATE TABLE ".MPREFIX."anteup_currency (
		id int(10) unsigned NOT NULL auto_increment,
		symbol varchar(250) NOT NULL,
		code varchar(250) NOT NULL,
		description varchar(250) NOT NULL,
		location varchar(250) NOT NULL,
		PRIMARY KEY  (id)
	) ENGINE=MyISAM AUTO_INCREMENT=1;"
);

foreach($anteup_cur as $cur){
	array_push($eplug_tables, "INSERT INTO ".MPREFIX."anteup_currency (`id`, `symbol`, `code`, `description`, `location`) VALUES ('', '".$cur[0]."', '".$cur[1]."', '".$cur[2]."', '".$cur[3]."');");
}

// -- [ MAIN SITE LINK ]
$eplug_link			= TRUE;
$eplug_link_name	= ANTELAN_MMENU_00;
$eplug_link_url		= e_PLUGIN."anteup/donations.php";

// -- [ INSTALLED MESSAGE ]
$eplug_done = $eplug_name." has been successfully installed."; //TODO LANGUAGE?

// -- [ UPGRADE INFORMATION ]
$upgrade_add_prefs    = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done   = $eplug_name." has been successfully upgraded."; //TODO LANGUAGE?

?>
