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

require_once("../../class2.php");

if (!getperms("P")) {
	header("location:".e_BASE."index.php");
	 exit ;
}

require_once(e_ADMIN."auth.php");

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");

$pageid = 'admin_menu_03';

  if(isset($_POST['save_settings']))
  {
    $pref['pal_menu_caption']   = $_POST['pal_menu_caption'];
    $pref['pal_text']           = $_POST['pal_text'];
    $pref['pal_button_image']   = $_POST['pal_button_image'];
    $pref['pal_button_popup']   = $_POST['pal_button_popup'];
    $pref['pal_business']       = $_POST['pal_business'];
    $pref['pal_item_name']      = $_POST['pal_item_name'];
    $pref['pal_currency_code']  = $_POST['pal_currency_code'];
    $pref['pal_no_protection']  = $_POST['pal_no_protection'];
    $pref['pal_key_private']    = md5(rand(0,100).time());

    $pref['pal_no_shipping']    = $_POST['pal_no_shipping'];
    $pref['pal_no_note']        = $_POST['pal_no_note'];
    $pref['pal_cn']             = $_POST['pal_cn'];

    $pref['pal_ipn_file']       = $_POST['pal_ipn_file']      ? "http://".eregi_replace("http://", "", trim($_POST['pal_ipn_file']))      : "";
    $pref['pal_return']         = $_POST['pal_return']        ? "http://".eregi_replace("http://", "", trim($_POST['pal_return']))        : "";
    $pref['pal_cancel_return']  = $_POST['pal_cancel_return'] ? "http://".eregi_replace("http://", "", trim($_POST['pal_cancel_return'])) : "";
    $pref['pal_page_style']     = $_POST['pal_page_style'];

    $pref['pal_lc']             = $_POST['pal_lc'];
    $pref['pal_item_number']    = $_POST['pal_item_number'];
    $pref['pal_custom']         = $_POST['pal_custom'];
    $pref['pal_invoice']        = $_POST['pal_invoice'];
    $pref['pal_amount']         = $_POST['pal_amount'];
    $pref['pal_tax']            = $_POST['pal_tax'];

    save_prefs();

    message_handler("MESSAGE", LAN_TRACK_03);
  }

$acur1 = array();
$acur1['¥']  = array("Japanese Yen",       "JPY");
$acur1['C$']  = array("Canadian Dollar",    "CAD");
$acur1['€'] = array("Euro",               "EUR");
$acur1['$']   = array("US Dollar",          "USD");
$acur1['£']  = array("Great Britain Pound","GBP");
$acur1['Kr']  = array("Dansk Krone",        "DKK");
$acur1['AU$'] = array("Australian Dollar",  "AUD");
$acur1['Kc']  = array("Czech Koruna",       "CZK");
$acur1['Ft']  = array("Hungarian Forint",   "HUF");
$acur1['kr']  = array("Norwegian Krone",    "NOK");
$acur1['kr']  = array("Swedish Krona",      "SEK");
$acur1['Zl']  = array("Polish Zloty",       "PLN");
if(isset($pref['pal_currency_code'])) {
  if($pref['pal_currency_code']=="") {
    $pref['pal_currency_code']=$acur1[$pref['rdtrack_currency']][1];
  }
}else{
  $pref['pal_currency_code']=$acur1[$pref['rdtrack_currency']][1];
}
//-----------------------------------------------------------------------------------------------------------+

  $file_handle = opendir(e_PLUGIN."rdonation_tracker/images");

  while ($file_name = readdir($file_handle))
  {
    if ($file_name == "." || $file_name == "..") { continue; }

    $iconlist[] = $file_name;
  }

  closedir($file_handle);

//-----------------------------------------------------------------------------------------------------------+

  $text = "
  
  <script type='text/javascript'>
    function addtext(sc)
    {
      document.forms.paypal_donate_form.pal_button_image.value=sc;
    }
  </script>

  <div style='text-align:center'>
    <form method='post' action='".e_SELF."' id='paypal_donate_form'>
      <table style='width:95%' class='fborder'>

        <tr>
          <td class='forumheader' colspan='2'>".LAN_TRACK_01."</td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%;vertical-align:top'>
            <b>".LAN_TRACK_PAL_01."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_02."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <textarea class='tbox' style='width:200px; height:140px' cols='25' rows='5' name='pal_text'>".$pref[pal_text]."</textarea>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_03."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_04."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' style='width:200px' type='text' name='pal_button_image' value='$pref[pal_button_image]' />
            <br /><br />
            <input class='button' style='cursor:hand' type='button' value='".LAN_TRACK_PAL_05."' onclick='expandit(this)' />
            <div style='display:none'>";
//-----------------------------------------------------------------------------------------------------------+
  while (list($key, $icon)=each($iconlist))
  {
    $text .= " <a href='javascript:addtext(\"$icon\")'><img src='".e_PLUGIN."rdonation_tracker/images/$icon' style='border:0px' alt='' /></a>";
  }
//-----------------------------------------------------------------------------------------------------------+
  $text .= "</div>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%;vertical-align:top;'>
            <b>".LAN_TRACK_PAL_06."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_07."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' style='width:200px' type='text' name='pal_button_popup' value='$pref[pal_button_popup]' maxlength='30' />
          </td>
        </tr>


        <tr>
          <td class='forumheader3' style='width:60%;vertical-align:top;'>
            <b>".LAN_TRACK_PAL_09."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_10."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' style='width:200px' type='text' name='pal_business' value='$pref[pal_business]' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%;vertical-align:top'>
            <b>".LAN_TRACK_PAL_11."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_12."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' style='width:200px' type='text' name='pal_item_name' value='$pref[pal_item_name]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_13."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_14."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <select class='tbox' name='pal_currency_code'>";
//-----------------------------------------------------------------------------------------------------------+
  $text .= $pref['pal_currency_code'] == "USD" ? "<option value='USD' selected='selected'> USD - United States Dollar </option>" : "<option value='USD'> USD - United States Dollar </option>";
  $text .= $pref['pal_currency_code'] == "GBP" ? "<option value='GBP' selected='selected'> GBP - Great Britain Pound  </option>" : "<option value='GBP'> GBP - Great Britain Pound  </option>";
  $text .= $pref['pal_currency_code'] == "EUR" ? "<option value='EUR' selected='selected'> EUR - Euro                 </option>" : "<option value='EUR'> EUR - Euro                 </option>";
  $text .= $pref['pal_currency_code'] == "CAD" ? "<option value='CAD' selected='selected'> CAD - Canadian Dollar      </option>" : "<option value='CAD'> CAD - Canadian Dollar      </option>";
  $text .= $pref['pal_currency_code'] == "JPY" ? "<option value='JPY' selected='selected'> JPY - Japanese Yen         </option>" : "<option value='JPY'> JPY - Japanese Yen         </option>";
  $text .= $pref['pal_currency_code'] == "AUD" ? "<option value='AUD' selected='selected'> AUD - Australian Dollar    </option>" : "<option value='AUD'> AUD - Australian Dollar </option>";
  $text .= $pref['pal_currency_code'] == "DKK" ? "<option value='DKK' selected='selected'> DKK - Dansk Krone          </option>" : "<option value='DKK'> DKK - Dansk Krone      </option>";
  $text .= $pref['pal_currency_code'] == "CZK" ? "<option value='CZK' selected='selected'> CZK - Czech Kerona         </option>" : "<option value='CZK'> CZK - Czech Kerona      </option>";
  $text .= $pref['pal_currency_code'] == "HUF" ? "<option value='HUF' selected='selected'> HUF - Hungarian Forint     </option>" : "<option value='HUF'> HUF - Hungarian Forint      </option>";
  $text .= $pref['pal_currency_code'] == "NOK" ? "<option value='NOK' selected='selected'> NOK - Norwegian Krone      </option>" : "<option value='NOK'> NOK - Norwegian Krone      </option>";
  $text .= $pref['pal_currency_code'] == "SEK" ? "<option value='SEK' selected='selected'> SEK - Swedish Krona        </option>" : "<option value='SEK'> SEK - Swedish Krona      </option>";
  $text .= $pref['pal_currency_code'] == "PLN" ? "<option value='PLN' selected='selected'> PLN - Polish Zloty         </option>" : "<option value='PLN'> PLN - Polish Zloty      </option>";
//-----------------------------------------------------------------------------------------------------------+
  $text .= "</select>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_15."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_16."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <select class='tbox' name='pal_no_shipping'>
              <option ".($pref['pal_no_protection'] ? "selected='selected'" : "")." value='1'>".LAN_TRACK_06."</option>
              <option ".($pref['pal_no_protection'] ? "" : "selected='selected'")." value='0'>".LAN_TRACK_05."</option>
            </select>
          </td>
        </tr>

        <tr>
          <td colspan='2'>
            <div class='forumheader' style='text-align:left'>".LAN_TRACK_08."</div>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_17."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_18."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <select class='tbox' name='pal_no_shipping'>
              <option ".($pref['pal_no_shipping'] ? "selected='selected'" : "")." value='1'>".LAN_TRACK_06."</option>
              <option ".($pref['pal_no_shipping'] ? "" : "selected='selected'")." value='0'>".LAN_TRACK_05."</option>
            </select>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_19."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_20."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <select class='tbox' name='pal_no_note'>
              <option ".($pref['pal_no_note'] ? "selected='selected'" : "")." value='1'>".LAN_TRACK_06."</option>
              <option ".($pref['pal_no_note'] ? "" : "selected='selected'")." value='0'>".LAN_TRACK_05."</option>
            </select>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_21."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_22."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_cn' value='$pref[pal_cn]' maxlength='30' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_41."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_42."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_ipn_file' value='$pref[pal_ipn_file]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_23."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_24."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_return' value='$pref[pal_return]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_25."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_26."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_cancel_return' value='$pref[pal_cancel_return]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_27."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_28."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_page_style' value='$pref[pal_page_style]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td colspan='2'>
            <div class='forumheader' style='text-align:left'>".LAN_TRACK_09."</div>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_29."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_30."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <select class='tbox' name='pal_lc'>";
  $sql->db_select("user_extended_country","*","country_iso != '' ORDER BY country_name ASC");
  $text .= $pref['pal_lc'] == "" ? "<option value='' selected='selected'>  </option>" : "<option value=''>  </option>";
  while($row = $sql->db_Fetch()) {
    extract($row);
    $text .= $pref['pal_lc'] == $country_iso ? "<option value='".$country_iso."' selected='selected'> ".$country_name." - ".$country_iso."</option>" : "<option value='".$country_iso."'> ".$country_name." - ".$country_iso."</option>";
  }
  $text .= "</select>
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_31."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_32."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' style='width:200px' type='text' name='pal_item_number' value='$pref[pal_item_number]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_33."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_34."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_custom' value='$pref[pal_custom]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_35."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_36."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_invoice' value='$pref[pal_invoice]' maxlength='127' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_37."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_38."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_amount' value='$pref[pal_amount]' />
          </td>
        </tr>

        <tr>
          <td class='forumheader3' style='width:60%; vertical-align:top'>
            <b>".LAN_TRACK_PAL_39."</b><br />
            <br /><span class='smalltext'>".LAN_TRACK_PAL_40."</span>
          </td>
          <td class='forumheader3' style='width:40%'>
            <input class='tbox' type='text' style='width:200px' name='pal_tax' value='$pref[pal_tax]' />
          </td>
        </tr>

        <tr>
          <td class='forumheader' style='text-align:center' colspan='2'>
            <input class='button' type='submit' name='save_settings' value='".LAN_TRACK_04."' />
          </td>
        </tr>
		<tr>
<td class='forumheader' colspan='2'>Visit the <a href='http://www.roofdog78.com/'>support forum</a></td>
</tr>

      </table>
    </form>
  </div>";

//-----------------------------------------------------------------------------------------------------------+

  $ns -> tablerender(LAN_TRACK_00, $text);
  require_once(e_ADMIN."footer.php");

//-----------------------------------------------------------------------------------------------------------+
  
?>

