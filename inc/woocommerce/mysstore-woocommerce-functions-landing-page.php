<?php
add_action('wp', 'remove_category_default_functions');

function remove_category_default_functions()
{
    global $wp_query;

    $id_parent_cat = (isset($wp_query->queried_object->parent)) ? $wp_query->queried_object->parent : false;
    $type_taxonomy = (isset($wp_query->queried_object->taxonomy)) ? $wp_query->queried_object->taxonomy : false;

    if (($id_parent_cat == 818) && ($type_taxonomy == "product_cat")) {
        // Remover la descripción de la categoría
        remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
        remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);

        remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
        remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
        remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
        remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);

        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_product_subcategories', 10);
        remove_action('woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9);
        remove_action('woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31);
        remove_action('woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
        remove_action('woocommerce_before_shop_loop', 'wc_setup_loop', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

        remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
        remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 30);
        remove_action('woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9);
        remove_action('woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31);

        remove_action('storefront_before_content', 'woocommerce_breadcrumb', 10);
    }
}

function mys_store_landing_marcas_theme_open()
{

    global $wp_query;

    $id_parent_cat = (isset($wp_query->queried_object->parent)) ? $wp_query->queried_object->parent : false;
    $type_taxonomy = (isset($wp_query->queried_object->taxonomy)) ? $wp_query->queried_object->taxonomy : false;

    if (($id_parent_cat == 818) && ($type_taxonomy == "product_cat")) {
        // Etiqueta de apertura
        echo '<div class="product-category-marca-theme">';
    }
}

function mys_store_landing_marcas_theme_close()
{
    global $wp_query;

    $id_parent_cat = (isset($wp_query->queried_object->parent)) ? $wp_query->queried_object->parent : false;
    $type_taxonomy = (isset($wp_query->queried_object->taxonomy)) ? $wp_query->queried_object->taxonomy : false;

    if (($id_parent_cat == 818) && ($type_taxonomy == "product_cat")) {
        // Etiqueta de apertura
        echo '</div>';
    }
}

function mys_store_landing_marcas_theme_content()
{
    global $wp_query;

    $id_parent_cat = (isset($wp_query->queried_object->parent)) ? $wp_query->queried_object->parent : false;
    $type_taxonomy = (isset($wp_query->queried_object->taxonomy)) ? $wp_query->queried_object->taxonomy : false;

    if (($id_parent_cat == 818) && ($type_taxonomy == "product_cat")) {
        $term_obj = $wp_query->queried_object;

        $image_url = wp_get_attachment_url(get_term_meta($term_obj->term_id, 'thumbnail_id', true));
        ?>
        <!-- Header marca --->
        <section class="header-cat-marca">
            <div class="content-title-marca">
                <div class="img-logo-marca">
                    <?php echo '<img src="' . esc_url($image_url) . '" alt="Motos' . $term_obj->name . '">'; ?>
                </div>
                <div class="title-marca">
                    <?php echo '<h1 class="first">' . $term_obj->name . '</h1>'; ?>
                    <?php echo '<h1 class="second">Encuentra los mejores accesorios y repuestos para tu motocicleta</h1>'; ?>
                </div>
            </div>
            <div class="description-marca">
                <p class="description-cat">
                    <?php echo $term_obj->description ?>
                </p>
            </div>
        </section>

        <!-- Modelos destacados --->
        <?php
        $modelo_1 = (get_term_meta($term_obj->term_id, 'modelo_destacado_1', true) != "") ? get_term(get_term_meta($term_obj->term_id, 'modelo_destacado_1', true), 'product_cat') : false;
        $modelo_2 = (get_term_meta($term_obj->term_id, 'modelo_destacado_2', true) != "") ? get_term(get_term_meta($term_obj->term_id, 'modelo_destacado_2', true), 'product_cat') : false;
        $modelo_3 = (get_term_meta($term_obj->term_id, 'modelo_destacado_3', true) != "") ? get_term(get_term_meta($term_obj->term_id, 'modelo_destacado_3', true), 'product_cat') : false;

        if ($modelo_1 && $modelo_2 && $modelo_3) {
            $img_modelo_1 = wp_get_attachment_url(get_term_meta($modelo_1->term_id, 'thumbnail_id', true));
            $img_modelo_2 = wp_get_attachment_url(get_term_meta($modelo_2->term_id, 'thumbnail_id', true));
            $img_modelo_3 = wp_get_attachment_url(get_term_meta($modelo_3->term_id, 'thumbnail_id', true));
            ?>
            <section class="highlighted-models">

                <!-- Titulo de seccion --->
                <div class="title-section">
                    <i class="fas fa-bookmark"></i>
                    <h2>Modelos Destacados</h2>
                </div>

                <!-- Descripcion de modelos destacados -->
                <?php
                $desc_modelos = (get_term_meta($term_obj->term_id, 'parrafo_modelos_destacados', true) != "") ? get_term_meta($term_obj->term_id, 'parrafo_modelos_destacados', true) : false ;
                if ($desc_modelos) {
                    echo '<div class="description-marca">';
                    echo '<p class="description-cat">';
                    echo $desc_modelos;
                    echo '</p>';
                    echo '</div>';
                }
                ?>

                <!-- Listado de modelos destacados --->
                <div class="models">
                    <div class="background-item"></div>
                        <div class="articles-modelos">

                            <!-- Modelo 1 --->
                            <a href="<?php echo esc_url(get_term_link($modelo_1)) ?>" class="modelo-1 modelo-marca-moto">
                                <div class="img-modelo">
                                    <?php echo '<img src="' . esc_url($img_modelo_1) . '" alt="Motos' . $modelo_1->name . '">'; ?>
                                </div>
                                <div class="text-name-modelo">
                                    <h3><?php echo $modelo_1->name ?></h3>
                                </div>
                            </a>

                            <!-- Modelo 2 --->
                            <a href="<?php echo esc_url(get_term_link($modelo_2)) ?>" class="modelo-2 modelo-marca-moto">
                                <div class="img-modelo">
                                    <?php echo '<img src="' . esc_url($img_modelo_2) . '" alt="Motos' . $modelo_2->name . '">'; ?>
                                </div>
                                <div class="text-name-modelo">
                                    <h3><?php echo $modelo_2->name ?></h3>
                                </div>
                            </a>

                            <!-- Modelo 3 --->
                            <a href="<?php echo esc_url(get_term_link($modelo_3)) ?>" class="modelo-3 modelo-marca-moto">
                                <div class="img-modelo">
                                    <?php echo '<img src="' . esc_url($img_modelo_3) . '" alt="Motos' . $modelo_3->name . '">'; ?>
                                </div>
                                <div class="text-name-modelo">
                                    <h3><?php echo $modelo_3->name ?></h3>
                                </div>
                            </a>
                    </div>
                </div>
            </section>
        <?php
        }
        ?>

        <!-- Marcas destacdas --->
        <?php
        $marca_1 = (get_term_meta($term_obj->term_id, 'marca_destacada_1', true) != "") ? get_term_meta($term_obj->term_id, 'marca_destacada_1', true) : false;
        $marca_2 = (get_term_meta($term_obj->term_id, 'marca_destacada_2', true) != "") ? get_term_meta($term_obj->term_id, 'marca_destacada_2', true) : false;
        $marca_3 = (get_term_meta($term_obj->term_id, 'marca_destacada_3', true) != "") ? get_term_meta($term_obj->term_id, 'marca_destacada_3', true) : false;

        if ($marca_1 && $marca_2 && $marca_3) {
            $obj_marca_1 = get_term($marca_1, 'marcas');
            $obj_marca_2 = get_term($marca_2, 'marcas');
            $obj_marca_3 = get_term($marca_3, 'marcas');
            
            $id_img_marca_1 = wp_get_attachment_url(get_term_meta($marca_1, 'fondo_marca', true));
            $id_img_marca_2 = wp_get_attachment_url(get_term_meta($marca_2, 'fondo_marca', true));
            $id_img_marca_3 = wp_get_attachment_url(get_term_meta($marca_3, 'fondo_marca', true));

            $id_logo_marca_1 = wp_get_attachment_url(get_term_meta($marca_1, 'marca-logo-id', true));
            $id_logo_marca_2 = wp_get_attachment_url(get_term_meta($marca_2, 'marca-logo-id', true));
            $id_logo_marca_3 = wp_get_attachment_url(get_term_meta($marca_3, 'marca-logo-id', true));

            ?>
            <section class="marcas-destacadas">

                <!-- Titulo de seccion --->
                <div class="title-section">
                    <i class="fas fa-bookmark"></i>
                    <h2>Marcas Destacadas</h2>
                </div>

                <!-- Descripcion de marcas destacdas -->
                <?php
                $desc_marcas = (get_term_meta($term_obj->term_id, 'parrafo_marcas_destacadas', true) != "") ? get_term_meta($term_obj->term_id, 'parrafo_marcas_destacadas', true) : false ;
                if ($desc_marcas) {
                    echo '<div class="description-marca">';
                    echo '<p class="description-cat">';
                    echo $desc_marcas;
                    echo '</p>';
                    echo '</div>';
                }
                ?>

                <!-- Listado de marcas destacdas --->
                <div class="marcas">
                    <a href="<?php echo esc_url(get_term_link($obj_marca_1)) ?>" class="marca-1 marca-producto-moto">
                        <div class="img-back-marca">
                            <img src="<?php echo esc_url($id_img_marca_1) ?>" alt="<?php echo esc_attr($obj_marca_1->name) ?>">
                        </div>
                        <div class="img-logo-marca">
                            <img src="<?php echo esc_url($id_logo_marca_1) ?>" alt="<?php echo esc_attr($obj_marca_1->name) ?>">
                        </div>
                    </a>
                    <a href="<?php echo esc_url(get_term_link($obj_marca_2)) ?>" class="marca-2 marca-producto-moto">
                        <div class="img-back-marca">
                            <img src="<?php echo esc_url($id_img_marca_2) ?>" alt="<?php echo esc_attr($obj_marca_2->name) ?>">
                        </div>
                        <div class="img-logo-marca">
                            <img src="<?php echo esc_url($id_logo_marca_2) ?>" alt="<?php echo esc_attr($obj_marca_2->name) ?>">
                        </div>
                    </a>
                    <a href="<?php echo esc_url(get_term_link($obj_marca_3)) ?>" class="marca-3 marca-producto-moto">
                        <div class="img-back-marca">
                            <img src="<?php echo esc_url($id_img_marca_3) ?>" alt="<?php echo esc_attr($obj_marca_3->name) ?>">
                        </div>
                        <div class="img-logo-marca">
                            <img src="<?php echo esc_url($id_logo_marca_3) ?>" alt="<?php echo esc_attr($obj_marca_3->name) ?>">
                        </div>
                    </a>
                </div>
            </section>
            <?php
        }
        ?>

        <!-- Todos los modelos --->
        <section class="otros-modelos">
            <!-- Titulo de seccion --->
            <div class="title-section">
                <i class="fas fa-bookmark"></i>
                <h2>Todos los modelos</h2>
            </div>

            <!-- Descripcion de todos los modelos -->
            <?php
            $desc_all_modelos = (get_term_meta($term_obj->term_id, 'parrafo_todos_los_modelos', true) != "") ? get_term_meta($term_obj->term_id, 'parrafo_todos_los_modelos', true) : false ;
            if ($desc_all_modelos) {
                echo '<div class="description-marca">';
                echo '<p class="description-cat">';
                echo $desc_all_modelos;
                echo '</p>';
                echo '</div>';
            }
            ?>

            <!-- Todos los modelos --->
            <div class="all-models">
                <?php
    
                $args = array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => false,
                    'parent'     => $term_obj->term_id
                );

                $subcategories = get_terms($args);

                if (!is_wp_error($subcategories) && !empty($subcategories)) {
                    
                    foreach ($subcategories as $subcategory) {
                        
                        echo '<a href="';
                        echo esc_url(get_term_link($subcategory));
                        echo '" class="model-' . $subcategory->term_id . ' model-moto-page-marcas">';
                        echo '<div class="img-modelo-marca">';
                        echo '<img src="'.wp_get_attachment_url(get_term_meta($subcategory->term_id, 'thumbnail_id', true)).'" alt="'.$subcategory->name.'">';
                        echo '</div>';
                        echo '<div class="name-modelo-marca">';
                        echo '<h3>'.$subcategory->name.'</h3>';
                        echo '</div>';
                        echo '</a>';

                    }
                }
                ?>
            </div>
        </section>
        <?php
    }
}

add_action('woocommerce_before_main_content', 'mys_store_landing_marcas_theme_open', 50);

add_action('woocommerce_before_shop_loop', 'mys_store_landing_marcas_theme_content', 10);

add_action('woocommerce_after_main_content', 'mys_store_landing_marcas_theme_close', 50);
