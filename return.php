<?php
require_once("../../class2.php");
require_once(HEADERF);
e107::lan('anteup');

if(e_QUERY == "cancel" || e_QUERY == "thanks"){
	if(e_QUERY == "cancel"){
		$caption = ANTELAN_CANCEL_01;
		$text = ANTELAN_CANCEL_02;
	}else if(e_QUERY == "thanks"){
		$caption = ANTELAN_THANKS_01;
		$text = ANTELAN_THANKS_02;
	}
	$ns->tablerender($caption, "<div style='text-align:center;'>".$text."</div>");
}else{
	header("location: ".e_BASE);
}

require_once(FOOTERF);
?>
