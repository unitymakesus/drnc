<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class AdminPageFiles
 * @package SecuritySafe
 * @since  0.2.0
 */
class AdminPageFiles extends AdminPage {


    /**
     * This sets the variables for the page.
     * @since  0.1.0
     */  
    protected function set_page() {

        // Fix Permissions
        $this->fix_permissions();

        $this->slug = 'security-safe-files';
        $this->title = 'Files & Folders';
        $this->description = 'It is important to keep all files updated and ensure only authorized users have access to them.';

        $this->tabs[] = array(
            'id' => 'settings',
            'label' => 'Settings',
            'title' => 'File Settings',
            'heading' => false,
            'intro' => false,
            'content_callback' => 'tab_settings',
        );

        $this->tabs[] = array(
            'id' => 'core',
            'label' => 'Core',
            'title' => 'WordPress Base Directory & Files',
            'heading' => 'Check to make sure all file permissions set properly.',
            'intro' => 'Incorrect directory or file permission values can lead to security vulnerabilities or even plugins or themes not functioning properly. If you are not sure what permissions value to set a file or directory to, use the standard recommended value provided. ',
            'classes' => array( 'full' ),
            'content_callback' => 'tab_core',
        );

        $this->tabs[] = array(
            'id' => 'theme',
            'label' => 'Theme',
            'title' => 'Theme Audit',
            'heading' => 'Check to make sure all theme file permissions set properly.',
            'intro' => 'If you use "Secure" permission settings, and experience problems, just set the file permissions back to "Standard."',
            'classes' => array( 'full' ),
            'content_callback' => 'tab_theme',
        );

        $this->tabs[] = array(
            'id' => 'uploads',
            'label' => 'Uploads',
            'title' => 'Uploads Directory Audit',
            'heading' => 'Check to make sure all uploaded files have proper permissions.',
            'intro' => '',
            'classes' => array( 'full' ),
            'content_callback' => 'tab_uploads',
        );

        $this->tabs[] = array(
            'id' => 'plugins',
            'label' => 'Plugins',
            'title' => 'Plugins Audit',
            'heading' => 'Check to make sure all plugin file permissions set properly.',
            'intro' => 'If you see some permissions that do not look correct, please contact the plugin developers to inform them of the issue. They should fix the issue and release a new version of their plugin. If there are serious security issues identified, and you do not get a response from them, we would recommend removing the plugin from your site.',
            'classes' => array( 'full' ),
            'content_callback' => 'tab_plugins',
        );

        $this->tabs[] = array(
            'id' => 'server',
            'label' => 'Server',
            'title' => 'Server Information',
            'heading' => 'It is your hosting provider\'s job to keep your server up-to-date.',
            'intro' => 'This table below will help identify the software versions currently on your hosting server. <br>NOTE: System administrators often do server updates once per month. If something is a version behind, then you might be between update cycles or there may be compatibility issues due to version dependencies.',
            'classes' => array( 'full' ),
            'content_callback' => 'tab_server',
        );

    } // set_page()


    /**
     * This tab displays file settings.
     * @since  0.2.0
     */ 
    function tab_settings() {

        global $wp_version;

        $html = '';

        // Shutoff Switch
        $rows = $this->form_select( $this->settings, 'File Policies', 'on', array( '0' => 'Disabled', '1' => 'Enabled' ), 'If you experience a problem, you may want to temporarily turn off all file policies at once to troubleshoot the issue.' );
        $html .= $this->form_table( $rows );

        if ( version_compare( $wp_version, '3.7.0') >= 0 && ! defined('AUTOMATIC_UPDATER_DISABLED') ) {

            // Wordpress Updates
            $rows = '';
            $html .= $this->form_section( 'Automatic WordPress Updates', 'Updates are one of the main culprits to a compromised website.' );
            
            if ( ! defined('WP_AUTO_UPDATE_CORE') ) {

                $rows .= $this->form_checkbox( $this->settings, 'Dev Core Updates', 'allow_dev_auto_core_updates', 'Automatic Nightly Core Updates', 'Select this option if the site is in development only.' );
                $rows .= $this->form_checkbox( $this->settings, 'Major Core Updates', 'allow_major_auto_core_updates', 'Automatic Major Core Updates', 'If you feel very confident in your code, you could automate the major version upgrades. (not recommended in most cases)' );
                $rows .= $this->form_checkbox( $this->settings, 'Minor Core Updates', 'allow_minor_auto_core_updates', 'Automatic Minor Core Updates', 'This is enabled by default in WordPress and only includes minor version and security updates.' );
            
            }
    
            $rows .= $this->form_checkbox( $this->settings, 'Plugin Updates', 'auto_update_plugin', 'Automatic Plugin Updates', false );
            $rows .= $this->form_checkbox( $this->settings, 'Theme Updates', 'auto_update_theme', 'Automatic Theme Updates', false );
            $html .= $this->form_table( $rows );

        } // version_compare()

        // File Access
        $html .= $this->form_section( 'File Access', false );
        $rows = $this->form_checkbox( $this->settings, 'Theme File Editing', 'DISALLOW_FILE_EDIT', 'Disable Theme Editing', 'Disable the ability for admin users to edit your theme files from the WordPress admin.' );
        $html .= $this->form_table( $rows );

        // Save Button
        $html .= $this->button( 'Save Settings' );

        // Memory Cleanup
        unset ( $rows );

        return $html;

    } // tab_settings()


    /**
     * This tab displays current and suggested file permissions.
     * @since  1.0.3
     */ 
    function tab_core() {

        // Determine File Structure
        $plugins_dir = ( defined( 'WP_PLUGIN_DIR' ) ) ? WP_PLUGIN_DIR : dirname ( dirname( __DIR__ ) );
        $content_dir = ( defined( 'WP_CONTENT_DIR' ) ) ? WP_CONTENT_DIR : dirname( $plugins_dir );
        $muplugins_dir = ( defined( 'WPMU_PLUGIN_DIR' ) ) ? WPMU_PLUGIN_DIR : $content_dir . '/mu-plugins';
        $uploads_dir = wp_upload_dir();
        $uploads_dir = $uploads_dir["basedir"];
        $themes_dir = dirname( get_template_directory() );

        // Array of Files To Be Checked
        $paths = array(
            $uploads_dir,
            $plugins_dir,
            $muplugins_dir,
            $themes_dir,
        );

        // Remove Trailing Slash
        $base = str_replace( '//', '', ABSPATH . '/' );

        // Get All Files / Folders In Base Directory
        $base = $this->get_dir_files( $base, false );
        
        // Combine File List
        $paths = array_merge( $base, $paths );

        // Get Rid of Duplicates
        $paths = array_unique( $paths );

        // Memory Cleanup
        unset( $plugins_dir, $content_dir, $muplugins_dir, $uploads_dir, $themes_dir, $base );

        return $this->display_permissions_table( $paths );

    } // tab_core()


    /**
     * This tab displays current and suggested file permissions.
     * @since  1.0.3
     */ 
    function tab_theme() {

        return $this->display_permissions_table( $this->get_dir_files( get_template_directory() ) );

    } // tab_theme()

    /**
     * This tab displays current and suggested file permissions.
     * @since  1.1.0
     */ 
    function tab_uploads() {

        $uploads_dir = wp_upload_dir();
        $uploads_dir = $uploads_dir["basedir"];

        return $this->display_permissions_table( $this->get_dir_files( $uploads_dir ) );

    } // tab_uploads()


    /**
     * This tab displays current and suggested file permissions.
     * @since  1.0.3
     */ 
    function tab_plugins() {

        $plugins_dir = ( defined( 'WP_PLUGIN_DIR' ) ) ? WP_PLUGIN_DIR : dirname ( dirname( __DIR__ ) );

        return $this->display_permissions_table( $this->get_dir_files( $plugins_dir ) );

    } // tab_plugins()


    /**
     * This tab displays software installed on the server.
     * @since  1.0.3
     */ 
    function tab_server() {

        // Latest Versions
        $latest_versions = array();
        $latest_versions['PHP'] = array( '7' => '7.2.1', '5.6' => '5.6.33' );

        $html = '';

        $html .= '
            <table class="wp-list-table widefat fixed striped file-perm-table" cellpadding="10px">
                <thead>
                    <tr>
                        <th class="manage-column">' . __( 'Description', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 250px;">' . __( 'Current Version', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 250px;">' . __( 'Recommend', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 75px;">' . __( 'Status', 'security-safe' ) . '</th>
                    </tr>
                </thead>';

        $versions = array();

        // PHP Version
        if( defined('PHP_VERSION') ) {

            $status = '';
            $recommend = '';

            if ( version_compare( PHP_VERSION, $latest_versions['PHP']['7'] ) == 0 ) {

                $status = 'Good';
                $recommend = $latest_versions['PHP']['7'];

            } elseif ( version_compare( PHP_VERSION, '7.0.0' ) >= 0 ) {
                
                $status = 'OK';
                $recommend = $latest_versions['PHP']['7'];

            } elseif ( version_compare( PHP_VERSION, $latest_versions['PHP']['5.6'] ) == 0 ) {

                $status = 'Good';
                $recommend = $latest_versions['PHP']['5.6'];
            
            } elseif ( version_compare( PHP_VERSION, '5.6.0' ) >= 0 ) {
                
                $status = 'OK';
                $recommend = $latest_versions['PHP']['5.6'];
                
            } else {
                
                $status = 'Bad';
                $recommend = $latest_versions['PHP']['5.6'];
                
            }

            $versions[] = array( 
                'name' => 'PHP', 
                'current' => PHP_VERSION,
                'recommend' => $recommend, 
                'status' => $status,
            );

        } // PHP_VERSION

        // Get All Versions From phpinfo
        $phpinfo = $this->get_phpinfo(8);

        if ( ! empty( $phpinfo ) ) {

            foreach ( $phpinfo as $name => $section ) {
                
                foreach ( $section as $key => $val ) {
                    
                    if ( strpos( strtolower( $key ), 'version') !== false && strpos( strtolower( $key ), 'php version') === false ) {
                        
                        if ( is_array($val) ) {
                            
                            $current = $val[0];
                        
                        } elseif ( is_string( $key ) ) {
                            
                            $current = $val;
                        
                        } // is_array()

                        // Remove Duplicate Text
                        $name = $name . ': ' . str_replace( $name, '', $key );

                        $versions[] = array( 
                            'name' => $name, 
                            'current' => $current,
                            'recommend' => '-', 
                            'status' => '-',
                        );

                    } // strpos()

                } // foreach()

            } // foreach()
        
        } // ! empty()

        // Display All Version
        foreach ( $versions as $v ) {

            $html .= '<tr>';
            $html .= '<td class="check-column">' . __( $v['name'] ) . '</td>';
            $html .= '<td class="check-column" style="text-align: center;">' . __( $v['current'], 'security-safe' ) . '</td>';
            $html .= '<td class="check-column" style="text-align: center;">' . __( $v['recommend'], 'security-safe' ) . '</td>';
            $html .= '<td class="check-column ' . strtolower( $v['status'] ) . '" style="text-align: center;">' . __( $v['status'], 'security-safe' ) . '</td>';
            $html .= '</tr>';

        } // foreach

        // If phpinfo is disabled, display notice
        if ( empty( $phpinfo ) ) {

            $html .= '<tr><td colspan="4">It seems that the phpinfo() function is disabled. You may need to contact the hosting provider to enable this function for more advanced version details. <a href="http://php.net/manual/en/function.phpinfo.php">See the documentation.</a></td></tr>';
        
        } // ! empty()

        $html .= '</table>';

        // Memory Cleanup
        unset( $latest_versions, $versions, $status, $recommend, $phpinfo, $name, $section, $key, $val, $current, $v );

        return $html;

    } // tab_server()


    /**
     * Returns phpinfo as an array
     * @since  1.0.3
     */ 
    private function get_phpinfo( $type = 1 ) {

        ob_start();

        phpinfo( $type );

        $phpinfo = array();
        $pattern = '#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s';

        if ( preg_match_all( $pattern, ob_get_clean(), $matches, PREG_SET_ORDER)){
            
            foreach ( $matches as $m ) {
            
                if ( strlen( $m[1] ) ) {
                    
                    $phpinfo[ $m[1] ] = array();
                
                } else {

                    $keys = array_keys( $phpinfo );

                    if ( isset( $m[3] ) ) {
                    
                        $phpinfo[ end( $keys ) ][ $m[2] ] = ( isset( $m[4] ) ) ? array( $m[3], $m[4] ) : $m[3];
                
                    } else {
                    
                        $phpinfo[ end( $keys ) ][] = $m[2];

                    } // isset()

                } // strlen()
        
            } // foreach()
            
        } // preg_match_all()

        // Memory Cleanup
        unset( $type, $pattern, $matches, $m, $keys );

        return $phpinfo;

    } // get_phpinfo()


    /**
     * Display all file permissions in a table
     * @since  1.0.3
     */
    private function display_permissions_table( $paths = false ) {

        $html = '
            <table class="wp-list-table widefat fixed striped file-perm-table">
                <thead>
                    <tr>
                        <th class="manage-column">' . __( 'Relative Location', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 100px;"">' . __( 'Type', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 75px;"">' . __( 'Current', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 70px;"">' . __( 'Status', 'security-safe' ) . '</th>
                        <th class="manage-column" style="width: 160px;"">' . __( 'Modify', 'security-safe' ) . '</th>
                    </tr>
                </thead>';

        if ( is_array( $paths ) && ! empty ( $paths ) ) { 

            $file_count = 0;

            foreach ( $paths as $p ) {

                if ( file_exists( $p ) ){

                    // Get Relative Path
                    $rel_path = str_replace( array( ABSPATH, '//' ), '/', $p );

                    // Get File Type
                    $is_dir = is_dir( $p );

                    // Get Details of Path
                    $info = @stat( $p );
                    $permissions = sprintf( '%o', $info['mode'] ); // Get all info about permissions
                    $current = substr( $permissions, -3 ); // Get current o/g/w permissions
                    $perm = str_split( $current ); // Convert permissions to an array
                    
                    // Specific Role Permissions
                    $owner = ( isset( $perm[0] ) ) ? $perm[0] : 0;
                    $group = ( isset( $perm[1] ) ) ? $perm[1] : 0;
                    $world = ( isset( $perm[2] ) ) ? $perm[2] : 0;

                    // Determine Directory or File
                    if ( $is_dir ) {

                        $type = 'directory';
                        $min = '775'; // Standard
                        $sec = '755'; // Secure
                        
                        if ( $current == $min || $current == $sec ) {

                            $status = ( $current == $sec ) ? 'secure' : 'good';

                        } else {

                            // Ceiling
                            $status = ( $world > 5 ) ? 'bad' : 'ok';

                        } // $current

                    } else {

                        $type = 'file';
                        $min = '644'; // Standard
                        $sec = '644'; // Secure

                        // Secure Permissions for certain files
                        $sec = ( strpos( $p, 'wp-config.php' ) ) ? '600' : $sec;
                        $sec = ( strpos( $p, 'php.ini' ) ) ? '600' : $sec;

                        if ( $current == $min || $current == $sec ) {

                            if ( $min == $sec ) {
                                $status = 'good';
                            } else {
                                $status = ( $current == $sec ) ? 'secure' : 'good';
                            }
                            
                        } else {

                            // Ceiling
                            $status = ( $owner > 6 || $group > 4 || $world > 4 ) ? 'bad' : 'ok';

                            // Floor
                            $status = ( $owner < 4 || $group < 0 || $world < 0 ) ? 'bad' : $status;

                        } // $current
                        
                    } // $permissions[0]
                        
                    // Create Standard Option
                    $option_min = ( $status != 'good' && $min != $current ) ? '<option value="' . $min . '|' . $rel_path . '">' . $min . ' - Standard</option>' : false;
                    
                    // Create Secure Option
                    $option_sec = ( $status != 'secure' ) ? '<option value="' . $sec . '|' . $rel_path . '">' . $sec . ' - Secure</option>' : false;
                    $option_sec = ( $min == $sec ) ? false : $option_sec;
                    
                    if ( $option_min || $option_sec ) {

                        $file_count++;

                        // Create Select Dropdown
                        $select = '<select name="file-' . $file_count . '"><option value="-1"> -- Select One -- </option>';
                        $select .= ( $option_min ) ? $option_min : '';
                        $select .= ( $option_sec ) ? $option_sec : '';
                        $select .= '</select>';

                    } else { 

                        $select = '-';

                    } // $option_min

                    $html .=    '<tr>
                                    <td class="check-column">' . $rel_path . '</td>
                                    <td class="check-column" style="text-align: center;">' . $type . '</td>
                                    <td class="check-column" style="text-align: center;">' . $owner . $group . $world . '</td>
                                    <td class="check-column ' . strtolower( $status ) . '" style="text-align: center;">' . ucwords( $status ) . '</td>
                                    <td class="check-column" style="text-align: center;">' . $select . '</td>
                                </tr>';

                } // file_exists()

            } // foreach()

        } else {

            $html .= '<tr><td colspan="5">Error: There were not any files to check.</td></tr>';

        } // is_array()

        // Show Update Permissions Button
        $html .= '<tr><td colspan="4"></td><td>' . $this->button('Update Permissions') . '</td></tr>';

        $html .= '</table>';

        // Memory Cleanup
        unset( $paths, $p, $info, $permissions, $perm, $owner, $group, $world, $type, $rec, $status );

        return $html;

    } // display_permissions_table()


    /**
     * Grabs all the files and folders for a provided directory. It scans in-depth by default.
     * @since  1.0.3
     */ 
    private function get_dir_files( $folder, $deep = true ) {

        // Scan All Files In Plugins Directory
        $files = scandir( $folder );
        $results = array();

        foreach ( $files as $file ) {

            if( in_array( $file, array('.','..') ) ) {

                if ( $file == '.' ) {

                    $abspath = $folder . '/';

                    if ( $abspath == ABSPATH ){
                        $results[] = ABSPATH;
                    } else {
                        $results[] = $folder;
                    }

                } // $file
            
            } elseif ( is_dir( $folder . '/' . $file ) ) {
                
                if ( $deep ) {

                    //It is a dir; let's scan it
                    $array_results = $this->get_dir_files( $folder . '/' . $file );
                    
                    foreach ( $array_results as $r ){
                        $results[] = $r;
                    }// foreach()

                } else {

                    // Add folder to list and do not scan it.
                    $results[] = $folder . '/' . $file;

                } // $deep

            } else {
                //It is a file
                $results[] = $folder . '/' . $file;
            }

        } // foreach()

        // Memory Cleanup
        unset( $folder, $deep, $files, $file, $abspath, $array_results );

        return $results;

    } // get_dir_files()

    /**
     * Fix File Permissions
     * @since  1.1.0
     */
    private function fix_permissions() {

        global $SecuritySafe;

        if ( isset( $_POST ) && ! empty( $_POST ) ) {

            if ( isset( $_GET['tab'] ) && in_array( $_GET['tab'], array( 'core', 'theme', 'plugins', 'uploads' ) ) ) {

                // Add Notice To Look At Process Log
                $SecuritySafe->messages[] = array( 'Please review the Process Log below for details.' , 1, 0 );

                // Display Notice
                $SecuritySafe->display_notices();

                foreach ( $_POST as $name => $value ) {

                    $v = explode( '|', $value );

                    if( strpos( $name, 'file-' ) === false || $v[0] == '0' ) {

                        // Pass On This One
                        
                    } else {

                        $this->set_permissions( $v[1], $v[0] );

                    } // strpos()

                } // foreach()

            } // $_GET['tab']

        } // $_POST

    } // fix_permissions()


    /** 
     * Set Permissions For File or Directory
     * @param [type] $path Absolute path to file or directory
     * @param [type] $perm Desired permissions value 3 chars
     */
    private function set_permissions( $path, $perm ) {
        
        // Get File Path With A Baseline Sanitization
        $path = esc_url( $path );

        // Cleanup Path ( bc WP doesn't have a file path sanitization filter )
        $path = str_replace( array( ABSPATH, 'http://', 'https://', '..', '"', "'", ')', '(' ), '', $path );

        // Add ABSPATH
        $path = ABSPATH . $path;

        // Cleanup Path Again..
        $path = str_replace( array( '/./', '////', '///', '//' ), '/', $path );

        // Relative Path (clean)
        $rel_path = str_replace( ABSPATH, '/', $path );

        // Get Permissions
        $perm = sanitize_text_field( $perm );

        $result = false;

        if ( file_exists( $path ) ) {

            // Permissions Be 3 Chars In Length
            if ( strlen( $perm ) == 3 ) {

                // Perm Value Must Be Octal; Not A String 
                if      ( $perm == '775' ) {  $result = chmod( $path, 0775 ); }
                elseif  ( $perm == '755' ) {  $result = chmod( $path, 0755 ); }
                elseif  ( $perm == '711' ) {  $result = chmod( $path, 0711 ); }
                elseif  ( $perm == '644' ) {  $result = chmod( $path, 0644 ); }
                elseif  ( $perm == '604' ) {  $result = chmod( $path, 0604 ); }
                elseif  ( $perm == '600' ) {  $result = chmod( $path, 0600 ); }

                $result = true;
            } // strlen()

        } else {

            $this->messages[] = array( 'NOT EXIST file: ' . $path , 3, 0 );

        } // file_exists()

        if ( $result ) {

            $this->messages[] = array( 'SUCCESS: File permissions were successfully updated to ' . $perm . ' for file: ' . $rel_path, 0, 0 );
            
        } else {

            $this->messages[] = array( 'ERROR: File permissions could not be updated to ' . $perm . ' for file: ' . $rel_path . '. Please contact your hosting provider for assistance.', 3, 0 );

        } // $result

    } // set_permissions()


} // AdminPageFiles()
