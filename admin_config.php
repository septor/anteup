<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */
require_once('../../class2.php');
if (!getperms('P'))
{
	header('location:'.e_BASE.'index.php');
	exit;
}
e107::lan('anteup', 'admin', true);

class anteup_adminArea extends e_admin_dispatcher
{
	protected $modes = array(
		'main'	=> array(
			'controller' 	=> 'anteup_ipn_ui',
			'path' 			=> null,
			'ui' 			=> 'anteup_ipn_form_ui',
			'uipath' 		=> null
		),
		'currency'	=> array(
			'controller' 	=> 'anteup_currency_ui',
			'path' 			=> null,
			'ui' 			=> 'anteup_currency_form_ui',
			'uipath' 		=> null
		),
	);

	protected $adminMenu = array(
		'main/list'			=> array('caption'=> LAN_ANTEUP_MANAGE_DONATIONS, 'perm' => 'P'),
		'main/create'		=> array('caption'=> LAN_ANTEUP_CREATE_DONATIONS, 'perm' => 'P'),
		'currency/list'		=> array('caption'=> LAN_ANTEUP_MANAGE_CURRENCIES, 'perm' => 'P'),
		'currency/create'	=> array('caption'=> LAN_ANTEUP_CREATE_CURRENCIES, 'perm' => 'P'),
		'main/prefs' 		=> array('caption'=> LAN_ANTEUP_PREFERENCES, 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = 'AnteUp';
}

class anteup_ipn_ui extends e_admin_ui
{
	protected $pluginTitle		= 'AnteUp';
	protected $pluginName		= 'anteup';
	//	protected $eventName		= 'anteup-anteup_ipn'; // remove comment to enable event triggers in admin.
	protected $table			= 'anteup_ipn';
	protected $pid				= 'ipn_id';
	protected $perPage			= 20;
	protected $batchDelete		= true;
	//	protected $batchCopy		= true;
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'ipn_id DESC';

	protected $fields = array (
		'checkboxes' =>   array (
			'title' => '',
			'type' => null,
			'data' => null,
			'width' => '5%',
			'thclass' => 'center',
			'forced' => '1',
			'class' => 'center',
			'toggle' => 'e-multiselect',
		),
		'ipn_id' =>   array (
			'title' => LAN_ID,
			'data' => 'int',
			'width' => '5%',
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'item_name' => array (
			'title' => LAN_ANTEUP_IPN_01,
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'payment_status' => array (
			'title' => LAN_ANTEUP_IPN_02,
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'mc_gross' =>   array (
			'title' => LAN_ANTEUP_IPN_03,
			'type' => 'text',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'mc_currency' => array (
			'title' => LAN_ANTEUP_IPN_04,
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'txn_id' => array (
			'title' => LAN_ANTEUP_IPN_05,
			'type' => 'text',
			'data' => 'str',
			'width' => '5%',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'user_id' => array (
			'title' => LAN_USER,
			'type' => 'user',
			'data' => 'str',
			'width' => '5%',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'buyer_email' => array (
			'title' => LAN_EMAIL,
			'type' => 'email',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'payment_date' => array (
			'title' => LAN_ANTEUP_IPN_06,
			'type' => 'datestamp',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'filter' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'comment' =>   array (
			'title' => LAN_ANTEUP_IPN_07,
			'type' => 'textarea',
			'data' => 'str',
			'width' => '40%',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'options' =>   array (
			'title' => LAN_OPTIONS,
			'type' => null,
			'data' => null,
			'width' => '10%',
			'thclass' => 'center last',
			'class' => 'center last',
			'forced' => '1',
		),
	);

	protected $fieldpref = array('payment_date', 'user_id', 'txn_id', 'buyer_email', 'comment', 'payment_status', 'mc_gross');

	protected $prefs = array(
		'anteup_mtitle' => array(
			'title' => LAN_ANTEUP_PREFS_01_A,
			'type' => 'text',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_01_B,
		),
		'anteup_currency' => array(
			'title' => LAN_ANTEUP_PREFS_02_A,
			'type' => 'dropdown',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_02_B,
		),
		'anteup_goal' => array(
			'title' => LAN_ANTEUP_PREFS_03_A,
			'type' => 'text',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_03_B,
		),
		'anteup_due' => array(
			'title' => LAN_ANTEUP_PREFS_04_A,
			'type' => 'datestamp',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_04_B,
		),
		'anteup_lastdue' => array(
			'title' => LAN_ANTEUP_PREFS_05_A,
			'type' => 'datestamp',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_05_B,
		),
		'anteup_menutext' => array(
			'title' => LAN_ANTEUP_PREFS_06_A,
			'type' => 'text',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_06_B,
		),
		'anteup_pagetext' => array(
			'title' => LAN_ANTEUP_PREFS_07_A,
			'type' => 'textarea',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_07_B,
		),
		'anteup_pageviewclass' => array(
			'title' => LAN_ANTEUP_PREFS_08_A,
			'type' => 'userclass',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_08_B,
		),
		'anteup_menuviewclass' => array(
			'title' => LAN_ANTEUP_PREFS_09_A,
			'type' => 'userclass',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_09_B,
		),
		'anteup_button' => array(
			'title' => LAN_ANTEUP_PREFS_10_A,
			'type' => 'dropdown',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_10_B,
		),
		'anteup_paypal' => array(
			'title' => LAN_ANTEUP_PREFS_11_A,
			'type' => 'text',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_11_B,
		),
		'anteup_dateformat' => array(
			'title' => LAN_ANTEUP_PREFS_12_A,
			'type' => 'dropdown',
			'data' => 'str',
			'help' => LAN_ANTEUP_PREFS_12_B,
		),
	);

	public function init()
	{
		// create donation page
		$sql = e107::getDb();

		$this->currency[0] = "default";
		if($sql->select('anteup_currency'))
		{
			while($row = $sql->fetch())
			{
				$this->currency[$row['id']] = $row['description']." (".$row['code'].")";
			}
		}

		$this->fields['mc_currency']['writeParms'] = $this->currency;

		$this->donateReason = array(
			'thanks' => LAN_ANTEUP_IPN_11,
			'noreason' => LAN_ANTEUP_IPN_12,
			'costs' => LAN_ANTEUP_IPN_13,
			'anonymous' => LAN_ANTEUP_IPN_14
		);
		$this->fields['item_name']['writeParms'] = $this->donateReason;

		$this->status = array('Pending' => LAN_ANTEUP_IPN_08, 'Completed' => LAN_ANTEUP_IPN_09, 'Denied' => LAN_ANTEUP_IPN_10);
		$this->fields['payment_status']['writeParms'] = $this->status;

		// preferences
		$this->prefs['anteup_currency']['writeParms'] = $this->currency;

		$this->dateformat = array('short' => LAN_ANTEUP_PREFS_13, 'long' => LAN_ANTEUP_PREFS_14, 'relative' => LAN_ANTEUP_PREFS_15);
		$this->prefs['anteup_dateformat']['writeParms'] = $this->dateformat;

		$this->donateImage[e107::pref('anteup', 'anteup_button')] = e107::pref('anteup', 'anteup_button');
		foreach(glob(e_PLUGIN."anteup/images/icons/*.gif") as $icon)
		{
			$icon = str_replace(e_PLUGIN."anteup/images/icons/", "", $icon);

			if($icon != e107::pref('anteup', 'anteup_button'))
			{
				$this->donateImage[$icon] = $icon;
			}
		}
		$this->prefs['anteup_button']['writeParms'] = $this->donateImage;
	}
	// ------- Customize Create --------
	public function beforeCreate($new_data)
	{
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onCreateError($new_data, $old_data)
	{
		// do something
	}

	// ------- Customize Update --------
	public function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something
	}

		/*
		// optional - a custom page.
		public function customPage()
		{
			$text = 'Hello World!';
			return $text;

		}
		*/
}

class anteup_ipn_form_ui extends e_admin_form_ui
{
}

class anteup_currency_ui extends e_admin_ui
{
	protected $pluginTitle		= 'AnteUp';
	protected $pluginName		= 'anteup';
	//	protected $eventName		= 'anteup-anteup_currency'; // remove comment to enable event triggers in admin.
	protected $table			= 'anteup_currency';
	protected $pid				= 'id';
	protected $perPage			= 20;
	protected $batchDelete		= true;
	//	protected $batchCopy		= true;
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

	protected $listOrder		= 'id DESC';

	protected $fields = array (
		'checkboxes' =>   array (
			'title' => '',
			'type' => null,
			'data' => null,
			'width' => '5%',
			'thclass' => 'center',
			'forced' => '1',
			'class' => 'center',
			'toggle' => 'e-multiselect',
		),
		'id' => array (
			'title' => LAN_ID,
			'data' => 'int',
			'width' => '5%',
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'symbol' => array (
			'title' => LAN_ANTEUP_CURR_01,
			'type' => 'text',
			'data' => 'str',
			'width' => 'auto',
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'code' =>   array (
			'title' => LAN_ANTEUP_CURR_02,
			'type' => 'text',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'description' =>   array (
			'title' => LAN_DESCRIPTION,
			'type' => 'text',
			'data' => 'str',
			'width' => '40%',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'location' => array (
			'title' => LAN_ANTEUP_CURR_03,
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'options' =>   array (
			'title' => LAN_OPTIONS,
			'type' => null,
			'data' => null,
			'width' => '10%',
			'thclass' => 'center last',
			'class' => 'center last',
			'forced' => '1',
		),
	);

	protected $fieldpref = array();

	public function init()
	{
		$this->symLoc = array('front' => LAN_ANTEUP_CURR_04, 'back' => LAN_ANTEUP_CURR_05);
		$this->fields['location']['writeParms'] = $this->symLoc;
	}

	// ------- Customize Create --------
	public function beforeCreate($new_data)
	{
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onCreateError($new_data, $old_data)
	{
		// do something
	}

	// ------- Customize Update --------
	public function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
		// do something
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
		// do something
	}
		/*
		// optional - a custom page.
		public function customPage()
		{
			$text = 'Hello World!';
			return $text;

		}
		*/
}

class anteup_currency_form_ui extends e_admin_form_ui
{
}

new anteup_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
