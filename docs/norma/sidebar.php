<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package norma
 */
?>

<?php 
if (get_custom_option(get_custom_option('prefix').'sidebar_position') != 'fullwidth') {
?>
        <div id="sidebar_main" class="widget_area sidebar_main" role="complementary">
            <?php do_action( 'before_sidebar' ); ?>
            <?php if ( ! dynamic_sidebar( get_custom_option(get_custom_option('prefix').'sidebar_main') ) ) { ?>
    			<?php // Put here html if user no set widgets in sidebar ?>
            <?php } // end sidebar widget area ?>
        </div>
<?php
}
?>