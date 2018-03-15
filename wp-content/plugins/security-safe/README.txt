=== Security Safe ===
Contributors: sovstack, cfullsteam
Tags: security, wp security, privacy, security audit, file permissions, brute force login
Requires at least: 4
Requires PHP: 5.3
Tested up to: 4.9.4
Stable tag: trunk

A plugin to quickly implement WordPress hardening and security techniques.

== Description ==

Security Safe is a free wp security plugin.

Features:

* Hide WordPress CMS Version
* Hide Script Versions
* Make Website Anonymous During Updates
* Enable Automatic Core, Plugin, and Theme Updates
* Disable Editing Theme Files
* Audit & Fix File Permission
* Audit Hosting Software Versions
* Login Security
* Disable XML-RPC.php
* Brute Force Protection
* Content Copyright Protection
* Turn On/Off All Security Policies Easily

== Installation ==

1. Install Security Safe automatically or by uploading the ZIP file to your plugins folder. 
2. Activate the Security Safe on the 'Plugins' admin page. The plugin initially sets minimum security policies active.
3. Navigate to the General Settings by clicking on the Security Safe menu located on the left side admin panel.
4. On General Settings, You will notice the main icon menu at the top of the page. Navigate through all of them and change settings as they pertain to your site's needs.
5. Test your site thoroughly. If you notice that your site is not functioning as expected, you can turn off each type of security policy (Privacy, Files, User Access, etc.) by navigating to each page and disabling the policy type. If necessary, you can disable all policy types at once using General Settings.

== Screenshots ==

1. Privacy Settings
2. File Settings
3. File Permissions
4. Server Software
5. User Access Settings
6. Content Settings

== Changelog ==

= 1.1.3 =
*Release Date - 25 February 2018*
* Added Feature: Hide WordPress Version from the RSS feed.
* Added Feature: Hide Script Versions from enqueued CSS and JS files
* BUG FIX: Hide WordPress stays on despite the settings value
* BUG FIX: An error is displayed when saving settings if the settings are the same in the database.

= 1.1.2 =
*Release Date - 20 February 2018*
* BUG FIX: Icon CSS conflict with other icon plugins

= 1.1.1 =
*Release Date - 20 February 2018*
* Added Feature: Disable text highlighting to deter copying content
* Added Feature: Disable right clicking to deter copying content
* Added Feature: Fix file permissions
* Added Feature: Make website anonymous when checking for updates
* Added Feature: Plugin information tab for debugging purposes
* Bug Fix: Database was including nonce and referrer when saving settings
* Improvement: Update UI styling
* Thank you @epohs and @isabisa for file permissions UI testing and feedback
* Tested up to: 4.9.4

= 1.0.3 =
*Release Date - 24 January 2018*
* Added Feature: Server software version auditing
* Added Feature: Theme file permissions auditing
* Added Feature: Plugins files permissions auditing
* Bug Fix: Plugin version history was not logging properly
* Bug Fix: Automatic Updates were not running when the settings were selected
* Security: Added Nonce to admin forms
* Security: Removed the absolute path from file permissions auditing
* Improvement: File permissions were expanded to include all files and folders of WordPress base directory
* Improvement: Minor code standardization
* Improvement: Updated all screenshots
* Tested up to: 4.9.2

= 1.0.2 =
*Release Date - 10 January 2018*
* Bug Fix: File permissions would display files and directories even if they did not exist
* Bug Fix: File permissions status would display Bad if the 'world' had no permissions to read, write, or execute
* Bug Fix: Directory structure references relied on constants that could potentially conflict with custom site directory structures

= 1.0.1 =
*Release Date - 9 January 2018*
* Initial Release
* Thank you @daggerhart for plugin development feedback
* Thank you @cfullsteam for PHP structure feedback
