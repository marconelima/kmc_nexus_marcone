<?php
/*
 * The template for displaying one article of blog streampage with style "Blog 2"
 * 
 * @package norma
*/
?>
<article <?php post_class('post_format_'.$post_format.' '.($post_number%2==0 ? 'even' : 'odd') . ($post_number==0 ? ' first' : '') . ($post_number==$per_page? ' last' : '')); ?>>
<?php 
if ($post_protected) { 
?>
	<div class="post_content"><?php echo $post_descr; ?></div>
<?php 
} else {
	
	// Post title
	if ($post_format != 'quote') {
	?>	
		<div class="title_area">
			<h1 class="post_title"><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h1>
			<div class="post_info post_info_2">
				<span class="post_date"><?php echo $post_date; ?></span>
				<span class="post_info_delimiter"></span>
				<span class="post_author"><?php _e('By: ', 'wpspace'); ?><a href="<?php echo $post_author_url; ?>" class="post_author"><?php echo $post_author; ?></a></span>
				<?php if ($counters!='none') { ?>
				<span class="post_info_delimiter"></span>
				<span class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></span>
		        <?php } ?>
			</div>
		</div>
	<?php
	}
	// If post have thumbnail - show it
	if ( $post_thumb ) {
	?>
		<div class="pic_wrapper image_wrapper">
			<?php echo $post_thumb; ?>
		</div>
	<?php
	}
	?>

		<div class="post_content">
			<?php if (get_custom_option('blog_mode')=='short') {
				echo apply_filters('the_content', $post_descr);
				?>
				<div class="readmore"><a href="<?php echo $post_link; ?>" class="more-link"><?php _e('Read more', 'wpspace'); ?></a></div>
				<?php 
			} else {		// blog_mode == 'full'
				if ($post_excerpt) {
					echo apply_filters('the_content', $post_excerpt);
					?>
					<div class="readmore"><a href="<?php echo $post_link; ?>" class="more-link"><?php _e('Read more', 'wpspace'); ?></a></div>
					<?php 
				} else {
					echo $post_content; 
				}
			}
			?>
		</div>

		<div class="post_info post_info_3 clearboth">
			<?php 
			if ($post_format != 'quote') {
				if ($post_tags_str != '') {
					?>
					<span class="post_tags">
						<span class="tags_label"><?php _e('Tags:', 'wpspace'); ?></span>
						<?php echo $post_tags_str; ?>
					</span>
					<?php 
				} // post_tags 
			} else {
				?>
				<span class="post_date"><?php echo $post_date; ?></span>
				<span class="post_info_delimiter"></span>
				<span class="post_author"><?php _e('By: ', 'wpspace'); ?><a href="<?php echo $post_author_url; ?>" class="post_author"><?php echo $post_author; ?></a></span>
				<?php if ($counters!='none') { ?>
				<span class="post_info_delimiter"></span>
				<span class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></span>
		        <?php } ?>
				<?php
			}
			?>
		</div>
<?php
}
?>
</article>
