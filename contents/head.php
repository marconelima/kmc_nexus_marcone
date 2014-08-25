<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title('|', true, 'left'); ?></title>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
<![endif]-->
<!--[if IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
<![endif]-->
<link rel="icon" type="image/png" href="<?php bloginfo('template_url') ?>/assets/img/favicon.png" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" type="text/css" media="all"/>
<?php wp_head(); ?>