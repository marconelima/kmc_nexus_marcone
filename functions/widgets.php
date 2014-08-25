<?php

function get_select_options_tags(array $options, $valueSelected = NULL, $echo = FALSE) {
    $html = '';
    foreach($options as $key => $value) {
        $selected = ($key == $valueSelected) ? 'selected="selected"' : '';
        $html .= <<<HTML
<option value="{$key}" {$selected}>{$value}</option>
HTML;
    }

    if($echo) {
        echo $html;
    } else {
        return $html;
    }
}

function temapadraokmc_widgets() {
    $widgets = array(
        'temapadraokmc-widgets' => 'WidgetPadrao',
    );

    foreach($widgets as $file => $widget) {
        require_once "widgets/{$file}.php";
        register_widget($widget);
    }
}

add_action('widgets_init', 'temapadraokmc_widgets');
