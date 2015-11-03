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

	function sc_anteup_goal($parm)
	{
		$pref = e107::pref('anteup');
		$output = (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : 0);

		return (isset($parm['format']) ? format_currency($output, $pref['anteup_currency']) : $output);
	}

	function sc_anteup_lastdue($parm='')
	{
		return e107::pref('anteup', 'anteup_lastdue');
	}

	function sc_anteup_due($parm='')
	{
		return e107::pref('anteup', 'anteup_due');
	}

	function sc_anteup_remaining($parm)
	{
		$pref = e107::pref('anteup');
		$current = get_info("current");
		$goal =  (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : 0);
		$output = round($goal - $current, 2);

		return (isset($parm['format']) ? format_currency($output, $pref['anteup_currency']) : $output);
	}

	function sc_anteup_current($parm)
	{
		return (isset($parm['format']) ? format_currency(get_info("current"), e107::pref('anteup', 'anteup_currency')) : get_info("current"));
	}

	function sc_anteup_total($parm)
	{
		return (isset($parm['format']) ? format_currency(get_info("total"), e107::pref('anteup', 'anteup_currency')) : get_info("total"));
	}
	function sc_anteup_percent($parm)
	{
		$pref = e107::pref('anteup');
		$current = get_info("current");
		$goal =  (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : 0);
		$output = round(($current / $goal) * 100, 0);

		return (isset($parm['format']) ? format_currency($output, $pref['anteup_currency']) : $output);
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

	function sc_anteup_donator($parm)
	{
		if(USER)
		{
			$output = "<input type='hidden' name='item_name' value='".USERNAME."' />\n".USERNAME."";
		}
		else
		{
			$class = (!empty($parm['class']) ? $parm['class'] : "tbox");
			$output = "<input name='item_name' type='text' class='".$class."' id='item_name' value='' maxlength='50' />";
		}

		return $output;
	}

	function sc_anteup_currencyselector($parm)
	{
		$sql = e107::getDb();
		$pref = e107::pref('anteup');

		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");
		$output = "<select class='".$class."' name='currency_code'>";

		$sql->select("anteup_currency", "*");
		while($row = $sql->fetch())
		{
			$output .= "<option value='".$row['code']."'".($row['id'] == $pref['anteup_currency'] ? " selected" : "").">".$row['description']." (".$row['symbol'].")</option>";
		}

		$output .= "</select>";

		return $output;
	}
	
	function sc_anteup_amountselector($parm)
	{
		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");
		$output = "<select class='".$class."' name='amount'>
		<option value='0.00'>".ANTELAN_DONATE_04."</option>
		<option value='1.00'>1.00</option>
		<option value='5.00' selected>5.00</option>
		<option value='10.00'>10.00</option>
		<option value='15.00'>15.00</option>
		<option value='20.00'>20.00</option>
		<option value='30.00'>30.00</option>
		<option value='40.00'>40.00</option>
		<option value='50.00'>50.00</option>
		<option value='100.00'>100.00</option>
		<option value='500.00'>500.00</option>
		</select>";

		return $output;
	}

	function sc_anteup_submitdonation($parm='')
	{
		$pref = e107::pref('anteup');

		return "<input name='submit' type='image' src='".e_PLUGIN."anteup/images/icons/".$pref['anteup_button']."' title='".$pref['anteup_button']."' style='border:none' />";
	}
}

?>
