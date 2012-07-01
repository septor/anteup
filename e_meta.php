<?php

if (!defined('e107_INIT')) { exit; }

echo "<link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'/>
<style>
.ui-widget-content {
	background: #".$pref['anteup_empty']." repeat-x 50% 50%;
	border: 1px solid #".$pref['anteup_border'].";
	border-radius: 0;
	height: ".$pref['anteup_height'].";
}
.ui-widget-header {
	background: #".$pref['anteup_full']." repeat-x 50% 50%;
}
</style>";

?>