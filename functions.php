<?php
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}
	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
	/*
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
	*/
	
	/*-----------------------------------------------------------------------------------*/
	/*	Queue Scripts
	/*-----------------------------------------------------------------------------------*/
	 
	 /*
	function tk_admin_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('tk-upload', get_template_directory_uri() . '/functions/js/upload-button.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('tk-upload');
	}
	function tk_admin_styles() {
		wp_enqueue_style('thickbox');
	}
	add_action('admin_print_scripts', 'tk_admin_scripts');
	add_action('admin_print_styles', 'tk_admin_styles');
	*/
	
	
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		//add_image_size( 'custom-thumbnail', 800 );
	}
		
	function paginate() {  
	    global $wp_query, $wp_rewrite;  
	    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;  
	    $pagination = array(  
	        'base' => @add_query_arg('page','%#%'),  
	        'format' => '',  
	        'total' => $wp_query->max_num_pages,  
	        'current' => $current,  
	        'show_all' => true,  
	        'type' => 'plain'  
	    );  
	    if ( $wp_rewrite->using_permalinks() ) $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 'post_type', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
		/*
	    //echo $pagination['base']."<br>";
	    $pagination['base'] = strtok($pagination['base'],'?');
	    $pagination['base'] .= 'page/%#%/'; 
	    //echo $pagination['base']."<br>";
	    
	    
	    
	    
	    
	    $pagination['base'].='?'.$_SERVER['QUERY_STRING'];
	    if ( !empty($wp_query->query_vars['s']) ) $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
	      */
	    /*if ($wp_query->query_vars['post_type'] && $wp_query->query_vars['post_type']!='post')
			$pagination['base'].='?post_type='.$wp_query->query_vars['post_type'];
		*/
		 
	    echo paginate_links( $pagination );
	}

	function wptuts_opengraph_for_posts() {
	    if ( is_singular() ) {
	        global $post;
	        setup_postdata( $post );
	        $output = '<meta property="og:type" content="article" />' . "\n";
	        $output .= '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
	        $output .= '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
	        $output .= '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
	        if ( has_post_thumbnail() ) {
	            $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'endorsement-feature' );
	            $output .= '<meta property="og:image" content="' . $imgsrc[0] . '" />' . "\n";
	        }
	        echo $output;
	    }
	}
	add_action( 'wp_head', 'wptuts_opengraph_for_posts' );

/*	menu-related
	add_action( 'init', 'register_my_menus' );
	function register_my_menus() {
		register_nav_menus(
			array(
				'header-1' => __( 'Header Menu' ),
				'resource-1' => __( 'Download Resource' ),
				'footer-1' => __( 'Footer Menu' )
			)
		);
	}
	
	function menu_fallback(){
	?>
		<ul class="sf-menu">
		  <!-- <li><a href="<?php echo get_option('home'); ?>/" class="on">Home</a></li> -->
		  <?php wp_list_pages('title_li='); ?>
		</ul>
	<?php 
	}

 */
 
 /* qtranslate
	add_filter( 'wp_default_editor', create_function('', 'return "html";') );
	
	function qtranslate_edit_taxonomies(){
	   if (function_exists('qtrans_modifyTermFormFor')){	
		   $args=array(
		      'public' => true ,
		      '_builtin' => false
		   ); 
		   $output = 'object'; // or objects
		   $operator = 'and'; // 'and' or 'or'
		
		   $taxonomies = get_taxonomies($args,$output,$operator); 
		
		   if  ($taxonomies) {
		     foreach ($taxonomies  as $taxonomy ) {
		         add_action( $taxonomy->name.'_add_form', 'qtrans_modifyTermFormFor');
		         add_action( $taxonomy->name.'_edit_form', 'qtrans_modifyTermFormFor');        
		      
		     }
		   }
	   }   
	}
	add_action('admin_init', 'qtranslate_edit_taxonomies');
*/

	/* Custom Style in Editor 
	add_filter('mce_css', 'tuts_mcekit_editor_style');
	function tuts_mcekit_editor_style($url) {
	
	    if ( !empty($url) )
	        $url .= ',';
	
	    // Retrieves the plugin directory URL
	    // Change the path here if using different directories
	    $url .= get_bloginfo("template_url").'/editor-styles.css';
	
	    return $url;
	}
	
	/**
	 * Add "Styles" drop-down
	 
	add_filter( 'mce_buttons_2', 'tuts_mce_editor_buttons' );
	
	function tuts_mce_editor_buttons( $buttons ) {
	    array_unshift( $buttons, 'styleselect' );
	    return $buttons;
	}
	
	/**
	 * Add styles/classes to the "Styles" drop-down
	 
	add_filter( 'tiny_mce_before_init', 'tuts_mce_before_init' );
	
	function tuts_mce_before_init( $settings ) {
	
	    $style_formats = array(        
	        array(
	            'title' => 'Click Button (accordion - Click to Open)',
	            'selector' => 'p',
	            'classes' => 'accordion',
	        ),
	        array(
	            'title' => 'Hidden Section (accordion - Content)',
	            'block' => 'div',            
	            'classes' => 'accordion_content',
	            'wrapper'=>true
	        )
	        
	    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}
*/ 

?>