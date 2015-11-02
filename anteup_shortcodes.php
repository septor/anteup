<?php
/* 
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if(!defined('e107_INIT')){ exit; }

class anteup_shortcodes extends e_shortcode
{
	function sc_anteup_symbol($parm='')
	{
		return e107::getDb()->retrieve('anteup_currency',  'symbol', 'id = '.e107::pref('anteup', 'anteup_currency'));
	}

	function sc_anteup_code($parm='')
	{
		return e107::getDb()->retrieve('anteup_currency',  'code', 'id = '.e107::pref('anteup', 'anteup_currency'));
	}

	function sc_anteup_goal($parm='')
	{
		return (!empty(e107::pref('anteup', 'anteup_goal')) ? e107::pref('anteup', 'anteup_goal') : 0);
	}

	function sc_anteup_lastdue($parm='')
	{
		return e107::pref('anteup', 'anteup_lastdue');
	}

	function sc_anteup_due($parm='')
	{
		return e107::pref('anteup', 'anteup_due');
	}

	function sc_anteup_remaining($parm='')
	{
		$current = get_info("current");
		$goal =  (!empty(e107::pref('anteup', 'anteup_goal')) ? e107::pref('anteup', 'anteup_goal') : 0);

		return round($goal - $current, 2);
	}

	function sc_anteup_current($parm='')
	{
		return get_info("current");
	}

	function sc_anteup_total($parm='')
	{
		return get_info("total");
	}
	function sc_anteup_percent($parm='')
	{
		$current = get_info("current");
		$goal =  (!empty(e107::pref('anteup', 'anteup_goal')) ? e107::pref('anteup', 'anteup_goal') : 0);

		return round(($current / $goal) * 100, 0);
	}
	function sc_anteup_bar($parm='')
	{
		$goal = (!empty(e107::pref('anteup', 'anteup_goal')) ? e107::pref('anteup', 'anteup_goal') : 0);
		$current = get_info("current");
		$percent = round(($current / $goal) * 100, 0);
		
		return "<div class='progress'>\n\t<div class='progress-bar' role='progressbar' aria-valuenow='".$percent."' aria-valuemin='0' aria-valuemax='100' style='width:".$percent."%'>\n\t\t<span class='sr-only'>".$percent."% donated</span>\n\t</div>\n</div>";
	}

	function sc_anteup_admin($parm='')
	{
		if(ADMIN)
			return "<a href='".e_PLUGIN."anteup/admin_config.php'>".LAN_SETTINGS."</a>";
	}
}

?>
