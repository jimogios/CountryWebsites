<?php

/*-----------------------------------------------------------------------------------*/
/*	Create a new post type called tour
/*-----------------------------------------------------------------------------------*/


function tk_create_post_type_tour() 
{
	$labels = array(
		'name' => __( 'Tour'),
		'singular_name' => __( 'Tour' ),
		'rewrite' => array('slug' => __( 'Tour' )),
		'add_new' => _x('Add New', 'Tour'),
		'add_new_item' => __('Add New Tour'),
		'edit_item' => __('Edit Tour'),
		'new_item' => __('New Tour'),
		'view_item' => __('View Tour'),
		'search_items' => __('Search Tour'),
		'not_found' =>  __('No Tour found'),
		'not_found_in_trash' => __('No Tour found in Trash'), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'tour' ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','page-attributes','excerpt')
	  ); 
	  
	  register_post_type(__( 'tour' ),$args);
}


//http://wp.tutsplus.com/tutorials/custom-post-type-pagination-chaining-method/
function tour_posts_per_page( $query ) {  
    if ( $query->query_vars['post_type'] == 'tour' ) 
    	$query->query_vars['posts_per_page'] = of_get_option('galleries_posts_per_page');  //of_get_option('galleries_posts_per_page') - admin-options;;  
    return $query;  
}  
if ( !is_admin() ) add_filter( 'pre_get_posts', 'tour_posts_per_page' );  




/*-----------------------------------------------------------------------------------*/
/*	All the pre-made messages for the slide post type
/*-----------------------------------------------------------------------------------*/

function tk_tour_updated_messages( $messages ) {

  $messages[__( 'tour' )] = 
  	array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Tour updated. <a href="%s">View Tour</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Tour updated.'),
		/* translators: %s: date and time of the retour */
		5 => isset($_GET['retour']) ? sprintf( __('Tour restored to retour from %s'), wp_post_retour_title( (int) $_GET['retour'], false ) ) : false,
		6 => sprintf( __('Tour published. <a href="%s">View Tour</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Tour saved.'),
		8 => sprintf( __('Tour submitted. <a target="_blank" href="%s">Preview Tour</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Tour scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Tour</a>'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Tour draft updated. <a target="_blank" href="%s">Preview Tour</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  
  return $messages;
  
}  

function tk_build_tour_taxonomies(){
	register_taxonomy(__( "tour-category" ), array(__( "tour" )), array("hierarchical" => true, "label" => __( "Tour Category" ), "singular_label" => __( "Category" ), "rewrite" => array('slug' => 'tour-category', 'hierarchical' => false)));
} 


add_action('restrict_manage_posts','tk_tour_restrict_manage_posts');
function tk_tour_restrict_manage_posts() {
	global $typenow,$wp_query;
	if ($typenow=='tour'){
                 $args = array(
                     'show_option_all' => "Show All Categories",
                     'taxonomy'        => 'tour-category',
                     'selected' => ( isset( $wp_query->query['tour-category'] ) ? $wp_query->query['tour-category'] : '' ),
                     'name'               => 'tour-category');
				wp_dropdown_categories($args);
	}
}

add_filter( 'parse_query','tk_tour_request' );
function tk_tour_request( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['tour-category'] ) && is_numeric( $qv['tour-category'] ) ) {
        $term = get_term_by( 'id', $qv['tour-category'], 'tour-category' );
        $qv['tour-category'] = $term->slug;
    }
}

add_filter( 'manage_edit-tour_columns', 'tour_columns' );
function tour_columns( $columns ) {
    $columns['menu_order'] = 'Order';
    return $columns;
}

add_action( 'manage_posts_custom_column', 'populate_tour_columns' );
function populate_tour_columns( $column ) {
    if ( 'menu_order' == $column ) {
    	$temp_post = get_post(get_the_ID());
        echo $temp_post->menu_order;
    }
}

add_filter( 'manage_edit-tour_sortable_columns', 'sort_tour' );
function sort_tour( $columns ) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}



add_action( 'init', 'tk_create_post_type_tour' );
add_action( 'init', 'tk_build_tour_taxonomies' );
add_filter('post_updated_messages', 'tk_tour_updated_messages');
//add_filter('post_type_link', 'qtrans_convertURL');



?>