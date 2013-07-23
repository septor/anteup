<?php

//------------------------------------------------------------------------------------------------------------+
// admin_cash.php
define("ANTELAN_CASHM_CAPTION00", "Donation Invoice");

define("ANTELAN_CASHM_01", "Balance");
define("ANTELAN_CASHM_02", "Start Date:");
define("ANTELAN_CASHM_03", "End Date:");
define("ANTELAN_CASHM_04", "Filter");
define("ANTELAN_CASHM_05", "Add New Entry");

// add entry
define("ANTELAN_CASHM_E_01", "Transaction ID:");

define("ANTELAN_CASHM_E_05", "Payment Status:");
define("ANTELAN_CASHM_E_06", "Completed");
define("ANTELAN_CASHM_E_07", "Pending");
define("ANTELAN_CASHM_E_08", "Denied");

define("ANTELAN_CASHM_E_09", "Payment Date:");
define("ANTELAN_CASHM_E_10", "Payment Amount:");

define("ANTELAN_CASHM_E_12", "Donator:");
define("ANTELAN_CASHM_E_13", "Other, not listed:");
define("ANTELAN_CASHM_E_14", "Comment:");

define("ANTELAN_CASHM_E_16", "Add Entry");
define("ANTELAN_CASHM_E_17", "Cancel");

// donation invoice
define("ANTELAN_CASHM_I_01", "Donation Invoice");

define("ANTELAN_CASHM_I_02", "Date");
define("ANTELAN_CASHM_I_03", "Donator");
define("ANTELAN_CASHM_I_04", "Transaction ID");
define("ANTELAN_CASHM_I_06", "Comment");
define("ANTELAN_CASHM_I_07", "Status");
define("ANTELAN_CASHM_I_09", "Amount");

define("ANTELAN_CASHM_I_12", "Initial balance");
define("ANTELAN_CASHM_I_13", "Save");

define("ANTELAN_CASHM_I_14", "Are you sure you want to delete this entry?");

define("ANTELAN_CASHM_I_15", "There are no entries to display during the selected time periods.");

define("ANTELAN_CASHM_I_16", "Entry successfully edited.");
define("ANTELAN_CASHM_I_17", "Entry successfully deleted."); 
define("ANTELAN_CASHM_I_18", "Error deleting entry.");
define("ANTELAN_CASHM_I_19", "Entry successfully added.");

define("ANTELAN_CASHM_I_20", "Not Supplied.");


//------------------------------------------------------------------------------------------------------------+
// admin_config.php
define("ANTELAN_CONFIG_CAPTION00", "Configure Ante Up!");

define("ANTELAN_CONFIG_CAPTION01", "General Configuration"); 
define("ANTELAN_CONFIG_CAPTION02", "Item Display Configuration"); 
define("ANTELAN_CONFIG_CAPTION03", "Menu Configuration"); 
define("ANTELAN_CONFIG_CAPTION04", "PayPal Configuration"); 

define("ANTELAN_CONFIG_01", "Save Settings");
define("ANTELAN_CONFIG_02", "Settings Saved");
define("ANTELAN_CONFIG_03", "You are required to set a due date and a goal amount.");

	// General Configuration
	define("ANTELAN_CONFIG_G_01", "Currency to display on menu:");
	define("ANTELAN_CONFIG_G_02", "Select the currency symbol to display in the menu.");	
	define("ANTELAN_CONFIG_G_03", "Goal Donation Amount:");
	define("ANTELAN_CONFIG_G_04", "The amount of money you are requesting.");
	define("ANTELAN_CONFIG_G_05", "Due Date:");
	define("ANTELAN_CONFIG_G_06", "The date by which you want to receive your target donation.<br />If not defined, the due date is set on the last day of the current month.");	
	define("ANTELAN_CONFIG_G_07", "Date Format:");
	define("ANTELAN_CONFIG_G_08", "Format you would like dates to be displayed on the plugin.");
	define("ANTELAN_CONFIG_G_09", "Donation Request Blurb");
	define("ANTELAN_CONFIG_G_10", "Text to convince people to donate. Displayed on the donations page.");
	
	// Item Display Configuration
	define("ANTELAN_CONFIG_I_01", "Show initial balance?");
	define("ANTELAN_CONFIG_I_02", "Displays the balance prior to the current due date.");	
	define("ANTELAN_CONFIG_I_03", "Show current donation amount?");
	define("ANTELAN_CONFIG_I_04", "Displays the amount of donations received so far.");	
	define("ANTELAN_CONFIG_I_05", "Show total balance?");	
	define("ANTELAN_CONFIG_I_06", "Displays the entire donation balance.");	
	define("ANTELAN_CONFIG_I_07", "Show goal amount?");
	define("ANTELAN_CONFIG_I_08", "Displays the goal donation amount.");	
	define("ANTELAN_CONFIG_I_09", "Show due date?");
	define("ANTELAN_CONFIG_I_10", "Displays the due date.");
	define("ANTELAN_CONFIG_I_11", "Show amount left?");
	define("ANTELAN_CONFIG_I_12", "Displays the amount of money you need to get before you met your goal.");
	define("ANTELAN_CONFIG_I_13", "Show configuration link?");
	define("ANTELAN_CONFIG_I_14", "Displays the link to this page on the menu item.");
	
	// Menu Configuration
	define("ANTELAN_CONFIG_M_01", "Menu Title:");
	define("ANTELAN_CONFIG_M_02", "The title of your donation tracker menu.");	
	define("ANTELAN_CONFIG_M_03", "Display Bar?");
	define("ANTELAN_CONFIG_M_04", "Uncheck to disable the progress bar.");	
	define("ANTELAN_CONFIG_M_05", "Menu Text:");	
	define("ANTELAN_CONFIG_M_06", "Text to display under the progress bar. This will display even if the progress bar does not.");	
	define("ANTELAN_CONFIG_M_07", "Full Progress Bar Color:");
	define("ANTELAN_CONFIG_M_08", "The color of the full progress bar. Enter the 6 digit hex code.");	
	define("ANTELAN_CONFIG_M_09", "Empty Progress Bar Color: ");
	define("ANTELAN_CONFIG_M_10", "The background color of the progress bar. Enter the 6 digit hex code.");
	define("ANTELAN_CONFIG_M_11", "Progress Bar Border Color:");
	define("ANTELAN_CONFIG_M_12", "The color of the border. Enter the 6 digit hex code.");	
	define("ANTELAN_CONFIG_M_13", "Progress Bar Height: ");
	define("ANTELAN_CONFIG_M_14", "The height of the progress bar. Enter your value in pixels.");
	define("ANTELAN_CONFIG_M_15", "Progress Bar Width: ");
	define("ANTELAN_CONFIG_M_16", "The width of the progress bar. Use either a static number (12px) or a percentage (90%).");

	// PayPal Configuration
	define("ANTELAN_CONFIG_P_C_01", "PayPal settings");
	define("ANTELAN_CONFIG_P_B_01", "Choose");
	
	define("ANTELAN_CONFIG_P_01", "Button image:");
	define("ANTELAN_CONFIG_P_02", "Choose an image or upload your own into '/anteup/images/icons/'");	
	define("ANTELAN_CONFIG_P_03", "PayPal Email or PayPal Business ID:");
	define("ANTELAN_CONFIG_P_04", "This must be a valid PayPal account.");	

	
//------------------------------------------------------------------------------------------------------------+
// admin_menu.php
define("ANTELAN_MMENU_00", "Ante Up!");

define("ANTELAN_MMENU_01", "Configuration");
define("ANTELAN_MMENU_02", "Donation Invoice");
define("ANTELAN_MMENU_03", "Readme");


//------------------------------------------------------------------------------------------------------------+
// admin_readme.php
define("ANTELAN_README_CAPTION00", "Readme");


//------------------------------------------------------------------------------------------------------------+
// anteup_menu.php
define("ANTELAN_MENU_01",  "Received!");
define("ANTELAN_MENU_02",  "See who has donated!");
define("ANTELAN_MENU_03",  "We have met our goal! Thanks a lot!");

define("ANTELAN_MENU_04",  "Current:");
define("ANTELAN_MENU_05",  "Remaining:");
define("ANTELAN_MENU_06",  "Target:");
define("ANTELAN_MENU_07",  "Grand Total:");
define("ANTELAN_MENU_08",  "Due date:");

define("ANTELAN_MENU_09",  "Admin configure");


//------------------------------------------------------------------------------------------------------------+
// donate.php
define("ANTELAN_DONATE_CAPTION00", "Donate");

define("ANTELAN_DONATE_01", "Name:");
define("ANTELAN_DONATE_02", "Currency:");
define("ANTELAN_DONATE_03", "Amount:");
define("ANTELAN_DONATE_04", "-- other --");


//------------------------------------------------------------------------------------------------------------+
// donations.php
define("ANTELAN_DONATIONS_CAPTION00", "Donations");

define("ANTELAN_DONATIONS_01", "Start Date:");
define("ANTELAN_DONATIONS_02", "End Date:");
define("ANTELAN_DONATIONS_03", "Donator");
define("ANTELAN_DONATIONS_04", "Message");
define("ANTELAN_DONATIONS_05", "Date donated");
define("ANTELAN_DONATIONS_06", "Amount");
define("ANTELAN_DONATIONS_07", "No donations found during that time period.");
define("ANTELAN_DONATIONS_08", "Total:");
define("ANTELAN_DONATIONS_09", "We sincerely appreciate your kind donation!");


//------------------------------------------------------------------------------------------------------------+
// plugin.php
define("ANTELAN_PLUGIN_01", "An extensive Donation Tracker with PayPal integration.");
define("ANTELAN_PLUGIN_02", "Configure Ante Up!");
define("ANTELAN_PLUGIN_03", "Donations");
define("ANTELAN_PLUGIN_04", " has been successfully installed!");
define("ANTELAN_PLUGIN_05", " has been successfully upgraded!");


//------------------------------------------------------------------------------------------------------------+
// return.php
define("ANTELAN_CANCEL_01", "Cancelled Payment");
define("ANTELAN_CANCEL_02", "You have cancelled your transaction. Please consider making a donation in the future, we would really appreciate it!.");
define("ANTELAN_THANKS_01", "Thanks!");
define("ANTELAN_THANKS_02", "Thank you for your donation!<br /><br />Be on the look out for a confirmation email from PayPal!<br />");

?>