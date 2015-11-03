<?php
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
	
		protected $fields 		= array (  
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
		  	'item_name' =>   array ( 
				'title' => 'Item Name', 
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
		  	'payment_status' =>   array ( 
				'title' => 'Payment Status', 
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
				'title' => 'Gross Income', 
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
		  	'mc_currency' =>   array ( 
				'title' => 'Currency', 
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
		  	'txn_id' =>   array ( 
				'title' => 'Transaction ID',
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
		  	'user_id' =>   array ( 
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
		  	'buyer_email' =>   array ( 
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
		  	'payment_date' =>   array (
 			   	'title' => 'Payment Date', 
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
				'title' => LAN_COMMENT, 
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
				'title' => 'Menu Title',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The text you want displayed as your menu item',
			),
			'anteup_currency' => array(
				'title' => 'Default Currency',
				'type' => 'dropdown',
				'data' => 'str',
				'help' => 'The default currency for accepting donations',
			),
			'anteup_goal' => array(
				'title' => 'Donation Goal',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The current donation goal',
			),
			'anteup_due' => array(
				'title' => 'Due Date',
				'type' => 'datestamp',
				'data' => 'str',
				'help' => 'The date in which you want the donations by',
			),
			'anteup_lastdue' => array(
				'title' => 'Previous Due Date',
				'type' => 'datestamp',
				'data' => 'str',
				'help' => 'The previous due date',
			),
			'anteup_description' => array(
				'title' => LAN_DESCRIPTION,
				'type' => 'text',
				'data' => 'str',
				'help' => ANTELAN_DONATIONS_09,
			),
			'anteup_button' => array(
				'title' => 'Donation Image',
				'type' => 'dropdown',
				'data' => 'str',
				'help' => 'Donation image to use',
			),
			'anteup_paypal' => array(
				'title' => 'PayPal Address',
				'type' => 'text',
				'data' => 'str',
				'help' => 'Your PayPal email address. Donations cannot be accepted without it!',
			),
			'anteup_dformat' => array(
				'title' => 'Date Format',
				'type' => 'dropdown',
				'data' => 'str',
				'help' => 'The format used for dates, refer to the e107 forum date format',
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

			$this->status = array('Pending' => 'Pending', 'Completed' => 'Completed', 'Denied' => 'Denied');
			$this->fields['payment_status']['writeParms'] = $this->status;

			// preferences
			$this->prefs['anteup_currency']['writeParms'] = $this->currency;

			$this->dformat = array('short' => 'short', 'long' => 'long', 'forum' => 'forum');
			$this->prefs['anteup_dformat']['writeParms'] = $this->dformat;
			
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
	
		protected $fields 		= array (  
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
		  	'id' =>   array ( 
				'title' => LAN_ID, 
				'data' => 'int', 
				'width' => '5%', 
				'help' => '', 
				'readParms' => '', 
				'writeParms' => '', 
				'class' => 'left', 
				'thclass' => 'left',  
			),
		  	'symbol' =>   array ( 
				'title' => 'Currency Symbol',
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
				'title' => 'Code', 
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
		  	'location' =>   array ( 
				'title' => 'Symbol Location',
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
			$this->symLoc = array('front' => 'front', 'back' => 'back');
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
