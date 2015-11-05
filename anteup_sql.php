CREATE TABLE anteup_ipn (
	`ipn_id` int(10) unsigned NOT NULL auto_increment,
	`item_name` varchar(255) default NULL,
	`payment_status` varchar(15) NOT NULL default '',
	`mc_gross` varchar(250) NOT NULL default '',
	`mc_currency` varchar(250) NOT NULL default '',
	`txn_id` varchar(250) NOT NULL default '',
	`user_id` varchar(250) NOT NULL default '',
	`buyer_email` varchar(250) NOT NULL default '',
	`payment_date` varchar(250) NOT NULL default '',
	`comment` text,
	PRIMARY KEY (`ipn_id`)
) ENGINE=MyISAM;

CREATE TABLE anteup_currency (
	`id` int(10) unsigned NOT NULL auto_increment,
	`symbol` varchar(250) NOT NULL,
	`code` varchar(250) NOT NULL,
	`description` varchar(250) NOT NULL,
	`location` varchar(250) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;
