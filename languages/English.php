<?php

//------------------------------------------------------------------------------------------------------------+
// admin_cash.php
define("ANTELAN_CASHM_CAPTION00", "Cash Manager");

define("ANTELAN_CASHM_01", "Balance");
define("ANTELAN_CASHM_02", "Start Date:");
define("ANTELAN_CASHM_03", "End Date:");
define("ANTELAN_CASHM_04", "Filter");
define("ANTELAN_CASHM_05", "Add New Entry"); // title of image next to balance - hover

// add entry
define("ANTELAN_CASHM_E_01", "Transaction ID:");
define("ANTELAN_CASHM_E_02", "Payment Type:");
define("ANTELAN_CASHM_E_03", "Credit");
define("ANTELAN_CASHM_E_04", "Debit");

define("ANTELAN_CASHM_E_05", "Payment Status:");
define("ANTELAN_CASHM_E_06", "Completed");
define("ANTELAN_CASHM_E_07", "Pending");
define("ANTELAN_CASHM_E_08", "Denied");

define("ANTELAN_CASHM_E_09", "Payment Date:");
define("ANTELAN_CASHM_E_10", "Payment Amount:");
define("ANTELAN_CASHM_E_11", "Fee:");

define("ANTELAN_CASHM_E_12", "Donator:");
define("ANTELAN_CASHM_E_13", "Other, not listed:");
define("ANTELAN_CASHM_E_14", "Comment:");
define("ANTELAN_CASHM_E_15", "Custom:");

define("ANTELAN_CASHM_E_16", "Add Entry");
define("ANTELAN_CASHM_E_17", "Cancel");

// donation invoice
define("ANTELAN_CASHM_I_01", "Donation Invoice");

define("ANTELAN_CASHM_I_02", "ID");
define("ANTELAN_CASHM_I_03", "Date");
define("ANTELAN_CASHM_I_04", "Description");
define("ANTELAN_CASHM_I_05", "Transaction ID");
define("ANTELAN_CASHM_I_06", "Status");
define("ANTELAN_CASHM_I_07", "Type");
define("ANTELAN_CASHM_I_08", "Amount");
define("ANTELAN_CASHM_I_09", "Fee");
define("ANTELAN_CASHM_I_10", "Total");

define("ANTELAN_CASHM_I_11", "Initial balance");
define("ANTELAN_CASHM_I_12", "Save");

define("ANTELAN_CASHM_I_13", "Are you sure you want to delete this entry?");

define("ANTELAN_CASHM_I_14", "There are no entries to display during the selected time periods.");

define("ANTELAN_CASHM_I_15", "Entry successfully edited.");
define("ANTELAN_CASHM_I_16", "Entry successfully deleted."); 
define("ANTELAN_CASHM_I_17", "Error deleting entry.");
define("ANTELAN_CASHM_I_18", "Entry successfully added.");

define("ANTELAN_CASHM_I_19", "Not Supplied.");


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
	define("ANTELAN_CONFIG_G_06", "The date by which you want to recieve your target donation.<br />If not defined, the due date is set on the last day of the current month.");	
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
	
	// Menu Configuration
	define("ANTELAN_CONFIG_M_01", "Menu Title:");
	define("ANTELAN_CONFIG_M_02", "The title of your donation tracker menu.");	
	define("ANTELAN_CONFIG_M_03", "Display Bar?");
	define("ANTELAN_CONFIG_M_04", "Uncheck to disable progress bar.");	
	define("ANTELAN_CONFIG_M_05", "Menu Text:");	
	define("ANTELAN_CONFIG_M_06", "Text under the graphic's bar, should be formatted using XHTML such as &lt;br /&gt; for new lines.");	
	define("ANTELAN_CONFIG_M_07", "Full Progress Bar Color:");
	define("ANTELAN_CONFIG_M_08", "The color of the full progress bar. Enter the 6 digit hex code.");	
	define("ANTELAN_CONFIG_M_09", "Empty Progress Bar Color: ");
	define("ANTELAN_CONFIG_M_10", "The background color of the progress bar. Enter the 6 digit hex code.");
	define("ANTELAN_CONFIG_M_11", "Progress Bar Border Color:");
	define("ANTELAN_CONFIG_M_12", "The color of the border. Enter the 6 digit hex code.");	
	define("ANTELAN_CONFIG_M_13", "Progress Bar Height: ");
	define("ANTELAN_CONFIG_M_14", "The height of the progress bar. Enter your value in pixels.");

	// Paypal Configuration
	define("ANTELAN_CONFIG_P_C_01", "Paypal settings");
	define("ANTELAN_CONFIG_P_C_02", "Optional settings");
	define("ANTELAN_CONFIG_P_C_03", "Extra settings");	
	define("ANTELAN_CONFIG_P_B_01", "Choose");
	
	define("ANTELAN_CONFIG_P_01", "Button image:");
	define("ANTELAN_CONFIG_P_02", "Choose an image or upload your own into '/anteup/images/icons/'");	
	define("ANTELAN_CONFIG_P_03", "PayPal Email or PayPal Business ID:");
	define("ANTELAN_CONFIG_P_04", "This must be a valid PayPal account.");	
	define("ANTELAN_CONFIG_P_05", "Donation Description:");	
	define("ANTELAN_CONFIG_P_06", "If left blank, the donor will see a field which they can fill in themselves.");	
	define("ANTELAN_CONFIG_P_07", "Request a Postal Address:");
	define("ANTELAN_CONFIG_P_08", "Asks the donor to provide a postal address.");	
	define("ANTELAN_CONFIG_P_09", "Request a Note:");
	define("ANTELAN_CONFIG_P_10", "Asks the donor to provide a short note with the payment.");
	define("ANTELAN_CONFIG_P_11", "Custom Note Caption:");
	define("ANTELAN_CONFIG_P_12", "Text that is shown above the note.");	
	define("ANTELAN_CONFIG_P_13", "Page Style Name:");
	define("ANTELAN_CONFIG_P_14", "Log into PayPal to create styles. My Account, Profile, Custom Payment Pages.");
	define("ANTELAN_CONFIG_P_15", "Locale:");
	define("ANTELAN_CONFIG_P_16", "Defaults to US English, use a two digit 'ISO 3166-1 Code' to change.");
	define("ANTELAN_CONFIG_P_17", "Item Number:");
	define("ANTELAN_CONFIG_P_18", "If set is shown below the item name.");
	define("ANTELAN_CONFIG_P_19", "Custom: ");
	define("ANTELAN_CONFIG_P_20", "Not shown to donor, passed back for tracking payments.");
	define("ANTELAN_CONFIG_P_21", "Invoice:");
	define("ANTELAN_CONFIG_P_22", "Not shown to donor, passed back for tracking payments.");
	define("ANTELAN_CONFIG_P_23", "Amount:");
	define("ANTELAN_CONFIG_P_24", "Fixes payment value, blank allows donor to set the amount.");
	define("ANTELAN_CONFIG_P_25", "Tax:");
	define("ANTELAN_CONFIG_P_26", "Override any tax settings that are part of a donors profile.");

	
//------------------------------------------------------------------------------------------------------------+
// admin_menu.php
define("ANTELAN_MMENU_00", "Ante Up!");

define("ANTELAN_MMENU_01", "Configuration");
define("ANTELAN_MMENU_02", "Cash Manager");
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
define("ANTELAN_MENU_07",  "Total:");
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
define("ANTELAN_DONATIONS_09", "Want to be a part of this elite club of donators? Guess what! You can be! <a href='".e_PLUGIN."anteup/donate.php'>Click here</a> to send us a very welcome donation!");


//------------------------------------------------------------------------------------------------------------+
// index.php
define("ANTELAN_INDEX_CAPTION00", "Ante Up!");

define("ANTELAN_INDEX_01", "To prevent spam from reaching the PayPal address, please answer the following:");
define("ANTELAN_INDEX_02", "Submit");
define("ANTELAN_INDEX_03", "Click below to make your donation.");


//------------------------------------------------------------------------------------------------------------+
// return.php
define("ANTELAN_CANCEL_01", "Cancelled Payment");
define("ANTELAN_CANCEL_02", "You have cancelled your transaction. Please consider making a donation in the future or try again now.");
define("ANTELAN_THANKS_01", "Thanks!");
define("ANTELAN_THANKS_02", "Thank you for your donation!<br /><br />Be on the look out for a confirmation email from PayPal!<br />");




// ===  JUST LEAVING IT HERE FOR BACKUP, WILL BE REMOVED SOON ===
/*
define("LAN_TRACK_MENU_01",  "RECEIVED!");
define("LAN_TRACK_MENU_02",  "Current:");
define("LAN_TRACK_MENU_03",  "Remaining:");
define("LAN_TRACK_MENU_04",  "Target:");
define("LAN_TRACK_MENU_05",  "Due Date:");
define("LAN_TRACK_MENU_06",  "This Months Donators:");
define("LAN_TRACK_MENU_07",  "Admin configure");
define("LAN_TRACK_MENU_08",  "Total:");
define("LAN_TRACK_MENU_09",  "Spent/Allocated:");

define("LAN_TRACK_CONFIG_01", "Menu Title:");
define("LAN_TRACK_CONFIG_02", "Currency to display on Menu:");
define("LAN_TRACK_CONFIG_03", "Full Progress Bar Color:");
define("LAN_TRACK_CONFIG_04", "Empty Progress Bar Color:");
define("LAN_TRACK_CONFIG_05", "Progress Bar Border Color:");
define("LAN_TRACK_CONFIG_06", "Progress Bar Height:");
define("LAN_TRACK_CONFIG_07", "Donation Goal Amount:");
define("LAN_TRACK_CONFIG_08", "Current Donation Amount:");
define("LAN_TRACK_CONFIG_09", "Due date:");
define("LAN_TRACK_CONFIG_10", "This months donators:");
define("LAN_TRACK_CONFIG_11", "The title of your donation tracker menu.");
define("LAN_TRACK_CONFIG_12", "Select the currency symbol to display in the menu.");
define("LAN_TRACK_CONFIG_13", "The color of the full progress bar. Enter the 6 digit hex code.");
define("LAN_TRACK_CONFIG_14", "The background color of the progress bar. Enter the 6 digit hex code.");
define("LAN_TRACK_CONFIG_15", "The color of the border. Enter the 6 digit hex code.");
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
define("LAN_TRACK_PAL_04",  "Choose an image or upload your own into '/anteup/images/icons/'");
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
define("LAN_TRACK_PAL_27",  "Page Style Name:");
define("LAN_TRACK_PAL_28",  "Log into PayPal to create styles. My Account, Profile, Custom Payment Pages.");
define("LAN_TRACK_PAL_41",  "IPN - Instant Payment Notification:");

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
define("LAN_TRACK_M_0", "Donations");
define("LAN_TRACK_M_1", "NEW");
define("LAN_TRACK_M_2", "EDIT");
define("LAN_TRACK_M_3", "ACCESS DENIED!!!");
define("LAN_TRACK_M_4", "You are not allowed to see this page!");
define("LAN_TRACK_M1", "Successful created");
define("LAN_TRACK_M2", "Creation failed");
define("LAN_TRACK_M3", "Successful upddated");
define("LAN_TRACK_M4", "Update failed");
define("LAN_TRACK_M7", "Invalid");
define("LAN_TRACK_M8", "E-mail");

//-----------------------------------------------------------------------------------------------------------+

define("LAN_PAL_BUTTON_POPUP_DEFAULT", "Click here to donate with PayPal");

*/

?>