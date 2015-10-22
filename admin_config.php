<?php
require_once('../../class2.php');
if (!getperms('P')) 
{
	header('location:'.e_BASE.'index.php');
	exit;
}

class anteup_admin extends e_admin_dispatcher
{
	protected $modes = array(	
		'main' array(
			'controller'	=> 'anteup_ui',
			'path'			=> null,
			'ui'			=> 'anteup_form_ui',
			'uipath'		=> null
		);
	);	
	
	protected $adminMenu = array(
		'main/prefs' 		=> array('caption'=> LAN_PREFS, 'perm' => 'P'),	
		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'AnteUp';
}

new anteup_admin();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>
