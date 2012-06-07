<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By roofdog78 & DelTree
|    
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|     Plugin support at http://www.roofdog78.com
|     
|     For the e107 website system visit http://e107.org     
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
*/

  require_once "../../class2.php";
  require_once HEADERF;
  
// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");

  $cap_number_one  = rand(1,5);
  $cap_number_two  = rand(1,5);
  $cap_number_sum  = $cap_number_one + $cap_number_two;

  $pal_key_private = $pref['pal_key_private'];
  $pal_key_public  = md5($pal_key_private.$cap_number_sum.$pal_key_private.$_SERVER['REMOTE_ADDR']);
  $pal_key_check   = md5($pal_key_private.$_POST['cap_answer'].$pal_key_private.$_SERVER['REMOTE_ADDR']);
  
  if (!USER && $pal_key_check != $_POST['cap_key'] && !$pref['pal_no_protection'])
  {
    $text = "

    <form method='post' action='".e_PLUGIN."rdonation_tracker/'>
      <div style='text-align:center'>
        <br />
        <br />
        ".RD_TRACK_PROTECTION_01."<br />
        <br />
        ".RD_TRACK_PROTECTION_02." $cap_number_one + $cap_number_two =
        <input              type='hidden' name='cap_key'    value='$pal_key_public' />
        <input class='tbox' type='text'   name='cap_answer' value='' size='5' maxlength='5' />
        <input class='tbox' type='submit' name='submit'     value='".RD_TRACK_PROTECTION_03."' />
        <br />
        <br />
        <br />
      </div>
    </form>";
  }
  else
  {

    $paypal_donate_action = "https://www.paypal.com/cgi-bin/webscr";
    $paypal_donate_email  = $pref['pal_business'];

    $text = "
    
    <div style='text-align:center'>
      <br />
      ".RD_TRACK_PROTECTION_04."<br />
      <br />
    </div>

    <form method='post' action='$paypal_donate_action' id='paypal_donate_form'>
      <div style='width:100%; margin-left:auto; margin-right:auto; text-align:center;'>

        <input type='hidden' name='cmd'      value='_xclick' />
        <input type='hidden' name='business' value='$paypal_donate_email' id='paypal_donate_email' />";

  if($pref['pal_item_name'])     { $text .="<input type='hidden' name='item_name'     value='$pref[pal_item_name]'     />"; }
  if($pref['pal_currency_code']) { $text .="<input type='hidden' name='currency_code' value='$pref[pal_currency_code]' />"; }
  if($pref['pal_no_shipping'])   { $text .="<input type='hidden' name='no_shipping'   value='$pref[pal_no_shipping]'   />"; }
  if($pref['pal_no_note'])       { $text .="<input type='hidden' name='no_note'       value='$pref[pal_no_note]'       />"; }
  if($pref['pal_cn'])            { $text .="<input type='hidden' name='cn'            value='$pref[pal_cn]'            />"; }
  if($pref['pal_return'])        { $text .="<input type='hidden' name='return'        value='$pref[pal_return]'        />"; }
  if($pref['pal_cancel_return']) { $text .="<input type='hidden' name='cancel_return' value='$pref[pal_cancel_return]' />"; }
  if($pref['pal_page_style'])    { $text .="<input type='hidden' name='page_style'    value='$pref[pal_page_style]'    />"; }
  if($pref['pal_lc'])            { $text .="<input type='hidden' name='lc'            value='$pref[pal_lc]'            />"; }
  if($pref['pal_item_number'])   { $text .="<input type='hidden' name='item_number'   value='$pref[pal_item_number]'   />"; }
  if($pref['pal_custom'])        { $text .="<input type='hidden' name='custom'        value='$pref[pal_custom]'        />"; }
  if($pref['pal_invoice'])       { $text .="<input type='hidden' name='invoice'       value='$pref[pal_invoice]'       />"; }
  if($pref['pal_amount'])        { $text .="<input type='hidden' name='amount'        value='$pref[pal_amount]'        />"; }
  if($pref['pal_tax'])           { $text .="<input type='hidden' name='tax'           value='$pref[pal_tax]'           />"; }

  $image_path = e_PLUGIN."rdonation_tracker/images/$pref[pal_button_image]";

  $text .= "
  
        <div style='padding-top:5px'>
          <input name='submit' type='image' src='$image_path' alt='$image_text' title='$pref[pal_button_popup]' style='border:none' />
        </div>

      </div>
    </form>";
  
  }

  $ns -> tablerender("$mtitle",  "<div align='center'>\n".$text."\n</div>", 'rdtrack');
  
  require_once FOOTERF;

?>
