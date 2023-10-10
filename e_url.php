<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

class anteup_url // plugin-folder + '_url'
{
	function config() 
	{
		$config = array();

		$config['donations'] = array(
			'regex'			=> '^donations?',
			'sef'			=> 'donations',
			'redirect'		=> '{e_PLUGIN}anteup/donations.php',
		);

		$config['donate'] = array(
			'regex'			=> '^donate?',
			'sef'			=> 'donate',
			'redirect'		=> '{e_PLUGIN}anteup/donate.php',
		);

		return $config;
	}	
}