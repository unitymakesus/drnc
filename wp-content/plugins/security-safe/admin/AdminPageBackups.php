<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Class AdminPageBackups
 * @package SecuritySafe
 * @since  0.2.0
 */
class AdminPageBackups extends AdminPage {


    /**
     * This sets the variables for the page.
     * @since  0.1.0
     */  
    protected function set_page() {

        $this->slug = 'security-safe-backups';
        $this->title = 'Backups Page';
        $this->description = 'Backups page description.';

    } // set_page()


} // AdminPageBackups()
