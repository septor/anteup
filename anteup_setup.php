<?php

class anteup_setup
{
	function install_pre($var)
	{
		//
	}

	function install_post($var)
	{
		$sql = e107::getDb();
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

		$status = ($sql->gen($query_currencies)) ? E_MESSAGE_SUCCESS : E_MESSAGE_ERROR;
		$mes->add("Adding currencies", $status);
	}

	function uninstall_pre($var)
	{
		//
	}

	function upgrade_post($needed)
	{
		//
	}
}

?>
