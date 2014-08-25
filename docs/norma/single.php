<?php
/**
 * The Template for displaying all single posts.
 *
 * @package norma
 */

get_header(); 

$mult = min(2, max(1, get_theme_option("retina_ready")));
$counters = get_theme_option("blog_counters");
$page_style = get_custom_option('blog_style');
if (!in_array($page_style, array('b1', 'b2', 'b3', 'p1', 'p2', 'p3', 'p4')))
	$page_style = 'b1';
else if (in_array($page_style, array('p1', 'p2', 'p3', 'p4')))
	$page_style = 'p1';
else if (is_page())
	$page_style = 'b3';
$thumb_size = array(
	'b1' => array('w' => array(790, 1090),  'h' => array(391, 391)),
	'b2' => array('w' => array(860, 1170),  'h' => array(391, 391)),
	'b3' => array('w' => array(370, 370),   'h' => array(232, 232)),
	'p1' => array('w' => array(870, 1170),  'h' => array(null, null)),
);
$subst_style = $page_style=='b3' ? 'b2' : $page_style;
$thumb_idx = get_custom_option('single_sidebar_position')=='fullwidth' ? 1 : 0;
?>
	<div id="main_inner" class="clearboth">
		<div id="content" class="content_blog blog_style_<?php echo $page_style; ?> post_single" role="main">

            <?php while ( have_posts() ) : the_post(); ?>
                <?php setPostViews(get_the_ID()); ?>

                <?php
				$tpl_dir = get_template_directory_uri();

				$post_id = get_the_ID();
				$post_protected = post_password_required();
				$post_format = get_post_format();
				if (empty($post_format)) $post_format = 'standard';
				$post_link = get_permalink();
				$post_comments_link = $counters=='comments' ? get_comments_link( $post_id ) : $post_link;
				$post_date = get_the_date();
				$post_title = getPostTitle();
				$post_descr = get_the_excerpt();					//getPostDescription();
				$post_comments = get_comments_number();
				$post_views = getPostViews($post_id);
				$post_custom_options = get_post_meta($post_id, 'post_custom_options', true);
				$post_icon = isset($post_custom_options['page_icon']) ? $post_custom_options['page_icon'] : get_post_meta($post_id, 'page_icon', true);
				if ($post_icon=='' || $post_icon=='default') $post_icon = getPostFormatIcon($post_format);
				$post_thumb = get_custom_option("single_featured_image") == 'yes' 
					? getResizedImageTag($post_id, $thumb_size[$page_style]['w'][$thumb_idx]*$mult, $thumb_size[$page_style]['h'][$thumb_idx] ? $thumb_size[$page_style]['h'][$thumb_idx]*$mult : null)
					: '';
				// Author info
				$post_author = get_the_author();
				$post_author_id = get_the_author_meta('ID');
				$post_author_url = get_author_posts_url($post_author_id, '');

				// Content
				$post_content = get_the_content(null, get_custom_option('single_text_before_readmore')!='yes');
				if ($post_format == 'gallery') {
					if (get_custom_option('blog_substitute_gallery')=='yes') {
						$post_content = substituteGallery($post_content, $post_id, $thumb_size[$subst_style]['w'][$thumb_idx]*$mult, $thumb_size[$subst_style]['h'][$thumb_idx]*$mult);
					}
				} else if ($post_format == 'video') {
					if (get_custom_option('blog_substitute_video')=='yes') {
						$post_content = substituteVideo($post_content, $thumb_size[$subst_style]['w'][$thumb_idx], $thumb_size[$subst_style]['h'][$thumb_idx]);
					}
				} else if ($post_format == 'audio') {
					if (get_custom_option('blog_substitute_audio')=='yes') {
						$post_content = substituteAudio($post_content);
					}
				}
				$post_content = apply_filters('the_content', $post_content);
				// Categories list
				$post_categories_str = '';
				$post_categories_ids = array();
				$post_categories = getCategoriesByPostId($post_id);
				for ($i = 0; $i < count($post_categories); $i++) {
					$post_categories_ids[] = $post_categories[$i]['term_id'];
					$post_categories_str .= '<a class="cat_link" href="' . $post_categories[$i]['link'] . '">'
						. $post_categories[$i]['name'] 
						. ($i < count($post_categories)-1 ? ',' : '')
						. '</a> ';
				}
				// Tags list
				$post_tags_str = '';
				if (get_custom_option("single_show_post_tags") == 'yes') {				
					if (($post_tags = get_the_tags()) != 0) {
						$tag_number=0;
						foreach ($post_tags as $tag) {
							$tag_number++;
							$post_tags_str .= '<a class="tag_link" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . ($tag_number==count($post_tags) ? '' : ',') . '</a> ';
						}
					}
				}
				?>

				<article <?php post_class('post_format_'.$post_format); ?>>
					<?php 
					if ($page_style=='b1') { 
					?>
					<div class="post_info_1">
						<div class="post_format"><span class="<?php echo $post_icon; ?>"></span></div>
						<div class="post_date"><span class="day"><?php $d = date('d', strtotime($post_date)); echo my_substr($d, 0, 1)=='0' ? my_substr($d, -1) : $d; ?></span><span class="month"><?php echo date('M.', strtotime($post_date)); ?></span></div>
						<?php if ($counters!='none') { ?>
                        <div class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span></a></div>
                        <?php } ?>
					</div>
					<?php 
					}
				if ($post_protected) { 
				?>
					<div class="post_content"><?php echo $post_descr; ?></div>
				<?php 
				} else {
					if ($post_format!='quote') {
						if (get_custom_option('single_title')=='yes') {
							if ($page_style!='p1') {
							?>
								<div class="title_area">
									<h1 class="post_title"><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h1>
									<?php if ($page_style=='b2') { ?>
									<div class="post_info post_info_2">
										<span class="post_date"><?php echo $post_date; ?></span>
										<span class="post_info_delimiter"></span>
										<span class="post_author"><?php _e('By: ', 'wpspace'); ?><a href="<?php echo $post_author_url; ?>" class="post_author"><?php echo $post_author; ?></a></span>
										<?php if ($counters!='none') { ?>
                                        <span class="post_info_delimiter"></span>
                                        <span class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></span>
                                        <?php } ?>
									</div>
									<?php } ?>
								</div>
							<?php 
							}
							if ($page_style=='b1') { 
							?>
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
						}
						// If post have thumbnail - show it
						if ( $post_thumb ) {
						?>
							<div class="pic_wrapper image_wrapper">
								<?php echo $post_thumb; ?>
							</div>
						<?php
						}
						if ($page_style=='p1') {
						?>
                            <div class="post_info post_details">
                            	<h4 class="post_title"><?php _e('Project Details', 'wpspace'); ?></h4>
                                <?php if (($portfolio_url = get_custom_option('portfolio_url'))!='') { ?>
                                <div class="post_url"><a href="<?php echo $portfolio_url; ?>" title="<?php echo $portfolio_url; ?>"><?php echo $portfolio_url; ?></a></div>
                                <?php } ?>
                                <?php if (($portfolio_date = get_custom_option('portfolio_date'))!='') { ?>
                                <div class="post_date"><?php echo $portfolio_date; ?></div>
                                <?php } ?>
                                <?php if (($portfolio_customer = get_custom_option('portfolio_customer'))!='') { $portfolio_customer_url = get_custom_option('portfolio_customer_url'); ?>
                                <div class="post_author">
									<?php _e('Customer: ', 'wpspace'); ?>
									<?php if ($portfolio_customer_url) {?><a href="<?php echo $portfolio_customer_url; ?>" class="post_author"><?php } ?>
										<?php echo $portfolio_customer; ?>
                                    <?php if ($portfolio_customer_url) {?></a><?php } ?>
                                </div>
                                <?php } ?>
								<?php if ($post_tags_str != '') { ?>
                                    <div class="post_tags">
                                        <span class="tags_label"><?php _e('Tags:', 'wpspace'); ?></span>
                                        <?php echo $post_tags_str; ?>
                                    </div>
                                <?php } // post_tags ?>
                            </div>
							<?php if (get_custom_option('single_title')=='yes') { ?>
                                <div class="title_area post_title_area">
                                    <h2 class="post_title"><a href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a></h2>
									<?php if ($counters!='none') { ?>
                                    <span class="post_views"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="views_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></span>
                                    <?php } ?>
                                    <?php if ($post_categories_str != '') { ?>
                                        <span class="post_categories">
                                            <?php echo $post_categories_str; ?>
                                        </span>
                                    <?php } // post_categories ?>
                                </div>
							<?php 
							}
						}
					}
					?>
					
					<div class="post_content">
						<?php 
							echo $post_content; 
							wp_link_pages( array( 
								'before' => '<div class="nav_pages_parts"><span class="pages">' . __( 'Pages:', 'wpspace' ) . '</span>', 
								'after' => '</div>',
								'link_before' => '<span class="page_num">',
								'link_after' => '</span>'
							) ); 
						?>
					</div>
					
					<?php if (!is_page() && $page_style != 'p1') { ?>
                    <div class="post_info post_info_3 clearboth">
						<?php if ($page_style == 'b3') { ?>
						<?php if ($counters!='none') { ?>
						<span class="post_comments"><a href="<?php echo $post_comments_link; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="comments_number"><?php echo $counters=='comments' ? $post_comments : $post_views; ?></span></a></span>
						<?php } ?>
						<span class="post_date"><?php echo $post_date; ?></span>
						<span class="post_info_delimiter"></span>
						<span class="post_author"><?php _e('Posted by: ', 'wpspace'); ?><a href="<?php echo $post_author_url; ?>" class="post_author"><?php echo $post_author; ?></a></span>
						<?php } ?>
						<?php if ($post_tags_str != '') { ?>
							<?php if ($page_style == 'b3') { ?>
							<span class="post_info_delimiter"></span>
							<?php } ?>
							<span class="post_tags">
								<span class="tags_label"><?php _e('Tags:', 'wpspace'); ?></span>
								<?php echo $post_tags_str; ?>
							</span>
						<?php } // post_tags ?>
					</div>
					<?php } ?>

					<?php
					//===================================== Social Share =====================================
					if (get_custom_option("single_show_post_share") == 'yes') {
					?>
						<div class="post_social">
							<span class="social_label"><?php _e('Share this Story', 'wpspace'); ?></span>
							<?php
								showShareSocialLinks(array(
									'post_link' => $post_link,
									'post_title' => $post_title,
									'post_descr' => $post_descr,
									'icon_size' => '',
									'allowed' => array('dribbble', 'linkedin', 'gplus', 'twitter', 'facebook')
								));
							?>
						</div>
					<?php
					}

					//===================================== Post author info =====================================
					if (get_custom_option("single_show_post_author") == 'yes') {
						$post_author_email = get_the_author_meta('user_email', $post_author_id);
						$post_author_avatar = get_avatar($post_author_email, 50);
						$post_author_descr = apply_filters('the_content', get_the_author_meta('description', $post_author_id));
					?>
						<div class="post_author_details">
							<div class="post_author_avatar_wrapper">
								<div class="post_author_avatar pic_wrapper image_wrapper"><a href="<?php echo $post_author_url; ?>"><?php echo $post_author_avatar; ?></a></div>
							</div>
							<div class="extra_wrap">
								<h3 class="author_name"><a href="<?php echo $post_author_url; ?>"><span><?php echo __('About the Author', 'wpspace'); ?></span> <?php //echo $post_author; ?></a></h3>
								<div class="author_description"><?php echo $post_author_descr; ?></div>
							</div>	
						</div>
					<?php
					}
				}
				?>
				</article>

                <?php 
				if (!$post_protected) {
					//===================================== Related posts =====================================
					if (get_custom_option("single_show_post_related") == 'yes') {
						$args = array( 
							'numberposts' => '6',
							'post_type' => 'post', 
							'post_status' => 'publish',
							'post__not_in' => array($post_id) 
						);
						if ($post_categories_str) {
							$args['category__in'] = $post_categories_ids;
						}
						if ($post_format != '' && $post_format != 'standard') {
							$args['tax_query'] = array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-' . $post_format
								)
							);
						}
						$recent_posts = wp_get_recent_posts( $args );
						if (count($recent_posts) > 0) {
						?>
						<div id="related_posts">
							<div class="subtitle_area">
								<h2 class="post_subtitle"><?php echo $page_style=='p1' ? __('Related projects', 'wpspace') : __('Related posts', 'wpspace'); ?></h2>
							</div>
							<?php
							$i=0;
							foreach( $recent_posts as $recent ) {
								if ($recent['post_date'] > date('Y-m-d 23:59:59') && $recent['post_date_gmt'] > date('Y-m-d 23:59:59')) continue;
								$i++;
								$recent['link'] = get_permalink($recent['ID']);
								$recent['comments_link'] = $counters=='comments' ? get_comments_link( $recent['ID'] ) : $recent['link'];
								$recent['thumb'] = getResizedImageTag($recent['ID'], 260*$mult, 160*$mult);
								$recent['attachment'] = wp_get_attachment_url(get_post_thumbnail_id($recent['ID']));
								if ($counters!='none') { 
									$recent['views'] = getPostViews($recent['ID']);
									$recent['comments'] = get_comments_number($recent['ID']);
								}
								if ($page_style == 'p1') {
									$recent['categories_str'] = '';
									$recent['categories'] = getCategoriesByPostId($recent['ID']);
									for ($c = 0; $c < count($recent['categories']); $c++) {
										$recent['categories_str'] .= '<a class="cat_link" href="' . $recent['categories'][$c]['link'] . '">'
											. $recent['categories'][$c]['name'] 
											. ($c < count($recent['categories'])-1 ? ',' : '')
											. '</a>';
									}
								}
								?>
								<div class="related_posts_item <?php echo ($i % 2 == 0 ? 'even' : 'odd') . ($i==1 ? ' first' : '') . ($i==3+$thumb_idx ? ' last' : ''); ?>">
									<?php 
									if ( $recent['thumb'] ) {
									?>
										<div class="pic_wrapper image_wrapper">
											<?php echo $recent['thumb']; ?>
                                            <span class="image_overlay"></span>
                                            <a href="<?php echo $recent['link']; ?>" class="image_link"><span class="icon-link"></span></a>
                                            <a href="<?php echo $recent['attachment']; ?>" class="image_zoom prettyPhoto"><span class="icon-search"></span></a>
										</div>
									<?php
									}
									?>
									<div class="title_area">
										<?php if ($counters!='none') { ?>
										<span class="post_comments"><a href="<?php echo $recent['comments_link']; ?>"><span class="icon-<?php echo $counters=='comments' ? 'comment' : 'eye'; ?>"></span><span class="post_comments_number"><?php echo $counters=='comments' ? $recent['comments'] : $recent['views']; ?></span></a></span>
										<?php } ?>
										<h4 class="related_posts_title"><a href="<?php echo $recent['link']; ?>"><?php echo $recent['post_title']; ?></a></h4>
									</div>
									<div class="post_info">
                                    	<?php
										if ($page_style == 'p1')
											echo $recent['categories_str'];
										else {
										?>
										<span class="post_date"><?php echo date(get_option('date_format'), strtotime($recent['post_date'])); ?></span>
                                        <?php
										}
										?>
									</div>
								</div>
								<?php
								if ($i>=3+$thumb_idx) break;
							}
							?>
						</div>
						<?php
						}
					}	// if (blog_show_related_posts)
					//===================================== Comments =====================================
					if (get_custom_option("single_show_post_comments") == 'yes') {
						if ( comments_open() || get_comments_number() != 0 ) {
							comments_template();
						}
					}
                } // if (!post_password_required())
                ?>
    
            <?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

		<?php get_sidebar(); ?>

	</div><!-- #main_inner -->

<?php get_footer(); ?>
