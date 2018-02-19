<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class Plugin - Main class for plugin
 * @package SecuritySafe
 */
class Plugin {

    /**
     * Information about the plugin.
     * @var array
     */
    protected $plugin = array();


    /**
     * Toggle testing mode on/off.
     * @var boolean
     */
    protected $debug;


    /**
     * local settings values array.
     * @var array
     */
    protected $settings = array();


    /**
     * Contains all the admin message values.
     * @var array
     */
    protected $messages = array();


    /**
     * Plugin constructor.
     * @since  0.1.0
     */
	function __construct( $plugin = false ) {

        // Testing Plugin
        $this->debug = false;

        // Set Plugin Information
        $this->plugin = ( is_array( $plugin ) ) ? $plugin : exit;

        // Add Text Domain For Translations
        load_plugin_textdomain( 'security-safe', false, $this->plugin['dir_lang'] );

        // Retrieve Plugin Settings
        $this->check_settings();

        // Cleanup Settings on Plugin Disable
        register_deactivation_hook( $this->plugin['file'], array( $this, 'disable_plugin') );

        // Memory Cleanup
        unset( $plugin );

	} // __construct()


    /**
     * Used to update settings in the database.
     * @return array
     * @since 0.1.0
     */
    protected function get_settings() {

        $this->log( 'Getting settings from db get_settings().' );

        return get_option( $this->plugin['options'] );

    } // get_settings()


    /**
     * Used to remove settings in the database.
     * @return array
     * @since 0.2.0
     */
    protected function delete_settings() {

        $this->log( 'Deleting settings from db.' );

        // Delete settings
        return delete_option( $this->plugin['options'] );

    } // delete_settings()


    /**
     * Used to update settings in the database.
     * @return  boolean
     * @since 0.1.0
     */
    protected function set_settings( $settings ) {

        // Check to see if the posted request is valid
        if( isset( $_POST ) && ! empty( $POST) ) {

            $valid = check_admin_referer( 'security-safe-settings' );

            if ( ! $valid ) { die( 'Not A Valid Request!' ); }

        } // isset()

        if ( is_array( $settings ) && isset( $settings['plugin']['version'] ) ) {
            
            $results = update_option( $this->plugin['options'], $settings );

            // Memory Cleanup
            unset( $settings );

            if ( $results ) {

                $this->log( 'Settings have been updated.' );

                //Update Plugin Variable
                $this->settings = $this->get_settings();

                // Memory Cleanup
                unset( $results );

                return true;

            } else {

                $this->log( 'ERROR: Settings were not updated.', __FILE__, __LINE__ );

                // Memory Cleanup
                unset( $results );

                return false;

            } // $results

        } else {

            if ( ! isset( $settings['plugin']['version'] ) ) {

                $this->log( 'ERROR: Settings variable is formatted properly. Settings not updated.', __FILE__, __LINE__ );
            
            } else {

                $this->log( 'ERROR: Settings variable is not an array. Settings not updated.', __FILE__, __LINE__ );
            
            }

            // Memory Cleanup
            unset( $settings );

            return false;

        } // is_array()

    } // set_settings()


    /**
     * Checks settings and determines whether they need to be reset to default
     * @since  0.1.0
     */
    function check_settings() {

        // Initially Get Settings
        $this->settings = $this->get_settings();

        if ( isset( $_POST ) && ! empty( $_POST ) && isset( $_GET['page'] ) && strpos( $_GET['page'], 'security-safe' ) !== false ){

            // Remove Reset Variable
            if ( isset( $_GET['reset'] ) ) { 
                
                unset( $_GET['reset'] );

            }

            $page_slug = str_replace( array( 'security-safe-', 'security-safe' ), '', $_GET['page'] );
            
            // Compensation For Oddball Scenarios
            $page_slug = ( $page_slug == '' ) ? 'general' : $page_slug;
            $page_slug = ( $page_slug == 'user-access' ) ? 'access' : $page_slug;

            $this->post_settings( $page_slug );

            // Memory Cleanup
            unset( $page_slug );

        } elseif ( 
            isset( $_GET['page'] ) && 
            $_GET['page'] == $this->plugin['slug'] &&

            isset( $_GET['reset'] ) &&
            $_GET['reset'] == 1
        ) {
            // Reset On General Settings Only
            $this->reset_settings();

        } elseif ( ! isset( $this->settings['plugin']['version'] ) ) {

            // Initially Set Settings to Default
            $this->log( 'No version in the database. Initially set settings.' );
            $this->reset_settings( true );

        } else {

            // Check For Upgrades
            $this->upgrade_settings();

        } // isset( $_POST )

    } //check_settings()


    /**
     * Resets the plugin settings to default configuration.
     * @since  0.2.0
     */  
    protected function reset_settings( $initial = false ) {

        $this->log( 'System forced to RESET settings.' );

        // Keep Plugin Version History
        $plugin_history = ( isset( $this->settings['plugin']['version_history'] ) && $this->settings['plugin']['version_history'] ) ? $this->settings['plugin']['version_history'] : array( $this->plugin['version'] );

        if ( ! $initial ) {
            
            $delete = $this->delete_settings();

            if ( ! $delete ) {

                $this->messages[] = array( 'Error: Settings could not be set [1].', 3, 0 );
                return;

            } // ! $delete

        } // ! $initial

        // Privacy ---------------------------------|
        $privacy = array();
        $privacy['on'] = '1';
        $privacy['wp_generator'] = '1';

        // Files -----------------------------------|
        $files = array();
        $files['on'] = '1';
        $files['DISALLOW_FILE_EDIT'] = '1';
        $files['allow_dev_auto_core_updates'] = '0';
        $files['allow_major_auto_core_updates'] = '0';
        $files['allow_minor_auto_core_updates'] = '1';
        $files['auto_update_plugin'] = '0';
        $files['auto_update_theme'] = '0';

        // Content ---------------------------------|
        $content = array();
        $content['on'] = '1';

        // Access ----------------------------------|
        $access = array();
        $access['on'] = '1';
        $access['xml_rpc'] = '0';
        $access['login_errors'] = '1';
        $access['login_password_reset'] = '0';
        $access['login_remember_me'] = '0';
        $access['login_local'] = '0';

        // Firewall --------------------------------|
        $firewall = array();
        $firewall['on'] = '1';

        // Backups ---------------------------------|
        $backups = array();
        $backups['on'] = '1';

        // General Settings ------------------------|
        $general = array();
        $general['on'] = '1';
        $general['security_level'] = '1';
        $general['cleanup'] = '0';

        // Plugin Version Tracking -----------------|
        $plugin = array();
        $plugin['version'] = $this->plugin['version'];
        $plugin['version_history'] = $plugin_history;

        // Set everything in the $settings array
        $settings = array();
        $settings['privacy'] = $privacy;
        $settings['files'] = $files;
        $settings['content'] = $content;
        $settings['access'] = $access;
        $settings['firewall'] = $firewall;
        $settings['backups'] = $backups;
        $settings['general'] = $general;
        $settings['plugin'] = $plugin;

        $result = $this->set_settings( $settings );

        if ( $result && $initial ) {

            $this->messages[] = array( 'Security Safe settings have been set to the minimum standards.', 1, 1 );

        } elseif ( $result && ! $initial ) {

            $this->messages[] = array( 'The settings have been reset to default.', 1, 1 );

        } elseif ( !$result ) {

            $this->messages[] = array( 'Error: Settings could not be reset. [2]', 3, 0 );
        
        } // $result

        $this->log( 'Settings changed to default.' );

        // Memory Cleanup
        unset( $privacy, $files, $content, $access, $firewall, $backups, $general, $plugin, $settings, $result, $delete, $plugin_history );

    } // reset_settings()

    /**
     * Upgrade settings from an older version
     * @since  1.1.0
     */
    protected function upgrade_settings(){

        $settings = $this->settings;
        $upgrade = false;

        // Upgrade Versions
        if ( $this->plugin['version'] != $settings['plugin']['version'] ) {

            $upgrade = true;

            // Add old version to history
            $settings['plugin']['version_history'][] = $settings['plugin']['version'];
            $settings['plugin']['version_history'] = array_unique( $settings['plugin']['version_history'] );
            
            // Update DB To New Version
            $settings['plugin']['version'] = $this->plugin['version'];
        
        } // $this->plugin['version']

        // Upgrade to version 1.1.0
        if ( isset( $settings['files']['auto_update_core'] ) ) {

            $upgrade = true;

            // Remove old setting
            unset( $settings['files']['auto_update_core'] );

            if( ! isset( $settings['files']['allow_dev_auto_core_updates'] ) ) {
                $settings['files']['allow_dev_auto_core_updates'] = '0';
            } 

            if( ! isset( $settings['files']['allow_major_auto_core_updates'] ) ) {
                $settings['files']['allow_major_auto_core_updates'] = '0';
            }

            if( ! isset( $settings['files']['allow_minor_auto_core_updates'] ) ) {
                $settings['files']['allow_minor_auto_core_updates'] = '1';
            } 

        } // $settings['auto_update_core']

        if ( $upgrade ) {

            $result = $this->set_settings( $settings ); // Update DB

            if ( $result ) {

                $this->messages[] = array( 'Security Safe: Your settings have been upgraded.', 0, 1 );
                $this->log( 'Added upgrade success message.' );

                // Get Settings Again
                $this->settings = $this->get_settings();

            } else {

                $this->messages[] = array( 'Security Safe: There was an error upgrading your settings. We would recommend resetting your settings to fix the issue.', 3 );
                $this->log( 'Added upgrade error message.' );

            } // $success

        } // $upgrade

        // Memory Cleanup
        unset( $settings, $upgrade );

    } // upgrade_settings()

    /**
     * Sanitize Data before placing it in the database
     * @return $settings array of settings in database
     * @since  0.1.0
     */
    protected function post_settings( $settings_page ) {

        $settings_page = strtolower( $settings_page );

        $this->log( 'Running post_settings().' );

        if ( isset( $_POST ) && ! empty( $_POST ) ) {

            $this->log( 'Form was submitted.' );

            // Posted Settings
            $new_settings = $_POST;

            // Remove submit value
            unset( $new_settings['submit'] );

            // Get settings
            $settings = $this->settings; // Get copy of settings

            $options = $settings[ $settings_page ]; // Get page specific settings

            // Use flag to determine if settings are changed
            $same = true;

            // Set Settings Array With New Values
            foreach ( $options as $label => $value ) {

                if ( isset( $new_settings[ $label ] ) ) {

                    if ( $options[ $label ] != $new_settings[ $label ] ) {
                        // Set Value
                        //echo "set " . $label . "<br>";
                        $options[ $label ] = $new_settings[ $label ];
                        $same = false;
                    }

                    unset( $new_settings[ $label ] );

                } elseif ( !isset( $new_settings[ $label ] ) && $options[ $label ] != '0' ) {
                    
                    // Set Value To Default
                    //echo "default " . $label . "<br>";
                    $options[ $label ] = '0';
                    $same = false;

                } // isset()

            } //endforeach

            // Add New Settings
            if ( ! empty( $new_settings ) ) {

                foreach ( $new_settings as $label => $value ) {

                    $options[ $label ] = $new_settings[ $label ];
                    $same = false;

                } // foreach()

            } // ! empty()

            // Compare New / Old Settings
            if ( $same ) {

                $this->messages[] = array( 'Settings saved.', 0, 1 );

            } else {

                // Update Settings
                $settings[ $settings_page ] = $options; // Update page settings
                $success = $this->set_settings( $settings ); // Update DB

                if ( $success ) {

                    $this->messages[] = array( 'Your settings have been saved.', 0, 1 );
                    $this->log( 'Added success message.' );

                } else {

                    $this->messages[] = array( 'There was an error. Settings not saved.', 3 );
                    $this->log( 'Added error message.' );

                } // $success

                // Memory Cleanup
                unset( $success );

            } // $same

            // Memory Cleanup
            unset( $new_settings, $settings, $options, $same, $label, $value );

        } else {

            $this->log( 'Form NOT submitted.' );

        } // $_POST

        $this->log( 'Finished post_settings() for ' . $settings_page );

    } // post_settings()


    /**
     * Removes the global variable for the plugin after PHP is done executing.
     * @since  0.2.0
     */ 
    static function shutdown(){

        global $SecuritySafe;

        // Memory Cleanup
        unset( $SecuritySafe );

    } // shutdown()

    /**
     * Removes the settings from the database on plugin deactivation
     * @since  0.3.5
     */
    public function disable_plugin() {

        if( isset( $this->settings['general']['cleanup'] ) && $this->settings['general']['cleanup'] == '1' ) {

            $delete = $this->delete_settings();

        } // isset()

    } // disable_plugin()


    /**
     * Writes to debug.log for troubleshooting
     * @param string $message Message entered into the log
     * @param string $file Location of the file where the error occured
     * @param string $line Line number of where the error occured
     * @return void
     * @since 0.1.0
     */
     function log( $message, $file = false, $line = false ) {

        // Name of log file
        $filename = 'debug.log';

        if ( $this->debug ) {

            // Log message in the log file
            $activity_log_path = $this->plugin['dir'] . '/' . $filename;

            $datestamp = date( 'Y-M-j h:m:s' );
            $message = ( $message ) ? $message : 'Error: Log Message not defined!';

            if ( $file && $line ) {

                $message .= ' - ' . 'Occurred on line ' . $line . ' in file ' . $file;

            } // $file

            $activity_log = $datestamp . " - " . $message . "\n";

            error_log( $activity_log, 3, $activity_log_path );

            // Memory Cleanup
            unset( $activity_log_path, $datestamp, $message, $file, $line, $activity_log );

        } else {

            // Detect File Then Delete It
            if ( file_exists( $filename ) ) {

                unlink( $filename );

            } // file_exists()
            
        } // $this->debug

        // Memory Cleanup
        unset( $filename );

    } // log()

} // Plugin()
