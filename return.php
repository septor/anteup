<?php
/*
 * AnteUp - A Donation Tracking Plugin for e107
 *
 * Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
 * For additional information refer to the README.mkd file.
 *
 */

require_once("../../class2.php");
require_once(HEADERF);
e107::lan('anteup');

if(e_QUERY == "cancel" || e_QUERY == "thanks")
{
	if(e_QUERY == "cancel")
	{
		$caption 	= LAN_ANTEUP_RETURN_01;
		$text 		= LAN_ANTEUP_RETURN_02;
	}
	elseif(e_QUERY == "thanks")
	{
		$caption 	= LAN_ANTEUP_RETURN_03;
		$text 		= LAN_ANTEUP_RETURN_04;
	}
	e107::getRender()->tablerender($caption, "<div style='text-align:center;'>".$text."</div>");
}
else
{
	e107::redirect();
}

require_once(FOOTERF);
?>