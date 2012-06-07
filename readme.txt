+ ----------------------------------------------------------------------------+
|     ROOFDOG DONATION TRACKER v2.7
|     By roofdog78 & [email=lmsystema@gmail.com]DelTree[/email]
|
|     Original Donation Tracker plugin by Septor
|     Original Donate Menu plugin by Lolo Irie,Cameron,Barry Keal,Richard Perry
|     Plugin support at [link=http://www.roofdog78.com]www.roofdog78.com[/link]
|
|     For the e107 website system visit http://e107.org     
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+----------------------------------------------------------------------------+


About the plugin:
=================

A plugin that enables you to keep track of donations easily. Fully intergrated with PayPal Donations with IPN functionality.
also have a full financial cash control very dinamic!
 <b><u>** Is importand say here that it is not an update version!!!</u></b><br><br>

Prerequisites:
==============

Before actually using PayPal Donation functionality on your website, you will need the following:

REQUIRED
 * e107 core v0.7+ installed.
 * A PayPal Premier or Business account
 * The PayPal verified email address at which you will receive payments

OPTIONAL
 * The URL for the web page to validate the paypal Instant Payment Notification - IPN
 * The URL for the web page users see after a successful transaction
 * The URL for the web page users see after cancelling a transaction

Installation:
=============

Upload the rdonation_tracker files into your 'e107_plugins' folder, then go to the 'Plugin Manager' located on your website Admin page. Find the plugin in the list and click on 'Install'. You should be ready to go.
Although 'Upload plugin' from the Admin section might work, uploading your files by using an FTP client program is recommended.

To upgrade from a previous version simply overwrite all the files using FTP then go to Admin section/Plugin Manager and click on 'Upgrade'.

Changelog:
==========
Version 2.7 (Roofdog Donation Tracker, May 2011):
--------------------------------------------------------
 * Bug Fixes
   - Fixed many bugs that had on the last version 2.6

Version 2.6 (Roofdog Donation Tracker, May 2010):
--------------------------------------------------------
 * New Features
   - Fixed many bugs that had on the last version 2.5


Version 2.5 (Roofdog Donation Tracker, May 2010):
--------------------------------------------------------

 * New Features
   - Added the paypal validation script the (IPN) and integrated with the e107 system
   - Added the cash full control with receipts/payments independent's of the paypal system where you'll can: include/change or delete every entries for debits or credits
   - Added a new page to consult the receipts per period of dates
   - Added a Initial Balance field to define your initial cash before start your entries!
   - Changed the tracker menu box with a some few more informations, and with a new look of the donor's list
   - Added a new page to consult the Flux of cash per period with the final balance acumulated.(simulating a bank statement!)
   - Improvement of the return page "thank you" after payments/donations!
   - The amount of donations received on the tracker menu box is calculated automatic now!
   - The Due date by which you want to recieve your target donation is optional now!
   - The clean of the donors list on the tracker menu when started a new month is automatic now!

 * Note: The version 2.4 has been suppressed for many reasons and after inumerous tests and evaluations until have been corrected for this new version 2.5!

 <b><u>** Is importand say here that it is not an update version!!!</u></b><br><br><br>

Version 2.3 (Roofdog Donation Tracker, May 2008):
--------------------------------------------------------

 * New Features
   - Made select boxes for all menu options.
   - Added French language file, thanks to NooTe

 * Bug Fixes
   - Tracker bar now fills entire box so if its empty, its empty and if its full, its full!
   - Tracker bar height configuration now works.


Version 2.2 (Roofdog Donation Tracker, November 2007):
--------------------------------------------------------

 * New Features
   - Menu is now fully XHTML 1.1 Compliant
   - Added the following PayPal currencies:
     Danish Krone
     Australian Dollar
     Czech Korona
     Hungarian Forint
     Norwegian Krone
     Swedish Krona
     Polish Zloty

 * Bug Fix
   - Fixed a small bug which was preventing the admin menus showing
   - Fixed a bug which prevented currency from updating for some users
   - Fixed a bug which prevented some users from configuring the status bar

 * Minor Changes
   - Updated PayPal images to their latest designs
   - Changed the plugin logo's. I'm sticking with these now!! ;)
   - Corrected a rather embarrassing spelling mistake!

Version 2.1 (Roofdog Donation Tracker, September 2007):
-------------------------------------------------------

 * Bug Fix
   - Fixed bug which prevented non members from donating.

 * Minor Changes
   - Altered appearance slightly - made more readable.

Version 2.0 (Roofdog Donation Tracker, August 2007):
-------------------------------------------------------

 * New Features
   - Added easier admin configuration by splitting into different menus
   - Added languages folder and rewritten all code for independent language use
   - Added multiple currencies and symbols to menu display: US Dollars, Canadian Dollars, Japanese Yen, Euros and Pound Stirling
   - Added images folder
   - Added plugin logos
   - Added PayPal button
   - Added admin_donate.php to configure PayPal settings
   - Added admin_menu.php to disply admin menus
   - Added cancel_return.php to display when transaction is cancelled
   - Added thank_you.php to display after completed transaction
   - Added readme.php to disply readme.txt in admin panel
   - Support forum at [link=http://www.roofdog78.com/]www.roofdog78.com[/link]

 * Minor Changes
   - Changed plugin title
   - Fixed display of donators to show as a list
   - Now able to configure 'Thankyou for your support' message
   - Cleaned up code in admin_config.php and rdtrack_menu.php
   - Altered look of admin pages
   - Fixed other minor display issues

Version 1.0.3 (Roofdog's Donation Tracker, September 2006):
-----------------------------------------------------------

 * Minor Changes
   - Corrected file structure

Version 1.0.2 (Roofdog's Donation Tracker, September 2006):
-----------------------------------------------------------

 * New Features
   - Menu title can now be edited
   - Admin Configure link in the menu added

 * Minor Changes
   - Increased numbers of donators
   - Fixed language issue

Notes:
======
Thanks to the following for their original plugins:
Donation Tracker by:  septor
Donate Menu by:
Lolo Irie - [link=http://www.etalkers.org]www.etalkers.org[/link]
Cameron - [link=http://www.e107coders.org]www.e107coders.org[/link]
Barry Keal - [link=http://www.keal.me.uk]www.keal.me.uk[/link]
Richard Perry - [link=http://www.greycube.com]www.greycube.com[/link]
DelTree - [link=http://geforceelite.com]www.geforceelite.com[/link]

A big thankyou to Marj for your help with some problems! [link=http://etalkers.tuxfamily.org/home.php]www.etalkers.org[/link]
   
License
=======
Roofdog Donation Tracker is distributed as free open source code released under the terms and conditions of the [link=external=http://www.gnu.org/licenses/gpl.txt]GNU General Public License[/link].
 

