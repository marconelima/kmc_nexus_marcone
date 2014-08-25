<?php

if(function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('post', 'page', 'posttypes'));
    set_post_thumbnail_size(650, 250, true);
    add_image_size('customized', 200, 200, true);
}