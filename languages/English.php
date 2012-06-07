<?php
/*
+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.6
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

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_00",     "Configure Roofdog Donation Tracker");
define("LAN_TRACK_01",     "PayPal Settings");
define("LAN_TRACK_02",     "Configuration");
define("LAN_TRACK_03",     "Settings Saved");
define("LAN_TRACK_04",     "Save Settings");
define("RD_TRACK_PROTECTION_01",       "To prevent spam reaching the PayPal address");
define("RD_TRACK_PROTECTION_02",       "Please answer");
define("RD_TRACK_PROTECTION_03",       "Submit");
define("RD_TRACK_PROTECTION_04",       "Please click below to make the donation.");
define("LAN_TRACK_05",      "Yes");
define("LAN_TRACK_06",      "No");
define("LAN_TRACK_07",      "Main");
define("LAN_TRACK_08",      "Optional");
define("LAN_TRACK_09",      "Extra");
define("LAN_TRACK_10",      "Roofdog Donation Tracker successfully installed!");
define("LAN_TRACK_11",      "Plugin is now upgraded!");
define("LAN_TRACK_12",      "Update Donation Status");
define("LAN_TRACK_13",      "ReadMe.txt");
define("LAN_TRACK_14",      "Roofdog Donation Tracker successfully upgraded!");
define("LAN_TRACK_15",      "Menu Settings");
define("LAN_TRACK_16",      "Paypal Email");
define("LAN_TRACK_17",      "
[center][color=#ff9900][size=18][b]We Need Your Help[/b][/size][/color][/center]

[center]We are a non-profit organization completely supported by you, the members.
Our servers are run and owned by our members.
We encourage every member to contribute to our server fund in any way that they can.
Since we do not have our servers or bandwidth donated we have to pay our bills every month to keep things going.
For those of you who can, we ask that you make a monetary contribution in whatever denomination you would like.
Every little bit counts.[/center]

[center][color=#ff9900][size=14][b]MAKE A DONATION NOW![/b][/size][/color][/center]
");
//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_CONFIG_01", "Menu Title:");
define("LAN_TRACK_CONFIG_02", "Currency to display on Menu:");
define("LAN_TRACK_CONFIG_03", "Progress bar full colour:");
define("LAN_TRACK_CONFIG_04", "Progress bar empty colour:");
define("LAN_TRACK_CONFIG_05", "Progress bar border colour:");
define("LAN_TRACK_CONFIG_06", "Progress bar height:");
define("LAN_TRACK_CONFIG_07", "Goal donation amount:");
define("LAN_TRACK_CONFIG_08", "Current donation amount:");
define("LAN_TRACK_CONFIG_09", "Due date:");
define("LAN_TRACK_CONFIG_10", "This months donators:");
define("LAN_TRACK_CONFIG_11", "The title of your donation tracker menu.");
define("LAN_TRACK_CONFIG_12", "Select the currency symbol to display in the menu.");
define("LAN_TRACK_CONFIG_13", "The colour of the full progress bar. Enter the 6 digit hex code.");
define("LAN_TRACK_CONFIG_14", "The background colour of the progress bar. Enter the 6 digit hex code.");
define("LAN_TRACK_CONFIG_15", "The colour of the border. Enter the 6 digit hex code.");
define("LAN_TRACK_CONFIG_16", "The height of the progress bar. Enter your value in pixels.");
define("LAN_TRACK_CONFIG_17", "Enter your target donation amount. Uncheck to disable.");
define("LAN_TRACK_CONFIG_18", "Amount of donations received so far. Uncheck to disable.");
define("LAN_TRACK_CONFIG_19", "The date by which you want to recieve your target donation, Uncheck to disable.<br>If not defined the due date it will be the last day of the current month.");
define("LAN_TRACK_CONFIG_20", "Text to showing for your visitors bellow of the graphic's bar, should be formatted using XHTML such as &lt;br /&gt; for new lines.");
define("LAN_TRACK_CONFIG_21", "Display Bar?");
define("LAN_TRACK_CONFIG_22", "Uncheck to disable progress bar.");
define("LAN_TRACK_CONFIG_23", "Display Total Fund Box?");
define("LAN_TRACK_CONFIG_24", "Uncheck to disable total fund box.");
define("LAN_TRACK_CONFIG_25", "Total Donation Fund Amount:");
define("LAN_TRACK_CONFIG_26", "Enter the total amount of donations received");
define("LAN_TRACK_CONFIG_27", "Spent/Allocated:");
define("LAN_TRACK_CONFIG_28", "Enter the total amount of funds that have been allocated or spent.");
define("LAN_TRACK_CONFIG_29", "Initial Balance:");
define("LAN_TRACK_CONFIG_30", "Enter your initial balance amount. Uncheck to disable.");
define("LAN_TRACK_CONFIG_31", "Show button Balance Sheet to Class:");
define("LAN_TRACK_CONFIG_32", "Define the user class that is allowed to see the Financial Balance.");
define("LAN_TRACK_CONFIG_33", "Menu Text");
define("LAN_TRACK_CONFIG_34", "Format");
define("LAN_TRACK_CONFIG_35", "Display donators list?");
define("LAN_TRACK_CONFIG_36", "Uncheck to not display the donations list.");
define("LAN_TRACK_CONFIG_37", "Description:");
//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_PAL_01",  "Button Text:");
define("LAN_TRACK_PAL_02",  "Text above button image, should be formatted using XHTML such as &lt;br /&gt; for new lines.");
define("LAN_TRACK_PAL_03",  "Button Image:");
define("LAN_TRACK_PAL_04",  "Choose an image or upload your own into '/rdonation_tracker/images/'");
define("LAN_TRACK_PAL_05",  "Choose");
define("LAN_TRACK_PAL_06",  "Button Popup:");
define("LAN_TRACK_PAL_07",  "Appears when the mouse pointer hovers over the button.");
define("LAN_TRACK_PAL_08",  "Make a Donation with PayPal");
define("LAN_TRACK_PAL_09",  "PayPal Email or PayPal Business ID:");
define("LAN_TRACK_PAL_10",  "This must be a valid PayPal account.");
define("LAN_TRACK_PAL_11",  "Donation Description:");
define("LAN_TRACK_PAL_12",  "If left blank, the donor will see a field which they can fill in themselves.");
define("LAN_TRACK_PAL_13",  "Currency:");
define("LAN_TRACK_PAL_14",  "Sets the currency that the amount is to be paid in.");
define("LAN_TRACK_PAL_15",  "Spam Protection:");
define("LAN_TRACK_PAL_16",  "Prevents spambots from harvesting the PayPal email address.");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_PAL_17",  "Request a Postal Address:");
define("LAN_TRACK_PAL_18",  "Asks the donor to provide a postal address.");
define("LAN_TRACK_PAL_19",  "Request a Note:");
define("LAN_TRACK_PAL_20",  "Asks the donor to provide a short note with the payment.");
define("LAN_TRACK_PAL_21",  "Custom Note Caption:");
define("LAN_TRACK_PAL_22",  "Text that is shown above the note.");
define("LAN_TRACK_PAL_23",  "Successful Payment URL");
define("LAN_TRACK_PAL_24",  "Link donors will be redirected here after completing their payment. To use default page copy this link:<br /> www.yoursite.com/e107_plugins/rdonation_tracker/thank_you.php");
define("LAN_TRACK_PAL_25",  "Cancel Payment URL");
define("LAN_TRACK_PAL_26",  "Link donors will be redirected here if they click Cancel. To use default page copy this link:<br /> www.yoursite.com/e107_plugins/rdonation_tracker/cancel_return.php");
define("LAN_TRACK_PAL_27",  "Page Style Name:");
define("LAN_TRACK_PAL_28",  "Log into PayPal to create styles. My Account, Profile, Custom Payment Pages.");
define("LAN_TRACK_PAL_41",  "IPN - Instant Payment Notification:");
define("LAN_TRACK_PAL_42",  "Validate the payments and save it on your site database. To use default routine copy this link:<br /> www.yoursite.com/e107_plugins/rdonation_tracker/ipn_validate.php");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_PAL_29",  "Locale:");
define("LAN_TRACK_PAL_30",  "Defaults to US English, use a two digit 'ISO 3166-1 Code' to change.");
define("LAN_TRACK_PAL_31",  "Item Number:");
define("LAN_TRACK_PAL_32",  "If set is shown below the item name.");
define("LAN_TRACK_PAL_33",  "Custom:");
define("LAN_TRACK_PAL_34",  "Not shown to donor, passed back for tracking payments.");
define("LAN_TRACK_PAL_35",  "Invoice:");
define("LAN_TRACK_PAL_36",  "Not shown to donor, passed back for tracking payments.");
define("LAN_TRACK_PAL_37",  "Amount:");
define("LAN_TRACK_PAL_38",  "Fixes payment value, blank allows donor to set the amount.");
define("LAN_TRACK_PAL_39",  "Tax:");
define("LAN_TRACK_PAL_40",  "Override any tax settings that are part of a donors profile.");

//-----------------------------------------------------------------------------------------------------------+
define("LAN_TRACK_F_0", "Cash Mananger");
define("LAN_TRACK_F_1", " REGISTER #");
define("LAN_TRACK_F_2", "Date:");
define("LAN_TRACK_F_3", "Type:");
define("LAN_TRACK_F_4", "Credit");
define("LAN_TRACK_F_5", "Debit");
define("LAN_TRACK_F_6", "Transaction ID:");
define("LAN_TRACK_F_7", "Value:");
define("LAN_TRACK_F_8", "Fee:");
define("LAN_TRACK_F_9", "Status:");
define("LAN_TRACK_F_10", "Completed");
define("LAN_TRACK_F_11", "Pending");
define("LAN_TRACK_F_12", "Denied");
define("LAN_TRACK_F_13", "User/Hist:");
define("LAN_TRACK_F_14", "Comment/Group:");
define("LAN_TRACK_F_15", "Change");
define("LAN_TRACK_F_16", "Back");
define("LAN_TRACK_F_17", "Include");
define("LAN_TRACK_F_18", "Cancel");
define("LAN_TRACK_F_19", "Balance");
define("LAN_TRACK_F_20", "Period between");
define("LAN_TRACK_F_21", "NEW RECORD");
define("LAN_TRACK_F_22", "HISTORIC");
define("LAN_TRACK_F_23", "ID");
define("LAN_TRACK_F_24", "DATE");
define("LAN_TRACK_F_25", "DESCRIPTION/NOTES");
define("LAN_TRACK_F_26", "ID/COMMENTS");
define("LAN_TRACK_F_27", "STATS");
define("LAN_TRACK_F_28", "TYPE");
define("LAN_TRACK_F_29", "AMOUNT");
define("LAN_TRACK_F_30", "FEE");
define("LAN_TRACK_F_31", "BALANCE");
define("LAN_TRACK_F_32", " OPT ");
define("LAN_TRACK_F_33", "INITIAL BALANCE");
define("LAN_TRACK_F_34", "CRED");
define("LAN_TRACK_F_35", "DEBT");
define("LAN_TRACK_F_36", "Please confirm that you wish delete");
define("LAN_TRACK_F_37", "Edit");
define("LAN_TRACK_F_38", "Delete");
define("LAN_TRACK_F_39", "### NO ENTRIES TO THIS PERIOD ###");
define("LAN_TRACK_F_40", "TOTAL");
define("LAN_TRACK_F_41", "Notes:");
define("LAN_TRACK_F_42", "FINANCIAL BALANCE");
define("LAN_TRACK_F_43", "Canceled");
define("LAN_TRACK_F_44", "Refunded");
define("LAN_TRACK_F_45", "Expired");
define("LAN_TRACK_F_46", "Failed");
define("LAN_TRACK_F_47", "Created");
define("LAN_TRACK_F_48", "Reversed");
define("LAN_TRACK_F_49", "Processed");
define("LAN_TRACK_F_50", "Voided");

//-----------------------------------------------------------------------------------------------------------+
define("LAN_TRACK_M_1", "NEW");
define("LAN_TRACK_M_2", "EDIT");
define("LAN_TRACK_M_3", "ACCESS DENIED!!!");
define("LAN_TRACK_M_4", "You are not allowed to see this page!");
define("LAN_TRACK_M1", "Successful created");
define("LAN_TRACK_M2", "Creation failed");
define("LAN_TRACK_M3", "Successful upddated");
define("LAN_TRACK_M4", "Update failed");
define("LAN_TRACK_M5", "Successful deleted");
define("LAN_TRACK_M6", "Delete failed");
define("LAN_TRACK_M7", "Invalid");
define("LAN_TRACK_M8", "E-mail");
//-----------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_MENU_01",  "RECEIVED!");
define("LAN_TRACK_MENU_02",  "Current:");
define("LAN_TRACK_MENU_03",  "Remaining:");
define("LAN_TRACK_MENU_04",  "Target:");
define("LAN_TRACK_MENU_05",  "Due Date:");
define("LAN_TRACK_MENU_06",  "This Months Donators:");
define("LAN_TRACK_MENU_07",  "Admin configure");
define("LAN_TRACK_MENU_08",  "Total:");
define("LAN_TRACK_MENU_09",  "Spent/Allocated:");

//------------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_ADMENU_01",  "Donation status");
define("LAN_TRACK_ADMENU_02",  "Menu settings");
define("LAN_TRACK_ADMENU_03",  "PayPal settings");
define("LAN_TRACK_ADMENU_04",  "Cash Manager");
define("LAN_TRACK_ADMENU_05",  "Readme.txt");

//------------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_THANKS_01", "<b>Thankyou</b>");
define("LAN_TRACK_THANKS_02", "
<br /><br /><br /><br /><br /><br /><font face='Verdana' size='2'><br /><br /><br />
<b>Thankyou for your kind donation!</b>
<br /><br /><br /><br /><br /><br /><br />
Please check your email box for<br />
confirmation from PayPal.<br />
<br />
Thanks again!
<br><center>
<a href='../../index.php'>Return to homepage</a>
</font></center>");

//-------------------------------------------------------------------------------------------------------------+

define("LAN_TRACK_CANCELLED_01", "<b>Cancelled payment</b>");
define("LAN_TRACK_CANCELLED_02", "You have cancelled your transaction. Please consider making a donation in the future or try again now.<br /><br /><a href='".e_BASE."index.php'>Return to homepage</a>");
define("LAN_PAL_BUTTON_POPUP_DEFAULT", "Click here to donate with PayPal");

//-------------------------------------------------------------------------------------------------------------+
define("DAY_LAN_MONTHS",",Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec");
define("DAY_LAN_MONTHL",",January,February,March,April,May,June,July,August,September,October,November,December");
define("DAY_LAN_MONTHSUFFIX",",st,nd,rd,th,th,th,th,th,th,th,th,th,th,th,th,th,th,th,th,th,st,nd,rd,th,th,th,th,th,th,th,st");


?>