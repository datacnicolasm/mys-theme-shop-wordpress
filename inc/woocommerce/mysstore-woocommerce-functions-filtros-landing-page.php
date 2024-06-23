<?php

function mysstore_filtro_precios_landing_page_producto($q)
{
    // Realiza una copia de la consulta
    $main_query = new WP_Query($q);

    // Iteracion para obtener valor maximo y minimo de los productos
    if ($main_query->have_posts()) {
        $min_price = 0; // Inicializar con el valor máximo posible
        $max_price = 0; // Inicializar con el valor mínimo posible

        while ($main_query->have_posts()) {
            $main_query->the_post();
            global $product;

            if ($product instanceof WC_Product) {

                $price = floatval($product->get_price());

                if ($price < $min_price) {
                    $min_price = $price;
                }

                if ($price > $max_price) {
                    $max_price = $price;
                }
            }
        }
    }

    return array(
        "min-price" => $min_price,
        "max-price" => $max_price
    );
}

/**
 * Function para obtener todas los valores de tax
 */
function mys_filtro_get_values_tax_product($q, $name_tax)
{
    // Realiza una copia de la consulta
    $main_query = new WP_Query($q);
    $tax_unicas = array();

    if ($main_query->have_posts()) {
        while ($main_query->have_posts()) {
            $main_query->the_post();

            // Obtén los términos de la taxonomía
            $grup_tax = wp_get_post_terms(get_the_ID(), $name_tax);

            if (!empty($grup_tax) && !is_wp_error($grup_tax)) {
                foreach ($grup_tax as $value) {
                    $tax_unicas[$value->slug] = $value->name;
                }
            }
        }
    }

    return $tax_unicas;
};

/**
 * Function para obtener todos los valores de variaciones
 */
function mys_filtro_get_values_variations_product($q, $taxonomy)
{
    // Realiza una copia de la consulta
    $main_query = new WP_Query($q);
    $tax_terms = array();

    if ($main_query->have_posts()) {
        while ($main_query->have_posts()) {
            $main_query->the_post();
            $product_id = get_the_ID();

            // Obtén los términos de la taxonomía para el producto actual
            $terms = wp_get_post_terms($product_id, $taxonomy);

            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $tax_terms[$term->slug] = $term->name;
                }
            }

            // Obtener variaciones si es un producto variable
            $product = wc_get_product($product_id);
            if ($product && $product->is_type('variable')) {
                $available_variations = $product->get_available_variations();
                foreach ($available_variations as $variation) {
                    $variation_id = $variation['variation_id'];
                    $variation_terms = wp_get_post_terms($variation_id, $taxonomy);

                    if (!empty($variation_terms) && !is_wp_error($variation_terms)) {
                        foreach ($variation_terms as $term) {
                            $tax_terms[$term->slug] = $term->name;
                        }
                    }
                }
            }
        }
    }

    // Restablecer el post data
    wp_reset_postdata();

    return $tax_terms;
};

/**
 * Function para obtener todas los valores de tax de los filtros
 */
function handle_filtros_get_tax_products($q)
{
    global $is_lading_page;
    $is_lading_page = array(
        'is_landing_page' => true
    );

    global $all_grupos;
    $all_grupos = mys_filtro_get_values_tax_product($q, 'grupos');

    global $all_brands;
    $all_brands = mys_filtro_get_values_tax_product($q, 'marcas');

    global $all_lineas;
    $all_lineas = mys_filtro_get_values_tax_product($q, 'lineas');

    global $all_tallas;
    $all_tallas = mys_filtro_get_values_variations_product($q, 'pa_talla');

    global $all_colores;
    $all_colores = mys_filtro_get_values_variations_product($q, 'pa_color');

    global $all_generos;
    $all_generos = mys_filtro_get_values_variations_product($q, 'pa_genero');

    global $max_min_price;
    $max_min_price = mysstore_filtro_precios_landing_page_producto($q); 

    // Restablecer el post data
    wp_reset_postdata();

    return $q;
}


function handle_custom_query_filtros($query)
{

    // Inicializar el meta query
    $meta_query = array();

    // Inicializar el tax query
    $tax_query = array();

    // Condicional para aplicar filtro de precio
    if (isset($_GET['price-min']) && isset($_GET['price-max'])) {

        // Modificar la consulta para agregar una condición de precio
        $min_precio = $_GET['price-min'];
        $max_precio = $_GET['price-max'];

        $meta_query[] = array(
            'relation' => 'AND',
            array(
                'key' => '_price',
                'value' => $min_precio,
                'compare' => '>=',
                'type' => 'NUMERIC'
            ),
            array(
                'key' => '_price',
                'value' => $max_precio,
                'compare' => '<=',
                'type' => 'NUMERIC'
            )
        );
    }

    // Condicional para aplicar filtro de marca
    if (isset($_GET['marca']) && !empty($_GET['marca'])) {

        // Obtén las marcas de la URL y sanitiza los valores
        $marcas = array_map('sanitize_text_field', (array) $_GET['marca']);

        // Configura el tax_query para filtrar por varias marcas con lógica de 'OR'
        $tax_query[] = array(
            'relation' => 'OR',
        );

        foreach ($marcas as $marca) {
            $tax_query[] = array(
                'taxonomy' => 'marcas',
                'field'    => 'slug',
                'terms'    => $marca,
            );
        }
    }

    // Condicional para aplicar filtro de linea
    if (isset($_GET['linea']) && !empty($_GET['linea'])) {

        // Obtén las lineas de la URL y sanitiza los valores
        $lineas = array_map('sanitize_text_field', (array) $_GET['linea']);

        // Configura el tax_query para filtrar por varias lineas con lógica de 'OR'
        $tax_query[] = array(
            'relation' => 'OR',
        );

        foreach ($lineas as $linea) {
            $tax_query[] = array(
                'taxonomy' => 'lineas',
                'field'    => 'slug',
                'terms'    => $linea,
            );
        }
    }

    // Condicional para aplicar filtro de disponibilidad
    if (isset($_GET['disponibilidad']) && !empty($_GET['disponibilidad'])) {

        $disponibilidad = sanitize_text_field($_GET['disponibilidad']);

        if ($disponibilidad == 'disponible') {
            $meta_query[] = array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '=',
            );
        } elseif ($disponibilidad == 'agotado') {
            $meta_query[] = array(
                'key'     => '_stock_status',
                'value'   => 'outofstock',
                'compare' => '=',
            );
        }
    }

    // Condicional para aplicar filtro de descuento
    if (isset($_GET['descuento']) && !empty($_GET['descuento'])) {

        // Filtrar productos con descuento
        if ($_GET['descuento'] === 'si') {

            $meta_query[] = array(
                'relation' => 'OR',
                array(
                    'key'     => '_sale_price',
                    'value'   => '',
                    'compare' => '!=',
                ),
                array(
                    'key'     => '_sale_price',
                    'value'   => '0',
                    'compare' => '>',
                    'type'    => 'NUMERIC',
                ),
            );
        }

        // Filtrar productos sin descuento
        if ($_GET['descuento'] === 'no') {

            $meta_query[] = array(
                'relation' => 'OR',
                array(
                    'key'     => '_sale_price',
                    'compare' => 'NOT EXISTS',
                ),
                array(
                    'key'     => '_sale_price',
                    'value'   => '0',
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ),
            );
        }
    }

    // Condicional para aplicar filtro de tallas
    if (isset($_GET['tallas']) && !empty($_GET['tallas'])) {

        // Obtén las tallas de la URL y sanitiza los valores
        $tallas = array_map('sanitize_text_field', (array) $_GET['tallas']);

        $tax_query[] = array(
            array(
                'taxonomy' => 'pa_talla',
                'field'    => 'slug',
                'terms'    => $tallas,
            ),
        );
    }

    // Condicional para aplicar filtro de colores
    if (isset($_GET['colores']) && !empty($_GET['colores'])) {

        // Obtén las tallas de la URL y sanitiza los valores
        $colores = array_map('sanitize_text_field', (array) $_GET['colores']);

        $tax_query[] = array(
            array(
                'taxonomy' => 'pa_color',
                'field'    => 'slug',
                'terms'    => $colores,
            ),
        );
    }

    // Condicional para aplicar filtro de generos
    if (isset($_GET['generos']) && !empty($_GET['generos'])) {

        // Obtén las tallas de la URL y sanitiza los valores
        $generos = array_map('sanitize_text_field', (array) $_GET['generos']);

        $tax_query[] = array(
            array(
                'taxonomy' => 'pa_genero',
                'field'    => 'slug',
                'terms'    => $generos,
            ),
        );
    }

    // Agregar el meta query
    if (!empty($meta_query)) {
        $query['meta_query'][] = $meta_query;
    }

    // Agregar el tax query
    if (!empty($tax_query)) {
        $query['tax_query'][] = $tax_query;
    }

    return $query;
}

add_filter('woocommerce_product_data_store_cpt_get_products_query', 'handle_filtros_get_tax_products', 10);
add_filter('woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_filtros', 20);
