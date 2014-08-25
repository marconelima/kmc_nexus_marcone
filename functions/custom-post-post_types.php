<?php

function temapadraokmc_create_post_type() {
    register_post_type('posttypes', array(
        'labels' => array(
            'name' => 'Post Types',
            'singular_name' => 'Post Type',
            'add_new' => 'Add Novo Post Type',
            'add_new_item' => 'Adicionar Novo Post Type',
            'all_items' => 'Todos os Post Types',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-welcome-edit-page',
        'supports' => array(
            'editor',
            'excerpt',
            'title',
            'thumbnail',
        ),
        'menu_position' => 4,
    ));

    register_taxonomy('categoria', 'posttypes', array(
        'labels' => array(
            'name' => 'Categorias',
            'singular_name' => 'Categoria',
            'add_new' => 'Add Nova Categoria',
            'add_new_item' => 'Adicionar Nova Categoria',
            'all_items' => 'Todas as Categorias',
        ),
        'rewrite' => array(
            'slug' => 'categoria',
            'with_front' => true,
            'hierarchical' => true,
        ),
        'hierarchical' => true,
        'query_var' => true,
        'show_admin_column' => true,
    ));

    register_taxonomy('tag', 'posttypes', array(
        'labels' => array(
            'name' => 'Tags',
            'singular_name' => 'Tag',
            'add_new' => 'Add Nova Tag',
            'add_new_item' => 'Adicionar Nova tag',
            'all_items' => 'Todas as Tags',
        ),
        'rewrite' => array(
            'slug' => 'tag',
            'with_front' => true,
            'hierarchical' => false,
        ),
        'hierarchical' => false,
        'query_var' => true,
        'show_admin_column' => true,
    ));
}

add_action('init', 'temapadraokmc_create_post_type');

/**
 * metaboxes para os Post Types
 */
$metaboxes = array(
    'main' => array(
        'codigo' => array(
            'label' => 'Código do Produto',
            'type' => 'text',
            'style' => 'width: 50%; padding: 3px 8px; font-size: 20px;',
        ),
        'numero' => array(
            'label' => 'Número',
            'type' => 'number',
            'style' => 'width: 50%; padding: 3px 8px; font-size: 20px;',
        ),
        'descricao' => array(
            'label' => 'Descrição',
            'type' => 'textarea',
        ),
        'ativo' => array(
            'label' => 'Ativo',
            'type' => 'checkbox',
        ),
    ),
);

function temapadraokmc_metaboxes_content() {
    global $post, $metaboxes;
    $html = NULL;
    foreach($metaboxes['main'] as $key => $metabox) {
        $value = get_post_meta($post->ID, $key, true);
        if($value == "" || !isset($value)) {
            $value = isset($metabox['default']) ? $metabox['default'] : '';
        }

        $class = isset($metabox['class']) ? $metabox['class'] : '';
        $desc = isset($metabox['desc']) ? $metabox['desc'] : '';
        $style = isset($metabox['style']) ? $metabox['style'] : '';

        $input = NULL;
        switch($metabox['type']) {
            case 'checkbox':
                $checked = ($value == 'on') ? 'checked="checked "' : '';
                $input = '<input type="checkbox" id="' . $key . '" class="' . $class . '" name="' . $key . '" ' . $checked . '/>';
                break;

            case 'number':
                $input = '<input type="number" id="' . $key . '" class="' . $class . '" name="' . $key . '" value="' . $value . '" min="1" style="' . $style . '"/>';
                break;

            case 'textarea':
                $cols = isset($metabox['cols']) ? (int) $metabox['cols'] : '84';
                $rows = isset($metabox['rows']) ? (int) $metabox['rows'] : '5';
                $input = '<textarea id="' . $key . '" class="' . $class . '" name="' . $key . '" rows="' . $rows . '" cols="' . $cols . '" style="' . $style . '">' . $value . '</textarea>';
                break;

            default:
                $input = '<input type="' . $metabox['type'] . '" id="' . $key . '" class="' . $class . '" name="' . $key . '" value="' . $value . '" style="' . $style . '" />';
                break;
        }

        $html .= <<<HTML
<p>
    <label for="{$key}" style="font-weight:bold; ">{$metabox['label']}:</label> &nbsp; <small>{$desc}</small><br/>
    {$input}
</p>
HTML;
    }
    echo $html;
}

function temapadraokmc_custom_fields_boxes() {
    if(function_exists('add_meta_box')) {
        add_meta_box('posttypes-details', 'Detalhes (Metaboxes)', 'temapadraokmc_metaboxes_content', 'posttypes', 'advanced', 'high');
    }
}

add_action('admin_menu', 'temapadraokmc_custom_fields_boxes');

function temapadraokmc_custom_fields_insert($post_id) {
    global $metaboxes;
    foreach($metaboxes as $meta_cat) {
        foreach($meta_cat as $key => $metabox) {
            $metabox = NULL;
            if(isset($_POST[$key])) {
                if(get_post_meta($post_id, $key) == "") {
                    add_post_meta($post_id, $key, $_POST[$key], true);
                } elseif($_POST[$key] != get_post_meta($post_id, $key, true)) {
                    update_post_meta($post_id, $key, $_POST[$key]);
                } elseif($_POST[$key] == "") {
                    delete_post_meta($post_id, $key, get_post_meta($post_id, $key, true));
                }
            } else {
                delete_post_meta($post_id, $key, get_post_meta($post_id, $key, true));
            }
        }
    }
}

add_action('wp_insert_post', 'temapadraokmc_custom_fields_insert');
