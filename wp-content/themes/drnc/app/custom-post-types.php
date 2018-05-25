<?php

namespace App;

add_action( 'init', function() {

  register_post_type( 'drnc-resource', array(
    'labels' => array(
				'name' => 'Resources',
				'singular_name' => 'Resource',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Resource',
				'edit' => 'Edit',
				'edit_item' => 'Edit Resource',
				'new_item' => 'New Resource',
				'view_item' => 'View Resource',
				'search_items' => 'Search Resources',
				'not_found' =>  'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash',
				'parent_item_colon' => ''
    ),
    'public' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_nav_menus' => false,
    'menu_position' => 23,
    'menu_icon' => 'dashicons-media-document',
    'capability_type' => 'page',
    'hierarchical' => false,
    'supports' => array(
      'title',
      'author',
      'revisions',
      'page-attributes',
    ),
    'has_archive' => false,
    'rewrite' => array(
      'slug' => 'resource'
    )
  ));

	register_taxonomy('resource-topic',  array('post', 'drnc-resource'), array(
		'labels' => array(
			'name' => __( 'Topics' ),
			'singular_name' => __( 'Topic' )
		),
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'hierarchical' => true,
		'rewrite' => true
	));

  	register_taxonomy('resource-type', 'drnc-resource', array(
  		'labels' => array(
  			'name' => __( 'Types' ),
  			'singular_name' => __( 'Type' )
  		),
  		'publicly_queryable' => true,
  		'show_ui' => true,
  		'show_in_nav_menus' => false,
  		'hierarchical' => true,
  		'rewrite' => true
  	));

	register_taxonomy('resource-source', 'drnc-resource', array(
		'labels' => array(
			'name' => __( 'Sources' ),
			'singular_name' => __( 'Source' )
		),
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'hierarchical' => true,
		'rewrite' => true
	));

});

// Redirect all resources single templates to their actual resource
add_action( 'template_redirect', function() {
  if ( is_singular('drnc-resource') ) {
    $id = get_the_id();
    $link = (get_field('uploaded_file', $id) == 1) ? wp_get_attachment_url(get_field('file', $id)) : get_field('link', $id);

    wp_redirect( $link, 301 );
    exit;
  }
});
