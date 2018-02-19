<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class AdminPageAccess
 * @package SecuritySafe
 * @since  0.2.0
 */
class AdminPageAccess extends AdminPage {


    /**
     * This sets the variables for the page.
     * @since  0.1.0
     */  
    protected function set_page() {

        $this->slug = 'security-safe-user-access';
        $this->title = 'User Access Control';
        $this->description = 'Control how your users access your admin area.';

        $this->tabs[] = array(
            'id' => 'settings',
            'label' => 'Settings',
            'title' => 'User Access Settings',
            'heading' => false,
            'intro' => false,
            'content_callback' => 'tab_settings',
        );

    } // set_page()


    /**
     * This populates all the metaboxes for this specific page.
     * @since  0.2.0
     */ 
    function tab_settings() {

        $html = '';

        // Shutoff Switch
        $rows = $this->form_select( $this->settings, 'User Access Policies', 'on', array('0' => 'Disabled', '1' => 'Enabled'), 'If you experience a problem, you may want to temporarily turn off all user access policies at once to troubleshoot the issue.' );
        $html .= $this->form_table( $rows );

        // Login Security
        $html .= $this->form_section( 'Login Form', "Your website's first line of defense is the login form." );
        $rows = $this->form_checkbox( $this->settings, 'Login Errors', 'login_errors', 'Make login errors generic.', 'When someone attempts to login to the website, by default, the error messages will tell the user that the password is incorrect or that the username is not valid. This exposes too much information to the potential intruder.' );
        $rows .= $this->form_checkbox( $this->settings, 'Password Reset', 'login_password_reset', 'Disable Password Reset', 'If you are the only user of the site, you may want to disable this feature as you have access to the database and hosting control panel.' );
        $rows .= $this->form_checkbox( $this->settings, 'Remember Me', 'login_remember_me', 'Disable Remember Me Checkbox', 'If the device that uses the remember me feature gets stolen, then the person in possession can now login to the site.' );
        $html .= $this->form_table( $rows );

        // Remote Access
        $html .= $this->form_section( 'Remote Control', 'How do you want your users to access your site?' );
        $rows = $this->form_checkbox( $this->settings, 'XML-RPC', 'xml_rpc', 'Disable Remote Control', 'The xml-rpc.php file allows remote execution of scripts. This can be useful in some cases, but most of the time it is not needed.' );
        $html .= $this->form_table( $rows );

        // Brute Force
        $html .= $this->form_section( 'Brute Force Logins', 'Brute Force login attempts are repetitive attempts to login to your site.' );
        $rows = $this->form_checkbox( $this->settings, 'Local Logins', 'login_local', 'Only Allow Local Logins', 'Software can remotely login to your site without actually visiting your website or using the login form. Unless you know that you need to be able to remotely login, it is best to only allow local logins. This will help reduce the amount of Brute Force attacks.' );
        $html .= $this->form_table( $rows );

        // Save Button
        $html .= $this->button( 'Save Settings' );

        // Memory Cleanup
        unset( $rows );

        return $html;

    } // tab_settings()


} // AdminPageAccess()
