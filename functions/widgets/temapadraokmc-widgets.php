<?php

/**
 * Avatar + Texto livre
 * @author Marcus Aurélius <marcus@agenciakmc.com.br>
 */
class WidgetPadrao extends WP_Widget {

    public function __construct() {
        parent::__construct('depoimentos_widget', 'Depoimentos', array(
            'description' => 'Avatar + Texto livre',
        ));
    }

    public function widget($args, $instance) {
        echo <<<HTML
{$args['before_widget']}
    <article class="testimonial-body clearfix">
        <div class="testimonial-box">
            <div class="testimonial-content">
                <p>{$instance['texto']}</p>
            </div>
            <h5>{$instance['title']}</h5>
        </div>
        <div class="testimonial-author">
            <img width="72" height="72" src="{$instance['url']}" class="attachment-thumbnail wp-post-image" alt="{$instance['title']}">
        </div>
    </article>
{$args['after_widget']}
HTML;
    }

    public function update($new_instance, $old_instance) {
        return array_merge($old_instance, $new_instance);
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $url = isset($instance['url']) ? $instance['url'] : NULL;
        $texto = isset($instance['texto']) ? $instance['texto'] : '';

        $img = isset($url) ? '<img src="' . $url . '" alt="" style="max-width:380px;" />' : '';

        echo <<<HTML
<p>
    <label for="{$this->get_field_id('title')}">Nome:</label>
    <input type="text" id="{$this->get_field_id('title')}" class="widefat" name="{$this->get_field_name('title')}" value="{$title}">
</p>
<p>
    Imagem:
    <span style="float:right;">
        <a href="#upload" class="widgets_upload" onclick="widget_upload('{$this->get_field_id('url')}')">upload</a>
    </span>
    <br/>
    <span id="upl_{$this->get_field_id('url')}">
        {$img}
    </span>
    <input type="hidden" id="{$this->get_field_id('url')}" name="{$this->get_field_name('url')}" value="{$url}">
</p>
<p>
    <label for="{$this->get_field_id('texto')}">Depoimento:</label>
    <textarea id="{$this->get_field_id('texto')}" class="widefat" name="{$this->get_field_name('texto')}">{$texto}</textarea>
</p>
HTML;
    }

}