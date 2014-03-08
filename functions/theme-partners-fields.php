<?php

/*-----------------------------------------------------------------------------------

	Add metaboxes to partner items

-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/


/*
 * 
 * 
 * foreach ($meta_box_partner['fields'] as $custom_field){
		${$custom_field['id']}=get_post_meta($post->ID, $custom_field['id'], true);
	}
 */
$prefix = 'tk_';
 
$meta_box_partner = array(
	'id' => 'tk-meta-box-partner',
	'title' => 'Additional Information',
	'page' => 'partner',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
	
	
		
		
	array(
			'name' => __('Time', 'framework'),
			'desc' => __('e.g. 19 Oct (Sat), 4:30pm-6:30pm', 'framework'),
			'id' => $prefix . 'time',
			'type' => 'text',
			'std' => ''
		),
	array(
			'name' => __('Price', 'framework'),
			'desc' => __('e.g. HK$200', 'framework'),
			'id' => $prefix . 'price',
			'type' => 'text',
			'std' => ''
		),			
	array(
			'name' => __('Meeting Point', 'framework'),
			'desc' => __('', 'framework'),
			'id' => $prefix . 'venue',
			'type' => 'text',
			'std' => ''
		),
	array(
			'name' => __('Meeting Point (Chinese)', 'framework'),
			'desc' => __('', 'framework'),
			'id' => $prefix . 'venue_zh',
			'type' => 'text',
			'std' => ''
		),
	array(
			'name' => __('Registration Link', 'framework'),
			'desc' => __('', 'framework'),
			'id' => $prefix . 'registration_link',
			'type' => 'text',
			'std' => ''
		)
));



add_action('admin_menu', 'tk_add_partner_box');


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
 
function tk_add_partner_box() {
	global $meta_box_partner, $meta_box_partner_video; 
	add_meta_box($meta_box_partner['id'], $meta_box_partner['title'], 'tk_show_partner_box', $meta_box_partner['page'], $meta_box_partner['context'], $meta_box_partner['priority']);
}


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/

function tk_show_partner_box() {
	global $meta_box_partner, $post;
 	
	
	// Use nonce for verification
	echo '<input type="hidden" name="tk_meta_box_partner_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
 
	foreach ($meta_box_partner['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
 
			
			//If Text		
			case 'text':
			
			echo '<tr style="border-top:1px solid #eeeeee;">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; line-height: 20px; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			echo '</td></tr>';			
			break;
			
			case 'file':
			
			echo '<tr style="border-top:1px solid #eeeeee;">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; line-height: 20px; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';
						
			break;
			
			case 'textarea':
			echo '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; line-height: 20px; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>', 
				'<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea></td></tr>';
			break;
 
			//If Button	
			case 'button':
				echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '"value="', $meta ? $meta : $field['std'], '" />';
				echo 	'</td>',
			'</tr>';
			
			break;
			
			//If Select	
			case 'select':
			
				echo '<tr style="border-top:1px solid #eeeeee;">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				echo'<select name="'.$field['id'].'">';
			
				foreach ($field['options'] as $option) {
					
					echo'<option';
					if ($meta == $option ) { 
						echo ' selected="selected"'; 
					}
					echo'>'. $option .'</option>';
				
				} 
				
				echo'</select></td></tr>';
			
			break;
			
			case 'calendar':
			
			echo '<tr style="border-top:1px solid #eeeeee;">',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
			echo '<input type="text" class="date-pick" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';
				
		}

	}
 
	echo '</table>';
}


add_action('save_post', 'tk_partner_save_data');


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
 
function tk_partner_save_data($post_id) {
	global $meta_box_partner, $meta_box_partner_video;
 
	// verify nonce
	if (!wp_verify_nonce($_POST['tk_meta_box_partner_nonce'], basename(__FILE__))) {
		return $post_id;
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 
	foreach ($meta_box_partner['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
	
	
}

add_filter('is_protected_meta', 'partner_is_protected_meta_filter', 10, 2);
function partner_is_protected_meta_filter($protected, $meta_key) {
    //return $meta_key == 'test1' ? true : $protected;
    global $meta_box_partner;
    
    
	foreach ($meta_box_partner['fields'] as $field)
		if ($meta_key==$field['id'])
			return true;
			
	return $protected;
	
}
