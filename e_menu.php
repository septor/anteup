<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if (!defined('e107_INIT')) { exit; }

class anteup_menu
{
	function __construct()
	{
		//	e107::lan('banner','admin', 'true');
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu='')
	{
		$fields = array();
		//print_a($menu);

		$fields['caption'] 	= array(
			'title' 		=> LAN_CAPTION, 
			'type' 			=> 'text', 
			'multilan' 		=> true, 
			'writeParms' 	=> array('size' => 'xxlarge')
		);

		$fields['campaign'] = array(
			'title' 		=> "Campaign", // TODO LAN
			'type' 			=> 'method',
			'data'			=> 'array', 
		);

        return $fields;
	}
}


class anteup_menu_form extends e_form
{
	public function campaign($curVal)
	{
		$sql = e107::getDb();
		$frm = e107::getForm();

		$text = '';

		if(empty($curVal))
		{
			$curVal = 0;
		}

		$campaigns = array();

		// Add 'All campaigns' option (id = 0) to array
		$campaigns["0"] = LAN_ANTEUP_ALL_CAMPAIGNS; 

		// Get existing campaigns from database
		if($sql->select('anteup_campaign'))
		{
			while($row = $sql->fetch())
			{
				$campaigns[$row['id']] = $row['name'];
			}
		}		

		$text = $frm->select('campaign', $campaigns, $curVal);		

		return $text;
	}
}