<?php

/**

 * Template hooks del tema

 */



require 'mysstore-template-functions.php';

add_action( 'mysstore_header_content_ecommerce', 'mysstore_header_container_open', 10 );

//add_action( 'mysstore_header_content_ecommerce', 'mysstore_header_comercial_sect', 15 );

add_action( 'mysstore_header_content_ecommerce', 'mysstore_menu_navegacion_phone', 20);

add_action( 'mysstore_header_content_ecommerce', 'mysstore_header_logo', 25 );

add_action( 'mysstore_header_content_ecommerce', 'mystore_header_open_container_menu_cart', 30 );

add_action( 'mysstore_header_content_ecommerce', 'mysstore_header_buscador', 35 );


add_action( 'mysstore_header_content_ecommerce', 'mysstore_menu_principal_navegacion', 40 );

add_action( 'mysstore_header_content_ecommerce', 'mystore_header_close_container_menu_cart', 45 );

add_action( 'mysstore_header_content_ecommerce', 'mysstore_header_logos_marcas', 50 );

add_action( 'mysstore_header_content_ecommerce', 'mysstore_header_container_close', 55 );

/**

 * Template hooks footer del tema

 */

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_open_widget', 5 );

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_widgets', 10 );

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_close_widget', 15 );

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_menu_redes_sociales', 20 );

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_button_top', 25 );

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_politicas', 30 );

add_action( 'mysstore_footer_content_ecommerce', 'mysstore_footer_creditos', 35 );

/**

 * Template hooks de la pagina de inicio e-commerce

 */

add_action( 'mysstore_inicio_ecommerce', 'mysstore_ultimos_posts_blog', 50 ); // Funcion obtener post de blog

add_action( 'mysstore_inicio_ecommerce', 'mysstore_get_the_content_page', 60 ); // Funcion obtener contenido de pagina de editor WP

add_action( 'mysstore_inicio_ecommerce', 'mysstore_inicio_marcas_partners', 70 ); // Funcion obtener inocos de marcas

add_action( 'mysstore_inicio_ecommerce', 'mysstore_add_slider_comercial', 10 ); // Funcion obtener avisos de slider

add_action( 'mysstore_page_entradas_nav', 'mysstore_paging_nav', 10 );

/**

 * Template hooks de la plantilla de landing page

 */

add_action( 'mysstore_landing_page', 'mysstore_banner_landing_page', 20 ); // Funcion para el banner principal de la campaña

add_action( 'mysstore_landing_page', 'mysstore_banner_explorar_tienda', 30 ); // Funcion para el banner de explorar tienda

?>