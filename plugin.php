<?php
// TODO: Trim out unneeded PayPal specific preferences? How many can safely be hardcoded in?
// TODO: Once Ante Up hits beta hardcoded text should be converted to LANs.


include_lan(e_PLUGIN."anteup/languages/".e_LANGUAGE.".php");

// -- [ PLUGIN INFO ]
$eplug_name			= "Ante Up!";
$eplug_version		= "0.2.0";
$eplug_author		= "Patrick Weaver";
$eplug_url			= "http://trickmod.com/";
$eplug_email		= "patrickweaver@gmail.com";
$eplug_description	= ANTELAN_PLUGIN_01;
$eplug_compatible	= "e107 v1.0+";
$eplug_readme		= "admin_readme.php";
$eplug_compliant	= TRUE;
$eplug_folder		= "anteup";
$eplug_menu_name	= "anteup_menu";
$eplug_conffile		= "admin_config.php";
$eplug_icon			= $eplug_folder."/images/icon.png";
$eplug_icon_small	= $eplug_icon;
$eplug_caption		= ANTELAN_PLUGIN_02; 

// -- [ DEFAULT PREFERENCES ]
$eplug_prefs = array(
    "anteup_currency" => '20',
    "anteup_full" => '63f578',
    "anteup_empty" => '888888',
    "anteup_border" => '000000',
    "anteup_height" => '12px',
    "anteup_width" => '90%',
    "anteup_goal" => '0',
    "anteup_lastdue" => date("m/d/Y"),
	"anteup_due" => date("m/d/Y", strtotime("last day of this month")),
    "anteup_description"  => ANTELAN_DONATIONS_09,  
    "anteup_dformat" => "short",
    "anteup_showibalance" => "0",
    "anteup_showtotal" => "0",
    "anteup_showcurrent" => "0",
    "anteup_showleft" => "0",
    "anteup_showdue" => "0",
	"anteup_showconfiglink" => "0",
	
    "pal_button_image" => "donate.gif",
    "pal_business" => ""
);
	
// -- [ MYSQL TABLES ]

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
		comment text,
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

foreach($anteup_cur as $cur){
	array_push($eplug_tables, "INSERT INTO ".MPREFIX."anteup_currency (`id`, `symbol`, `code`, `description`, `location`) VALUES ('', '".$cur[0]."', '".$cur[1]."', '".$cur[2]."', '".$cur[3]."');");
}

// -- [ MAIN SITE LINK ]
$eplug_link			= TRUE;
$eplug_link_name	= ANTELAN_PLUGIN_03;
$eplug_link_url		= e_PLUGIN."anteup/donations.php";

// -- [ INSTALLED MESSAGE ]
$eplug_done = $eplug_name.ANTELAN_PLUGIN_04;

// -- [ UPGRADE INFORMATION ]
$upgrade_add_prefs    = array(
	"anteup_showconfiglink" => "0"
);
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done   = $eplug_name.ANTELAN_PLUGIN_05;

?>
