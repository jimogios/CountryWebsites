<?php

/*-----------------------------------------------------------------------------------*/
/*	Create a new post type called Partner
/*-----------------------------------------------------------------------------------*/


function tk_create_post_type_Partner() 
{
	$labels = array(
		'name' => __( 'Partner'),
		'singular_name' => __( 'Partner' ),
		'rewrite' => array('slug' => __( 'Partner' )),
		'add_new' => _x('Add New', 'Partner'),
		'add_new_item' => __('Add New Partner'),
		'edit_item' => __('Edit Partner'),
		'new_item' => __('New Partner'),
		'view_item' => __('View Partner'),
		'search_items' => __('Search Partner'),
		'not_found' =>  __('No Partner found'),
		'not_found_in_trash' => __('No Partner found in Trash'), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'Partner' ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','page-attributes','excerpt')
	  ); 
	  
	  register_post_type(__( 'Partner' ),$args);
}


//http://wp.tutsplus.com/tutorials/custom-post-type-pagination-chaining-method/
function Partner_posts_per_page( $query ) {  
    if ( $query->query_vars['post_type'] == 'Partner' ) 
    	$query->query_vars['posts_per_page'] = of_get_option('galleries_posts_per_page');  //of_get_option('galleries_posts_per_page') - admin-options;;  
    return $query;  
}  
if ( !is_admin() ) add_filter( 'pre_get_posts', 'Partner_posts_per_page' );  




/*-----------------------------------------------------------------------------------*/
/*	All the pre-made messages for the slide post type
/*-----------------------------------------------------------------------------------*/

function tk_Partner_updated_messages( $messages ) {

  $messages[__( 'Partner' )] = 
  	array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Partner updated. <a href="%s">View Partner</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Partner updated.'),
		/* translators: %s: date and time of the rePartner */
		5 => isset($_GET['rePartner']) ? sprintf( __('Partner restored to rePartner from %s'), wp_post_rePartner_title( (int) $_GET['rePartner'], false ) ) : false,
		6 => sprintf( __('Partner published. <a href="%s">View Partner</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Partner saved.'),
		8 => sprintf( __('Partner submitted. <a target="_blank" href="%s">Preview Partner</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Partner scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Partner</a>'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Partner draft updated. <a target="_blank" href="%s">Preview Partner</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  
  return $messages;
  
}  

function tk_build_Partner_taxonomies(){
	register_taxonomy(__( "Partner-category" ), array(__( "Partner" )), array("hierarchical" => true, "label" => __( "Partner Category" ), "singular_label" => __( "Category" ), "rewrite" => array('slug' => 'Partner-category', 'hierarchical' => false)));
	register_taxonomy(__( "Partner-tag" ), array(__( "Partner" )), array("hierarchical" => false, "label" => __( "Partner Tag" ), "singular_label" => __( "Tag" ), "rewrite" => array('slug' => 'Partner-tag', 'hierarchical' => false)));
} 


add_action('restrict_manage_posts','tk_Partner_restrict_manage_posts');
function tk_Partner_restrict_manage_posts() {
	global $typenow,$wp_query;
	if ($typenow=='Partner'){
                 $args = array(
                     'show_option_all' => "Show All Categories",
                     'taxonomy'        => 'Partner-category',
                     'selected' => ( isset( $wp_query->query['Partner-category'] ) ? $wp_query->query['Partner-category'] : '' ),
                     'name'               => 'Partner-category');
				wp_dropdown_categories($args);
	}
}

add_filter( 'parse_query','tk_Partner_request' );
function tk_Partner_request( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['Partner-category'] ) && is_numeric( $qv['Partner-category'] ) ) {
        $term = get_term_by( 'id', $qv['Partner-category'], 'Partner-category' );
        $qv['Partner-category'] = $term->slug;
    }
}

add_filter( 'manage_edit-Partner_columns', 'Partner_columns' );
function Partner_columns( $columns ) {
    $columns['menu_order'] = 'Order';
    return $columns;
}

add_action( 'manage_posts_custom_column', 'populate_Partner_columns' );
function populate_Partner_columns( $column ) {
    if ( 'menu_order' == $column ) {
    	$temp_post = get_post(get_the_ID());
        echo $temp_post->menu_order;
    }
}

add_filter( 'manage_edit-Partner_sortable_columns', 'sort_Partner' );
function sort_Partner( $columns ) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}



add_action( 'init', 'tk_create_post_type_Partner' );
add_action( 'init', 'tk_build_Partner_taxonomies' );
add_filter('post_updated_messages', 'tk_Partner_updated_messages');
//add_filter('post_type_link', 'qtrans_convertURL');



?>