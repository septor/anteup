<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
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
		'main/list'			=> array('caption' => LAN_ANTEUP_MANAGE_DONATIONS, 'perm' => 'P'),
		'main/create'		=> array('caption' => LAN_ANTEUP_CREATE_DONATIONS, 'perm' => 'P'),
		'currency/list'		=> array('caption' => LAN_ANTEUP_MANAGE_CURRENCIES, 'perm' => 'P'),
		'currency/create'	=> array('caption' => LAN_ANTEUP_CREATE_CURRENCIES, 'perm' => 'P'),
		'main/custom'		=> array('caption' => LAN_ANTEUP_CSV_EXPORT, 'perm' => 'P'),
		'main/prefs' 		=> array('caption' => LAN_PREFS, 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'
	);

	protected $menuTitle = LAN_ANTEUP_NAME;
}

class anteup_ipn_ui extends e_admin_ui
{
	protected $pluginTitle		= 'AnteUp';
	protected $pluginName		= 'anteup';
	protected $table			= 'anteup_ipn';
	protected $pid				= 'ipn_id';
	protected $perPage			= 20;
	protected $batchDelete		= true;
	protected $listOrder		= 'ipn_id DESC';

	protected $fields = array(
		'checkboxes' =>  array(
			'title' => '',
			'type' => null,
			'data' => null,
			'width' => '5%',
			'thclass' => 'center',
			'forced' => '1',
			'class' => 'center',
			'toggle' => 'e-multiselect',
		),
		'ipn_id' => array(
			'title' => LAN_ID,
			'data' => 'int',
			'width' => '5%',
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'item_name' => array(
			'title' => LAN_ANTEUP_IPN_01,
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
		'payment_status' => array(
			'title' => LAN_ANTEUP_IPN_02,
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => array('optArray' => array(
				'Pending' => LAN_ANTEUP_IPN_08,
				'Completed' => LAN_ANTEUP_IPN_09,
				'Denied' => LAN_ANTEUP_IPN_10,
			)),
			'class' => 'left',
			'thclass' => 'left',
		),
		'mc_gross' => array(
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
		'mc_currency' => array(
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
		'txn_id' => array(
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
		'user_id' => array(
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
		'buyer_email' => array(
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
		'payment_date' => array(
			'title' => LAN_ANTEUP_IPN_06,
			'type' => 'datestamp',
			'data' => 'int',
			'width' => 'auto',
			'inline' => true,
			'filter' => true,
			'help' => '',
			'readParms' => '',
			'writeParms'=> 'type=date',
			'class' => 'left',
			'thclass' => 'left',
		),
		'comment' => array(
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
		'options' => array(
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
			'type' 	=> 'text',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_01_B,
		),
		'anteup_currency' => array(
			'title' => LAN_ANTEUP_PREFS_02_A,
			'type' 	=> 'dropdown',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_02_B,
		),
		'anteup_goal' => array(
			'title' => LAN_ANTEUP_PREFS_03_A,
			'type' 	=> 'number',
			'data' 	=> 'int',
			'help' 	=> LAN_ANTEUP_PREFS_03_B,
		),
		'anteup_due' => array(
			'title' => LAN_ANTEUP_PREFS_04_A,
			'type' 	=> 'datestamp',
			'writeParms'=> 'type=date',
			'data' 	=> 'int',
			'help' 	=> LAN_ANTEUP_PREFS_04_B,
		),
		'anteup_lastdue' => array(
			'title' => LAN_ANTEUP_PREFS_05_A,
			'type' 	=> 'datestamp',
			'writeParms'=> 'type=date',
			'data' 	=> 'int',
			'help' 	=> LAN_ANTEUP_PREFS_05_B,
		),
		'anteup_menutext' => array(
			'title' => LAN_ANTEUP_PREFS_06_A,
			'type' 	=> 'bbarea',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_06_B,
		),
		'anteup_pagetext' => array(
			'title' => LAN_ANTEUP_PREFS_07_A,
			'type' 	=> 'bbarea',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_07_B,
		),
		'anteup_pageviewclass' => array(
			'title' => LAN_ANTEUP_PREFS_08_A,
			'type' 	=> 'userclass',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_08_B,
		),
		'anteup_menuviewclass' => array(
			'title' => LAN_ANTEUP_PREFS_09_A,
			'type' 	=> 'userclass',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_09_B,
		),
		'anteup_button' => array(
			'title' => LAN_ANTEUP_PREFS_10_A,
			'type' 	=> 'dropdown',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_10_B,
		),
		'anteup_paypal' => array(
			'title' => LAN_ANTEUP_PREFS_11_A,
			'type' 	=> 'text',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_11_B,
		),
		'anteup_dateformat' => array(
			'title' => LAN_ANTEUP_PREFS_12_A,
			'type' 	=> 'dropdown',
			'data' 	=> 'str',
			'help' 	=> LAN_ANTEUP_PREFS_12_B,
		),
		'anteup_sandbox' => array(
			'title' => LAN_ANTEUP_PREFS_13_A,
			'type'	=> 'boolean',
			'data' 	=> 'integer',
			'help' 	=> LAN_ANTEUP_PREFS_13_B,
		),
		'anteup_logging' => array(
			'title'			=> LAN_ANTEUP_PREFS_14_A,
			'type'        	=> 'boolean',
			'writeParms'	=> 'label=yesno',
			'data'        	=> 'int',
			'help'		  	=> LAN_ANTEUP_PREFS_14_B,
		),
	);

	public function init()
	{
		$sql = e107::getDb();

		// Check for sandbox mode
		$sandbox = e107::pref('anteup', 'anteup_sandbox');
		if(vartrue($sandbox))
		{
			e107::getMessage()->addWarning(LAN_ANTEUP_SANDBOX_ON);
		}

		$this->currency[0] = "default";
		if($sql->select('anteup_currency'))
			while($row = $sql->fetch())
				$this->currency[$row['id']] = $row['description']." (".$row['code'].")";

		$this->fields['mc_currency']['writeParms'] = $this->currency;
		$this->prefs['anteup_currency']['writeParms'] = $this->currency;

		$this->dateformat = array('short' => LAN_ANTEUP_PREFS_12_C, 'long' => LAN_ANTEUP_PREFS_12_D, 'relative' => LAN_ANTEUP_PREFS_12_E);
		$this->prefs['anteup_dateformat']['writeParms'] = $this->dateformat;

		$this->donateImage[e107::pref('anteup', 'anteup_button')] = e107::pref('anteup', 'anteup_button');
		foreach(glob(e_PLUGIN."anteup/images/icons/*.gif") as $icon)
		{
			$icon = str_replace(e_PLUGIN."anteup/images/icons/", "", $icon);

			if($icon != e107::pref('anteup', 'anteup_button'))
				$this->donateImage[$icon] = $icon;
		}
		$this->prefs['anteup_button']['writeParms'] = $this->donateImage;
	}

	public function beforeCreate($new_data)
	{
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
	}

	public function onCreateError($new_data, $old_data)
	{
	}

	public function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
	}

	public function customPage()
	{
		if(file_exists('anteup_donations.csv'))
		{
			$sql = e107::getDb();
			$fp = fopen('anteup_donations.csv', 'w+');
			$donations = $sql->retrieve('anteup_ipn', '*', '', true);

			fputcsv($fp, array(LAN_ID, LAN_ANTEUP_IPN_01, LAN_ANTEUP_IPN_02, LAN_ANTEUP_IPN_03, LAN_ANTEUP_IPN_04, LAN_ANTEUP_IPN_05, LAN_USER, LAN_EMAIL, LAN_ANTEUP_IPN_06, LAN_ANTEUP_IPN_07));

			foreach($donations as $donation)
			{
				fputcsv($fp, $donation);
			}

			fclose($fp);

			$text = e107::getMessage()->addSuccess(LAN_ANTEUP_IPN_15);
		}
		else
		{
			$text = e107::getMessage()->addError(LAN_ANTEUP_IPN_16);
		}

		return $text;
	}
}

class anteup_ipn_form_ui extends e_admin_form_ui
{
}

class anteup_currency_ui extends e_admin_ui
{
	protected $pluginTitle		= 'AnteUp';
	protected $pluginName		= 'anteup';
	protected $table			= 'anteup_currency';
	protected $pid				= 'id';
	protected $perPage			= 20;
	protected $batchDelete		= true;
	protected $listOrder		= 'id DESC';

	protected $fields = array(
		'checkboxes' => array(
			'title' => '',
			'type' => null,
			'data' => null,
			'width' => '5%',
			'thclass' => 'center',
			'forced' => '1',
			'class' => 'center',
			'toggle' => 'e-multiselect',
		),
		'id' => array(
			'title' => LAN_ID,
			'data' => 'int',
			'width' => '5%',
			'help' => '',
			'readParms' => '',
			'writeParms' => '',
			'class' => 'left',
			'thclass' => 'left',
		),
		'symbol' => array(
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
		'code' => array(
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
		'description' => array(
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
		'location' => array(
			'title' => LAN_ANTEUP_CURR_03,
			'type' => 'dropdown',
			'data' => 'str',
			'width' => 'auto',
			'inline' => true,
			'help' => '',
			'readParms' => '',
			'writeParms' => array('optArray' => array(
				'front' => LAN_ANTEUP_CURR_04,
				'back' => LAN_ANTEUP_CURR_05,
			)),
			'class' => 'left',
			'thclass' => 'left',
		),
		'options' => array(
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
		// Check for sandbox mode
		$sandbox = e107::pref('anteup', 'anteup_sandbox');
		if(vartrue($sandbox))
		{
			e107::getMessage()->addWarning(LAN_ANTEUP_SANDBOX_ON);
		}
	}

	public function beforeCreate($new_data)
	{
		return $new_data;
	}

	public function afterCreate($new_data, $old_data, $id)
	{
	}

	public function onCreateError($new_data, $old_data)
	{
	}

	public function beforeUpdate($new_data, $old_data, $id)
	{
		return $new_data;
	}

	public function afterUpdate($new_data, $old_data, $id)
	{
	}

	public function onUpdateError($new_data, $old_data, $id)
	{
	}
}

class anteup_currency_form_ui extends e_admin_form_ui
{
}

new anteup_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;
