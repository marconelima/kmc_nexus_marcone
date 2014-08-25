<?php

/**
 * Custom Login Page
 */
function temapadraokmc_login_logo() {
    $img = get_bloginfo('template_directory') . '/assets/img/login_logo.png';

    echo <<<HTML
<style type="text/css">
    body.login div#login h1 a {
        background-image: url({$img});
        background-size: 320px 100px;
        height: 100px;
        width: 320px;
    }
</style>
HTML;
}

add_action('login_enqueue_scripts', 'temapadraokmc_login_logo');

function temapadraokmc_login_logo_url() {
    return get_bloginfo('url');
}

add_filter('login_headerurl', 'temapadraokmc_login_logo_url');

/**
 * Custom footer information
 */
function temapadraokmc_admin_footer_text($text) {
    $text = '© <a href="http://agenciakmc.com.br/" target="_blank">Agência KMC</a> - Desenvolvimento de Websites e Soluções para Internet';
    return $text;
}

add_filter('admin_footer_text', 'temapadraokmc_admin_footer_text');
