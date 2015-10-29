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

// -- [ Ante Up Constants ]

define("ANTEUP", e_PLUGIN."anteup/");
define("ANTEUP_ABS", SITEURLBASE.e_PLUGIN_ABS."anteup/");
define("CALENDAR_IMG", "<img style='vertical-align: middle;' src='".e_PLUGIN."anteup/images/admin/calendar.png' />");
