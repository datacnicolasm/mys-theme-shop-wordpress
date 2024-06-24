<?php
// Scripts y Styles
function mys_scripts_styles()
{
    // Estilo general
    wp_enqueue_style('styleGeneral', get_stylesheet_directory_uri() . '/css/build/main.min.css', array(), '1.0.0');
    wp_enqueue_style('google-font', 'https://fonts.googleapis.com/css2?family=Anton&display=swap', false);
    
    // Script general
    wp_enqueue_script('hammerJS', "https://hammerjs.github.io/dist/hammer.min.js", array(), '2.0.8');
    wp_enqueue_script('scriptGeneral', get_stylesheet_directory_uri() . '/js/build/app.min.js', array('jquery', 'jquery-ui-tabs'), '1.0.0');

    wp_localize_script(
        'scriptGeneral',
        'ajax_object',
        [
            'url' => admin_url('admin-ajax.php'),
            'token' => wp_create_nonce('api_token')
        ]
    );
}
add_action('wp_enqueue_scripts', 'mys_scripts_styles');

require 'inc/mysstore-template-hooks.php';
require 'inc/woocommerce/mysstore-woocommerce-template-hooks.php';
require_once 'inc/mysstore-api-wp.php';

add_filter('big_image_size_threshold', '__return_false');

/**
 * Registro de menus adicionales
 */
register_nav_menu("nav-marcas", "Menu de marcas"); //Menu de marcas de header
register_nav_menu("nav-social", "Menu de redes sociales"); //Menu de redes sociales de footer
/**
 * Remover meta data de productos
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);