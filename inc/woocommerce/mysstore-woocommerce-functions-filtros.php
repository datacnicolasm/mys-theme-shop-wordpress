<?php

/**
 * Function para obtener todas las marcas de los productos sin filtros
 */
if (!function_exists('mysstore_filtro_get_marcas_producto')) {
    /**
     * Function para obtener todas las marcas de los productos sin filtros
     */
    function mysstore_filtro_get_marcas_producto($q)
    {
        // Realiza una copia de la consulta principal
        $main_query = new WP_Query($q->query_vars);
        $marcas_unicas = array();

        if ($main_query->have_posts()) {
            while ($main_query->have_posts()) {
                $main_query->the_post();

                // Obtén los términos de la taxonomía "marcas" para el producto actual
                $marcas = wp_get_post_terms(get_the_ID(), 'marcas');

                if (!empty($marcas) && !is_wp_error($marcas)) {
                    foreach ($marcas as $marca) {
                        $marcas_unicas[$marca->slug] = $marca->name;
                    }
                }
            }
        }

        // Restablecer el post data
        wp_reset_postdata();

        return $marcas_unicas;
    }
}

/**
 * Function para obtener todas las marcas de motos de los productos sin filtros
 */
if (!function_exists('mysstore_filtro_get_marcas_motos_producto')) {
    /**
     * Function para obtener todas las marcas de los productos sin filtros
     */
    function mysstore_filtro_get_marcas_motos_producto($q)
    {
        // Realiza una copia de la consulta principal
        $main_query = new WP_Query($q->query_vars);
        $marcas_unicas = array();

        if ($main_query->have_posts()) {
            while ($main_query->have_posts()) {
                $main_query->the_post();

                // Obtén los términos de la taxonomía "marcas" para el producto actual
                $marcas = wp_get_post_terms(get_the_ID(), 'marcas-moto');

                if (!empty($marcas) && !is_wp_error($marcas)) {
                    foreach ($marcas as $marca) {
                        $marcas_unicas[$marca->slug] = $marca->name;
                    }
                }
            }
        }

        // Restablecer el post data
        wp_reset_postdata();

        return $marcas_unicas;
    }
}

/**
 * Function para obtener todas las lineas de motos de los productos sin filtros
 */
if (!function_exists('mysstore_filtro_get_lineas_motos_producto')) {
    /**
     * Function para obtener todas las marcas de los productos sin filtros
     */
    function mysstore_filtro_get_lineas_motos_producto($q)
    {
        // Realiza una copia de la consulta principal
        $main_query = new WP_Query($q->query_vars);
        $marcas_unicas = array();

        if ($main_query->have_posts()) {
            while ($main_query->have_posts()) {
                $main_query->the_post();

                // Obtén los términos de la taxonomía "lineas" para el producto actual
                $marcas = wp_get_post_terms(get_the_ID(), 'lineas-moto');

                if (!empty($marcas) && !is_wp_error($marcas)) {
                    foreach ($marcas as $marca) {
                        $marcas_unicas[$marca->slug] = $marca->name;
                    }
                }
            }
        }

        // Restablecer el post data
        wp_reset_postdata();

        return $marcas_unicas;
    }
}

// Usar un hook para almacenar todas las marcas antes de que la consulta principal se ejecute
add_action('woocommerce_product_query', function ($q) {
    global $all_brands;
    $all_brands = mysstore_filtro_get_marcas_producto($q);

    global $all_brands_moto;
    $all_brands_moto = mysstore_filtro_get_marcas_motos_producto($q);

    global $all_lineas_moto;
    $all_lineas_moto = mysstore_filtro_get_lineas_motos_producto($q);
}, 1);

/**
 * Function para obtener todos los terminos de un atributo
 */
if (!function_exists('mysstore_filtro_get_atributo_producto')) {
    /**
     * Function para obtener todos los terminos de un atributo
     */
    function mysstore_filtro_get_atributo_producto($q, $taxonomy)
    {
        // Realiza una copia de la consulta principal
        $main_query = new WP_Query($q->query_vars);
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
    }
}

// Usar un hook para almacenar todas las marcas antes de que la consulta principal se ejecute
add_action('woocommerce_product_query', function ($q) {
    global $all_tallas;
    $all_tallas = mysstore_filtro_get_atributo_producto($q, 'pa_talla');
    global $all_colores;
    $all_colores = mysstore_filtro_get_atributo_producto($q, 'pa_color');
    global $all_generos;
    $all_generos = mysstore_filtro_get_atributo_producto($q, 'pa_genero');
}, 1);

/**
 * Function para obtener todas las lineas de los productos sin filtros
 */
if (!function_exists('mysstore_filtro_get_lineas_producto')) {
    /**
     * Function para obtener todas las lineas de los productos sin filtros
     */
    function mysstore_filtro_get_lineas_producto($q)
    {
        // Realiza una copia de la consulta principal
        $main_query = new WP_Query($q->query_vars);
        $lineas_unicas = array();

        if ($main_query->have_posts()) {
            while ($main_query->have_posts()) {
                $main_query->the_post();

                // Obtén los términos de la taxonomía "lineas" para el producto actual
                $lineas = wp_get_post_terms(get_the_ID(), 'lineas');

                if (!empty($lineas) && !is_wp_error($lineas)) {
                    foreach ($lineas as $linea) {
                        $lineas_unicas[$linea->slug] = $linea->name;
                    }
                }
            }
        }

        // Restablecer el post data
        wp_reset_postdata();

        return $lineas_unicas;
    }
}

// Usar un hook para almacenar todas las lineas antes de que la consulta principal se ejecute
add_action('woocommerce_product_query', function ($q) {
    global $all_lineas;
    $all_lineas = mysstore_filtro_get_lineas_producto($q);
}, 1);

/**
 * Function para obtener todas los grupos de los productos sin filtros
 */
if (!function_exists('mysstore_filtro_get_grupos_producto')) {
    /**
     * Function para obtener todas las lineas de los productos sin filtros
     */
    function mysstore_filtro_get_grupos_producto($q)
    {
        // Realiza una copia de la consulta principal
        $main_query = new WP_Query($q->query_vars);
        $grupos_unicas = array();

        if ($main_query->have_posts()) {
            while ($main_query->have_posts()) {
                $main_query->the_post();

                // Obtén los términos de la taxonomía "lineas" para el producto actual
                $grupos = wp_get_post_terms(get_the_ID(), 'grupos');

                if (!empty($grupos) && !is_wp_error($grupos)) {
                    foreach ($grupos as $grupo) {
                        $grupos_unicas[$grupo->slug] = $grupo->name;
                    }
                }
            }
        }

        // Restablecer el post data
        wp_reset_postdata();

        return $grupos_unicas;
    }
}

// Usar un hook para almacenar todas las lineas antes de que la consulta principal se ejecute
add_action('woocommerce_product_query', function ($q) {
    global $all_grupos;
    $all_grupos = mysstore_filtro_get_grupos_producto($q);
}, 1);

/**
 * Function para filtro de lineas
 */
if (!function_exists('mysstore_filtro_lineas_producto')) {
    /**
     * Function para filtro de lineas
     */
    function mysstore_filtro_lineas_producto()
    {
        global $all_lineas;

        if (!empty($all_lineas)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Linea';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_lineas as $slug => $name) {
                $checked = isset($_GET['linea']) && in_array($slug, (array) $_GET['linea']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="linea[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de marca
 */
if (!function_exists('mysstore_filtro_marcas_producto')) {
    /**
     * Function para filtro de marca
     */
    function mysstore_filtro_marcas_producto()
    {
        global $all_brands;

        if (!empty($all_brands)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Marca';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_brands as $slug => $name) {
                $checked = isset($_GET['marca']) && in_array($slug, (array) $_GET['marca']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="marca[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de marcas de moto
 */
if (!function_exists('mysstore_filtro_marcas_moto_producto')) {
    /**
     * Function para filtro de marcas de moto
     */
    function mysstore_filtro_marcas_moto_producto()
    {
        global $all_brands_moto;

        if (!empty($all_brands_moto)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por marca de moto';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_brands_moto as $slug => $name) {
                $checked = isset($_GET['marcas-moto']) && in_array($slug, (array) $_GET['marcas-moto']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="marcas-moto[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de lineas de moto
 */
if (!function_exists('mysstore_filtro_lineas_moto_producto')) {
    /**
     * Function para filtro de marca
     */
    function mysstore_filtro_lineas_moto_producto()
    {
        global $all_lineas_moto;

        if (!empty($all_lineas_moto)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Marca';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_lineas_moto as $slug => $name) {
                $checked = isset($_GET['lineas-moto']) && in_array($slug, (array) $_GET['lineas-moto']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="lineas-moto[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de precio
 */
if (!function_exists('mysstore_filtro_precios_producto')) {
    /**
     * Function para filtro de precio
     */
    function mysstore_filtro_precios_producto()
    {
        global $wp_query;

        // Iteracion para obtener valor maximo y minimo de los productos
        if (have_posts()) {
            $min_price = 0; // Inicializar con el valor máximo posible
            $max_price = 0; // Inicializar con el valor mínimo posible

            while (have_posts()) {
                the_post();
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

        ?>
        <div class="filters-item">
            Precio

            <?php
            global $is_lading_page;

            if (!isset($is_lading_page)) {
                $min_value = (isset($_GET['price-min'])) ? $_GET['price-min'] : $min_price;
                $max_value = (isset($_GET['price-max'])) ? $_GET['price-max'] : $max_price;
            }else{
                global $max_min_price;
                
                $min_value = (isset($_GET['price-min'])) ? $_GET['price-min'] : $max_min_price['min-price'];
                $max_value = (isset($_GET['price-max'])) ? $_GET['price-max'] : $max_min_price['max-price'];
            }
            ?>
            <div class="price-filter">
                <div class="price-filter-range">
                    <label for="min-price">
                        Precio Min:
                        <span id="min-price-label"> <?php echo number_format($min_value, 0, ',', '.') ?></span>
                    </label>
                    <input type="range" id="min-price" name="min-price" min="<?php echo $min_value ?>" max="<?php echo $max_value ?>" value="<?php echo $min_value ?>">
                </div>
                <div class="price-filter-range">
                    <label for="max-price">
                        Precio Max:
                        <span id="max-price-label">
                            <?php echo number_format($max_value, 0, ',', '.') ?>
                        </span>
                    </label>
                    <input type="range" id="max-price" name="max-price" min="<?php echo $min_value ?>" max="<?php echo $max_value ?>" value="<?php echo $max_value ?>">
                </div>
            </div>

        </div>
    <?php
    }
}

/**
 * Function para filtro de grupos
 */
if (!function_exists('mysstore_filtro_grupos_producto')) {
    /**
     * Function para filtro de precio
     */
    function mysstore_filtro_grupos_producto()
    {
        global $all_grupos;

        if (!empty($all_grupos)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Grupo';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_grupos as $slug => $name) {
                $checked = isset($_GET['grupo']) && in_array($slug, (array) $_GET['grupo']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="grupo[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de disponibilidad
 */
if (!function_exists('mysstore_filtro_disponibilidad_producto')) {
    /**
     * Function para filtro de disponibilidad
     */
    function mysstore_filtro_disponibilidad_producto()
    {
    ?>
        <div class="filters-item">
            Filtrar por Disponibilidad
            <div class="check-list-filter">
                <div class="check-list-items">
                    <label>
                        <input type="checkbox" id="disponible" name="disponibilidad" value="disponible">Disponible
                    </label>
                    <label>
                        <input type="checkbox" id="agotado" name="disponibilidad" value="agotado">Agotado
                    </label>
                </div>
            </div>
        </div>

    <?php
    }
}

/**
 * Function para filtro de descuento
 */
if (!function_exists('mysstore_filtro_descuento_producto')) {
    /**
     * Function para filtro de disponibilidad
     */
    function mysstore_filtro_descuento_producto()
    {
    ?>
        <div class="filters-item">
            Filtrar por Descuento
            <div class="check-list-filter">
                <div class="check-list-items">
                    <label>
                        <input type="checkbox" name="descuento" value="si">En descuento
                    </label>
                    <label>
                        <input type="checkbox" name="descuento" value="no">Sin descuento
                    </label>
                </div>
            </div>
        </div>
        <?php
    }
}

/**
 * Function para filtro de talla
 */
if (!function_exists('mysstore_filtro_talla_producto')) {
    /**
     * Function para filtro de talla
     */
    function mysstore_filtro_talla_producto()
    {
        global $all_tallas;

        if (!empty($all_tallas)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Talla';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_tallas as $slug => $name) {
                $checked = isset($_GET['tallas']) && in_array($slug, (array) $_GET['tallas']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="tallas[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de color
 */
if (!function_exists('mysstore_filtro_color_producto')) {
    /**
     * Function para filtro de color
     */
    function mysstore_filtro_color_producto()
    {
        global $all_colores;

        if (!empty($all_colores)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Color';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_colores as $slug => $name) {
                $checked = isset($_GET['colores']) && in_array($slug, (array) $_GET['colores']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="colores[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Function para filtro de genero
 */
if (!function_exists('mysstore_filtro_genero_producto')) {
    /**
     * Function para filtro de genero
     */
    function mysstore_filtro_genero_producto()
    {
        global $all_generos;

        if (!empty($all_generos)) {
            echo '<div class="filters-item">';
            echo 'Filtrar por Genero';
            echo '<div class="check-list-filter">';
            echo '<div class="check-list-items">';
            foreach ($all_generos as $slug => $name) {
                $checked = isset($_GET['generos']) && in_array($slug, (array) $_GET['generos']) ? 'checked' : '';
                echo '<label>';
                echo '<input type="checkbox" name="generos[]" value="' . esc_attr($slug) . '" ' . $checked . '>';
                echo esc_html($name);
                echo '</label>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

/**
 * Apertura de tag filtros
 */
if (!function_exists('mysstore_open_filtro_archive_product')) {

    /**
     * Apertura de tag filtros
     */
    function mysstore_open_filtro_archive_product()
    {
        global $wp_query;
        global $is_lading_page;

        if (
            (isset($is_lading_page) && $is_lading_page["is_landing_page"]) ||
            (isset($wp_query->query["product_cat"]) && $wp_query->post_count > 0 && $wp_query->queried_object->count > 0) ||
            (isset($wp_query->query["s"]) && isset($wp_query->query["post_type"]) == "product" && $wp_query->post_count > 0)
        ) { 
            ?>
            <div class="content-archive-productos">
                <div class="filtros-tienda">
                    <div class="title-filtros">
                        <p>Filtrar por</p>
                    </div>
                    <div class="content-filtros">
                        <div class="filter-container">

                            <!-- Botones para filtro -->
                            <div class="buttons-filter">
                                <button id="restore-filter">Borrar</button>
                                <button id="apply-filter">Aplicar</button>
                            </div>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de precio -->
                            <?php mysstore_filtro_precios_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de marca -->
                            <?php mysstore_filtro_marcas_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de disponibilidad -->
                            <?php mysstore_filtro_disponibilidad_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de lineas -->
                            <?php mysstore_filtro_lineas_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de descuento -->
                            <?php mysstore_filtro_descuento_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de lineas -->
                            <?php mysstore_filtro_grupos_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de tallas -->
                            <?php mysstore_filtro_talla_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de tallas -->
                            <?php mysstore_filtro_color_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de tallas -->
                            <?php mysstore_filtro_genero_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de marcas de moto -->
                            <?php mysstore_filtro_marcas_moto_producto() ?>

                            <!-- Division -->
                            <div class="sect-divisor"></div>

                            <!-- Filtro de lineas de moto -->
                            <?php mysstore_filtro_lineas_moto_producto() ?>

                        </div>
                        <?php
                        ?>
                    </div>
                </div>
            <?php
            // Restablecer el post data
            wp_reset_postdata();
        }
    }
}

/**
 * Cierre de tag filtros
 */
if (!function_exists('mysstore_close_filtro_archive_product')) {

    /**
     * Cierre de tag filtros
     */
    function mysstore_close_filtro_archive_product()
    {
        global $wp_query;

        if (
            (isset($wp_query->query["product_cat"]) && $wp_query->post_count > 0 && $wp_query->queried_object->count > 0) ||
            (isset($wp_query->query["s"]) && isset($wp_query->query["post_type"]) == "product" && $wp_query->post_count > 0)
        ) {
            echo "</div>";
        }
    }
}

/**
 * Actualizar productos variables en descuento
 */
function mysstore_get_id_variation_on_sale($query)
{
    // Realiza una copia de la consulta principal
    $main_query = new WP_Query($query->query_vars);
    // IDs de los productos
    $ids_unicas = array();
    $ids_unicas_no = array();

    if ($main_query->have_posts()) {

        while ($main_query->have_posts()) {
            $main_query->the_post();

            global $product;

            if ($product instanceof WC_Product_Variable) {

                // Obtén las variaciones del producto
                $variations = $product->get_children();

                foreach ($variations as $variation_id) {
                    // Obtén el objeto de la variación
                    $variation = wc_get_product($variation_id);
                    $sale_price = $variation->get_sale_price();

                    if ($sale_price && $sale_price > 0) {
                        $ids_unicas[$product->get_id()] = $product->get_id();
                    } else {
                        $ids_unicas_no[$product->get_id()] = $product->get_id();
                    }
                }
            }
        }
    }

    // Restablecer el post data
    wp_reset_postdata();

    foreach ($ids_unicas as $id_value) {
        $meta_key = '_wc_mys_variable_on_sale';
        $meta_value = '1';
        update_post_meta($id_value, $meta_key, $meta_value);
    }
    foreach ($ids_unicas_no as $id_value) {
        $meta_key = '_wc_mys_variable_on_sale';
        delete_post_meta($id_value, $meta_key);
    }
}

/**
 * Función para modificar la consulta principal en la plantilla de archivo de productos
 */
if (!function_exists('mysstore_modificar_consulta_principal_products')) {

    /**
     * Función para modificar la consulta principal en la plantilla de archivo de productos
     */
    function mysstore_modificar_consulta_principal_products($query)
    {
        global $wp_query;

        // Variable para contar productos de categorias
        $query_count = isset($wp_query->queried_object->count) ? $wp_query->queried_object->count : 0;

        // Verificar si la consulta es la principal y si estamos en la página de archivo de productos
        if (
            ($query->is_main_query() && isset($wp_query->queried_object) && isset($wp_query->queried_object->count) && $query_count > 0)
            ||
            ($query->is_main_query() && isset($wp_query->query["s"]) && isset($wp_query->query["post_type"]) == "product")
        ) {

            // Inicializar el meta query
            $meta_query = array();

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
                        'compare' => '>=', // Mayor o igual que
                        'type' => 'NUMERIC'
                    ),
                    array(
                        'key' => '_price',
                        'value' => $max_precio,
                        'compare' => '<=', // Menor o igual que
                        'type' => 'NUMERIC'
                    )
                );
                if (!empty($meta_query)) {
                    $query->set('meta_query', $meta_query);
                }
            }

            // Condicional para aplicar filtro de marca
            if (isset($_GET['marca']) && !empty($_GET['marca'])) {
                // Obtén las marcas de la URL y sanitiza los valores
                $marcas = array_map('sanitize_text_field', (array) $_GET['marca']);

                // Configura el tax_query para filtrar por varias marcas con lógica de 'OR'
                $tax_query = array(
                    'relation' => 'OR',
                );

                foreach ($marcas as $marca) {
                    $tax_query[] = array(
                        'taxonomy' => 'marcas',
                        'field'    => 'slug',
                        'terms'    => $marca,
                    );
                }

                // Añade la taxonomía 'marca' a la consulta
                $query->set('tax_query', $tax_query);
            }

            // Condicional para aplicar filtro de marca moto
            if (isset($_GET['marcas-moto']) && !empty($_GET['marcas-moto'])) {
                // Obtén las marcas de la URL y sanitiza los valores
                $marcas = array_map('sanitize_text_field', (array) $_GET['marcas-moto']);

                // Configura el tax_query para filtrar por varias marcas con lógica de 'OR'
                $tax_query = array(
                    'relation' => 'OR',
                );

                foreach ($marcas as $marca) {
                    $tax_query[] = array(
                        'taxonomy' => 'marcas-moto',
                        'field'    => 'slug',
                        'terms'    => $marca,
                    );
                }

                // Añade la taxonomía 'marca' a la consulta
                $query->set('tax_query', $tax_query);
            }

            // Condicional para aplicar filtro de linea moto
            if (isset($_GET['lineas-moto']) && !empty($_GET['lineas-moto'])) {
                // Obtén las marcas de la URL y sanitiza los valores
                $marcas = array_map('sanitize_text_field', (array) $_GET['lineas-moto']);

                // Configura el tax_query para filtrar por varias marcas con lógica de 'OR'
                $tax_query = array(
                    'relation' => 'OR',
                );

                foreach ($marcas as $marca) {
                    $tax_query[] = array(
                        'taxonomy' => 'lineas-moto',
                        'field'    => 'slug',
                        'terms'    => $marca,
                    );
                }

                // Añade la taxonomía 'marca' a la consulta
                $query->set('tax_query', $tax_query);
            }

            // Condicional para aplicar filtro de linea
            if (isset($_GET['linea']) && !empty($_GET['linea'])) {
                // Obtén las lineas de la URL y sanitiza los valores
                $lineas = array_map('sanitize_text_field', (array) $_GET['linea']);

                // Configura el tax_query para filtrar por varias lineas con lógica de 'OR'
                $tax_query = array(
                    'relation' => 'OR',
                );

                foreach ($lineas as $linea) {
                    $tax_query[] = array(
                        'taxonomy' => 'lineas',
                        'field'    => 'slug',
                        'terms'    => $linea,
                    );
                }

                // Añade la taxonomía 'linea' a la consulta
                $query->set('tax_query', $tax_query);
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
                if (!empty($meta_query)) {
                    $query->set('meta_query', $meta_query);
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
                    if (!empty($meta_query)) {
                        $query->set('meta_query', $meta_query);
                    }
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
                        /*'relation' => 'AND',
                        array(
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
                        ),
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => '_wc_mys_variable_on_sale',
                                'compare' => 'NOT EXISTS',
                            ),
                            array(
                                'relation' => 'AND',
                                array(
                                    'key' => '_wc_mys_variable_on_sale',
                                    'compare' => 'EXISTS',
                                ),
                                array(
                                    'key' => '_wc_mys_variable_on_sale',
                                    'value' => '1',
                                    'compare' => '!=',
                                ),
                            ),
                        ),*/
                    );
                }
            }

            // Condicional para aplicar filtro de tallas
            if (isset($_GET['tallas']) && !empty($_GET['tallas'])) {
                // Obtén las tallas de la URL y sanitiza los valores
                $tallas = array_map('sanitize_text_field', (array) $_GET['tallas']);

                $tax_query = array(
                    array(
                        'taxonomy' => 'pa_talla',
                        'field'    => 'slug',
                        'terms'    => $tallas,
                    ),
                );

                $query->set('tax_query', $tax_query);
            }

            // Condicional para aplicar filtro de colores
            if (isset($_GET['colores']) && !empty($_GET['colores'])) {
                // Obtén las tallas de la URL y sanitiza los valores
                $colores = array_map('sanitize_text_field', (array) $_GET['colores']);

                $tax_query = array(
                    array(
                        'taxonomy' => 'pa_color',
                        'field'    => 'slug',
                        'terms'    => $colores,
                    ),
                );

                $query->set('tax_query', $tax_query);
            }

            // Condicional para aplicar filtro de generos
            if (isset($_GET['generos']) && !empty($_GET['generos'])) {
                // Obtén las tallas de la URL y sanitiza los valores
                $generos = array_map('sanitize_text_field', (array) $_GET['generos']);

                $tax_query = array(
                    array(
                        'taxonomy' => 'pa_genero',
                        'field'    => 'slug',
                        'terms'    => $generos,
                    ),
                );

                $query->set('tax_query', $tax_query);
            }
        }
    }
}

/**
 * Funcion de filtro en archivo Woocommerce
 */
if (!function_exists('mysstore_filtro_archive_product')) {

    /**
     * Funcion de filtro en archivo Woocommerce
     */
    function mysstore_filtro_archive_product()
    {
        global $wp_query;

        if ((isset($wp_query->query["product_cat"]) && $wp_query->post_count > 0 && $wp_query->queried_object->count > 0) ||
            (isset($wp_query->query["s"]) && isset($wp_query->query["post_type"]) == "product" && $wp_query->post_count > 0)
        ) {
            /*
            echo "<pre>";
            var_dump($wp_query->query);
            var_dump($wp_query->post_count);
            var_dump($wp_query->queried_object->count);
            //echo var_dump($wp_query->tax_query->queries);
            echo "</pre>";
            */

            foreach (get_object_vars($wp_query) as $propiedad => $valor) {
                //echo "<pre>";
                //echo $propiedad;
                //echo "</pre>";
            }
        }
    }
}
