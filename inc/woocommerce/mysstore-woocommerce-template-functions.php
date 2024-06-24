<?php

require 'mysstore-woocommerce-functions-filtros-landing-page.php';
require 'mysstore-woocommerce-functions-landing-page.php';
require 'mysstore-woocommerce-functions-filtros.php';

/**
 * Funciones de header
 */
if (!function_exists('mysstore_cart_link')) {

    /**

     * Link de subtotal y cantidades de carrito

     */

    function mysstore_cart_link()
    {

        ?>

        <a class="carrito-compras-link" href="<?php echo esc_url(wc_get_cart_url()); ?>">

            <span class="count-items-car">

                <?php echo wp_kses_data(sprintf(_n('%d', '%d', WC()->cart->get_cart_contents_count(), 'mysecommerce'), WC()->cart->get_cart_contents_count())); ?>

            </span>

        </a>

    <?php

    }
}

if (!function_exists('mysstore_carrito_compras')) {

    /**

     * Carrito de compras

     */

    function mysstore_carrito_compras()
    {

    ?>

        <div class="car-header-sect">

            <ul id="carrito-header-web" class="carrito-compras-header">

                <li>

                    <?php mysstore_cart_link(); ?>

                </li>

                <li>

                    <?php the_widget('WC_Widget_Cart', 'title='); ?>

                </li>

            </ul>

        </div>
        </div>

    <?php

    }
}

/**
 * Funciones de pagina de inicio e-commerce
 */
if (!function_exists('mysstore_productos_nuevos')) {

    /**
     * Funcion para mostrar productos nuevos en la pagina de inicio
     */

    function mysstore_productos_nuevos()
    {

        $argsQuery = array(
            'post_type'         =>  'product',
            'post_status'       =>  'publish',
            'posts_per_page'    =>  10,
            'orderby'           =>  'date',
            'order'             =>  'DESC'
        );

        $loop = new WP_Query($argsQuery);

        if ($loop->have_posts()) {

            $args = array(
                'title'     =>  'titulo_ultimos_productos',
                'field'     =>  'cantidad_ultimos_productos',
                'products'  =>  'ultimos',
                'class'     =>  'productos-nuevos'
            );
            mysstore_inicio_ecommerce_section_open($args);
            do_action('mysstore_carrusel_products_tienda', $args);
            mysstore_inicio_ecommerce_section_close();
        }
    }
}

if (!function_exists('mysstore_add_open_div_item_product')) {

    /**

     * Etiqueta de apertura de div para producto

     */

    function mysstore_add_open_div_item_product()
    {

    ?>

        <div class="content-product">

        <?php

    }
}

if (!function_exists('mysstore_add_close_div_item_product')) {

    /**

     * Etiqueta de cierre de div para producto

     */

    function mysstore_add_close_div_item_product()
    {

        ?>

        </div>

    <?php

    }
}

if (!function_exists('mysstore_wc_custom_oferta_span')) {

    /**

     * Aviso de oferta personalizado

     */

    function mysstore_wc_custom_oferta_span($output_html, $post, $product)
    {

        $output_html = '<div class="container-onsale-span">';

        $output_html .= '<span class="onsale-span">' . esc_html('OFERTA!') . '</span>';

        $output_html .= '</div>';



        return $output_html;
    }
}

if (!function_exists('mysstore_content_item_price')) {

    function mysstore_content_item_price()
    {
        global $product;

        if (null !== get_field('tipo_producto') && get_field('tipo_producto')[0] !== 'servicio') {
            if ($product->is_on_sale() && $product->is_type('simple')) {

                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();

                $price = '<div class="regular-price-sale">';
                $price .= '<span class="regular-price"><del>' . wc_price($regular_price) . '</del></span>';
                $price .= '<span class="portj-price">' . number_format((($regular_price - $sale_price) / $regular_price) * 100, 0) . '%</span>';
                $price .= '</div>';

                $price .= '<div class="sale-price-product">';
                $price .= '<span>' . wc_price($sale_price) . '</span>';
                $price .= '</div>';
            }

            if (!$product->is_on_sale() && $product->is_type('simple')) {

                $price = '<div class="sale-price-product">';
                $price .= '<span>' . wc_price($product->get_price()) . '</span>';
                $price .= '</div>';
            }

            if (!$product->is_on_sale() && $product->is_type('variable')) {

                $int_price = 0;
                $price = '<div class="sale-price-product">';
                foreach ($product->get_available_variations() as $key => $val) {
                    $this_product = new WC_Product_Variation($val['variation_id']);
                    $this_price = intval($this_product->get_price());
                    if ($this_price > $int_price) {
                        $int_price = $this_price;
                    }
                }
                $price .= '<span>' . wc_price($int_price) . '</span>';
                $price .= '</div>';
            }

            if ($product->is_on_sale() && $product->is_type('variable')) {

                $reg_price = 0;

                foreach ($product->get_available_variations() as $key => $val) {
                    $this_product = new WC_Product_Variation($val['variation_id']);

                    if ($key == 0) {
                        $int_price = intval($this_product->get_sale_price());
                    }

                    //$reg_price = intval($this_product->get_regular_price());

                    $this_price = intval($this_product->get_sale_price());
                    $this_reg_price = intval($this_product->get_regular_price());

                    // Precio de descuento
                    if ($this_price > 0 && $this_price < $int_price) {
                        $int_price = $this_price;
                    }

                    // Precio regular
                    if ($this_reg_price > $reg_price) {
                        $reg_price = $this_reg_price;
                    }
                }

                $price = '<div class="regular-price-sale">';
                $price .= '<span class="regular-price"><del>' . wc_price($reg_price) . '</del></span>';
                $price .= '<span class="portj-price">' . number_format((($reg_price - $int_price) / $reg_price) * 100, 0) . '%</span>';
                $price .= '</div>';

                $price .= '<div class="sale-price-product">';
                $price .= '<span>' . wc_price($int_price) . '</span>';
                $price .= '</div>';
            }
            echo $price;
        }
    }
}

if (!function_exists('mysstore_wc_show_title_product_edit')) {

    /**

     * Titulo de cada producto personalizado

     */

    function mysstore_wc_show_title_product_edit()
    {

        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

        echo '<h2 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</h2>';
    }
}

if (!function_exists('mysstore_wc_on_sale_products')) {

    /**

     * Funcion para mostrar productos en descuento en la pagina de inicio

     */

    function mysstore_wc_on_sale_products($args)
    {

        $argsQuery = array(
            'post_type'         =>  'product',
            'post_status'       =>  'publish',
            'posts_per_page'    =>  10,
            'orderby'           =>  'date',
            'order'             =>  'DESC',
            'meta_query'     => array(
                'relation' => 'OR',
                array( // Productos de tipo simple
                    'key'           => '_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                ),
                array( // Productos de tipo variable
                    'key'           => '_min_variation_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                )
            )
        );

        $loop = new WP_Query($argsQuery);

        if ($loop->have_posts()) {

            $args = array(
                'title'     =>  'titulo_productos_descuento',
                'field'     =>  'cantidad_productos_descuento',
                'products'  =>  'ofertas',
                'class'     =>  'productos-oferta'
            );

            mysstore_inicio_ecommerce_section_open($args);
            do_action('mysstore_carrusel_products_tienda', $args);
            mysstore_inicio_ecommerce_section_close();
        }
    }
}

if (!function_exists('mysstore_wc_destacados_products')) {

    /**

     * Funcion para mostrar productos destacados en la paginad de inicio

     */

    function mysstore_wc_destacados_products($args)
    {
        $meta_query = WC()->query->get_meta_query();
        $tax_query   = WC()->query->get_tax_query();
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN',
        );
        $argsQuery = array(
            'post_type'         =>  'product',
            'post_status'       =>  'publish',
            'posts_per_page'    =>  10,
            'orderby'           =>  'date',
            'order'             =>  'DESC',
            'meta_query'        => $meta_query,
            'tax_query'         => $tax_query,
        );

        $loop = new WP_Query($argsQuery);

        if ($loop->have_posts()) {

            $args = array(
                'title'     =>  'titulo_productos_destacados',
                'field'     =>  'cantidad_productos_destacados',
                'products'  =>  'destacados',
                'class'     =>  'productos-destacados'
            );

            mysstore_inicio_ecommerce_section_open($args);
            do_action('mysstore_carrusel_products_tienda', $args);
            mysstore_inicio_ecommerce_section_close();
        }
    }
}

/**
 * Funcion parea fila de productos 1
 */
if (!function_exists('mysstore_wc_fila_inicio_products_1')) {
    /**
     * Funcion parea fila de productos 1
     */
    function mysstore_wc_fila_inicio_products_1()
    {

        $argsQuery = array(
            'post_type'         =>  'product',
            'post_status'       =>  'publish',
            'posts_per_page'    =>  10,
            'orderby'           =>  'date',
            'order'             =>  'DESC'
        );

        $loop = new WP_Query($argsQuery);

        if ($loop->have_posts()) {
            $args = array(
                'title'     =>  'titulo_productos_inicio_1',
                'field'     =>  '',
                'products'  =>  'fila-inicio-1',
                'class'     =>  'productos-inicio-fila-1',
                'product_cat' => 'categoria_productos_inicio_1'
            );
            mysstore_inicio_ecommerce_section_open($args);
            do_action('mysstore_carrusel_products_tienda', $args);
            mysstore_inicio_ecommerce_section_close();
        }
    }
}

/**
 * Funcion parea fila de productos 2
 */
if (!function_exists('mysstore_wc_fila_inicio_products_2')) {

    /**
     * Funcion parea fila de productos 2
     */
    function mysstore_wc_fila_inicio_products_2()
    {

        $argsQuery = array(
            'post_type'         =>  'product',
            'post_status'       =>  'publish',
            'posts_per_page'    =>  10,
            'orderby'           =>  'date',
            'order'             =>  'DESC'
        );

        $loop = new WP_Query($argsQuery);

        if ($loop->have_posts()) {
            $args = array(
                'title'     =>  'titulo_productos_inicio_2',
                'field'     =>  '',
                'products'  =>  'fila-inicio-2',
                'class'     =>  'productos-inicio-fila-2',
                'product_cat' => 'categoria_productos_inicio_2'
            );
            mysstore_inicio_ecommerce_section_open($args);
            do_action('mysstore_carrusel_products_tienda', $args);
            mysstore_inicio_ecommerce_section_close();
        }
    }
}

/**
 * Funciones para landing page
 */

if (!function_exists('mysstore_wc_productos_categoria_promocion')) {

    /**
     * Funcion para obtener productos de la categoria en promocion
     */
    function mysstore_wc_productos_categoria_promocion()
    {
    ?>
        <section class="productos-promocion-landing-page">

            <div class="titulo-section-inicio">
                <h3>
                    <?php echo get_field("titulo_productos"); ?>
                </h3>
            </div>

            <?php
            if (!function_exists('wc_get_products')) {
                return;
            }

            $paged                   = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
            $ordering                = WC()->query->get_catalog_ordering_args();
            $explodVars              = explode(' ', $ordering['orderby']);
            $ordering['orderby']     = array_shift($explodVars);
            $ordering['orderby']     = stristr($ordering['orderby'], 'price') ? 'meta_value_num' : $ordering['orderby'];
            $products_per_page       = apply_filters('loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page());
            $id_category = get_field('categoria_promocion');
            $cat_slug = gettype($id_category) == "object" ? $id_category->slug : "";

            $featured_products = wc_get_products(array(
                'meta_key'  => '_price',
                'status'    => 'publish',
                'limit'     => $products_per_page,
                'page'      => $paged,
                'paginate'  => true,
                'return'    => 'ids',
                'orderby'   => $ordering['orderby'],
                'order'     => $ordering['order'],
                'category'  => $cat_slug,
            ));

            wc_set_loop_prop('current_page', $paged);
            wc_set_loop_prop('is_paginated', wc_string_to_bool(true));
            wc_set_loop_prop('page_template', get_page_template_slug());
            wc_set_loop_prop('per_page', $products_per_page);
            wc_set_loop_prop('total', $featured_products->total);
            wc_set_loop_prop('total_pages', $featured_products->max_num_pages);

            if ($featured_products) {
                do_action('woocommerce_before_main_content');
                do_action('woocommerce_before_shop_loop');
                woocommerce_product_loop_start();

                foreach ($featured_products->products as $featured_product) {
                    $post_object = get_post($featured_product);
                    setup_postdata($GLOBALS['post'] = &$post_object);
                    wc_get_template_part('content', 'product');
                }

                wp_reset_postdata();
                woocommerce_product_loop_end();

                do_action('woocommerce_after_shop_loop');
                do_action('woocommerce_after_main_content');
            } else {
                do_action('woocommerce_no_products_found');
            }

            ?>
        </section>
    <?php
    }
}

if (!function_exists('mysstore_carrusel_products_open')) {
    /**
     * Funcion de apertura de carrusel
     */
    function mysstore_carrusel_products_open()
    {
        $class_container_carrusel = 'container-carrusel';
        $class_carrusel = 'class-carrusel-products carrusel-productos-mys';
        echo '<div class="' . $class_container_carrusel . '">';
        echo '<div class="' . $class_carrusel . '">';
    }
}

if (!function_exists('mysstore_carrusel_products_close')) {
    /**
     * Funcion de cierre de carrusel
     */
    function mysstore_carrusel_products_close()
    {
        echo '</div></div>';
    }
}

if (!function_exists('mysstore_inicio_ecommerce_section_open')) {
    /**
     * Function de apertura de seccion de productos del inicio
     */
    function mysstore_inicio_ecommerce_section_open($args)
    {
        $class_section = isset($args['class']) ? $args['class'] : "";
        $class_section .= ' ultimos-productos-mysstore section-productos-inicio-ecommerce';

        $html_content = '<section class="' . $class_section . '">';
        $html_content .= '<div class="titulo-section-inicio">';
        $html_content .= '<h3>' . get_field($args['title']) . '</h3>';
        $html_content .= '</div>';
        $html_content .= '<div class="shop-productos-mys">';
        echo $html_content;
    }
}

if (!function_exists('mysstore_inicio_ecommerce_section_close')) {
    /**
     * Function de cierre de seccion de productos del inicio
     */
    function mysstore_inicio_ecommerce_section_close()
    {
        echo '</div></section>';
    }
}

if (!function_exists('mysstore_before_product_item_product')) {

    /**
     * Apertura de item producto
     */
    function mysstore_before_product_item_product()
    { ?>
        <div class="add_class_scroll item-slider-desw item-product-mys">
            <div class="content-item-product">
            <?php
        }
    }

    if (!function_exists('mysstore_after_product_item_product')) {

        /**
         * Cierre de item producto
         */
        function mysstore_after_product_item_product()
        {
            ?>
            </div>
        </div>
    <?php
        }
    }

    if (!function_exists('mysstore_template_media_product')) {

        /**
         * Template de imagen del producto
         */
        function mysstore_template_media_product()
        {
            global $product;

    ?>
        <div class="media-product">
            <a class="product-thumbnail-link" href="<?php echo get_permalink($product->get_id()); ?>">
                <?php echo woocommerce_get_product_thumbnail() ?>
            </a>
            <div class="container-tags-product">

                <?php if ($product->is_on_sale() && ($product->is_type('simple') || $product->is_type('variable'))) {
                    echo '<div class="tag-product container-onsale-span"><span>';
                    echo esc_html('OFERTA!');
                    echo '</span></div>';
                }

                if (get_field('tipo_producto')[0] == 'normal' && $product->is_in_stock()) {
                    echo '<div class="tag-product stock-disponible"><span>';
                    echo esc_html('DISPONIBLE');
                    echo '</span></div>';
                }

                $log_nuevo = get_field("producto_nuevo");
                if (isset($log_nuevo[0]) && $log_nuevo[0] == 'Nuevo' && $product->is_in_stock() && ($product->is_type('simple') || $product->is_type('variable'))) {
                    echo '<div class="tag-product container-new-span"><span>';
                    echo esc_html('NUEVO!');
                    echo '</span></div>';
                }

                $log_importacion = get_field("en_importacion");
                if (isset($log_importacion[0]) && $log_importacion[0] == 'importacion' && ($product->is_type('simple') || $product->is_type('variable'))) {
                    echo '<div class="tag-product container-importacion"><span>';
                    echo esc_html('MUY PRONTO');
                    echo '</span></div>';
                }

                if (get_field('tipo_producto')[0] == 'normal' && !$product->is_in_stock()) {
                    echo '<div class="tag-product stock-agotado"><span>';
                    echo esc_html('AGOTADO');
                    echo '</span></div>';
                }
                ?>
            </div>
        </div>
    <?php
        }
    }

    if (!function_exists('mysstore_template_info_product')) {

        /**
         * Template de informacion del producto
         */
        function mysstore_template_info_product()
        {
            global $product; ?>
        <div class="info-product">
            <div class="sect-info-content">
                <h2 class="product-nombre-referencia">
                    <a class="product-thumbnail-link" href="<?php echo get_permalink($product->get_id()); ?>">
                        <?php echo substr($product->get_name(), 0, 55); ?>
                    </a>
                </h2>
                <?php
                if ($product->get_sku() && null !== get_field('tipo_producto') && get_field('tipo_producto')[0] == 'normal') {
                    echo '<span class="cod-referencia">';
                    echo 'REF: ' . $product->get_sku();
                    echo '</span>';
                };
                if (!isset(get_field("en_importacion")[0])) {
                ?>
                    <span class="precio-referencia">
                        <?php mysstore_content_item_price(); ?>
                    </span>
                <?php
                } ?>
            </div>
            <div class="actions-product">
                <div class="btn-add">
                    <?php
                    if (null !== get_field('tipo_producto') && get_field('tipo_producto')[0] == 'normal' && !isset(get_field("en_importacion")[0])) {
                        echo woocommerce_template_loop_add_to_cart();
                    } elseif (get_field("en_importacion")[0] = "en_importacion") {
                    ?>
                        <a href="<?php echo get_permalink(); ?>" class="button product_type_variable add_to_cart_button" rel="nofollow">M&aacute;s informaci&oacute;n</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
        }
    }

    if (!function_exists('mysstore_content_list_product_tienda')) {
        /**
         * Funcion de consulta para generar lista de productos
         */
        function mysstore_content_list_product_tienda($args_function)
        {

            $num_productos = get_field($args_function['field']);

            // Condicional para consulta a base de datos de ultimos productos
            if ($args_function['products'] == 'ultimos') :
                $args = array(
                    'post_type'         =>  'product',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  $num_productos,
                    'orderby'           =>  'date',
                    'order'             =>  'DESC'
                );
            endif;

            // Condicional para consulta a base de datos de productos en descuento
            if ($args_function['products'] == 'ofertas') :
                $args = array(
                    'post_type'         =>  'product',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  $num_productos,
                    'orderby'           =>  'date',
                    'order'             =>  'DESC',
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array( // Productos de tipo simple
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array( // Productos de tipo variable
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        )
                    )
                );
            endif;

            // Condicional para consulta a base de datos de productos destacados
            if ($args_function['products'] == 'destacados') :

                $meta_query = WC()->query->get_meta_query();
                $tax_query   = WC()->query->get_tax_query();
                $tax_query[] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
                $args = array(
                    'post_type'         =>  'product',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  $num_productos,
                    'orderby'           =>  'date',
                    'order'             =>  'DESC',
                    'meta_query'        =>  $meta_query,
                    'tax_query'         =>  $tax_query,
                );
            endif;

            if ($args_function['products'] == 'fila-inicio-1') :

                $product_cat = get_field($args_function['product_cat']);
                $meta_query = WC()->query->get_meta_query();
                $tax_query   = WC()->query->get_tax_query();
                $tax_query[] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $product_cat,
                    'operator' => 'IN',
                );
                $args = array(
                    'post_type'         =>  'product',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  10,
                    'orderby'           =>  'date',
                    'order'             =>  'DESC',
                    'meta_query'        =>  $meta_query,
                    'tax_query'         =>  $tax_query,
                );
            endif;

            if ($args_function['products'] == 'fila-inicio-2') :

                $product_cat = get_field($args_function['product_cat']);
                $meta_query = WC()->query->get_meta_query();
                $tax_query   = WC()->query->get_tax_query();
                $tax_query[] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $product_cat,
                    'operator' => 'IN',
                );
                $args = array(
                    'post_type'         =>  'product',
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  10,
                    'orderby'           =>  'date',
                    'order'             =>  'DESC',
                    'meta_query'        =>  $meta_query,
                    'tax_query'         =>  $tax_query,
                );
            endif;

            $loop = new WP_Query($args);

            if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();

                    global $product;

                    do_action('mysstore_template_item_product');

                endwhile;

            endif;

            wp_reset_postdata();
        }
    }

    /**
     * Funciones de la pagina de producto
     */

    if (!function_exists('mysstore_single_add_to_cart')) {
        /**
         * 
         */
        function mysstore_single_add_to_cart()
        {
            global $product;

            if (get_field('tipo_producto')[0] == 'normal' && !isset(get_field("en_importacion")[0])) {
                woocommerce_template_single_add_to_cart();
            }
        }
    }

    if (!function_exists('mysstore_single_product_primary_open')) {

        /**
         * 
         */
        function mysstore_single_product_primary_open()
        {
    ?>
        <div class="content-primary-product">
        <?php
        }
    }

    if (!function_exists('mysstore_single_product_primary_close')) {

        /**
         * 
         */
        function mysstore_single_product_primary_close()
        {
        ?>
        </div>
    <?php
        }
    }

    if (!function_exists('mysstore_single_product_primary_media')) {

        /**
         * 
         */
        function mysstore_single_product_primary_media()
        {
    ?>
        <div class="media-product-page">
            <div class="container-tags-product">
                <?php

                global $product;

                if ($product->is_on_sale() && ($product->is_type('simple') || $product->is_type('variable'))) {
                    echo '<div class="tag-product container-onsale-span"><span>';
                    echo esc_html('OFERTA!');
                    echo '</span></div>';
                }
                if (isset(get_field("producto_nuevo")[0]) && get_field("producto_nuevo")[0] == "Nuevo" && $product->is_in_stock() && ($product->is_type('simple') || $product->is_type('variable'))) {
                    echo '<div class="tag-product container-new-span"><span>';
                    echo esc_html('NUEVO!');
                    echo '</span></div>';
                }

                if (isset(get_field("en_importacion")[0]) && get_field("en_importacion")[0] == 'importacion' && ($product->is_type('simple') || $product->is_type('variable'))) {
                    echo '<div class="tag-product container-importacion"><span>';
                    echo esc_html('MUY PRONTO');
                    echo '</span></div>';
                }
                ?>
            </div>
            <?php woocommerce_show_product_images(); ?>
        </div>
    <?php
        }
    }

    if (!function_exists('mysstore_single_product_primary_info_open')) {

        /**
         * 
         */
        function mysstore_single_product_primary_info_open()
        {

    ?><div class="info-main-product-page">

            <?php

            global $product;

            if ($product->is_type('variable')) {
                echo '<span id="data-wc" data-productwc="' . $product->get_id() . '" style="display:none">data</span>';
            }
        }
    }

    if (!function_exists('mysstore_single_product_primary_info_close')) {

        /**
         * 
         */
        function mysstore_single_product_primary_info_close()
        {
            ?>
        </div>
        <?php
        }
    }

    if (!function_exists('mysstore_custom_get_stock_html')) {

        /**
         * 
         */
        function mysstore_custom_get_stock_html($stock)
        {
            return "";
        }
    }

    add_filter('woocommerce_get_stock_html', 'mysstore_custom_get_stock_html');

    if (!function_exists('mysstore_single_product_price')) {

        /**
         * 
         */
        function mysstore_single_product_price()
        {
            global $product;

            if (get_field('tipo_producto')[0] == 'servicio' || $product->is_type('variable')) {

                $price = apply_filters('woocommerce_empty_price_html', '', $product);
            } elseif ($product->is_on_sale() && $product->is_type('simple')) {

                $regular_price = $product->get_regular_price();

                $sale_price = is_numeric($product->get_sale_price()) ? $product->get_sale_price() : 0;

                $price = '<div class="price-product">';

                $price .= '<div class="precio-oferta">';

                $price .= '<div class="regular-price-sale">';

                $price .= '<span class="regular-price"><del>' . wc_price($regular_price) . '</del></span>';

                $price .= '<span class="portj-price">' . number_format((($regular_price - $sale_price) / $regular_price) * 100, 0) . '%</span>';

                $price .= '</div>';

                $price .= '<div class="sale-price-product">';

                $price .= wc_price($sale_price);

                $price .= '</div>';

                $price .= '</div>';

                $price .= '</div>';
            } elseif (!empty(get_field("en_importacion")) && null !== get_field("en_importacion")) {

                $price = '<div class="price-product"></div>';
            } else {

                $price = '<div class="price-product">';

                $price .= wc_price(wc_get_price_to_display($product)) . $product->get_price_suffix();

                $price .= '</div>';
            }

            echo $price;
        }
    }

    if (!function_exists('mysstore_single_product_sku')) {

        /**
         * 
         */
        function mysstore_single_product_sku()
        {
            global $product;

            if (get_field('tipo_producto')[0] == 'normal' && $product->is_type('simple')) {
                echo '<p class="product-sku">';
                echo '<span>';
                echo '<strong>Referencia:</strong> ' . $product->get_sku();
                echo '</span>';
                echo '</p>';
            }
        }
    }

    if (!function_exists('mysstore_single_product_marca')) {

        /**
         * 
         */
        function mysstore_single_product_marca()
        {
            global $product;
            $marca = get_the_terms($product->get_id(), 'marcas') ? get_the_terms($product->get_id(), 'marcas')[0] : null;

            if (!is_null($marca)) {

                echo '<p class="product-marca">';
                echo '<span>';
                echo '<strong>Marca:</strong> ';
                echo '<a href="' . get_term_link($marca->term_id, 'marcas') . '" target="_blank">' . $marca->name . '</a>';
                echo '</span>';
                echo '</p>';
            } else {
                echo '<p class="product-marca">';
                echo '</p>';
            }
        }
    }

    if (!function_exists('mysstore_single_product_stock_tag')) {
        /**
         * Funcion de stock del producto
         */
        function mysstore_single_product_stock_tag()
        {
            global $product;

            if ($product->is_type('variable')) {
                echo '<p class="product-sku"></p>';
                echo '<div class="tag-stock-product"></div>';
                echo '<div class="price-product"></div>';
            }

            if (get_field('tipo_producto')[0] == 'normal' && $product->is_type('simple') && null == get_field("en_importacion")) {

                if ($product->get_manage_stock() && $product->is_in_stock() && $product->get_stock_quantity() > 0) {

                    echo '<div class="tag-stock-product">';
                    echo '<span class="disponible">DISPONIBLE</span>';
                    echo '</div>';
                } else {
                    echo '<div class="tag-stock-product">';
                    echo '<span class="agotado">AGOTADO</span>';
                    echo '</div>';
                }
            }
        }
    }

    if (!function_exists('mysstore_single_product_import_note')) {
        /**
         * Funcion de nota sobre importacion del producto
         */
        function mysstore_single_product_import_note()
        {
            global $product;

            if (null !== get_field("en_importacion") && !empty(get_field("en_importacion"))) {

                if (get_field("en_importacion")[0] == 'importacion') {
        ?>
                <div class="nota-product">
                    <div class="info-note">
                        Por el momento este producto no est&aacute; disponible, pero llegar&aacute; muy pronto.
                    </div>
                </div>
            <?php
                }
            }
        }
    }

    if (!function_exists('mysstore_single_product_tabs')) {

        /**
         * 
         */
        function mysstore_single_product_tabs()
        {
            if (get_field('tipo_producto')[0] == 'normal') {
            ?>
            <div class="product-tabs-info">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Detalles</a></li>
                        <?php
                        if (isset(get_field("manual")['ID'])) {
                        ?> <li><a href="#tabs-2">Manuales</a></li> <?php
                                                                }
                                                                    ?>
                    </ul>
                    <div id="tabs-1">
                        <?php woocommerce_template_single_excerpt(); ?>
                    </div>
                    <?php
                    if (isset(get_field("manual")['ID'])) {
                    ?>
                        <div id="tabs-2">
                            <a href="<?php echo get_field("manual")["url"]; ?>" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                                <span class="manual">Instrucciones del producto en PDF</span>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
            }
        }
    }

    if (!function_exists('mysstore_single_summary_servicio')) {

        /**
         * 
         */
        function mysstore_single_summary_servicio()
        {
            if (get_field('tipo_producto')[0] !== 'normal') {
        ?>
            <div class="summary-servicio-section">
                <div class="tab-summary-tag">
                    <div>
                        <span>Detalles</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div class="content-summary">
                    <?php woocommerce_template_single_excerpt(); ?>
                </div>
            </div><?php
                }
            }
        }

        if (!function_exists('')) {

            /**

             * 

             */
        }
