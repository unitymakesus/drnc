<?php

namespace App;

/**
 * Detect custom WP_Query for filtering
 */
add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
  if ( '' !== $query->get( 'facetwp' ) ) {
    $is_main_query = (bool) $query->get( 'facetwp' );
  }
  return $is_main_query;
}, 10, 2 );

/**
 * Create facets from ACF Relationship Fields
 */
add_filter( 'facetwp_index_row', function( $params, $class ) {
    if ( 'resource_issue' == $params['facet_name'] || 'resource_initiative' == $params['facet_name'] ) {
        $values = (array) $params['facet_value']; // an array of post IDs (it's already unserialized)
        foreach ( $values as $val ) {
            $params['facet_value'] = $val;
            $params['facet_display_value'] = get_the_title( $val );
            $class->insert( $params ); // insert each value to the database
        }
        // skip the default indexing query
        return false;
    }
    error_log(print_r($params, true));
    return $params;
}, 10, 2 );

/**
 * Order year facets in descending order
 */
add_filter( 'facetwp_facet_orderby', function( $orderby, $facet ) {
    if ( 'resource_year' == $facet['name'] ) {
        $orderby = 'f.facet_display_value+0 DESC';
    }
    return $orderby;
}, 10, 2 );

/**
 * Add label before per-page selector
 */
add_filter( 'facetwp_per_page_html', function( $output ) {
  $find = [
    '<select class="facetwp-per-page-select">',
    '<option value="">Per page</option>'
  ];
  $replace = [
    '<select class="facetwp-per-page-select" id="facetwp-per-page-select">',
    ''
  ];
  $output = str_replace($find, $replace, $output);
  return '<label for="facetwp-per-page-select">Results per page</label> ' . $output;
}, 10, 1 );

/**
 * Add label before sort selector
 */
add_filter( 'facetwp_sort_html', function( $output ) {
  $find = [
    '<select class="facetwp-sort-select">',
    '<option value="default">Sort by</option>'
  ];
  $replace = [
    '<select class="facetwp-sort-select" id="facetwp-sort-select">',
    '<option value="default">Default</option>'
  ];
  $output = str_replace($find, $replace, $output);
  return '<label for="facetwp-sort-select">Sort by</label> ' . $output;
}, 10, 1 );

/**
 * Change output of results count
 */
add_filter( 'facetwp_result_count', function( $output, $params ) {
    $output = 'Displaying Results ' . $params['lower'] . '-' . $params['upper'] . ' of ' . $params['total'];
    return $output;
}, 10, 2 );

/**
 * Make pagination accessible
 */
add_filter( 'facetwp_pager_html', function( $output, $params ) {
  $output = '';

  if ( 1 < $params['total_pages'] ) {
    $output = '<ul>';
    for ( $i = 1; $i <= $params['total_pages']; $i++ ) {
      $output .= '<li>';
      if ( $i === $params['page'] ) {
        $output .= '<a class="facetwp-page active" data-page="' . $i . '" aria-current="true" aria-label="Current Page, Page ' . $i . '">' . $i . '</a>';
      } else {
        $output .= '<a class="facetwp-page" data-page="' . $i . '" aria-label="Go To Page ' . $i . '">' . $i . '</a>';
      }
      $output .= '</li>';
    }
    $output .= '</ul>';
  }

  return $output;
}, 10, 2 );
