<?php

function wp_pagination($wp_query = NULL) {
    $pagination = array(
        'base' => add_query_arg('page', '%#%'),
        'format' => '/page/%#%',
        'total' => $wp_query->max_num_pages,
        'current' => max(1, $wp_query->query_vars['paged']),
        'show_all' => false,
        'type' => 'list',
        'prev_next' => true,
        'before_page_number' => '&nbsp;',
        'after_page_number' => '&nbsp;',
    );

    global $wp_rewrite;
    if($wp_rewrite->using_permalinks()) {
        $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%', 'paged');
    }
    if(!empty($wp_query->query_vars['s'])) {
        $pagination['add_args'] = array('s' => get_query_var('s'));
    }

    echo '<div class="wp_pagination">' . paginate_links($pagination) . '</div>';
}
