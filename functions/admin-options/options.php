<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Displays a message that options aren't available in the current theme
 *  
 */

function optionsframework_options() {
		
		$images_path = get_template_directory_uri() . '/images/';
		$skins_array = array("default" => "Default","bumble-bee" => "Bumble Bee","mint" => "Mint","fancy" => "Fancy","silver" => "Silver","blue" => "Blue","rose" => "Rose","dark" => "Dark");
		$typography_styles = array("default" => "Sans Serif","serif" => "Serif");
		$box_sizes = array("col1" => "135px","col2" => "310px","col3" => "485px","col4" => "660px");
		
		// Pull all the categories into an array
		$options_categories = array();  
		$options_categories_obj = get_categories();
		$options_categories['all'] = 'All Categories';
		foreach ($options_categories_obj as $category) {
	    	$options_categories[$category->cat_ID] = $category->cat_name;
		}
		
		/* ************************************************
						General Settings
		************************************************ */
		
		$options[] = array( "name" => "General Settings",
							"type" => "heading");
		
		/* $options[] = array( "name" => "Analytics Code",
							"desc" => "Will be added immediately before the closing &lt;/head&gt; tag",
							"id" => "analytics_code",
							"validate" => "html",
							"type" => "textarea"); 	 */				
		
		$options[] = array( "name" => "Headers",
							"desc" => "The following options allow you to customize the header of your theme elements. ",
							"type" => "info");
		
		
		$options[] = array( "name" => "English wordings in Header",
							"desc" => "(e.g. Limited seat early bird extended to 9 Nov 2012. For enquireies on registration, please contact Registration Office at (852) 2561-5566)",
							"id" => "header_text",
							"std" => '',
							"type" => "text");
		
		
		$options[] = array( "name" => "Chinese wordings in Header",
							"desc" => "(e.g. 座位有限，報名從速 Early Bird優惠延長至11月9日 如就報名有任何疑問，敬請致電(852)2561-5566向登記處查詢)",
							"id" => "header_text_zh",
							"std" => '',
							"type" => "text");
							
		$options[] = array( "name" => "English wordings in Search bar",
							"desc" => "(e.g. Search for Issues, Events, Articles, and People)",
							"id" => "search_text",
							"std" => '',
							"type" => "text");
		
		
		$options[] = array( "name" => "Chinese wordings in Search bar",
							"desc" => "(e.g. 搜尋議題，活動，文章)",
							"id" => "search_text_zh",
							"std" => '',
							"type" => "text");					
		
		
		$options[] = array( "name" => "Footer",
							"desc" => "The following options allow you to customize the footer of your theme elements. ",
							"type" => "info");
		
		
		$options[] = array( "name" => "Contact Us Information",
							"desc" => "The one shown in the footer on the right",
							"id" => "contact_us",
							"std" => false,
							"type" => "textarea");
		
		$options[] = array( "name" => "Chinese Contact Us Information",
							"desc" => "The one shown in the footer on the right",
							"id" => "contact_us_zh",
							"std" => false,
							"type" => "textarea");
		
							
		$options[] = array( "name" => "Copyright Text",
							"desc" => "Add text before &copy; 20xx Copyright",
							"std"=>'Social Enterprise Summit 社企民間高峰會',
							"id" => "copyright",
							"type" => "text");
		
		/* ************************************************
						Homepage Settings
		************************************************ */
		
		$options[] = array( "name" => "Home Settings",
							"type" => "heading");
		
		$options[] = array( "name" => "Youtube ID for video player",
							"desc" => "",
							"id" => "youtube_link",
							"type" => "text"); 	 				
		
		
						
		/* ************************************************
						Social Networks
		************************************************ */
		$options[] = array( "name" => "Social Networks",
							"type" => "heading");	
							
		
						
		
		$options[] = array( "name" => '<img src="'.$images_path.'facebook-ic-16.png" width="16" height="16" alt="" /> Facebook',
						"desc" => "Enter the full Facebook Page URL",
						"id" => "facebook",
						"std"=>"",
						"type" => "text");
		
		
		
		
								
	return $options;
}