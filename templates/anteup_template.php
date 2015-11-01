<?php
/* 
* AnteUp - A Donation Tracking Plugin for e107
*
* Copyright (C) 2012-2015 Patrick Weaver (http://trickmod.com/)
* For additional information refer to the README.mkd file.
*
*/

if(!defined('e107_INIT')){ exit; }

$ANTEUP_TEMPLATE['menu'] = "
<a href='".e_PLUGIN."anteup/donations.php'>{ANTEUP_BAR}</a>
Status (in {ANTEUP_CODE}): {ANTEUP_CURRENT}/{ANTEUP_GOAL}<br />
Remaining: {ANTEUP_REMAINING}<br />
Lifetime Donation Total: {ANTEUP_TOTAL}<br />
{ANTEUP_ADMIN}
";

?>
