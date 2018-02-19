<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class AdminPage
 * @package SecuritySafe
 */
class AdminPage {

    public $title = 'Page Title';
    public $description = 'Description of page.';
    protected $settings = array();
    public $slug = '';
    public $tabs = array();

    /**
     * AdminPage constructor.
     * @param $settings
     */
    function __construct( $settings ) {

        $this->settings = $settings;

        // Set page variables
        $this->set_page();

    } // __construct()


    /**
     * Placeholder intended to be used by pages to override variables.
     * @since  0.1.0
     */ 
    protected function set_page() {

        // This is overwritten by specific page.
    
    } // set_page()


    /** 
     * Displays all the tabs set by the specific page
     * @since  0.2.0
     * @return html
     */
    public function display_tabs() {

        if ( ! empty( $this->tabs ) ){

            $html = '<h2 class="nav-tab-wrapper">';
            $num = 1;

            foreach ( $this->tabs as $t ){

                if ( is_array( $t ) ) {

                    $classes = 'nav-tab';
                    
                    // Add Active Class To Active Tab : Default First Tab
                    if( ( isset( $_GET['tab'] ) && $_GET['tab'] == $t['id'] ) || ( ! isset( $_GET['tab'] ) && $num == 1 ) ) {
                        
                        $classes .= ' nav-tab-active';

                    }

                    $html .= '<a href="?page=' . $this->slug . '&tab=' . $t['id'] . '" class="' . $classes . '">' . $t['label'] . '</a>';
                
                    $num++;

                } // is_array()

            } // foreach()

            $html .= '</h2>';

            echo $html;

            // Memory Cleanup
            unset( $num, $t, $classes, $html );

        } // $this->tabs

    } // display_tabs()


    /**
     * Display All Tabbed Content
     * @since  0.2.0
     * @return  html
     */  
    public function display_tabs_content() {

        if ( ! empty( $this->tabs ) ) {

            $num = 1;

            $html = '';

            foreach ( $this->tabs as $t ) {

                if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == $t['id'] ) || ( ! isset( $_GET['tab'] ) && $num == 1 ) ) {

                    $classes = 'tab-content';

                    // Add Active Class To Active Tab : Default First Tab Content
                    if ( ( isset( $_GET['tab'] ) && $_GET['tab'] == $t['id'] ) || ( ! isset( $_GET['tab'] ) && $num == 1 ) ) {
                        $classes .= ' active';
                    }

                    // Adds Custom Classes
                    if ( isset( $t['classes'] ) ) {

                        if ( is_array( $t['classes'] ) ) {

                            foreach ( $t['classes'] as $class ) {

                                $classes .= ' ' . $class;

                            } // foreach()

                        } else {

                            $classes .= ' ' . $t['classes'];

                        } // is_array()

                    } // isset()

                    $html .= '<div id="' . $t['id'] . '" class="' . $classes . '">';
                    
                    // Display Title
                    if ( isset( $t['title'] ) && $t['title'] ) {
                        $html .= '<h2>' . $t['title'] . '</h2>';
                    }

                    // Display Heading Text
                    if ( isset( $t['heading'] ) && $t['heading'] ) {
                        $html .= '<p class="new-desc desc">' . $t['heading'] . '</p>';
                    }

                    // Display Intro Text
                    if ( isset( $t['intro'] ) && $t['intro'] ) {
                        $html .= '<p>' . $t['intro'] . '</p>';
                    }

                    // Run Callback Method To Display Content
                    if ( isset( $t['content_callback'] ) && $t['content_callback'] ) {
                        $content = $t['content_callback'];
                        $html .= $this->$content();
                        
                        // Memory Cleanup
                        unset( $content );
                    }

                    $html .= '</div><!-- #' . $t['id'] . ' -->';

                    $num++;

                } // $_GET['tab']
                
            } // foreach

            echo $html;

            // Memory Cleanup
            unset( $num, $t, $classes, $html );

        } // $this->tabs

    } // display_tabs_content()


    /**
     * Creates the opening and closing tags for the form-table
     * @since  0.2.0
     */
    protected function form_table( $rows ) {

        return '<table class="form-table">' . $rows . '</table>';

    } // form_table()

    /**
     * Creates a new section for a form-table
     * @since  0.2.0
     */
    
    protected function form_section( $title, $desc ) {

        $html = '<h3>' . $title . '</h3>';
        $html .= '<p>' . $desc . '</p>';

        // Memory Cleanup
        unset( $title, $desc );

        return $html;

    } // form_section()

    /** 
     * Displays form checkbox for a settings page.
     * @since  0.1.0
     * @param array $page_options An array of setting values specific to the particular page. This is not the full array of settings.
     * @param string $name The name of the checkbox which corresponds with the setting name in the database.
     * @param string $slug The value for the settings in the database.
     * @param string $short_desc The text that is displayed to the right on the checkbox.
     * @param string $long_desc The description text displayed below the title.
     */
    protected function form_checkbox( $page_options, $name, $slug, $short_desc, $long_desc ) {

        $html = '<tr class="checkbox">';

        if ( is_array( $page_options ) && $slug && $short_desc ) {
            
            $html .= $this->row_label( $name );
            $html .= '<td>';

            $checked = ( isset( $page_options[ $slug ] ) && $page_options[ $slug ] == '1' ) ? ' CHECKED' : '';
        
            $html .= '<label><input name="' . $slug . '" type="checkbox" value="1"' . $checked . '/>' . $short_desc . '</label>';
            
            if ( $long_desc ) {

                $html .= '<p class="desc">' . $long_desc . '</p>';

            } // $long_desc

            // Testing Only
            //$html .= 'Value: ' . $page_options[ $slug ];
            
            $html .= '</td>';

            // Memory Cleanup
            unset( $checked );
        
        } else {
            
            $html .= '<td colspan="2"><p>Error: There are parameters missing to properly display checkbox.</p></td>';
            
        } //is_array()

        $html .= '</tr>';

        // Memory Cleanup
        unset( $page_options, $name, $slug, $short_desc, $long_desc );

        return $html;

    } //form_checkbox()


    protected function form_text() {

        // Placeholder for now
        
    } // form_text();


    protected function form_select( $page_options, $name, $slug, $options, $long_desc ) {

        $html = '<tr class="select">';

        if ( is_array( $page_options ) && $slug && $options ) {
            
            $html .= $this->row_label( $name );
            
            $html .= '<td><select name="' . $slug . '">';
            
            if ( is_array( $options ) ) {

                foreach ( $options as $value => $label ) {

                    $selected = ( isset( $page_options[ $slug ] ) && $page_options[ $slug ] == $value ) ? ' SELECTED' : '';
        
                    $html .= '<option value="' . $value . '"' . $selected . '>' . $label . '</option>';

                } // foreach()

                // Memory Cleanup
                unset( $value, $label, $selected );

            } else {

                $html .= '<option>Not An Array!</option>';

            } // is_array( $options )

            $html .= '</select>';

            if ( $long_desc ) {

                $html .= '<p class="desc">' . $long_desc . '</p>';

            } // $long_desc

            $html .= '</td>';

        } else {

            $html .= 'There is an issue.';

        } // is_array( $options ) && $slug ...

        $html .= '</tr>';

        // Memory Cleanup
        unset( $page_options, $name, $slug, $options, $long_desc );

        return $html;

    } // form_select();


    protected function row_label( $name ) {

        $html = '<th scope="row">';

        if ( $name ) {
            $html .= '<label>' . $name . '</label>';
        }

        $html .= '</th>';

        // Memory Cleanup
        unset( $name );

        return $html;

    } //row_label()

    /**
     * Creates Table Row For A Button
     * @since  0.3.0
     */ 
    protected function form_button( $text, $type, $value, $long_desc = false ) {

        $html = '<tr class="select">';
            
        $html .= $this->row_label( $text );
            
        $html .= '<td>';
        $html .= $this->button( $text, $type, $value );

        if ( $long_desc ) {

            $html .= '<p class="desc">' . $long_desc . '</p>';

        } // $long_desc

        $html .= '</td>';
        $html .= '</tr>';

        // Memory Cleanup
        unset( $text, $type, $value, $long_desc ); 
        
        return $html;

    } // form_button();


    /**
     * Return HTML for Submit Button
     * @since  0.3.0
     */ 
    protected function button( $text = 'Save Changes', $type = 'submit', $value = false ) {

        // Default Values
        $text = __( $text, 'security-safe' );
        $value = ( $value ) ? __( $value, 'security-safe' ) : $text;

        $html = '<p class="' . $type . '">';
        $classes = 'button ';

        if ( $type == 'submit' ) {

            $classes .= 'button-primary';
            $html .= '<input type="' . $type . '" name="' . $type . '" id="' . $type . '" class="' . $classes . '" value="' . $value . '" />';
        
        } elseif ( $type == 'link' ) {

            $classes .= 'button-secondary';
            $html .= '<a href="' . $value . '" class="' . $classes . '">' . $text . '</a>';

        } elseif ( $type == 'link-delete' ) {

            $classes .= 'button-secondary button-link-delete';
            $html .= '<a href="' . $value . '" class="' . $classes . '">' . $text . '</a>';

        } // $type

        $html .= '</p>';

        // Memory Cleanup
        unset( $text, $type, $value, $classes );

        return $html;
    
    } // button()


} // Admin()