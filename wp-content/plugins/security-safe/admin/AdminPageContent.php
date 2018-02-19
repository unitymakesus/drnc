<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class AdminPageContent
 * @package SecuritySafe
 * @since  0.2.0
 */
class AdminPageContent extends AdminPage {


    /**
     * This sets the variables for the page.
     * @since  0.1.0
     */  
    protected function set_page() {

        $this->slug = 'security-safe-content';
        $this->title = 'Content Page';
        $this->description = 'Content page description.';

    } // set_page()


} // AdminPageContent()
