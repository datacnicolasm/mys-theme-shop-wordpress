<?php

/**
 * Template hooks del tema relacionados con Woocommerce
 */

require 'mysstore-woocommerce-template-functions.php'; // Importacion de funciones de woocommerce

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

add_action( 'init', 'mysstore_remove_actions_storefront_woocommerce');
function mysstore_remove_actions_storefront_woocommerce() {
    remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',6 );
}

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

add_action('woocommerce_before_shop_loop_item', 'mysstore_before_product_item_product');
add_action('woocommerce_after_shop_loop_item', 'mysstore_after_product_item_product');
add_action('woocommerce_before_shop_loop_item_title', 'mysstore_template_media_product');
add_action('woocommerce_shop_loop_item_title', 'mysstore_template_info_product');

add_action( 'mysstore_header_content_ecommerce', 'mysstore_carrito_compras', 35 ); // Carrito de compras de header

add_action( 'mysstore_inicio_ecommerce', 'mysstore_productos_nuevos', 20 ); // Ultimos productos de pagina de inicio
add_action( 'mysstore_inicio_ecommerce', 'mysstore_wc_on_sale_products' , 30 ); // Productos en descuento de pagina de inicio
add_action( 'mysstore_inicio_ecommerce', 'mysstore_wc_destacados_products' , 40 ); // Productos destacados de pagina de inicio
add_action( 'mysstore_landing_page', 'mysstore_wc_productos_categoria_promocion', 20 ); // Funcion para obtener productos de categoria de promocion

/**
 * Template hooks del carrusel de productos
 */

add_action('mysstore_carrusel_products_tienda', 'mysstore_carrusel_products_open', 0); // Funcion de apertura de carrusel
add_action('mysstore_carrusel_products_tienda', 'mysstore_content_list_product_tienda', 5 ); // Funcion de lista de productos
add_action('mysstore_carrusel_products_tienda', 'mysstore_carrusel_products_close', 20); // Funcion de cierre de carrusel

/**
 * 
 */
add_action('mysstore_template_item_product', 'mysstore_before_product_item_product', 0); // F
add_action('mysstore_template_item_product', 'mysstore_template_media_product', 5); // F
add_action('mysstore_template_item_product', 'mysstore_template_info_product', 10); // F
add_action('mysstore_template_item_product', 'mysstore_after_product_item_product', 15); // F

/**
 * Template hooks de la pagina detalle del producto
 */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

add_action('woocommerce_single_product_summary', 'mysstore_single_product_tabs', 5);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_primary_open', 5);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_primary_media', 10);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_primary_info_open', 15);
add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 20);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_sku', 25);
add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_rating', 30);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_stock_tag', 35);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_import_note', 40);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_price', 50);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_add_to_cart', 55);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_summary_servicio', 60);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_primary_info_close', 65);
add_action('woocommerce_before_single_product_summary', 'mysstore_single_product_primary_close', 100);
?>