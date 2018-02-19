<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class AdminPagePrivacy
 * @package SecuritySafe
 * @since  0.2.0
 */
class AdminPagePrivacy extends AdminPage {


    /**
     * This sets the variables for the page.
     * @since  0.1.0
     */  
    protected function set_page() {

        $this->slug = 'security-safe-privacy';
        $this->title = 'Privacy';
        $this->description = "Don't share too much information. Silence is a virtue.";

        $this->tabs[] = array(
            'id' => 'settings',
            'label' => 'Settings',
            'title' => 'Privacy Settings',
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
        $rows = $this->form_select( $this->settings, 'Privacy Policies', 'on', array( '0' => 'Disabled', '1' => 'Enabled' ), 'If you experience a problem, you may want to temporarily turn off all privacy policies at once to troubleshoot the issue.' );
        $html .= $this->form_table( $rows );

        // Source Code Versions
        $rows = $this->form_checkbox( $this->settings, 'WordPress Version', 'wp_generator', 'Hide WordPress Version', 'WordPress leaves a little footprint on your site by default. This is used by WordPress to know how popular they are. Unfortunately, it also helps an attacker know what platform you are using and version.' );      
        $html .= $this->form_table( $rows );

        // Save Button
        $html .= $this->button( 'Save Settings' );

        // Memory Cleanup
        unset( $rows );

        return $html;

    } // tab_settings()


} // AdminPagePrivacy()
