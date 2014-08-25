<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. 
 *
 * @package norma
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

<div id="comments" class="post_comments">

	<?php 
	if ( have_comments() ) {
	?>
		<div class="subtitle_area">
			<h2 class="post_subtitle"><?php _e('Comments', 'wpspace'); ?><span>(<?php echo get_comments_number(); ?>)</span></h2>
		</div>
		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use vc_theme_comment() to format the comments.
				 */
				wp_list_comments( array( 'callback' => 'single_comment_output') );
			?>
		</ol><!-- .comment-list -->

	<?php 
	}

	if ( !comments_open() && get_comments_number()!=0 && post_type_supports( get_post_type(), 'comments' ) ) {
	?>
		<p class="no_comments"><?php _e( 'Comments are closed.', 'wpspace' ); ?></p>
	<?php
	}

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$comments_args = array(
			// change the title of send button 
			'label_submit'=>__('Submit', 'wpspace'),
			// change the title of the reply section
			'title_reply'=>__('Leave a comment', 'wpspace'),
			// remove "Logged in as"
			'logged_in_as' => '',
			// remove text before textarea
			'comment_notes_before' => '',
			// remove text after textarea
			'comment_notes_after' => '',
			// redefine your own textarea (the comment body)
			'comment_field' => '<p class="comment-form-comment">'
								. '<label for="comment" class="required">'
								. __('Your Message', 'wpspace')
								. '<span class="required"> (' . __('required', 'wpspace') . ')</span>'
								. '</label>'
								. '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>'
								. '</p>',
			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' => '<p class="comment-form-author">'
						. '<label for="author"' . ( $req ? ' class="required"' : '' ). '>' 
						. __( 'Name', 'wpspace' ) 
						. ( $req ? '<span class="required"> (' . __('required', 'wpspace') . ')</span>' : '') 
						. '</label>'
						. '<input id="author" name="author" type="text" value="' . esc_attr( isset($commenter['comment_author']) ? $commenter['comment_author'] : '' ) . '" size="30"' . $aria_req . ' />'
						. '</p>',
				'email' => '<p class="comment-form-email">'
						. '<label for="email"' . ( $req ? ' class="required"' : '' ) . '>' 
						. __( 'Email', 'wpspace' )  
						. ( $req ? '<span class="required"> (' . __('required', 'wpspace') . ')</span>' : '') 
						. '</label>'
						. '<input id="email" name="email" type="text" value="' . esc_attr(  isset($commenter['comment_author_email']) ? $commenter['comment_author_email'] : '' ) . '" size="30"' . $aria_req . ' />'
						. '</p>',
				'url' => '<p class="comment-form-website clearboth">'
						. '<label for="url" class="optional">' 
						. __( 'Website', 'wpspace' ) 
						. '<span class="optional"> (' . __('optional', 'wpspace') . ')</span>' 
						. '</label>'
						. '<input id="url" name="url" type="text" value="' . esc_attr(  isset($commenter['comment_author_url']) ? $commenter['comment_author_url'] : '' ) . '" size="30"' . $aria_req . ' />'
						. '</p>'
			) )
	);

	comment_form($comments_args);
	?>

	<div class="nav_comments"><?php paginate_comments_links(); ?></div>

</div><!-- #comments -->
<?php 

function single_comment_output( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
			?>
			<li class="trackback">
				<p><?php _e( 'Trackback:', 'wpspace' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'wpspace' ), '<span class="edit-link">', '<span>' ); ?></p>
			<?php
			break;
		case 'trackback' :
			?>
			<li class="pingback">
				<p><?php _e( 'Pingback:', 'wpspace' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'wpspace' ), '<span class="edit-link">', '<span>' ); ?></p>
			<?php
			break;
		default :
			$author_id = $comment->user_id;
			$author_link = get_author_posts_url( $author_id );
			?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<div class="comment_author_avatar_wrapper">
					<div class="comment_author_avatar pic_wrapper image_wrapper"><?php echo get_avatar( $comment, 50 ); ?></div>
				</div>
				<div class="extra_wrap">
	                <div class="comment_title_area">
						<h4 class="comment_title">
							<?php 
							if ($author_id) echo '<a href="' . $author_link . '">';
							comment_author(); 
							if ($author_id) echo '</a>';
							?>
						</h4>
	                    <?php if ($depth < $args['max_depth']) { ?>
                        <span class="comment_reply"><span class="icon-reply"></span><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
                        <?php } ?>
					</div>
	                <div class="post_info">
	                    <div class="comment_date"><span class="icon-clock"></span><?php echo dateDifference(get_comment_date('Y-m-d H:i:s')); ?> ago</div>
	                </div>

					<?php if ( $comment->comment_approved == 0 ) { ?>
	                <div class="comment_not_approved"><?php _e( 'Your comment is awaiting moderation.', 'wpspace' ); ?></div>
	                <?php } ?>

					<div class="comment_content">
						<?php 
						comment_text();
						?>
                    </div>
				</div>
            </li>
			<?php
			break;
	endswitch;
}
?>
