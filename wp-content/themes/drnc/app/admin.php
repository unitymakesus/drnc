<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

/**
 * Cleanup WP Admin bar for Board Members
 */
add_action( 'wp_before_admin_bar_render', function() {
  global $wp_admin_bar;
  if (!current_user_can('manage_options')) {  // If user can't manage options (ie is an Administrator) remove menu items
    $wp_admin_bar->remove_menu('mc-my-calendar');
    $wp_admin_bar->remove_menu('search');
    $wp_admin_bar->remove_menu('wp-logo');
  }
});
