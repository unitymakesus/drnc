<?php

namespace SecuritySafe;

// Prevent Direct Access
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * @package SecuritySafe
 * @version 1.1.3
 */

/*
 * Plugin Name: Security Safe
 * Plugin URI: https://sovstack.com/security-safe
 * Description: Security Safe - Security, Hardening, Auditing & Privacy
 * Author: Sovereign Stack, LLC
 * Author URI: https://sovstack.com
 * Version: 1.1.3
 * Text Domain: security-safe
 * Domain Path:  /languages
 * License: GPLv3 or later
 */

/*
Copyright (C) 2018  Sovereign Stack, LLC (email : support@sovstack.com)
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$plugin = array(
    'name'          => 'Security Safe',
    'version'       => '1.1.3',
    'slug'          => 'security-safe',
    'options'       => 'securitysafe_options',
    'file'          => __FILE__,
    'dir'           => __DIR__,
    'dir_admin'     => __DIR__ . '/admin',
    'dir_common'    => __DIR__ . '/common',
    'dir_lang'      => __DIR__ . '/languages',
    'url'           => plugin_dir_url( __FILE__ ),
    'url_author'    => 'https://sovstack.com/',
    'url_more_info' => 'https://sovstack.com/security-safe/',
    );

// Autoload
require_once( __DIR__ . '/vendor/autoload.php' );

// Initialize Plugin
$init = __NAMESPACE__ . '\\';
$init .= ( is_admin() ) ? 'Admin' : 'Security';
$SecuritySafe = new $init( $plugin );

// Memory Cleanup
unset( $init, $plugin );

// Cleanup Plugin Memory
if ( isset( $SecuritySafe ) ) {

    add_action( 'shutdown', __NAMESPACE__ . '\\Plugin::shutdown' );

} // isset()
