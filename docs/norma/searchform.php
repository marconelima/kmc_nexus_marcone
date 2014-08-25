<?php
/**
 * The template for displaying search forms
 *
 * @package norma
 */
?>
	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="screen-reader-text"><?php _e( 'Search', 'wpspace' ); ?></label>
		<input type="search" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php _e( 'Search &hellip;', 'wpspace' ); ?>" />
		<input type="submit" class="submit" id="searchsubmit" value="<?php _e( 'Search', 'wpspace' ); ?>" />
	</form>
