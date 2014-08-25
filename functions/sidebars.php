<?php

$sidebar = array(
    'sidebar_home' => array(
        'name' => 'Sidebar HOME',
        'description' => 'Sidebar na Home',
    ),
);

foreach($sidebar as $key => $value) {
    register_sidebar(array(
        'id' => $key,
        'name' => __(isset($value['name']) ? $value['name'] : $value, $key),
        'description' => isset($value['description']) ? $value['description'] : '',
        'class' => isset($value['class']) ? $value['class'] : '',
        'before_widget' => isset($value['before_widget']) ? $value['before_widget'] : '',
        'after_widget' => isset($value['after_widget']) ? $value['after_widget'] : '',
        'before_title' => isset($value['before_title']) ? $value['before_title'] : '',
        'after_title' => isset($value['after_title']) ? $value['after_title'] : '',
    ));
}