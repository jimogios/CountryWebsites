<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php global $meta_box_partner;
	foreach ($meta_box_partner['fields'] as $custom_field){
		${$custom_field['id']}=get_post_meta($post->ID, $custom_field['id'], true);
	}
	
?>
Time: <?php echo $tk_time;?><br>
Date: <?php echo $tk_price;?><br>
			<?php the_title();?>
			<?php the_permalink();?>	

	<?php endwhile; endif; ?>
	

<?php get_footer(); ?>