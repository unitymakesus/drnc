<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js', false, '3.2.1');
  wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
  wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);
}, 100);

/**
 * Remove duplicate canonical tags
 */
add_action('init', function() {
  // Remove Soil canonical link tag
  remove_action('wp_head', 'Roots\\Soil\\CleanUp\\rel_canonical');
}, 20);

add_filter( 'the_seo_framework_rel_canonical_output', function($canonical) {
  // Remove canonical link from SEO Framework plugin, so it only gets added by the calendar plugin
  return '';
});

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    // add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'social_links' => __('Social Links', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Enable logo uploader in customizer
     */
     add_image_size('drnc-logo', 481, 133, false);
     add_image_size('drnc-logo-2x', 962, 266, false);
     add_theme_support('custom-logo', array(
       'size' => 'drnc-logo-2x'
     ));

     /**
      * Add image sizes
      */
     add_image_size('tiny-thumbnail', 80, 80, true);
     add_image_size('small-thumbnail', 150, 150, true);

     add_filter( 'image_size_names_choose', function( $sizes ) {
       return array_merge( $sizes, array(
         'tiny-thumbnail' => __( 'Tiny Thumbnail' ),
         'small-thumbnail' => __( 'Small Thumbnail' ),
       ) );
     } );

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });

    /**
     * Configure SVG location for @svg() Blade directive
     */
    add_filter('bladesvg_image_path', function () {
      return \BladeSvgSage\get_dist_path('images');
    });
});

/**
 * If my-calendar plugin is enabled, re-register the CPT so we can include in search results
 */

add_action('after_setup_theme', function() {
  remove_action('init', 'mc_posttypes');
  add_action('init', __NAMESPACE__ . '\\drnc_mc_posttypes');
});
function drnc_mc_posttypes() {
 	$arguments = array(
 		'public'              => apply_filters( 'mc_event_posts_public', true ),
 		'publicly_queryable'  => true,
 		'exclude_from_search' => false,
 		'show_ui'             => true,
 		'show_in_menu'        => apply_filters( 'mc_show_custom_posts_in_menu', false ),
 		'menu_icon'           => null,
 		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' )
 	);

 	$types   = array(
 		'mc-events' => array(
 			__( 'event', 'my-calendar' ),
 			__( 'events', 'my-calendar' ),
 			__( 'Event', 'my-calendar' ),
 			__( 'Events', 'my-calendar' ),
 			$arguments
 		),
 	);
 	$enabled = array( 'mc-events' );
 	$slug = ( get_option( 'mc_cpt_base' ) != '' ) ? get_option( 'mc_cpt_base' ) : 'mc-events';
 	if ( is_array( $enabled ) ) {
 		foreach ( $enabled as $key ) {
 			$value  =& $types[ $key ];
 			$labels = array(
 				'name'               => _x( $value[3], 'post type general name' ),
 				'singular_name'      => _x( $value[2], 'post type singular name' ),
 				'add_new'            => _x( 'Add New', $key, 'my-calendar' ),
 				'add_new_item'       => sprintf( __( 'Create New %s', 'my-calendar' ), $value[2] ),
 				'edit_item'          => sprintf( __( 'Modify %s', 'my-calendar' ), $value[2] ),
 				'new_item'           => sprintf( __( 'New %s', 'my-calendar' ), $value[2] ),
 				'view_item'          => sprintf( __( 'View %s', 'my-calendar' ), $value[2] ),
 				'search_items'       => sprintf( __( 'Search %s', 'my-calendar' ), $value[3] ),
 				'not_found'          => sprintf( __( 'No %s found', 'my-calendar' ), $value[1] ),
 				'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'my-calendar' ), $value[1] ),
 				'parent_item_colon'  => ''
 			);
 			$raw    = $value[4];
 			$args   = array(
 				'labels'              => $labels,
 				'public'              => $raw['public'],
 				'publicly_queryable'  => $raw['publicly_queryable'],
 				'exclude_from_search' => $raw['exclude_from_search'],
 				'show_ui'             => $raw['show_ui'],
 				'show_in_menu'        => $raw['show_in_menu'],
 				'menu_icon'           => ( $raw['menu_icon'] == null ) ? plugins_url( 'images', __FILE__ ) . "/icon.png" : $raw['menu_icon'],
 				'query_var'           => true,
 				'rewrite'             => array(
 					'with_front' => false,
 					'slug'       => apply_filters( 'mc_event_slug', $slug )
 				),
 				'hierarchical'        => false,
 				'menu_position'       => 9,
 				'supports'            => $raw['supports']
 			);
 			register_post_type( $key, $args );
 		}
 	}
 }
