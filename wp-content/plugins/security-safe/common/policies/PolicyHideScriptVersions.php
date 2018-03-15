<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }


/**
 * Class PolicyHideScriptVersions
 * @package SecuritySafe
 * @since 1.1.3
 */
class PolicyHideScriptVersions {


    /**
     * PolicyHideWPVersion constructor.
     */
	function __construct(){

        // Remove Version From Scripts
        add_filter( 'style_loader_src', array( $this, 'css_js_version' ), 99999 );
        add_filter( 'script_loader_src', array( $this, 'css_js_version' ), 99999 );

	} // __construct()


    /** 
     * Remove All Versions From Enqueued Scripts
     * @param  string $src Original source of files with versions
     * @return string      Modified version
     * @since  1.1.3
     */
    function css_js_version( $src ) {

        if ( strpos( $src, 'ver=' ) ) {
            $src = preg_replace("/ver=(.*)/", 'ver=' . date('Ymd') , $src );
        }

        return $src;

    } // css_js_version()


} // PolicyHideScriptVersions()
