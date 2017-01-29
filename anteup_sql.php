CREATE TABLE anteup_ipn (
	`ipn_id` int(10) unsigned NOT NULL auto_increment,
	`campaign` varchar(255) default NULL,
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

CREATE TABLE anteup_campaign (
	`id` int(10) unsigned NOT NULL auto_increment,
	`name` varchar(250) NOT NULL,
	`description` varchar(250) NOT NULL,
	`start_date` varchar(250) NOT NULL,
	`goal_date` varchar(250) NOT NULL,
	`goal_amount` varchar(250) NOT NULL,
	`status` int(10) NOT NULL,
	`viewclass` varchar(250) NOT NULL,
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;
