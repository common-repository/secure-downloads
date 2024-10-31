=== Secure Downloads ===
Contributors: wpdevelop, oplugins
Donate link: https://oplugins.com/plugins/secure-downloads
Tags: file downloads, downloads, links, protected links, digital downloads
Requires at least: 4.0
Requires PHP: 5.2.4
Tested up to: 6.6
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy generate and distribute secure links for file downloads, that can expire, and track every download.

== Description ==

Secure Downloads plugin generate **secure download links** for protected files and can **send emails** to your clients for downloading. 
**Links can expire** after a predefined time, and you can set **IP lock** for specific download. Download links does not show real location of files at your server.
You can track every download of files by receiving email about file download with detailed info about download.

>[Plugin Homepage](https://oplugins.com/plugins/secure-downloads/ "Secure Downloads Homepage") | [Support](https://oplugins.com/plugins/secure-downloads/#support "Support")

= FEATURES =

* Securely distribute your files and track every download.
* Upload your files via familiar WP interface.
* Define Title, Description and **Version Number** at "Attachment details" for your protected files
* Plugin upload files into secure, protected folder. Website visitors will not have direct access to such  files.
* Generate secure links to your protected files,  which  does not show real location of file.
* Links can expire after  specific time.
* Links can  be locked to specific IP or IP mask (network).
* Configure email template with different parameters.
* Send emails to your customers with secure links for download your protected files.
* Monitor downloading of each file, by receiving email notification about file download with detailed info about download.
* Fast configure your protected files via CSV form. Useful for saving or editing list of files in one form.
* Easy reorder list of files via drag and drop  interface.
* Configure URLs for pages with  warning,  like "link expired notice".
* Mobile friendly.

= SECURE DOWNLOADS IS GREAT FOR =

* Distribute you files after purchase
* Delivery updates of your products to your customers

== Installation ==

= Automatic installation =

To do an automatic install, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New.
In the search field type "Secure Downloads" and click Search Plugins. 
Once you've found the plugin you can view details about it such as the the point release, rating and description. 
Now, you can install it by clicking "Install Now".

= Manual installation via WordPress admin panel =

* Download plugin zip file to your computer
* In your WordPress admin panel, navigate to the Plugins menu and click Add New.
* Click "Upload Plugin" button and hit "Choose File" button
* When the popup appears select your downloaded zip file of plugin
* Follow the on-screen instructions and wait as the upload completes.
* When it's finished, activate the plugin via the prompt. A message will show confirming activation was successful.

= Manual installation via FTP =

* Download plugin zip file to your computer and unzip it 
* Using an FTP application, or your hosting control panel, upload the unzipped plugin folder to your WordPress installation's `wp-content/plugins/` directory.
* In your WordPress admin panel, navigate to the Plugins menu and find your uploaded plugin
* Click on Activate link under the plugin. A message will show confirming activation was successful.

That's it! 

== Frequently Asked Questions ==

= Adding New Files =

* Open Secure Downloads > Files menu page in WordPress admin panel
* Click on "Add New" button and upload your files. Please note,  you must to  upload new files via menu  of plugin, for saving these files secure. Do not use previously uploaded files via standard media/pages/posts uploader.
* Enter Title, Version Number and Description at "Attachment details" section.
* Select one or multiple files, click insert button and Save changes.

= Configure Settings =

* Open Secure Downloads > Settings menu page in WordPress admin panel
* Configure different settings, like secret key  for hash generating, warning URLs, default options, etc...
* At Secure Downloads > Settings > Emails menu page you can  configure email templates that  are sending to your customers and administrator

= Secure Links for File Downloads =

* Open Secure Downloads menu page in WordPress admin panel
* Select specific file in selectbox
* Optionally enter email,  if you need to send protected link to  your customer
* Configure link expire time, optionally configure IP loc for file download, and activate option to send copy of email to administrator
* Click on Generate or Send button for generation or sending email with secure link to your protected file
* Check status of action

= Languages =

Plugin supports following languages:

- English

= Requirements =

- PHP 5.2.4 or newer,
- MySQL version 5.0 or newer,
- WordPress 4.0 or newer,
- jQuery 1.7.1 or newer

== Screenshots ==

1. **Send** or simply generate **secure download links** to  your protected files.
2. **Sortable List of your files** - edit and sort (drag and drop) list  of your protected files.
3. **CSV List of your files** - upload files to  protected folder, edit file title, description, and version number.
4. **Settings** - configure different options.
5. **Emails** - activate and configure email template for sending to your customers and download notification email.
6. **Email Delivery** - confirmation of email sending.

== Changelog ==
= 1.2.4 =
* Fixed Fatal error: Uncaught Error: Call to undefined function oper_plugin_url() in opsd-css.php

= 1.2.3 =
* Fixed a vulnerability that could occur if a WordPress user had access to the plugins menu (in the WordPress admin panel) and that user saved links that were not what they expected. The file link must contain a secret folder and no longer supports "up-leveling".
* Updated UI of settings tabs with a modern design. (2.0.3.1)
* Removed premium addon links in admin panel.

= 1.2.2 =
* Added never expire products option (1.2.2.2)
* Load some CSS files only at  admin panel (1.2.2.1)

= 1.2.1 =
* **New**. Icon for WordPress side menu. (2.0.1.2)

= 1.2 =
* **Compatibility**. Support **WordPress 5.7** - update of admin panel styles. (1.2.1)
* **Fix** Warning Deprecated: The each() function is deprecated. (1.2.2)
* **Fix** Deprecated: Function get_magic_quotes_runtime() is deprecated(1.2.3)

= 1.1.5 =
* **Compatibility**. Support **WordPress 5.5** - update of admin panel styles. (1.1.5.1)

= 1.1.4 =
* **Compatibility**. Support **WordPress 5.3** - update of admin panel styles. (2.0.13.1)
* **Under Hub** Added hook: " add_filter( 'opsd_define_ip_mask', 'my_opsd_define_ip_mask', 10, 1 );  function my_opsd_define_ip_mask (  $ip_mask ){ return $ip_mask } " for ability to override mask  for IP (1.1.4.2)
* **Fix** Checking of saving closing window state (nonce of window) in Ajax request only for current plugin (1.1.4.1)

= 1.1.3 =
* **Fix** Notice: Array to string conversion in ..\secure-downloads\core\any\api-emails.php (1.1.3.1)
* **Under Hub** Ability to  use action  for programmatically  send secure email. (1.1.3.2)  Example: do_action( 'opsd_send_secure_download_email_to_user', array( 'opsd_email_to' => 'email@server.com', 'send_copy_to_admin' => 'Off', 'opsd_product_selection' => 1, 'opsd_product_expire' => '+ 24 hours', 'continue_without_product' => false ) );

= 1.1.2 =
* **Fix** conflict issue with  Booking Calendar plugin (1.1.2.1)
* **Fix** Fatal error: Uncaught ArgumentCountError: Too few arguments to function opsd_recheck_plugin_locale()… in PHP 7.2 (1.1.2.2)
* **Fix** Notice: A non well formed numeric value encountered in ... in PHP 7.2 (1.1.2.3)
* **Fix** Possible Fatal error: Cannot redeclare debuge_log(),  if used with  some other new plugins. (1.1.2.4)
* **Fix** Error "404 Not found" "../assets/libs/chosen/chosen.css" (1.1.2.5)
* **Fix** Notice: A non well formed numeric value encountered in ../opsd-class-notices.php in PHP 7.2 (1.1.2.6)

= 1.1.1 =
* **Fix** issue of checkboxes and radio buttons  height in new Firefox updates in admin panel,  otherwise sometimes, there exist weird artefact (1.1.1.1)

= 1.1 =
* Add additional warning text  about ngnix servers. (1.1.1)
* Load  JavaScript variables only  for admin panel (1.1.2)
* Fix. Issue Fatal error: Uncaught Error: [] operator not supported for strings in ..\wp-content\plugins\secure-downloads\core\admin\api-settings.php:552  (1.1.3)
* Fix. Issue ( ! ) Notice: Array to string conversion in  ...\class-admin-settings-api.php:929 (1.1.4)
* **Improvement** Updated all links from  http to https of plugin website.
* **Improvement** Auto select product based on 'product_name' parameter in URL (1.1.5)
* **Improvement** Auto select product based on 'product_id' parameter in URL (1.1.5)
* **Improvement** Auto insert email based on 'email' parameter in URL Example: www.server.com?page=opsd&email=someemail%40server.com&product_name=text_file (1.1.5)

== Upgrade Notice ==
= 1.1 =
Latest WordPress version support. Minor fixes and improvements.