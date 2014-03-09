<?php

$prefix = 'tk_';
 
$meta_box_page_multi = array(
	'id' => 'tk-meta-box-page-multi',
	'title' => 'Custom Slides (965 x 344px)',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
	
	array(
			'name' => 'Slide',
			'desc' => '',
			'id' => $prefix . 'photo',
			'type' => 'upload',
	)
));


	function page_multi() 
	{
		global $post, $detailTitle,$the_detail,$meta_box_page_multi;
		$detailCount = 0;
		
		
		$detailCount = count($detailTitle);
		
		// Use nonce for verification
  		echo '<input type="hidden" name="ei_noncename" id="ei_noncename" value="' .wp_create_nonce('ei-n'). '" />';
		?>
		<p>After uploading image, please press insert into post to paste the link to the field.</p>
        <div class="detail detail-header">            
            <table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<?php foreach ($meta_box_page_multi['fields'] as $field):?>
                	<td class="<?php echo $field['id'];?>"><?php echo $field['name'];?></td>
                    <?php endforeach;?>
                </tr>
            </table>
        </div>
        <div class="details">
        <?php if(tk_page_has_details()): ?>
        	<?php while(tk_page_detail()): ?>
            	<div class="detail">
            		<table cellpadding="0" cellspacing="0" width="100%">
                   	<tr>
                   		<?php
               			$i=0; 
           				foreach ($meta_box_page_multi['fields'] as $field):
							switch ($field['type']){ 
								case 'text':
           				?>
               			<td class="<?php echo $field['id'];?>"><input type="text" name="<?php echo $field['id'];?>[]" value="<?php echo $the_detail[$i];?>"></td>
                   		<?php
                   				break;
								case 'textarea':
						?>
						<td class="<?php echo $field['id'];?>"><textarea name="<?php echo $field['id'];?>[]"><?php echo $the_detail[$i];?></textarea></td>
						<?php
								break;
								case 'select':
						?>
						<td class="<?php echo $field['id'];?>">
                        	<select name="<?php echo $field['id'];?>[]">
                        		<?php foreach ($field['options'] as $option):?>
                            	<option value="<?php echo $option;?>" <?php if($the_detail[$i] == $option){echo'selected="selected"';} ?>><?php echo $option;?></option>
                            	<?php endforeach;?>
                            </select>
                        </td>
						<?php
								break;
								case 'upload':
						?>
						<td class="<?php echo $field['id'];?>">
							<img src="<?php echo $the_detail[$i];?>" style="width:744px;height:265px;"/>
							<input type="text" name="<?php echo $field['id'];?>[]" value="<?php echo $the_detail[$i];?>">
							<input style="float: left;" type="button" class="button tk_upload" value="Upload"/>
						</td>
						<?php
						}
								
                   		$i++; 
                   		endforeach;?>
                   		
                    </tr>
                    
                    <tr>
                    	<td colspan="6">
                    		<a class="delete" href="#" title="Remove Detail"><?php _e( 'Remove'); ?></a>
		                    <div class="grab"><?php _e( 'Reorder'); ?></div>
                    	</td>
                    </tr>
                    
                    </table> 
                </div>
            <?php endwhile; ?>
        <?php else: ?>
         		<div class="detail">
                	<table cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<?php
	               			
	           				foreach ($meta_box_page_multi['fields'] as $field):
								switch ($field['type']){ 
									case 'text':
	           				?>
	               			<td class="<?php echo $field['id'];?>"><input type="text" name="<?php echo $field['id'];?>[]"<?php if($field['std']):?> value="<?php echo $field['std'];?>"<?php endif;?>></td>
	                   		<?php
	                   				break;
									case 'textarea':
							?>
							<td class="<?php echo $field['id'];?>"><textarea name="<?php echo $field['id'];?>[]"></textarea></td>
							<?php
									break;
									case 'select':
							?>
							<td class="<?php echo $field['id'];?>">
	                        	<select name="<?php echo $field['id'];?>[]">
	                        		<?php foreach ($field['options'] as $option):?>
	                            	<option value="<?php echo $option;?>"><?php echo $option;?></option>
	                            	<?php endforeach;?>
	                            </select>
	                        </td>
							<?php
									break;
									case 'upload':
							?>
							<td class="<?php echo $field['id'];?>">
								<input type="text" name="<?php echo $field['id'];?>[]">
								<input style="float: left;" type="button" class="button tk_upload" value="Upload"/>
							</td>
							<?php
							}
									
	                   		$i++; 
	                   		endforeach;?>
                            
                        </tr>
                        
                        <tr>
	                    	<td colspan="6">
	                    		<a class="delete" href="#" title="Remove Detail"><?php _e( 'Remove'); ?></a>
			                    <div class="grab"><?php _e( 'Reorder' ); ?></div>
	                    	</td>
	                    </tr>
                    </table> 
                </div>
        <?php endif; ?> 
        </div>  
		<div class="detail detail-footer">
			<p>
       			<a class="add-detail button-primary" href="javascript:void(0)" title="Add New Row"><?php _e('Add New Row','sh_invoice'); ?></a>
       		</p>
        </div> 
		<?php
	}
	
	
	
	/*--------------------------------------------------------------------------------------------
										Invoice_has_details
										
	* This function is called before the detail loop. 
	* Populates the detail's data array's
	* Checks that there are details
	* Then it returns either true or false.
	--------------------------------------------------------------------------------------------*/
	function tk_page_has_details()
	{
		global $post, $detailCount, $meta_box_page_multi,$Records;
		
		
		
		$detailCount=0;
		
		foreach ($meta_box_page_multi['fields'] as $field)
			$Records[$field['id']] = get_post_meta($post->ID, $field['id'], true);
		
		if($Records[$meta_box_page_multi['fields'][0]['id']][0])
		{
			return true;	
		}
		else
		{
			return false;	
		}
	}
	
	
	/*--------------------------------------------------------------------------------------------
										 Invoice_detail
										
	* This function is called at the start of the detail loop. 
	* It sets up the detail data and returns either true or false.
	--------------------------------------------------------------------------------------------*/
	function tk_page_detail()
	{
		global $the_detail, $detailCount, $meta_box_page_multi,$Records;
		
		
		
		if($Records[$meta_box_page_multi['fields'][0]['id']][$detailCount] != '')
		{
			$i=0;
			foreach ($meta_box_page_multi['fields'] as $field){
				$the_detail[$i]=$Records[$field['id']][$detailCount];
				$i++;
			}
			$detailCount++;
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	
	
	/*--------------------------------------------------------------------------------------------
										Save
	--------------------------------------------------------------------------------------------*/
	function save_page_multi($post_id) {
		global $meta_box_page_multi;
		// verify this with nonce because save_post can be triggered at other times
		if (!wp_verify_nonce($_POST['ei_noncename'], 'ei-n')) return $post_id;
	
		// do not save if this is an auto save routine
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		foreach ($meta_box_page_multi['fields'] as $field)
			update_post_meta($post_id, $field['id'], $_POST[$field['id']]);
		
	}


	add_action('save_post', 'save_page_multi');
	
	/*-----------------------------------------------------------------------------------*/
	/*	Add metabox to edit page
	/*-----------------------------------------------------------------------------------*/
	 
	function tk_add_page_multi_box() {
		global $meta_box_page_multi; 
		add_meta_box($meta_box_page_multi['id'], $meta_box_page_multi['title'], 'page_multi', $meta_box_page_multi['page'], $meta_box_page_multi['context'], $meta_box_page_multi['priority']);
	}
		
	add_action('admin_menu', 'tk_add_page_multi_box');


	function admin_page_multifields_head()
	{
		global $post,$meta_box_page_multi;
		// 1. add style + jquery to all invoice related pages
		if(get_post_type($post->ID) == $meta_box_page_multi['page'] || $_GET['post_type'] == $meta_box_page_multi['page']) 
		{
			echo '<link rel="stylesheet" href="'.get_template_directory_uri()  . '/functions/'.$meta_box_page_multi['page'].'/style.css" type="text/css" media="all" />';	
			echo '<script type="text/javascript" src="'.get_template_directory_uri()  . '/functions/'.$meta_box_page_multi['page'].'/admin-jquery.js" ></script>';
		}
	}
	
	add_action('admin_head', 'admin_page_multifields_head');	
?>