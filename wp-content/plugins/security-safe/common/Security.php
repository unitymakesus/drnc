<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class Security
 * @package SecuritySafe
 */
class Security extends Plugin {

    /**
     * List of all policies running.
     * @var array
     */
    protected $policies;

    /**
     * Security constructor.
     */
	function __construct( $plugin ) {

        // Run parent class constructor first
        parent::__construct( $plugin );

        if ( $this->settings['general']['on'] == '1' ) {
            
            // Run All Policies
            $this->privacy();
            $this->files();
            $this->content();
            $this->access();
            $this->firewall();
            $this->backups();

        } else {

                $this->messages['general'] = array( 'Security Safe: All security policies are disabled. You can enable them in <a href="admin.php?page=security-safe&tab=general">General Settings</a>.', 2, 0 );

        } // $this->settings['general']['on']

        // Memory Cleanup
        unset( $plugin );

	} // __construct()


    /**
     * Privacy Policies
     * @since  0.2.0
     */
    private function privacy() {

        $settings = $this->settings['privacy'];

        if ( $settings['on'] == "1" ) {

            $this->add_hook_policy( 'PolicyHideWPVersion', 'wp_generator', 'remove', 'action', 'wp_head' );

        } else {

            $this->messages['privacy'] = array( 'Security Safe: All privacy policies are disabled. You can enable them at the top of <a href="admin.php?page=security-safe-privacy&tab=settings">Privacy Settings</a>.', 2, 0 );

        } // $settings['on']

        // Memory Cleanup
        unset( $settings );

    } // privacy()


    /**
     * File Policies
     * @since  0.2.0
     */
    private function files() {

        global $wp_version;

        $settings = $this->settings['files'];

        if ( $settings['on'] == '1' ) {

            // Disallow Theme File Editing
            $this->add_constant_policy( $settings, 'PolicyDisallowFileEdit', 'DISALLOW_FILE_EDIT', true );

            // Auto Updates: https://codex.wordpress.org/Configuring_Automatic_Background_Updates
            if ( version_compare( $wp_version, '3.7.0') >= 0 && ! defined('AUTOMATIC_UPDATER_DISABLED') ) {

                if ( ! defined('WP_AUTO_UPDATE_CORE') ) {
                    
                    // Automatic Nightly Core Updates
                    $this->add_filter_bool( $settings, 'PolicyUpdatesCoreDev', 'allow_dev_auto_core_updates' );

                    // Automatic Major Core Updates
                    $this->add_filter_bool( $settings, 'PolicyUpdatesCoreMajor', 'allow_major_auto_core_updates' );

                    // Automatic Minor Core Updates
                    $this->add_filter_bool( $settings, 'PolicyUpdatesCoreMinor', 'allow_minor_auto_core_updates' );
                
                } else {
                        
                    if ( isset( $_GET['page'] ) && $_GET['page'] == 'security-safe-files' ) {

                        $this->messages['files'] = array( 'WordPress Automatic Core Updates are being controlled by the constant WP_AUTO_UPDATE_CORE possibly in the wp-config.php file. Automatic Core Update features disabled in this plugin.', 2, 0 );
                        
                    } // $_GET['page']

                }// WP_AUTO_UPDATE_CORE

                // Automatic Plugin Updates
                $this->add_filter_bool( $settings, 'PolicyUpdatesPlugin', 'auto_update_plugin' );

                // Automatic Theme Updates
                $this->add_filter_bool( $settings, 'PolicyUpdatesTheme', 'auto_update_theme' );

            } else {

                if ( defined('AUTOMATIC_UPDATER_DISABLED') ) {

                    if ( isset( $_GET['page'] ) && $_GET['page'] == 'security-safe-files' ) {

                        $this->messages['files'] = array( 'WordPress Automatic Updates are disabled by the constant AUTOMATIC_UPDATER_DISABLED possibly in the wp-config.php file. Automatic Update features are disabled in this plugin.', 2, 0 );
                    
                    } // $_GET['page']

                } // AUTOMATIC_UPDATER_DISABLED

                if ( version_compare( $wp_version, '3.7.0') < 0 ) {

                    $this->messages['files'] = array( 'You are using WordPress Version ' . $wp_version . '. The WordPress Automatic Updates feature controls require version 3.7 or greater.', 2, 0 );
            
                } // version_compare()

            } // version_compare()

        } else {

            $this->messages['files'] = array( 'Security Safe: All file policies are disabled. You can enable them at the top of <a href="admin.php?page=security-safe-files&tab=settings">File Settings</a>.', 2, 0 );

        } // $settings['on']

        // Memory Cleanup
        unset( $settings );

    } // files()


    /**
     * Content Policies
     * @since  0.2.0
     */ 
    private function content() {

        return; //disable functionality

        $settings = $this->settings['content'];

        if ( $settings['on'] == "1" ) {

            // Security Policies Go Here

        } else {

            $this->messages['content'] = array( 'Security Safe: All content policies are disabled. You can enable them at the top of <a href="admin.php?page=security-safe-content&tab=settings">Content Settings</a>.', 2, 0 );

        } // $settings['on']

        // Memory Cleanup
        unset( $settings );

    } // content()


    /**
     * Access Policies
     * @since  0.2.0
     */
    private function access() {

        $settings = $this->settings['access'];
        
        if ( $settings['on'] == "1" ) {

            // Generic Login Errors
            $this->add_policy( $settings, 'PolicyLoginErrors', 'login_errors' );

            // Disable Login Password Reset
            $this->add_policy( $settings, 'PolicyLoginPasswordReset', 'login_password_reset' );

            // Disable Login Remember Me Checkbox
            $this->add_policy( $settings, 'PolicyLoginRememberMe', 'login_remember_me' );

            // Disable xmlrpc.php
            $this->add_policy( $settings, 'PolicyXMLRPC', 'xml_rpc' );

            // Force Local Login
            $this->add_policy( $settings, 'PolicyLoginLocal', 'login_local' );

        } else {

            $this->messages['access'] = array( 'Security Safe: All user access policies are disabled. You can enable them at the top of <a href="admin.php?page=security-safe-user-access&tab=settings">User Access Settings</a>.', 2, 0 );

        } // $settings['on']

        // Memory Cleanup
        unset( $settings );

    } // access()


    /**
     * Firewall Policies
     * @since  0.2.0
     */
    private function firewall() {

        return; // Disable functionality

        $settings = $this->settings['firewall'];

        if ( $settings['on'] == "1" ) {

            // Security Policies Go Here

        } else {

            $this->messages['firewall'] = array( 'Security Safe: The firewall is disabled. You can enable it at the top of <a href="admin.php?page=security-safe-firewall&tab=settings">Firewall Settings</a>.', 2, 0 );

        } // $settings['on']

        // Memory Cleanup
        unset( $settings );

    } // firewall()


    /**
     * Backups Policies
     * @since  0.2.0
     */
    private function backups() {

        return; // Disable functionality

        $settings = $this->settings['backups'];

        if ( $settings['on'] == "1" ) {

            // Security Policies Go Here

        } else {

            $this->messages['backups'] = array( 'Security Safe: Backups are disabled. You can enable them at the top of <a href="admin.php?page=security-safe-backups&tab=settings">Backup Settings</a>.', 2, 0 );

        } // $settings['on']

        // Memory Cleanup
        unset( $settings );

    } // backups()


    /**
     * Runs specified policy class then adds it to the policies list.
     * @since  0.2.0
     */
    private function add_policy( $settings, $policy, $slug ) {

        if( isset( $settings[$slug] ) && $settings[$slug] ) {

            $policy = __NAMESPACE__ . '\\' . $policy;

            new $policy();

            $this->policies[] = $policy;
        }

        // Memory Cleanup
        unset( $settings, $policy, $slug );

    } // add_policy()


    /**
     * Adds policy hook and returns a boolean value then adds it to the policies list.
     * @since  0.2.0
     */
    private function add_hook_policy( $policy, $slug, $action, $type, $value = '' ) {

        if( $policy && $slug && $value != '' ) {

            // Force Specific Actions / types
            $action = ( $action == 'remove' ) ? $action : 'add';
            $type = ( $type == 'action' ) ? $type : 'filter';

            $hook = $action . '_' . $type;

            if( $hook == 'remove_action' ) {

                $hook( $value, $slug );

            } else {

                $hook( $slug, '__return_' . $value );

            } // $hook

            $this->policies[] = $policy;

        } // $policy

        // Memory Cleanup
        unset( $policy, $slug, $action, $type, $value, $hook );

    } // add_hook_policy()


    /**
     * Adds policy constant variable and then adds it to the policies list.
     * @since  0.2.0
     */
    private function add_constant_policy( $settings, $policy, $slug, $value = '' ) {

        if( is_array( $settings ) && $policy && $slug && $value ) {

            if( isset( $settings[ $slug ] ) && $settings[ $slug ] ) {

                if( !defined( $slug ) ) {

                    define( $slug, true );

                    $this->policies[] = $policy;

                } else {

                    $this->log( $slug . ' already defined' );

                } // !defined()

            } else {

                $this->log( $slug . ': Setting not set.' );

            } // isset()

        } else {

            $this->log( $slug . ': Problem adding Constant.' );

        } // is_array()

        // Memory Cleanup
        unset( $settings, $policy, $slug, $value );

    } // add_constant_policy()


    /**
     * Adds a filter with a forced boolean result.
     * @since  0.2.0
     */
    private function add_filter_bool( $settings, $policy, $slug ) {

        // Get Value
        $value = ( isset( $settings[ $slug ] ) && $settings[ $slug ] == '1' ) ? '__return_true' : '__return_false';
        
        // Add Filter
        add_filter( $slug, $value, 1 );
        
        // Add Policy
        $this->policies[] = $policy . $value;

        // Memory Cleanup
        unset( $settings, $policy, $slug, $value );

    } // add_filter_bool()

    /**
     * Throws a 403 Forbidden error to the browser and server. Hopefully the Forbidden will get noticed by firewall automatically.
     * @since  0.2.0
     */ 
    static function forbidden(){

        header('Status: 403 Forbidden');
        header('HTTP/1.1 403 Forbidden');

        exit();

    } // forbidden()


} // Security()
