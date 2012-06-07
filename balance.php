<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By DelTree
|
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|
|     For the e107 website system visit http://e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+
*/

require_once("../../class2.php");

//if(!getperms("P")) {
//   header("location:".e_BASE."index.php");
//   exit;
//}
require_once(HEADERF);
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."user_select_class.php");

// new language call method
$lan_file = e_PLUGIN."rdonation_tracker/languages/".e_LANGUAGE.".php";
require_once(file_exists($lan_file) ? $lan_file : e_PLUGIN."rdonation_tracker/languages/English.php");

if (!function_exists('format_numbers')) {
function format_numbers($num=0, $cur='GBP', $dec=2) {
$acur = array();
$acur['JPY'] = "¥";
$acur['CAD'] = "C$";
$acur['EUR'] = "€";
$acur['USD'] = "$";
$acur['GBP'] = "£";
$acur['DKK'] = "Kr";
$acur['AUD'] = "AU$";
$acur['CZK'] = "Kc";
$acur['HUF'] = "Ft";
$acur['NOK'] = "kr";
$acur['SEK'] = "kr";
$acur['PLN'] = "Zl";
return number_format($num, $dec).$acur[$cur];
}
}

if(!check_class($pref['rdtrack_showbalance']) && !ADMIN) {
    $caption = LAN_TRACK_M_3;
    $text = "<center><span style='font-size: 14px; text-align:center; color: white;'><strong class='bbcode'>".LAN_TRACK_M_4."</span></strong></center>";
}else{

    $caption = LAN_TRACK_F_42;

    require_once(e_HANDLER."calendar/calendar_class.php");
    $cal = new DHTML_Calendar(true);
    global $cal;
    $script = "
       <script type=\"text/javascript\">
        function addtext_us(sc){
          document.getElementById('dataform').image.value = sc;
        }
       </script>\n";
    $script .= $cal->load_files();

    $rs = new form;

    if (isset($_POST['setdates'])) {
       $date1x = $_POST['date1'];
       $date2x = $_POST['date2'];
       $action = "";
    }

    //-----------------------------------------------------------------------------------------------------------+
    // Main manager page

    $due = $pref['rdtrack_due'];
    if (strlen(trim($due))<1) {
       $due = date('t/m/Y');
    }

    if (!isset($date1x)) {
       $date = date('t/m/Y 23:59:59');
       $dt = explode("/",substr($date,0,10));
       $date1 = mktime("00","00","00",$dt[1],"01",$dt[2]);
       $date1x = date('d/m/Y', $date1);
    }else{
       $dt = explode("/",$date1x);
       $date1 = mktime("00","00","00",$dt[1],$dt[0],$dt[2]);
    }
    if (!isset($date2x)) {
       $date = date('t/m/Y 23:59:59');
       $date2 = mktime("23","59","59",$dt[1],$dt[0],$dt[2]);
       $date2x = date('d/m/Y', $date2);
    }else{
       $dt = explode("/",$date2x);
       $date2 = mktime("23","59","59",$dt[1],$dt[0],$dt[2]);
    }

    $total = 0;
    $partial = 0;
    if (varsettrue($pref['rdtrack_showibalance'])) {
       $partial = $pref['rdtrack_ibalance'];
       $total = $pref['rdtrack_ibalance'];
       $sql -> db_Select("ipn_info", "*", "payment_date > '0' ORDER BY payment_date ASC, type ASC, ipn_id ASC");
       while($row = $sql->db_Fetch()) {
          extract($row);
          if($type=="" || $type==0){
            $total += ($mc_gross-$mc_fee);
            if ($payment_date < $date1) {
               $partial += ($mc_gross-$mc_fee);
            }
          }else{
            $total -= ($mc_gross-$mc_fee);
            if ($payment_date < $date1) {
               $partial -= ($mc_gross-$mc_fee);
            }
          }
       }
    }
    $bg_line_n = $bg_line_n == 1? 0: 1;
    $bg_line_color = $bg_line_n == 1? "#F2F2F2": "#FFFFFF";
    $tt_clr = $total < 0 ? "red": "black";
    $text .= $rs->form_open("post", e_SELF, "MyForm0", "", "");
    $text .= $script."
    <div style='text-align:center'>
    <table style='width:100%' class='fborder' cellspacing='0' cellpadding='0'>";
    $text .= "
    <tr>
     <td colspan=2 width='30%' class='forumheader3' >";
    if(varsettrue($pref['rdtrack_showibalance'])) {
       $text .= "
       <div style='text-align:center; border: 1px solid; background-color: #6E6E6E; MARGIN: 0px 0px 0px 0px;'><font color='white' size='+1'>".LAN_TRACK_F_19."</b></font></div>
       <div style='text-align:center; border: 1px solid; MARGIN: 0px 0px 0px 0px;'><font color='white' size='+1'><b>".number_format($total,2).$pref['rdtrack_currency']."</b></font></div>";
    }else{
      $text .= "<span style='font-size: 14px; text-align:center; color: white;'><strong class='bbcode'>".LAN_TRACK_F_42."</span></strong>";
    }
    $text .= "
     </td>
     <td colspan=1 class='forumheader3' style='width:05; text-align:center;  background-color: ".$bgclr2."; color: yellow;' > </td>
     <td colspan=5 class='forumheader3'  >
      ".LAN_TRACK_F_20.":<br>
      ".$rs -> form_text("date1", 12, $date1x, 12,"tbox","","","","date1")." <a href='#' id='f-calendar-trigger-1'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date1','button':'f-calendar-trigger-1'});</script>
      -
      ".$rs -> form_text("date2", 12, $date2x, 12,"tbox","","","","date2")." <a href='#' id='f-calendar-trigger-2'><img style='border: 0px none ; vertical-align: middle;' src='".e_HANDLER."calendar/cal.gif' alt=''></a><script type='text/javascript'>Calendar.setup({'ifFormat':'%d/%m/%Y','daFormat':'%d/%m/%Y','inputField':'date2','button':'f-calendar-trigger-2'});</script>
        <input class='button' type='submit' name='setdates' value='Submit' />
      </td>
     </tr>";
     $bgclr1 = "#FAAC58";
     $bgclr2 = "#424242";
     $text .= "
     <tr>
        <td colspan=10 class='forumheader' style='text-align: center;'><b><center>".LAN_TRACK_F_22."</center></b></td>
     </tr>
     <tr>
       <td style='width:10%; text-align:center; background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_24."</td>
       <td style='width:20%; text-align:left;   background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_25."</td>
       <td style='width:20%; text-align:left;   background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_26."</td>
       <td style='width:10%; text-align:center; background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_27."</td>
       <td style='width:05%; text-align:center; background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_28."</td>
       <td style='width:10%; text-align:right;  background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_29."</td>
       <td style='width:10%; text-align:right;  background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_30."</td>
       <td style='width:10%; text-align:right;  background-color: ".$bgclr2."; color: yellow;' class='forumheader3'>".LAN_TRACK_F_31."</td>
     </tr>";
    if (varsettrue($pref['rdtrack_showibalance'])) {
       $text .= "
       <tr>
         <td colspan=7 class='fcaption' style='text-align: center;'><b><center>".LAN_TRACK_F_33."</center></b></td>
         <td style='width:10%; text-align:right;' class='fcaption'><b>".number_format($partial,2).$pref['rdtrack_currency']."</b></td>
       </tr>";
    }

    $xflag1 = 0;
    $bg_line_n = 1;
    $sql -> db_Select("ipn_info", "*", "WHERE payment_date >= '".$date1."' AND payment_date <= '".$date2."' ORDER BY payment_date ASC, type ASC, ipn_id ASC", false);
    while($row = $sql->db_Fetch()) {
      extract($row);
      $typex = ($type == "" || $type == 0)? "<font color='green'>".LAN_TRACK_F_34."</font>":"<font color='red'>".LAN_TRACK_F_35."</font>";
      $flag++;
      if($type=="" || $type==0){
        $partial += ($mc_gross-$mc_fee);
      }else{
        $partial -= ($mc_gross-$mc_fee);
      }
      $bg_line_n = $bg_line_n == 1? 0: 1;
      $bg_line_color = $bg_line_n == 1? "#6E6E6E": "#585858";
      $part_clr = $partial < 0 ? "red": "black";
      $mc_fee = $mc_fee == ""? "0.00": $mc_fee;
      $text .= "
      <tr>
            <td style='width:10%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader3'><b>".date('d.m.Y',$payment_date)."</b></td>
            <td style='width:20%; text-align:left;   background-color: ".$bg_line_color.";' class='forumheader3'><b>".$item_name."</b></td>
            <td style='width:20%; text-align:left;   background-color: ".$bg_line_color.";' class='forumheader3'><b>".trim($comment." ".$txn_id)."</b></td>
            <td style='width:10%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader3'><b>".$payment_status."</b></td>
            <td style='width:05%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader3'><b>".$typex."</b></td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color.";' class='forumheader3'><b>".format_numbers($mc_gross,$mc_currency,2)."</b></td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color.";' class='forumheader3'><b>".format_numbers($mc_fee,$mc_currency,2)."</b></td>
            <td style='width:10%; text-align:right;  background-color: ".$bg_line_color."; color: ".$part_clr.";' class='forumheader3'><b>".number_format($partial,2).$pref['rdtrack_currency']."</b></td>
      </tr>";
   }
   if($flag == 0){
      $text .= "
       <tr>
           <td colspan=8 style='width:05%; text-align:center; background-color: ".$bg_line_color.";' class='forumheader'>".LAN_TRACK_F_39."</td>
       </tr>";
   }
   $text .= "
    <tr>
     <td colspan=7 class='forumheader' style='text-align: center; '><strong>".LAN_TRACK_F_40."</strong></td>
     <td style='width:10%; text-align:right;' class='forumheader'><b>".number_format($partial,2).$pref['rdtrack_currency']."</b></td>
    </tr>
   </table>";
   if(getperms("P")) {
     $text .= "
     <center><a href='../../e107_plugins/rdonation_tracker/admin_cash.php' >".LAN_TRACK_MENU_07."</a></center><br>";
   }
   $text .= "
   </div>";
   $text .= $rs->form_close();
   //------------
}
$ns -> tablerender($caption, $text);
require_once(FOOTERF);
//-----------------------------------------------------------------------------------------------------------+
?>
