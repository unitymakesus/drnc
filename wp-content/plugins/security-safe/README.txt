=== Security Safe ===
Contributors: sovstack, cfullsteam
Tags: security, wp security, privacy, security audit, file permissions, brute force login
Requires at least: 4
Requires PHP: 5.3
Tested up to: 4.9.2
Stable tag: trunk

A plugin to quickly implement WordPress hardening and security techniques.

== Description ==

Security Safe is a free wp security plugin.

Features:

* Hide WordPress CMS Version
* Enable Automatic Core, Plugin, and Theme Updates
* Disable Editing Theme Files
* Audit WordPress File Permissions
* Audit All Plugins' File Permissions
* Audit Theme File Permissions
* Audit Hosting Software Versions
* Disable Remote Script Execution
* Make Login Errors Generic
* Force Local Logins
* Turn Off Login Remember Me Option
* Disable Password Reset
* Turn On/Off All Security Policies Easily

== Installation ==

1. Install Security Safe automatically or by uploading the ZIP file to your plugins folder. 
2. Activate the Security Safe on the 'Plugins' admin page. The plugin initially sets minimum security policies active.
3. Navigate to the General Settings by clicking on the Security Safe menu located on the left side admin panel.
4. On General Settings, You will notice the main icon menu at the top of the page. Navigate through all of them and change settings as they pertain to your site's needs.
5. Test your site thoroughly. If you notice that your site is not functioning as expected, you can turn off each type of security policy (Privacy, Files, User Access, etc.) by navigating to each page and disabling the policy type. If necessary, you can disable all policy types at once using General Settings.

== Screenshots ==

1. General Settings - Turn off all security settings temporarily and reset settings.
2. Privacy Settings - Hide WordPress version in the source code.
3. File Settings - Enable Automatic Updates and disable theme file editing from the admin panel.
4. WordPress Base Directory - Validate file permissions and quickly see if there are any suspicious looking files in the base directory.
5. Theme Audit - Quickly verify your theme files have secure file permissions.
6. Plugins Audit - Verify that all of your plugins have proper file permissions.
7. Server Information - Audit PHP version and all modules installed on the server.
8. User Access - Make login errors generic, disable password reset, disable the 'remember me' checkbox, disable xml-rpc.php, force local logins to deter brute-force logins.

== Changelog ==

= 1.0.3 =
* Added Feature: Server software version auditing.
* Added Feature: Theme file permissions auditing.
* Added Feature: Plugins files permissions auditing.
* Bug Fix: Plugin version history was not logging properly.
* Bug Fix: Automatic Updates were not running when the settings were selected.
* Security: Added Nonce to admin forms.
* Security: Removed the absolute path from file permissions auditing.
* Improvement: File permissions were expaned to include all files and folders of WordPress base directory.
* Improvement: Minor code standardization.
* Improvement: Updated all screenshots.
* Tested up to: 4.9.2

= 1.0.2 =
* Bug Fix: File permissions would display files and directories even if they did not exist.
* Bug Fix: File permissions status would display Bad if the 'world' had no permissions to read, write, or execute. 
* Bug Fix: Directory structure references relied on constants that could potentially conflict with custom site directory structures.

= 1.0.1 =
* Initial Release
