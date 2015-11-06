<?php
/* 
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
class anteup_notify extends notify
{
	function config()
	{
		$config = array();
		$config[] = array(
			'name'		=> 'New Donation Notification',
			'function'	=> 'anteup_trigger',
			'category'	=> ''
		);

		return $config;
	}

	function anteup_trigger($data)
	{
		$message = print_a($data, true);
		$this->send('anteup_trigger', 'New Donation Notification', $message);
	}
}
?>
