<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
class anteup_setup
{
	function install_pre($var)
	{
	}

	function install_post($var)
	{
		$query_currencies = "
		INSERT INTO `#anteup_currency` (`id`, `symbol`, `code`, `description`, `location`) VALUES
			(1, '&#36;AU','AUD', 'Australian Dollar', 'front'),
			(2, 'C&#36;', 'CAD', 'Canadian Dollar', 'front'),
			(3, 'SFr.', 'CHF', 'Swiss Franc', 'front'),
			(4, 'K&#196;', 'CZK', 'Czech Koruna', 'front'),
			(5, 'Dkr.', 'DKK', 'Danish Krone', 'front'),
			(6, '&#8364;', 'EUR', 'Euro', 'front'),
			(7, '&#163;', 'GBP', 'Pound Sterling', 'front'),
			(8, 'HK&#36;', 'HKD', 'Hong Kong Dollar', 'front'),
			(9, 'Ft', 'HUF', 'Hungarian Forint', 'front'),
			(10, '&#165;', 'JPY', 'Japanese Yen', 'front'),
			(11, 'Mex&#36;', 'MXN', 'Mexican Peso', 'front'),
			(12, 'Nkr.', 'NOK', 'Norwegian Krone', 'front'),
			(13, 'NZ&#36;', 'NZD', 'New Zealand Dollar', 'front'),
			(14, '&#8369;', 'PHP', 'Philippine Peso', 'back'),
			(15, 'P&#142;', 'PLN', 'Polish Zloty', 'front'),
			(16, 'Skr.', 'SEK', 'Swedish Krona', 'front'),
			(17, 'S&#36;', 'SGD', 'Singapore Dollar', 'front'),
			(18, '&#3647;', 'THB', 'Thai Baht', 'front'),
			(19, 'T&#36;', 'TWD', 'Taiwan New Dollar', 'back'),
			(20, '&#36;', 'USD', 'U.S. Dollar', 'front')
		";

		$status_currencies = (e107::getDb()->gen($query_currencies)) ? E_MESSAGE_SUCCESS : E_MESSAGE_ERROR;
		e107::getMessage()->add("Adding currencies", $status_currencies);

		$default_campaign = "
		INSERT INTO `#anteup_campaign` (`id`, `name`, `description`, `start_date`, `goal_date`, `goal_amount`, 'status', 'viewclass') VALUES
			(1, 'Default Campaign', 'A default campaign for all donations.', '".time()."', '', '0', '1', '')
		";

		$status_campaign = (e107::getDb()->gen($default_campaign)) ? E_MESSAGE_SUCCESS : E_MESSAGE_ERROR;
		e107::getMessage()->add("Adding default campaign". $status_campaign);
	}

	function uninstall_pre($var)
	{
	}

	function upgrade_post($needed)
	{

		// Files that can cause conflicts and problems.
		$deprecated = array(
			e_PLUGIN."anteup/cert/",
			e_PLUGIN."anteup/cert/api_cert_chain.crt",
			e_PLUGIN."anteup/ipn.php",
			e_PLUGIN."anteup/ipnlistener.php",
			e_PLUGIN."anteup/anteup_shortcodes.php"
		);

		foreach($deprecated as $file)
		{
			if(!file_exists($file))
			{
				continue;
			}
			if(@unlink($file))
			{
				e107::getMessage()->addSuccess("Deleted old file: ".$file);
			}
			else
			{
				e107::getMessage()->addError("Unable to delete ".$file.". Please remove the file manually.");
			}
		}

		// Refresh the plugin directory to make e107 aware of any changes that took place.
		e107::getPlugin()->refresh('anteup');

		//TODO: Create anteup_campaign if it doesn't exist and auto fill it with a default campaign.
	}
}
