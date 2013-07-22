<?php

// -- [ Functions ]

function format_currency($input, $id, $commify = true)
{
	$sql = new db();
	$sql->db_Select("anteup_currency", "*", "id='".intval($id)."'");
    while($row = $sql->db_Fetch())
    {
		$symbol = $row['symbol'];
        $loc = $row['location'];
    }
	$input = (($commify) ? number_format($input, 2) : $input);
	return ($loc == "back" ? $input.$symbol : $symbol.$input);
}

function config_block($data, $text, $subtext = "")
{
	return "<tr>
	<td style='width:50%;vertical-align:top' class='forumheader3'>
	<b>".$text."</b>
	".(!empty($subtext) ? "<br /><span class='smalltext'>".$subtext."</span>" : "")."
	</td>
	<td style='width:50%; vertical-align:middle; text-align:right;' class='forumheader3'>
	".$data."
	</td>
	</tr>";
}

// -- [ Ante Up Constants ]

define("ANTEUP", e_PLUGIN."anteup/");
define("ANTEUP_ABS", SITEURLBASE.e_PLUGIN_ABS."anteup/");
define("CALENDAR_IMG", "<img style='vertical-align: middle;' src='".e_PLUGIN."anteup/images/admin/calendar.png' />");

?>