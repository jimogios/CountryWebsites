<?php
function tk_admin_scripts_calendar_box() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker', get_template_directory_uri()  . '/functions/js/jquery-ui-1.8.13.custom.min.js', array('jquery', 'jquery-ui-core') );
}

function tk_admin_css_calendar_box(){
	wp_register_style('jquery.ui.theme', get_template_directory_uri()  . '/functions/smoothness/jquery-ui-1.8.13.custom.css');
	wp_enqueue_style('jquery.ui.theme');
}




function calendar_admin_footer() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.date-pick').datepicker({
			dateFormat : 'd M, yy'
		});
	});
	</script>
	<?php
}

add_action('admin_print_scripts', 'tk_admin_scripts_calendar_box');
add_action('admin_init', 'tk_admin_css_calendar_box');
add_action('admin_footer', 'calendar_admin_footer');

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

?>