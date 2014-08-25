<?php

require_once 'functions/admin-custom.php';
require_once 'functions/custom-post-post_types.php';
require_once 'functions/email-config.php';
require_once 'functions/paginacao.php';
require_once 'functions/sidebars.php';
require_once 'functions/thumbnails.php';
require_once 'functions/widgets.php';

// add excerpt to pages
if(function_exists('add_post_type_support')) {
    add_post_type_support('page', array('excerpt'));
}

/**
 * Registra navs menus do tema
 */
function temapadraokmc_register_nav_menus() {
    register_nav_menus(array(
        'menu_principal' => 'Menu de Navegação',
        'menu_lateral' => 'Menu Lateral',
        'menu_inferior' => 'Menu do Rodapé',
    ));
}

add_action('after_setup_theme', 'temapadraokmc_register_nav_menus');

/**
 * Título do site
 */
function temapadraokmc_wp_title($title, $sep) {
    global $paged, $page;
    if(is_feed()) {
        return $title;
    }
    $title .= get_bloginfo('name');
    $site_description = get_bloginfo('description', 'display');
    if($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    }
    if($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'temapadraokmc'), max($paged, $page));
    }
    return $title;
}

add_filter('wp_title', 'temapadraokmc_wp_title', 10, 2);

/**
 * removendo a metatag WordPress Generator
 */
remove_action('wp_head', 'wp_generator');

/**
 * Método FTP direto
 */
define('FS_METHOD', 'direct');
