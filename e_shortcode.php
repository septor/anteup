<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if (!defined('e107_INIT')) { exit; }


/**
* Class anteup_shortcodes
 * @question do these shortcodes need to be available outside of the plugin and its menu?
 */

class anteup_shortcodes extends e_shortcode
{
	function __construct()
	{
		include_lan(e_PLUGIN.'anteup/languages/'.e_LANGUAGE.'_front.php');
	}

	function sc_anteup_currency($parm)
	{
		$currency = e107::getDb()->retrieve('anteup_currency',  '*', 'id = '.e107::pref('anteup', 'anteup_currency'));

		return (isset($parm['code']) ? $currency['code'] : $currency['symbol']);
	}

	function sc_anteup_goal($parm)
	{

		$preGoal = (isset($parm['campaign']) ? e107::getDb()->retrieve('anteup_campaign', 'goal_amount', 'id='.$parm['campaign']) : '0');

		if($preGoal != "0")
		{
			$goal = (isset($parm['format']) ? format_currency($preGoal, e107::pref('anteup', 'anteup_currency')) : $preGoal);
		}
		else
		{
			$goal = LAN_ANTEUP_MENU_05;
		}

		return $goal;
	}

	function sc_anteup_goaldate($parm)
	{
		$duration = (isset($parm['campaign']) ? e107::getDb()->retrieve('anteup_campaign', 'goal_date', 'id='.$parm['campaign']) : 'unending');

		if($duration != 'unending')
		{
			$output = e107::getDate()->convert_date($duration, e107::pref('anteup', 'anteup_dateformat'));
		}
		else
		{
			$output = "No End Date"; // TODO/WARNING: DO NOT LAN --  display goal_amount instead
		}

		return $output;
	}

	function sc_anteup_remaining($parm)
	{
		$pref = e107::pref('anteup');
		$campaign = (isset($parm['campaign']) ? $parm['campaign'] : 1);
		$current = get_info("current", $campaign);
		$goal = (int) e107::getDb()->retrieve("anteup_campaign", "goal_amount", "id='".$campaign."'");

		if($goal != "0")
		{
			$remaining = round($goal - $current, 2);
			$output = (isset($parm['format']) ? format_currency($remaining, $pref['anteup_currency']) : $remaining);
		}
		else
		{
			// The goal is set to 'unlimited' so there is no true remaining value.
			// ENHANCEMENT: Possibly output text to indicate this?
			$output = "";
		}

		return $output;
	}

	function sc_anteup_current($parm)
	{
		$campaign = (isset($parm['campaign']) ? $parm['campaign'] : 1);
		return (isset($parm['format']) ? format_currency(get_info("current", $campaign), e107::pref('anteup', 'anteup_currency')) : get_info("current", $campaign));
	}

	function sc_anteup_total($parm)
	{
		$campaign = (isset($parm['campaign']) ? $parm['campaign'] : 1);
		return (isset($parm['format']) ? format_currency(get_info("total", $campaign), e107::pref('anteup', 'anteup_currency')) : get_info("total", $campaign));
	}
	function sc_anteup_percent($parm)
	{
		$pref = e107::pref('anteup');
		$campaign = (isset($parm['campaign']) ? $parm['campaign'] : 1);
		$current = get_info("current",$campaign);
		$goal =  (!empty($pref['anteup_goal']) ? $pref['anteup_goal'] : 0);
		$output = round(($current / $goal) * 100, 0);

		return (isset($parm['format']) ? format_currency($output, $pref['anteup_currency']) : $output);
	}
	function sc_anteup_bar($parm='')
	{
		$goal = e107::pref('anteup', 'anteup_goal'); // fix for PHP < 5.5
		$campaign = (isset($parm['campaign']) ? $parm['campaign'] : 1);
		$goal = (!empty($goal) ? $goal : 0);
		$current = get_info("current", $campaign);
		$percent = round(($current / $goal) * 100, 0);

		// e107::getForm()->progressBar(); // @todo

		return "<div class='progress'>\n\t<div class='progress-bar' role='progressbar' aria-valuenow='".$percent."' aria-valuemin='0' aria-valuemax='100' style='width:".$percent."%'>\n\t\t<span class='sr-only'>".$percent."% donated</span>\n\t</div>\n</div>";
	}

	function sc_anteup_mostrecent($parm='')
	{
		$amount = (isset($parm['amount'])) ? (int) $parm['amount'] : 5;

		$recents = e107::getDb()->retrieve('anteup_ipn', 'user_id', 'ORDER BY payment_date LIMIT 0,'.$amount.'', true);

		if($recents)
		{
			$donatorsArray = array();
			foreach($recents as $recent)
			{
				if($recent['user_id'] == 0)
				{
					$donatorsArray[] = LAN_ANONYMOUS;
				}
				else
				{
					$userInfo = e107::user($recent['user_id']);
					if(!in_array($userInfo['user_name'], $donatorsArray))
					{
						$donatorsArray[] = $userInfo['user_name'];
					}
				}
			}

			$donators = implode(', ', $donatorsArray);

			return $donators;
		}
		else
		{
			return LAN_NONE;
		}
	}

	function sc_anteup_admin($parm='')
	{
		if(ADMIN)
		{
			return "<a href='".e_PLUGIN_ABS."anteup/admin_config.php'>".LAN_SETTINGS."</a>";
		}
	}

	function sc_anteup_menutext($parm='')
	{
		$text = e107::pref('anteup', 'anteup_menutext');
		return e107::getParser()->toHtml($text, true);
	}

	function sc_anteup_donatelink($parm='')
	{
		$pref = e107::pref('anteup');
		return "<a href='".e_PLUGIN_ABS."anteup/donate.php'><img src='".e_PLUGIN_ABS."anteup/images/".$pref['anteup_button']."' title='".$pref['anteup_button']."' style='border:none' /></a>";
	}

	function sc_anteup_campaignselector($parm)
	{
		$frm = e107::getForm();

		$campaigns = e107::getDb()->retrieve('anteup_campaign', 'name', '', true);

		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");

		$output = $frm->select('campaign', $campaigns, array('class', $class));

		return $output;
	}


	function sc_anteup_currencyselector($parm)
	{
		$sql = e107::getDb();
		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");
		$defaultCode = $sql->retrieve('anteup_currency',  'code', 'id = '.e107::pref('anteup', 'anteup_currency'));

		$sql->select("anteup_currency", "*");
		$selectArray = array();
		while($row = $sql->fetch())
		{
			$selectArray[$row['code']] = $row['description']." (".$row['symbol'].")";
		}

		return e107::getForm()->select('currency_code', $selectArray, $defaultCode, array('class', $class));
	}

	function sc_anteup_amountselector($parm)
	{
		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");
		$frm = e107::getForm();

		if($parm['textbox'])
		{
			$output = $frm->text('amount', '5.00', array('class' => $class));
		}
		else
		{
			$amountArray = array();
			for($i=1; $i<101; $i++)
			{
				$amountArray[$i.'.00'] = $i.'.00';
			}

			$output = $frm->select('amount', $amountArray, '5.00', array('class', $class));
		}

		return $output;
	}

	function sc_anteup_submitdonation($parm='')
	{
		$pref = e107::pref('anteup');

		return "<input name='submit' type='image' src='".e_PLUGIN_ABS."anteup/images/icons/".$pref['anteup_button']."' title='".$pref['anteup_button']."' style='border:none' />";
	}

	function sc_anteup_donation_filter($parm)
	{
		$frm = e107::getForm();

		$output = $frm->open('filter', 'post', e_REQUEST_URI);
		$output .= "
		<table class='table'>
			<tr>
				<td>".$frm->datepicker('startDate', $this->var[0], 'type=date&format=DD, dd MM, yyyy&size=medium')."</td>
				<td>".$frm->datepicker('endDate', $this->var[1], 'type=date&format=DD, dd MM, yyyy&size=medium')."</td>
				<td class='right'>".$frm->button('filterDates', 'Filter', 'submit')."</td>
			</tr>
		</table>";
		$output .= $frm->close();

		return $output;
	}

	function sc_anteup_campaign_name($parm)
	{
		return e107::getDb()->retrieve('anteup_campaign', 'name', 'id='.$parm['campaign'].'');
	}

	function sc_anteup_campaign_description($parm)
	{
		return e107::getDb()->retrieve('anteup_campaign', 'description', 'id='.$parm['campaign'].'');
	}

	function sc_anteup_donation_comment($parm='')
	{
		return $this->var['comment'];
	}

	function sc_anteup_donation_date($parm='')
	{
		if($parm['format'] == 'relative')
		{
			return e107::getParser()->toDate($this->var['payment_date'], 'relative');
		}

		$dateformat = e107::pref('anteup', 'anteup_dateformat');
		return e107::getParser()->toDate($this->var['payment_date'], $dateformat);
	}

	function sc_anteup_donation_amount($parm='')
	{
		return (isset($parm['format']) ? format_currency($this->var['mc_gross'], e107::pref('anteup', 'anteup_currency')) : $this->var['mc_gross']);
	}

	function sc_anteup_donation_txnid($parm='')
	{
		return $this->var['txn_id'];
	}

	function sc_anteup_donation_status($parm='')
	{
		return $this->var['payment_status'];
	}

	function sc_anteup_donation_donator($parm='')
	{
		// Check if donation was done anonymously, else lookup the username of the donator
		if($this->var['user_id'] == 0)
		{
			return LAN_ANONYMOUS;
		}
		else
		{
			$userInfo = e107::user($this->var['user_id']);
		}

		return $userInfo['user_name'];
	}

	function sc_anteup_pagetext($parm='')
	{
		$text = e107::pref('anteup', 'anteup_pagetext');
		return e107::getParser()->toHtml($text, true);
	}
}
