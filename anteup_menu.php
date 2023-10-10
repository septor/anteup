<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2017 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

if(!defined('e107_INIT'))
{
    require_once("../../class2.php");
}

if(!e107::isInstalled('anteup'))
{
    return '';
}

// Load class file
require_once(e_PLUGIN."anteup/_class.php");

if(!class_exists('anteup_menu'))
{
    class anteup_menu
    {

        public $menuPref;
        public $template = array();

        function __construct()
        {
            $this->menuPref = e107::getMenu()->pref();

            // Set some defaults ...
            if (empty($this->menuPref['layout'])) $this->menuPref['layout'] = 'default';

            $this->template = e107::getTemplate('anteup', 'anteup_menu', $this->menuPref['layout']); 
        }

        public function render($parm = array())
        {
            $text = '';
            $sql  = e107::getDb();

           	$campaigninfo 	= $sql->retrieve("anteup_campaign", "*", "id='".$parm['campaign']."'");
           	$donations 		= $sql->retrieve("anteup_ipn", "*", "payment_status='Completed' AND campaign='".$parm['campaign']."'", true);

            // Check if campaign is active
            if($campaigninfo['status'])
            {
                // Load shortcodes
                $sc = e107::getScBatch('anteup', TRUE);
               
                // Pass campaign info to shortcode
                $sc->setVars($campaigninfo);
                    
                // Return render item from template
                $text .= e107::getParser()->parseTemplate($this->template['body'], true, $sc);

                return $text; 
            }
            // Campaign not active
            else
            {
                $text .= "Campaign not active"; // TODO LAN
            }

            // If SQL error, show to admins. 
            if(ADMIN && $sql->getLastErrorNumber())
            {
                $text .= 'SQL Error #'.$sql->getLastErrorNumber().': '.$sql->getLastErrorText();
            }

            return $text;
        }
    }
}

$class = new anteup_menu;

if(is_string($parm) && empty($parm))
{
	$parm = array(); 
}

// Override campaign id based on menupref (set in menu manager), or set default to 1
if(!isset($parm['campaign']))
{
	$parm['campaign'] = "1"; 
}

$text = $class->render($parm);

// Set default caption
$caption = LAN_ANTEUP_DONATIONS_TITLE;

// Allow for custom caption through shortcode parm 
if (!empty($parm))
{
    if(isset($parm['caption'][e_LANGUAGE]))
    {
        $caption = empty($parm['caption'][e_LANGUAGE]) ? LAN_ANTEUP_DONATIONS_TITLE : $parm['caption'][e_LANGUAGE];
    }
}

$campaign_name = e107::getDb()->retrieve('anteup_campaign', 'name', 'id='.$parm['campaign']);

// Pass caption to shortcode in template 
$var        = array('ANTEUP_MENUCAPTION' => $caption, 'ANTEUP_CAMPAIGN_NAME' => $campaign_name);
$caption    = e107::getParser()->simpleParse($class->template['caption'], $var);

e107::getRender()->tablerender($caption, $text, 'anteup_'.$parm['campaign']);