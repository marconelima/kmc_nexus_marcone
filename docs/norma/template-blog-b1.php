<?php
/*
 * The template for displaying one article of blog streampage with style "Blog 1"
 * 
 * @package norma
*/
?>
<article <?php post_class('post_format_'.$post_format.' '.($post_number%2==0 ? 'even' : 'odd') . ($post_number==0 ? ' first' : '') . ($post_number==$per_page? ' last' : '')); ?>>
	<div class="post_info_1">
		<div class="post_format"><span class="<?php echo $post_icon; ?>"></span></div>
		<div class="post_date"><span class="day"><?php $d = date('d', strtotime($post_date)); echo my_substr($d, 0, 1)=='0' ? my_substr($d, -1) : $d; ?></span><span class="month"><?php echo date('M.', strtotime($post_date)); ?></span></div>
		<?php if ($counters!='none') { ?>
        <div class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span></a></div>
        <?php } ?>
	</div>
<?php 
if ($post_protected) { 
?>
	<div class="post_content"><?php echo $post_descr; ?></div>
<?php 
} else {
	if ($post_format!='quote') {
	?>
		<div class="title_area">
			<h1 class="post_title"><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h1>
		</div>

		<div class="post_info post_info_2">
			<span class="post_author"><?php _e('Posted by: ', 'wpspace'); ?><a href="<?php echo $post_author_url; ?>" class="post_author"><?php echo $post_author; ?></a></span>
			<?php 
			if ($post_categories_str != '') { 
			?>
				<span class="post_info_delimiter"></span>
				<span class="post_categories">
					<span class="cats_label"><?php _e('Categories:', 'wpspace'); ?></span>
					<?php echo $post_categories_str; ?>
				</span>
			<?php } // post_cats ?>
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
			<?php if ($post_tags_str != '') { ?>
				<span class="post_tags">
					<span class="tags_label"><?php _e('Tags:', 'wpspace'); ?></span>
					<?php echo $post_tags_str; ?>
				</span>
			<?php } // post_tags ?>
		</div>
<?php
}
?>
</article>
