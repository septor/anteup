<?php
require_once('../../class2.php');
if (!getperms('P')) 
{
	header('location:'.e_BASE.'index.php');
	exit;
}

class anteup_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'anteup_ipn_ui',
			'path' 			=> null,
			'ui' 			=> 'anteup_ipn_form_ui',
			'uipath' 		=> null
		),

		'other1'	=> array(
			'controller' 	=> 'anteup_currency_ui',
			'path' 			=> null,
			'ui' 			=> 'anteup_currency_form_ui',
			'uipath' 		=> null
		),
	);	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> "Manage Donations", 'perm' => 'P'),
		'main/create'		=> array('caption'=> "Create Donation", 'perm' => 'P'),
		'currency/list'		=> array('caption'=> "Manage Currencies", 'perm' => 'P'),
		'currency/create'	=> array('caption'=> "Create Currency", 'perm' => 'P'),
		'main/prefs' 		=> array('caption'=> "Preferences", 'perm' => 'P'),	

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
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
		protected $perPage			= 10; 
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
				'title' => 'IPN ID', 
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
				'type' => 'text', 
				'data' => 'str', 
				'width' => 'auto', 
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
				'help' => '', 
				'readParms' => '', 
				'writeParms' => '', 
				'class' => 'left', 
				'thclass' => 'left',  
			),
		  	'mc_currency' =>   array ( 
				'title' => 'Currency', 
				'type' => 'text', 
				'data' => 'str', 
				'width' => 'auto', 
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
				'help' => '', 
				'readParms' => '', 
				'writeParms' => '', 
				'class' => 'left', 
				'thclass' => 'left', 
 		   	),
		  	'user_id' =>   array ( 
				'title' => 'e107 User ID', 
				'type' => 'number', 
				'data' => 'str',
 			   	'width' => '5%', 
				'help' => '', 
				'readParms' => '', 
				'writeParms' => '', 
				'class' => 'left', 
				'thclass' => 'left',  
			),
		  	'buyer_email' =>   array ( 
				'title' => 'User Email', 
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
				'type' => 'text', 
				'data' => 'str',
 			   	'width' => 'auto',
 			   	'filter' => true,
 			   	'help' => '',
 			   	'readParms' => '',
 			   	'writeParms' => '',
 			   	'class' => 'left',
 			   	'thclass' => 'left', 
 		   	),
		  	'comment' =>   array ( 
				'title' => 'Comment', 
				'type' => 'textarea', 
				'data' => 'str', 
				'width' => '40%', 
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

		protected $fieldpref = array('payment_date', 'user_id', 'txn_id', 'comment', 'payment_status', 'mc_gross');

		protected $prefs = array(
			'anteup_currency'	=> array(
				'title' => 'Default Currency',
				'type' => 'text',
				'data' => 'integer',
				'help' => 'The default currency for accepting donations',
			),
			'anteup_full' => array(
				'title' => 'Full Color',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The hex color code for the full progress bar color',
			),
			'anteup_empty' => array(
				'title' => 'Empty Color',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The hex color code for the empty progress bar color',
			),
			'anteup_border' => array(
				'title' => 'Border Color',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The hex color code for the progress bar border color',
			),
			'anteup_height' => array(
				'title' => 'Progress Bar Height',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The height, in pixels, of the progress bar',
			),
			'anteup_width' => array(
				'title' => 'Progress Bar Width',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The width, in percent, of the progress bar',
			),
			'anteup_goal' => array(
				'title' => 'Donation Goal',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The current donation goal',
			),
			'anteup_due' => array(
				'title' => 'Due Date',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The date in which you want the donations by',
			),
			'anteup_lastdue' => array(
				'title' => 'Previous Due Date',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The previous due date',
			),
			'anteup_description' => array(
				'title' => LAN_DESCRIPTION,
				'type' => 'text',
				'data' => 'str',
				'help' => ANTELAN_DONATIONS_09,
			),
			'anteup_dformat' => array(
				'title' => 'Date Format',
				'type' => 'text',
				'data' => 'str',
				'help' => 'The format used for dates, refer to the e107 forum date format',
			),
			'anteup_showibalance' => array(
				'title' => 'Show Initial Balance',
				'type' => 'boolean',
				'data' => 'integer',
				'help' => 'Displays the balance prior to the current due date',
			),
			'anteup_showtotal' => array(
				'title' => 'Show current donation amount?',
				'type' => 'boolean',
				'data' => 'integer',
				'help' => 'Displays teh amount of donations received so far',
			),
			'anteup_showcurrent' => array(
				'title' => 'Show total balance?',
				'type' => 'boolean',
				'data' => 'integer',
				'help' => 'Displays the entire donation balance',
			),
			'anteup_showleft' => array(
				'title' => 'Show goal amount?',
				'type' => 'boolean',
				'data' => 'integer',
				'help' => 'Displays the amount of donations you need/want',
			),
			'anteup_showdue' => array(
				'title' => 'Show due date?',
				'type' => 'boolean',
				'data' => 'integer',
				'help' => 'Displays the date you would like the donations by',
			),
			'anteup_showconfiglink' => array(
				'title' => 'Show configuration link?',
				'type' => 'boolean',
				'data' => 'integer',
				'help' => 'Displays the link to this page on the menu item',
			),
		);

		public function init()
		{
			// Set drop-down values (if any). 
	
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
			
		protected $pluginTitle		= 'Ante Up';
		protected $pluginName		= 'anteup';
	//	protected $eventName		= 'anteup-anteup_currency'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'anteup_currency';
		protected $pid				= 'id';
		protected $perPage			= 10; 
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
				'type' => 'number', 
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
				'help' => '', 
				'readParms' => '', 
				'writeParms' => '', 
				'class' => 'left', 
				'thclass' => 'left', 
 		   	),
		  	'location' =>   array ( 
				'title' => 'Symbol Location',
 			   	'type' => 'text', 
				'data' => 'str', 
				'width' => 'auto', 
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
			// Set drop-down values (if any). 
	
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

?>
