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

	function sc_anteup_menutext($parm='')
	{
		$text = e107::pref('anteup', 'anteup_menutext');
		return ($text == "LAN_ANTEUP_MENU_TEXT" ? LAN_ANTEUP_MENU_TEXT : $text);
	}

	function sc_anteup_donatelink($parm='')
	{
		$pref = e107::pref('anteup');
		return "<a href='".e_PLUGIN."anteup/donate.php'><img src='".e_PLUGIN."anteup/images/icons/".$pref['anteup_button']."' title='".$pref['anteup_button']."' style='border:none' /></a>";
	}

	function sc_anteup_reasonselector($parm)
	{
		$frm = e107::getForm();

		$reasons = array(
			'thanks' => LAN_ANTEUP_DONATE_REASON_01,
			'noreason' => LAN_ANTEUP_DONATE_REASON_02,
			'costs' => LAN_ANTEUP_DONATE_REASON_03,
			'anonymous' => LAN_ANTEUP_DONATE_REASON_04
		);

		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");

		$output = $frm->select('item_name', $reasons, array('class', $class));
		if(USER)
			$output .= $frm->hidden('user_id', USERNAME);
		else
			$output .= $frm->hidden('user_id', LAN_ANTEUP_DONATE_ANONYMOUS);

		return $output;
	}


	function sc_anteup_currencyselector($parm)
	{
		$sql = e107::getDb();
		$class = (!empty($parm['class']) ? $parm['class'] : "tbox");
		$defaultCode = $sql->retrieve('anteup_currency',  'code', 'id = '.e107::pref('anteup', 'anteup_currency'));

		$sql->select("anteup_currency", "*");
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

		return "<input name='submit' type='image' src='".e_PLUGIN."anteup/images/icons/".$pref['anteup_button']."' title='".$pref['anteup_button']."' style='border:none' />";
	}

	function sc_anteup_donation_filter($parm)
	{
		$frm = e107::getForm();

		$output = $frm->open('filter');
		$output = "
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

	function sc_anteup_donation_name($parm='')
	{
		return $this->var['item_name'];
	}
	
	function sc_anteup_donation_comment($parm='')
	{
		return $this->var['comment'];
	}

	function sc_anteup_donation_date($parm='')
	{
		return e107::getParser()->toDate($this->var['payment_date'], relative);
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
		return $this->var['user_id'];
	}

	function sc_anteup_pagetext($parm='')
	{
		$text = e107::pref('anteup', 'anteup_pagetext');
		return ($text == "LAN_ANTEUP_PAGE_TEXT" ? LAN_ANTEUP_PAGE_TEXT : $text);
	}
}

?>
