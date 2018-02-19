<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class Admin
 * @package SecuritySafe
 */
class Admin extends Security {

    protected $page;

    /**
     * Admin constructor.
     */
	function __construct( $plugin ) {

        // Run parent class constructor first
        parent::__construct( $plugin );

        // Display Admin Notices
        add_action( 'admin_notices', array( $this, 'display_messages' ) );

        // Load CSS / JS
        add_action( 'admin_init', array( $this, 'scripts' ) );

        // Body Class
        add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );

        // Create Admin Menus
        add_action( 'admin_menu', array( $this, 'admin_menus' ) );

        if ( $this->debug ) {

            $this->messages[] = array( 'Plugin Debug Mode is on.', 1, 0 );

        } // $this->debug

	} // __construct()


    /**
     * Initializes admin scripts
     */
    public function scripts() {

        if ( isset( $_GET['page'] ) ) {

            // Shorten Code References
            $plugin = $this->plugin;

            // See if the page is one of ours
            $local_page = strpos( $_GET['page'], $this->plugin['slug'] );

            // Only load CSS and JS for our admin pages.
            if ( $local_page !== false ) {

                // Load CSS
                wp_register_style( $plugin['slug'] . '-admin', $plugin['url'] . 'css/admin.css', array(), $plugin['version'], 'all' );
                wp_enqueue_style( $plugin['slug'] . '-admin' );

                // Load JS
                wp_enqueue_script( 'common' );
                wp_enqueue_script( 'wp-lists' );
                wp_enqueue_script( 'postbox' );
                //wp_enqueue_script( $plugin['slug'] . '-admin', $plugin['url'] . 'js/admin.js', array( 'jquery' ), $plugin['version'], true );

            } // $local_page

            // Memory Cleanup
            unset( $plugin, $local_page );

        } // isset()

    } //scripts()


    /**
     * Adds a class to the body tag
     * @since  0.2.0
     */
    public function admin_body_class( $classes ) {

        $classes .= $this->plugin['slug'];

        return $classes;

    } // admin_body_class()


    /**
     * Creates Admin Menus
     */
    public function admin_menus() {

        $this->log( 'Creating Admin Menus.' );

        $page = array();

        // Add the menu page
        $page['menu_title'] = 'Security Safe';
        $page['title'] = $page['menu_title'] . ' Dashboard';
        $page['capability'] = 'activate_plugins';
        $page['slug'] = $this->plugin['slug'];
        $page['function'] = array( $this, 'page_dashboard' );
        $page['icon_url'] = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iODMuNDExcHgiIGhlaWdodD0iOTQuMTNweCIgdmlld0JveD0iMC4wMDEgMzQ4LjkzNSA4My40MTEgOTQuMTMiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMC4wMDEgMzQ4LjkzNSA4My40MTEgOTQuMTMiDQoJIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggZmlsbD0iI0YyNjQxOSIgZD0iTTgzLjI3MSwzNTYuODk2YzAsMC0yMC41NjItNy45NjEtNDEuNjI4LTcuOTYxYy0yMS4wNjcsMC00MS42MjksNy45NjEtNDEuNjI5LDcuOTYxDQoJCXMtMC43OTUsMzAuMDMsMTAuMDMyLDUxLjgwNGMxMC44MjUsMjEuNzcxLDMyLjA5OSwzNC4zNjUsMzIuMDk5LDM0LjM2NXMyMS4wNzgtMTMuMjI3LDMyLjEtMzYuODU0DQoJCUM4NS4yNjYsMzgyLjU4MSw4My4yNzEsMzU2Ljg5Niw4My4yNzEsMzU2Ljg5NnogTTUuMjksMzYxLjgxNGwwLjAzOC0xLjQ4M2wxLjQwNi0wLjQ4MWMwLjQ0OS0wLjE1NCw3LjQzMS0yLjUwNywxNi45NTktNC4xOQ0KCQljLTIuMTU0LDEuMjcxLTQuMjQ0LDIuNzc1LTUuNjQyLDMuODk5Yy01LjU0OSw0LjQ1NC0xMC4wMTgsOS4wOTktMTIuNDg4LDExLjgzMUM1LjIwMSwzNjUuOTM1LDUuMjgsMzYyLjIwOSw1LjI5LDM2MS44MTR6DQoJCSBNNi4wMTIsMzc2LjYzMWMyLjQ2OCwyLjM1LDYuODU1LDUuNzk1LDEzLjc2Nyw4Ljg2OWMxMS40MDgsNS4wNzIsMjEuODIyLDcuMTc2LDIxLjgyMiw3LjE3NnM4LjgxLTIuNTYxLDE4LjA2MS03LjkyNg0KCQlzMTEuNTI2LTcuNTg4LDExLjUyNi03LjU4OHMtMTMuMjkzLDAuNzA3LTI0LjA4LTEuMTQ5Yy0xMi45MTktMi4yMjQtMTcuMzI1LTUuNDQtMTcuMzI1LTUuNDRzNC40MDYtNC4wNjIsMTAuNDI1LTcuNjY2DQoJCWM2LjMxNC0zLjc3NywxMy45MzctNi43NDIsMTYuNTQ1LTcuNzA5YzEwLjkzOCwxLjY3NiwxOS4yNzMsNC40ODQsMTkuNzY0LDQuNjUzbDEuMzM2LDAuNDU0bDAuMTA0LDEuNDA4DQoJCWMwLjAzMywwLjQ1NSwwLjQxMyw2LjAwMi0wLjMwNCwxMy44NzljLTIuNzUyLDIuNjUtMTMuMzc0LDEyLjAzMS0zMi41OTgsMTkuMTk5Yy0xOC4zNTQsNi44NDQtMjkuOTA2LDguNzU2LTMyLjQ4NCw5LjEyNQ0KCQlDOC42OTUsMzk0Ljk2Myw2Ljg2NiwzODQuNzYsNi4wMTIsMzc2LjYzMXogTTY5LjMyLDQwNi40ODljLTMuODQ4LDIuNDA2LTEyLjA2Nyw3LjA2MS0yMy41MzQsMTAuOTENCgkJYy0xMi41NDYsNC4yMTUtMTguNDY4LDUuMzAxLTIwLjM1OSw1LjU2NmMtMC42OTMtMC43MjktMS4zODUtMS40OTQtMi4wNzUtMi4yODVjMi40MDUtMC41OTIsMTEuNzkzLTIuOTk4LDIzLjkwMy03LjM0Ng0KCQljMTEuMDU4LTMuOTY5LDIwLjU1NS05LjgyNiwyNC42MTctMTIuNTFjLTAuNDczLDEuMTg4LTAuOTc5LDIuMzc3LTEuNTI2LDMuNTU3QzcwLjAxNCw0MDUuMDk4LDY5LjY3LDQwNS43OTcsNjkuMzIsNDA2LjQ4OXoiLz4NCjwvZz4NCjwvc3ZnPg0K';
        $page['position'] = '999';

        add_menu_page( $page['title'], $page['menu_title'], $page['capability'], $page['slug'], $page['function'], $page['icon_url'], $page['position'] );

        $subpages = $this->get_admin_pages();

        $this->add_submenu_pages( $subpages, $page );

        // Memory Cleanup
        unset( $page, $subpages );

    } //admin_menus()


    /**
     * Get all admin pages as an array
     * @return  array An array of all the admin pages
     * @uses  get_category_pages()
     * @since  0.1.0
     */
    private function get_admin_pages() {

        // All Admin Pages
        $pages = array();
        $pages = $this->get_category_pages();
        //$pages[] = 'General Settings';

        return $pages;

    } // get_admin_pages()


    /**
     * Get Category Pages
     * @return  $pages array
     * @since  0.2.0
     */
    private function get_category_pages( $disabled = false ) {

        // All Category Pages
        $pages = array();
        $pages[] = 'Privacy';
        $pages[] = 'Files';
        $pages[] = 'User Access';

        // Return Disabled Menus Also
        // Disabled values are arrays for each of checking
        if ( $disabled ) {

            $pages[] = array( 'Content' );
            $pages[] = array( 'Firewall' );
            $pages[] = array( 'Backups' );

        } // $disabled

        // Memory Cleanup
        unset( $disabled );

        return $pages;

    } // get_category_pages()


    /**
     * Creates all the subpages for the menu
     * @param array $subpages
     * @since  0.1.0
     */
    private function add_submenu_pages( $subpages = false, $page = false ) {

        $this->log( 'Function add_submenu_pages().' );

        if ( is_array( $subpages ) && is_array( $page ) ) {

            foreach ( $subpages as $title ) {

                $title_lc = strtolower( $title );
                $title_uscore = str_replace( ' ', '_', $title_lc );
                $title_hyphen = str_replace( ' ', '-', $title_lc );

                add_submenu_page(
                    $page['slug'],                          // Parent Slug
                    $page['menu_title'] . ' ' . $title,     // Page Title
                    $title,                                 // Menu Title
                    $page['capability'],                    // Capability
                    $page['slug'] . '-' . $title_hyphen,    // Menu Slug
                    array( $this, 'page_' . $title_uscore ) // Callable Function
                );

                $this->log( 'Created submenu page ' . $title . '.' );

            } // endforeach

            // Memory Cleanup
            unset( $title, $title_lc, $title_uscore, $title_hyphen );

        } else {

            $this->log( 'ERROR: Variable $subpages is not an array.', __FILE__, __LINE__ );

        } // endif

        $this->log( 'Finished function add_submenu_pages().' );

        // Memory Cleanup
        unset( $subpages, $pages );

    } // add_submenu_pages()


    /**
     * Gets the admin page
     * @param  string $title The title of the submenu
     * @since  0.2.0
     */
    private function get_page( $page_slug = false ) {

        if ( $page_slug ) {

            $this->log( 'Getting ' . $page_slug . ' Page' );

            // Format Title
            $title_camel = str_replace( ' ', '', $page_slug );

            // Class For The Page
            $class = __NAMESPACE__ . '\AdminPage' . $title_camel;

            $page_slug = strtolower( $page_slug );

            // Get Page Specific Settings
            $page_settings = $this->settings[ $page_slug ];

            if ( is_array( $page_settings ) ) {

                $this->page = new $class( $page_settings );
                $this->display_page();

            } // is_array()

            $this->log( $page_slug . ' Page Finished' );

            // Memory Cleanup
            unset( $title_camel, $class, $page_settings );

        } else {

            $this->log( 'ERROR: Parameter title is empty.', __FILE__, __LINE__ );

        }

        // Memory Cleanup
        unset( $page_slug );

    } // get_page()


    /**
     * Wrapper for creating Dashboard page
     * @since  0.1.0
     */
    public function page_dashboard() {

        $this->get_page( 'General' );

    } // page_dashboard()


    /**
     * Wrapper for creating Privacy page
     * @since  0.2.0
     */
    public function page_privacy() {

        $this->get_page( 'Privacy' );

    } // page_privacy()


    /**
     * Wrapper for creating Files page
     * @since  0.2.0
     */
    public function page_files() {

        $this->get_page( 'Files' );

    } // page_files()


    /**
     * Wrapper for creating Content page
     * @since  0.2.0
     */
    public function page_content() {

        $this->get_page( 'Content' );

    } // page_content()


    /**
     * Wrapper for creating User Access page
     * @since  0.2.0
     */
    public function page_user_access() {

        $this->get_page( 'Access' );

    } // page_user_access()


    /**
     * Wrapper for creating Firewall page
     * @since  0.2.0
     */
    public function page_firewall() {

        $this->get_page( 'Firewall' );

    } // page_firewall()


    /**
     * Wrapper for creating Backups page
     * @since  0.2.0
     */
    public function page_backups() {

        $this->get_page( 'Backups' );

    } // page_backups()


    /**
     * Page template
     * @return string
     * @since  0.2.0
     */
    protected function display_page() {

        $plugin = $this->plugin;
        $page = $this->page;

        ?>
        <div class="wrap">

            <div class="intro">
                            
                <h1><?php printf( __( '%s', 'security-safe' ), $page->title ); ?></h1>
                
                <p class="desc"><?php printf( __( '%s', 'security-safe' ), $page->description ); ?></p>
            
                <a href="<?php echo $plugin['url_more_info']; ?>" target="_blank" class="ss-logo"><img src="<?php echo $plugin['url']; ?>/img/logo.svg" alt="<?php echo $plugin['name']; ?>"><br />
                <span class="version">Version <?php echo $plugin['version']; ?></span></a>

            </div><!-- .intro -->

            <?php $this->display_heading_menu(); ?>
            
            <?php $page->display_tabs(); ?>

            <form method="post" action="">

                <?php wp_nonce_field( 'security-safe-settings' ); ?>
    
                <div class="all-tab-content">

                    <?php $page->display_tabs_content(); ?>

                    <div id="tab-content-footer" class="footer tab-content"></div>

                    <div id="sidebar" class="sidebar"></div>

                </div><!-- .all-tab-content -->

            </form>

            <div class="wrap-footer full clear">

                <hr />
                <p><?php echo $plugin['name'] . ' v.' . $plugin['version']; ?>: Need help? Visit the <a href="https://wordpress.org/support/plugin/security-safe" target="_blank">support forum</a>.</p>
            
            </div>
        </div><!-- .wrap -->
        <?php

        // Memory Cleanup
        unset( $page, $plugin );

    } // display_page()


    /**
     * Display Heading Menu
     * @since  0.2.0
     */
    protected function display_heading_menu() {

        $menus = $this->get_category_pages( true );

        $html = '<ul class="featured-menu">';

        foreach ( $menus as $m ) {

            // Add Class For Disabled Menus
            $disabled = '';

            if ( is_array( $m ) ) {

                $disabled = ' disabled';
                $m = $m[0];

            } // is_array()

            $class = strtolower( str_replace( ' ', '-', $m ) );
            $href = ( $disabled ) ? '' : 'href="admin.php?page=' . $this->plugin['slug'] . '-' . $class . '"';
            
            // Highlight Active Menu
            $active = ( strpos( $_GET['page'], $class ) !== false ) ? ' active' : '';
            $class .= $active . $disabled;

            $html .= '<li><a ' . $href . 'class="icon-' . $class . '"><span>' . $m . '</span></a></li>';

        } // foreach

        $html .= '</ul>';

        echo $html;

        // Memory Cleanup
        unset( $html, $menus, $m, $disabled, $class, $href, $active );

    } // display_heading_menu()

    /**
     * Displays all messages
     * @since  0.2.0
     */
    public function display_messages() {

        $this->log( 'display_messages()' );

        if ( is_array( $this->messages ) ) {
            
            foreach ( $this->messages as $m ) {

                $message = ( isset( $m[0] ) ) ? $m[0] : false;
                $status = ( isset( $m[1] ) ) ? $m[1] : 0;
                $dismiss = ( isset( $m[2] ) ) ? $m[2] : 0;
                
                if ( $message ) {

                    // Display Message
                    $this->admin_notice( $message, $status, $dismiss );

                } // $message
                
            } // foreach ()

            // Memory Cleanup
            unset( $m, $message, $status, $dismiss );

        } // is_array()

    } // display_messages()


    /**
     * Displays a message at the top of the screen.
     * @return  $html html code
     * @since  0.1.0
     */
    protected function admin_notice( $message, $status = 0, $dismiss = 0 ) {

        $this->log( 'admin_notice()' );
        
        // Set Classes
        $class = 'notice-success';
        $class = ( $status == 1 ) ? 'notice-info' : $class;
        $class = ( $status == 2 ) ? 'notice-warning' : $class;
        $class = ( $status == 3 ) ? 'notice-error' : $class;
        $class = 'active notice ' . $class;

        if ( $dismiss ) { 

            $class .= ' is-dismissible'; 

        }
        
        // Add Message
        $message = __( $message, 'security-safe' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );

        // Memory Cleanup
        unset( $message, $status, $dismiss, $class );

    } //admin_notice()


} // Admin()
