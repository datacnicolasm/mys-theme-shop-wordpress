<?php

/**

 * Template functions del tema

 */

/**

 * Funciones del header

 */

if ( ! function_exists( 'mysstore_header_container_open' ) ) {

    /**
     * Apertura de etiqueta header
     */

    function mysstore_header_container_open(){
        ?>

        <div class="header-container">

        <?php
    }
}

if ( ! function_exists( 'mysstore_header_comercial_sect' ) ) {

    /**
     * Apertura de etiqueta header
     */

    function mysstore_header_comercial_sect(){
        ?>

        <div class="header-comercial-sect">
            <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id ab, accusantium deleniti reiciendis, laudantium necessit</h4>
        </div>

        <?php
    }
}

if ( ! function_exists( 'mysstore_header_logo' ) ) {

    /**

     * Logo de la empresa en el header

     */

    function mysstore_header_logo(){

        ?>

        <div class="site-branding-shop">

            <?php echo get_custom_logo(); ?>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_header_buscador' ) ) {

	/**

	 * Buscador de productos

	 */

	function mysstore_header_buscador() {

        ?>

        <div class="container-buscador-cart">

            <div class="buscador-productos">

                <?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>

            </div>

        <?php

	}

}

if ( ! function_exists( 'mysstore_theme_get_nav' ) ) {

    function mysstore_theme_get_nav($theme_location){

        $nav_menus = get_theme_mod( 'nav_menu_locations' );

        foreach ($nav_menus as $key => $value):

            if ($key == $theme_location):

                return $value;

            endif;

        endforeach;

    }

}

if ( ! function_exists( 'mysstore_get_categories_product' ) ) {

    function mysstore_get_categories_product($id) {

        $return_cats = get_categories(array(

            'taxonomy'     => 'product_cat',

            'child_of'     => 0,

            'parent'       => $id,

            'orderby'      => 'name',

            'show_count'   => 0,

            'pad_counts'   => 0,

            'hierarchical' => 1,

            'title_li'     => "",

            'hide_empty'   => 0

        ));

        return $return_cats;

    }

}

if ( ! function_exists( 'mysstore_menu_principal_navegacion' ) ) {

    /**

     * Menu de navegación principal

     */

    function mysstore_menu_principal_navegacion(){

        ?>

            <div id='navegacion-principal' class="menu-navegacion-principal" role="navigation">

            <?php

            /* Obteniendo los items del menú */
            $terms_data_by = wp_get_nav_menu_items(get_term(mysstore_theme_get_nav('primary')));

            ?>

                <nav class="menu-menu-principal-tienda">

                    <ul id="menu-menu-principal-tienda" class="nav-menu-list-items">

            <?php

            /* Array vacio para adicionar los id de los items del menu en orden jerarquico */
            $id_items = array();

            /* Array vacio para adicionar los items completos en orden jerarquico */
            $menu_nav_items = array();

            /* Iteracion de items del menu */

            foreach ( $terms_data_by as $value ):

                $item_nav = get_object_vars($value);

                /* Validacion si el item de menu es de nivel superior */

                if( $value->menu_item_parent == "0" ):

                    /* Se agrega el id del item en el array vacio de items */

                    array_push( $id_items, $value->ID );

                    /* Se agrega en el array vacio de items el id, item, array vacio, array vacio */

                    array_push( $menu_nav_items, array( $value->ID, $item_nav, array( ), array( ) ) );

                    /* Validacion de item de menu tipo categoria woocommerce */

                    if ( $value->object == "product_cat" ):

                        /* Funcion para obtener subcategorias del item tipo categoria */

                        $cats = mysstore_get_categories_product( $value->object_id );

                        /* Si se obtuvieron subcategorias */

                        if( count($cats) > 0 ):

                            /* Buscando el index del item en el array de id's */

                            $index = array_search( $value->ID, $id_items );

                            /* Iteracion de subcategorias para incluirlas en array vacio de items de menu */

                            foreach ($cats as $category):

                                array_push($menu_nav_items[$index][3], $category);

                            endforeach;

                        endif;

                    endif;

                endif;

                if($item_nav["menu_item_parent"] !== "0"):

                    $index = array_search($item_nav["menu_item_parent"], $id_items);

                    array_push($menu_nav_items[$index][2], $item_nav);

                endif;

            endforeach;

            /* Iteracion de array construido de items del menu organizados */
            $last_key = array_key_last($menu_nav_items);
            foreach ($menu_nav_items as $index => $nav_item_menu):

                /* Variable de clase para items superiores */

                $class_parent_item = "";

                /* Condicional para para dar valor a la variable anterior */

                if(count($nav_item_menu[2]) > 0 || count($nav_item_menu[3]) > 0):

                    $class_parent_item = "menu-item-parent";

                endif;

                /* Condicional de ultimo item del menu */
                if($last_key == $index):

                    $class_parent_item .= "last-item-menu";

                endif;

                /* Condicional para items categorias woocommerce superiores */
                if(count($nav_item_menu[3]) > 0):

                    $class_parent_item .= " menu-item-parent-cat-products";

                else:

                    $class_parent_item .= " no-item-marcas";

                endif;
                ?>

                <!-- Cada item de menu aqui -->

                <li id="menu-item-<?php echo $nav_item_menu[1]["ID"]; ?>" class="menu-item <?php echo $class_parent_item; ?>">

                    <!-- Link a cada item de menu -->

                    <a href="<?php echo $nav_item_menu[1]["url"]; ?>"><?php echo $nav_item_menu[1]["title"]; ?></a>

                    <?php

                    /* Condicional de submenu */

                    if ( count($nav_item_menu[2]) > 0 ):

                        ?>

                        <!-- Submenu de item aqui -->

                        <ul class="sub-menu-item">

                            <?php

                            /* Iteracion de items del submenu */

                            foreach($nav_item_menu[2] as $sub_nav_item):

                                ?>

                                <li class="item-sub-menu">

                                    <!-- Link a item de submenu -->

                                    <a href="<?php echo $sub_nav_item["url"]; ?>"><?php echo $sub_nav_item["title"]; ?></a>

                                </li>

                                <?php

                            endforeach;

                            ?>

                        </ul>

                        <?php    

                    endif;

                    /* Condicional de submenu de categorias */

                    if ( count($nav_item_menu[3]) > 0 ):

                        /* Condicional para categorias */

                        ?>

                        <!-- Submenu de categorias -->

                        <ul class="sub-menu-item">

                            <?php

                            /* Iteracion de cada item del submenu */

                            foreach($nav_item_menu[3] as $sub_nav_item):

                                ?>

                                <li class="item-sub-menu">

                                    <?php

                                    /* Obtener link de la categoria */

                                    $cat_link = get_category_link($sub_nav_item->term_id)

                                    ?>

                                    <a href="<?php echo $cat_link; ?>"><?php echo $sub_nav_item->name; ?></a>

                                </li>

                                <?php

                            endforeach;

                            ?>

                        </ul>

                        <?php

                    endif;

                    ?>

                </li>

                <?php

            endforeach;

            ?>

                    </ul>

                </nav>

            </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_header_container_close' ) ) {

    /**

     * Cierre de etiqueta header

     */

    function mysstore_header_container_close(){

        ?>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_menu_navegacion_phone' ) ) {

    /**

     * 

     */

    function mysstore_menu_navegacion_phone(){

        ?>

        <div class="menu-navegacion-phone">

            <button class="hamburger hamburger--collapse" type="button">

                <span class="hamburger-box">

                    <span class="hamburger-inner"></span>

                </span>

            </button>

        </div>

        <div class="nav-phone-navegacion" role="navigation">

            <?php

            /* Obteniendo los items del menú */

            $terms_data_by = wp_get_nav_menu_items(get_term(mysstore_theme_get_nav('primary')));

            ?>

                <nav class="menu-menu-principal-tienda-container-phone">

                    <ul id="menu-menu-principal-tienda-phone" class="nav-menu-list-items-phone">

            <?php

            /* Array vacio para adicionar los id de los items del menu en orden jerarquico */

            $id_items = array();

            /* Array vacio para adicionar los items completos en orden jerarquico */

            $menu_nav_items = array();

            /* Iteracion de items del menu */

            foreach ( $terms_data_by as $value ):

                $item_nav = get_object_vars($value);

                /* Validacion si el item de menu es de nivel superior */

                if( $value->menu_item_parent == "0" ):

                    /* Se agrega el id del item en el array vacio de items */

                    array_push( $id_items, $value->ID );

                    /* Se agrega en el array vacio de items el id, item, array vacio */

                    array_push( $menu_nav_items, array( $value->ID, $item_nav, array( ), array( ) ) );

                    /* Validacion de item de menu tipo categoria woocommerce */

                    if ( $value->object == "product_cat" ):

                        /* Funcion para obtener subcategorias del item tipo categoria */

                        $cats = mysstore_get_categories_product( $value->object_id );

                        /* Si se obtuvieron subcategorias */

                        if( count($cats) > 0 ):

                            /* Buscando el index del item en el array de id's */

                            $index = array_search( $value->ID, $id_items );

                            /* Iteracion de subcategorias para incluirlas en array vacio de items de menu */

                            foreach ($cats as $category):

                                array_push($menu_nav_items[$index][3], $category);

                            endforeach;

                        endif;

                    endif;

                endif;

                if($item_nav["menu_item_parent"] !== "0"):

                    $index = array_search($item_nav["menu_item_parent"], $id_items);

                    array_push($menu_nav_items[$index][2], $item_nav);

                endif;

            endforeach;

            foreach ( $menu_nav_items as $item_nav ):

                if ( count($item_nav[2]) == 0 && count($item_nav[3]) == 0 ):

                    ?>

                    <li id="item-<?php echo esc_attr( $item_nav[1]["ID"] ); ?>" class="menu-item item-no-child">

                        <a href="<?php echo esc_attr( $item_nav[1]["url"] ); ?>"><?php echo esc_html( $item_nav[1]["title"] ); ?></a>

                    </li>

                    <?php

                else:

                    ?>

                    <li id="item-<?php echo esc_attr( $item_nav[1]["ID"] ); ?>" class="menu-item item-parent">

                        <div class="span-item-parent">

                            <span><?php echo esc_html( $item_nav[1]["title"] ); ?></span>

                        </div>

                        <ul class="sub-menu-item">

                            <?php

                            foreach($item_nav[2] as $sub_item):

                                ?>

                                <li id="item-<?php echo esc_attr( $sub_item["ID"] ); ?>" class="menu-item item-no-child">

                                    <a href="<?php echo esc_attr( $sub_item["url"] ); ?>"><?php echo esc_html( $sub_item["title"] ); ?></a>

                                </li>

                                <?php

                            endforeach;

                            foreach($item_nav[3] as $sub_item):

                                $cat_link = get_category_link($sub_item->term_id);

                                ?>

                                <li id="item-<?php echo esc_attr( $sub_item->term_id ); ?>" class="menu-item item-no-child">

                                    <a href="<?php echo esc_attr( $cat_link ); ?>"><?php echo esc_html( $sub_item->name ); ?></a>

                                </li>

                                <?php

                            endforeach;

                            ?>

                        </ul>

                    </li>

                    <?php

                endif;

            endforeach;

            ?>

                    </ul>

                </nav>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_header_logos_marcas' ) ) {

    /**

     * 

     */

    function mysstore_header_logos_marcas(){

        ?>

        <div class="navegacion-marcas">

            <ul>

        <?php

        $terms_data_by = wp_get_nav_menu_items(get_term(mysstore_theme_get_nav("nav-marcas")));

        /* Array vacio para adicionar los id de los items del menu en orden jerarquico */

        $id_items = array();

        /* Array vacio para adicionar los items completos en orden jerarquico */

        $menu_nav_items = array();

        /* Iteracion de items del menu */

        foreach ( $terms_data_by as $value ):

            if ( $value->object == "product_cat" ):

                /* Funcion para obtener subcategorias del item tipo categoria */

                $cats = mysstore_get_categories_product( $value->object_id );

                /* Si se obtuvieron subcategorias */

                if( count($cats) > 0 ):

                    foreach ($cats as $cat):

                        // Obtener link de la categoria

                        $cat_link = get_category_link($cat->term_id);

                        /* Obtener id de imagen de la linea */

                        $id_atch = get_term_meta($cat->term_id, 'thumbnail_id', true);

                        /* Obtener url de imagen de la linea */

                        $img = wp_get_attachment_url($id_atch);

                        ?>

                            <li id="<?php echo esc_attr( $cat->term_id ); ?>" class="item-menu-categorias-header">

                                <script>

                                    if (jQuery(window).width() >= 700){

                                        jQuery('<a href="<?php echo esc_url( $cat_link ); ?>"><img src="<?php echo $img; ?>" alt="<?php echo $cat->slug; ?>" style="height: 40px;"></a>').prependTo('li#<?php echo $cat->term_id; ?>');

                                    }

                                </script>

                                <ul class="sub-menu-item-categorias-header">

                                    <?php

                                    $sub_cats = mysstore_get_categories_product($cat->term_id);

                                    foreach($sub_cats as $sub_cat):

                                        // Obtener link de la categoria

                                        $cat_link = get_category_link( $sub_cat->term_id );

                                        /* Obtener id de imagen de la linea */

                                        $id_atch = get_term_meta( $sub_cat->term_id, 'thumbnail_id', true );

                                        /* Obtener url de imagen de la linea */

                                        $img = wp_get_attachment_url( $id_atch );

                                        ?>

                                        <li id="linea-<?php echo esc_attr( $sub_cat->term_id ); ?>">

                                            <a href="<?php echo esc_url( $cat_link ); ?>">

                                                <div class="item-menu-marcas-linea">

                                                    <div class="img-linea">

                                                        <script>

                                                            if (jQuery(window).width() >= 700){

                                                                jQuery('<img src="<?php echo $img; ?>" alt="<?php echo $sub_cat->slug; ?>">').prependTo('li#linea-<?php echo $sub_cat->term_id; ?> div.img-linea');

                                                            }

                                                        </script>

                                                    </div>

                                                    <div class="title-linea">

                                                        <span><?php echo esc_html( $sub_cat->name ) ?></span>

                                                    </div>

                                                </div>

                                            </a>

                                        </li>

                                        <?php

                                    endforeach;

                                    ?>

                                </ul>

                            </li>

                        <?php

                    endforeach;

                endif;

            endif;

        endforeach;

        ?>

                </ul>

            </div>

        <?php

    }

}

if ( ! function_exists( 'mystore_header_open_container_menu_cart' ) ) {

    /**

     * 

     */

    function mystore_header_open_container_menu_cart(){

        ?>

        <div class="container-menu-buscador">

        <?php

    }

}

if ( ! function_exists( 'mystore_header_close_container_menu_cart' ) ) {

    /**

     * 

     */

    function mystore_header_close_container_menu_cart(){

        ?>

        </div>

        <?php

    }

}

/**

 * Funciones del footer

 */

if ( ! function_exists( 'mysstore_footer_politicas' ) ) {

    /**

     * 

     */

    function mysstore_footer_politicas(){

        ?>

        <div class="terminos-legales">

            <ul>

                <li>

                    <a href="https://www.motosyservitecas.com/wp-content/uploads/2019/03/POLITICA-DE-PRIVACIDAD-MOTOS-Y-SERVITECAS.pdf" target="_blank">Política de privacidad</a>

                </li>

                <li>

                    <a href="https://www.motosyservitecas.com/wp-content/uploads/2019/03/POLITICAS-DE-COMPRA-MOTOS-Y-SERVITECAS.pdf" target="_blank">Políticas de compra</a>

                </li>

                <li>

                    <a href="https://www.motosyservitecas.com/wp-content/uploads/2019/03/TERMINOS-Y-CONDICIONES-MOTOS-Y-SERVITECAS.pdf" target="_blank">Términos y condiciones</a>

                </li>

            </ul>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_footer_creditos' ) ) {

    /**

     * 

     */

    function mysstore_footer_creditos(){

        ?>

        <div class="credits-web-copy">

            <p>© Copyright <?php echo date('Y') ?> Motos & Servitecas</p>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_footer_open_widget' ) ) {

    /**

     * 

     */

    function mysstore_footer_open_widget(){

        ?>

        <div class="footer-container-widget-social">

            <div class="widget-footer-container">

        <?php

    }

}

if ( ! function_exists( 'mysstore_footer_close_widget' ) ) {

    /**

     * 

     */

    function mysstore_footer_close_widget(){

        ?>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_footer_widgets' ) ) {

    /**

     * 

     */

    function mysstore_footer_widgets() {

		$rows    = intval( apply_filters( 'storefront_footer_widget_rows', 1 ) );

		$regions = intval( apply_filters( 'storefront_footer_widget_columns', 4 ) );



		for ( $row = 1; $row <= $rows; $row++ ) :



			// Defines the number of active columns in this footer row.

			for ( $region = $regions; 0 < $region; $region-- ) {

				if ( is_active_sidebar( 'footer-' . esc_attr( $region + $regions * ( $row - 1 ) ) ) ) {

					$columns = $region;

					break;

				}

			}



			if ( isset( $columns ) ) :

				?>

				<div class=<?php echo '"row-footer-widgets row-widget-' . esc_attr( $row ) . ' colum-' . esc_attr( $columns ) . '"'; ?>>

				<?php

				for ( $column = 1; $column <= $columns; $column++ ) :

					$footer_n = $column + $regions * ( $row - 1 );



					if ( is_active_sidebar( 'footer-' . esc_attr( $footer_n ) ) ) :

						?>

					<div class="colum-widget col-widget-<?php echo esc_attr( $column ); ?>">

						<?php dynamic_sidebar( 'footer-' . esc_attr( $footer_n ) ); ?>

					</div>

						<?php

					endif;

				endfor;

				?>

			</div><!-- .footer-widgets.row-<?php echo esc_attr( $row ); ?> -->

				<?php

				unset( $columns );

			endif;

		endfor;

	}

}

if ( ! function_exists( 'mysstore_footer_menu_redes_sociales' ) ) {

    /**

     * 

     */

    function mysstore_footer_menu_redes_sociales(){

        ?>

            <div class="footer-social-media">

                <nav class="nav-icons-social">

                    <ul>

                    <?php

                    $terms_data_by = wp_get_nav_menu_items(get_term(mysstore_theme_get_nav("nav-social")));

                    if($terms_data_by):
                        foreach( $terms_data_by as $item ):

                            ?>

                            <li class="item-menu-social">

                                <a id="<?php echo esc_attr( $item->title ); ?>" href="<?php echo esc_url( $item->url ); ?>"></a>

                            </li>

                            <?php

                        endforeach;
                    endif;
                    ?>

                    </ul>

                </nav>

            </div>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_footer_button_top' ) ) {

    /**

     * Funcion para boton top 

     */

    function mysstore_footer_button_top(){

        ?>

        <div class="button-top-page">

            <a href="#masthead">

            </a>

        </div>
        
        <div class="wht-contact">

            <div class="logo-wht">

                <a href="https://api.whatsapp.com/send?phone=573114485265&text=Hola" target="_blank">

                    <div class="img-whatsapp"></div>

                </a>

            </div>

        </div>

        <?php

    }

}

/**

 * Funciones del inicio e-commerce

 */

if ( ! function_exists( 'mysstore_inicio_marcas_partners' ) ) {

    /**

     * 

     */

    function mysstore_inicio_marcas_partners(){

        ?>
        <section class="section-partners-icons-site section-productos-inicio-ecommerce">
            <div class="titulo-section-inicio">
                <h3><?php echo wp_kses_post( "NUESTRAS MARCAS / PARTNERS" ); ?></h3>
            </div>
            
            <div class="marcas-partners-icons">   
                <ul><?php
                    $return_cats = get_terms(array(
            
                        'taxonomy'      => 'marcas',
                        'hide_empty'    => false,
            
                    ));
            
                    foreach ($return_cats as $value) {
            
                        $logo_id = get_term_meta( $value->term_id, 'marca-logo-id', true );
            
                        if ( $logo_id ) {
                            $image = wp_get_attachment_url( $logo_id );
                        } else {
                            $image = wc_placeholder_img_src();
                        }
            
                        $image = str_replace( ' ', '%20', $image );
            
                        $link = get_term_link($value->term_id, 'marcas');

                        ?>
                        <li class="item-marcas">
                            <a href="<?php echo esc_url($link); ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo $value->slug; ?>" height="150px">
                            </a>
                        </li>
                        <?php
                    }?>
                </ul>
            </div>
        </section>
        <?php
    }
}

if ( ! function_exists( 'mysstore_add_slider_comercial' ) ) {

    /**

     * 

     */

    function mysstore_add_slider_comercial(){

        ?>

            <?php

                $args = array(

                    'post_type' => 'avisos_post_type',

                    'posts_per_page' => 100,

                    'orderby' => 'title'

                );

                $avisos = new WP_Query($args);

                if($avisos):?>

                    <div class="slider shop-slider">

                    <div class="slick-prev-arrow slick-arrow" href=""><i class="fas fa-chevron-left"></i></div>

                    <?php

                    $inc = 1;

                    while($avisos->have_posts()): $avisos->the_post();

                    ?>

                    <div class="slider-item" id="aviso-<?php echo esc_attr( $inc ); ?>">

                        <?php

                            $url_aviso = get_field('enlace');

                            $id_img_aviso_phone = get_field('imagen_banner_phone'); 

                            $img_aviso_phone = wp_get_attachment_image_src($id_img_aviso_phone, 'full')[0];

                            $id_img_aviso = get_field('imagen_banner');

                            $img_aviso = wp_get_attachment_image_src($id_img_aviso, 'full')[0];

                        ?>

                        <a href="<?php echo $url_aviso; ?>">

                            <span data-sliderl="<?php echo esc_attr($img_aviso); ?>" data-sliders="<?php echo esc_attr($img_aviso_phone); ?>"></span>

                        </a>

                    </div>

                    <?php

                    $inc += 1;

                    endwhile;

                    wp_reset_postdata();

                    ?>
    
                    <div class="slick-next-arrow slick-arrow" href=""><i class="fas fa-chevron-right"></i></div>

                    </div>

                    <?php

                endif;

                ?>

        <?php

    }

}

if ( ! function_exists( 'mysstore_get_the_content_page' ) ) {

    /**

     * 

     */

    function mysstore_get_the_content_page(){

        if ( have_posts() ): 

            while ( have_posts() ): the_post();

                echo the_content();

            endwhile;

        endif;

    }

}

if ( ! function_exists( 'mysstore_ultimos_posts_blog' ) ) {

    /**

     * Funcion para obtener ultimos posts de blog

     */

    function mysstore_ultimos_posts_blog(){

        $num_posts = get_field( "cantidad_ultimos_posts" );

        $args = array(

            'posts_per_page' => $num_posts,

            'orderby' => 'date',

            'order' => 'desc'

        );

        $posts = new WP_Query($args);

        if($posts):

            ?>

            <section class="ultimos-posts-mysstore section-productos-inicio-ecommerce">

                <div class="titulo-section-inicio">

                    <h3>

                    <?php

                    $titulo = get_field( "titulo_ultimos_posts" ); 

                    echo $titulo;

                    ?>

                    </h3>

                </div>

                <div class="posts-items">

                    <ul>

                        <?php

                        while($posts->have_posts()): $posts->the_post();

                            ?>

                            <li class="add_class_scroll post-item post-<?php echo esc_attr( the_ID() ); ?> on_scroll_show">

                                <a href="<?php echo the_permalink(); ?>">

                                    <div class="content-post">

                                        <div class="img-post">

                                            <?php echo the_post_thumbnail('medium_large'); ?>

                                        </div>

                                        <div class="title-post">

                                            <h2><?php echo esc_html( the_title() ); ?></h2>

                                        </div>

                                        <div class="resumen-post">

                                            <?php echo the_excerpt(); ?>

                                        </div>

                                    </div>

                                </a>

                            </li>

                            <?php

                        endwhile;

                        ?>  

                    </ul>

                </div>

                <div class="link-page-blog">

                    <button>

                        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">VER MAS</a>

                    </button>

                </div>

            </section>

            <?php

        endif;

    }

}

if ( ! function_exists( 'mysstore_paging_nav' ) ) {

	/**

	 * Mostrar el navegador de posts.

	 */

	function mysstore_paging_nav() {

		$args = array(

			'type'      => 'list',

			'next_text' => 'Siguiente',

            'prev_text' => 'Anterior',

		);



        the_posts_pagination( $args );

	}

}

/**

 * Funciones para landing page template

 */

if ( ! function_exists( 'mysstore_banner_landing_page' ) ) {

    /**

     * Funcion para banner principal

     */

    function mysstore_banner_landing_page(){

        $img_banner_grande = gettype(wp_get_attachment_image_src( get_field( 'banner_grande' ), 'full' )) == "array" ? wp_get_attachment_image_src( get_field( 'banner_grande' ), 'full' )[0] : "";

        $img_banner_small = gettype(wp_get_attachment_image_src( get_field( 'banner_small' ), 'full' )) == "array" ? wp_get_attachment_image_src( get_field( 'banner_small' ), 'full' )[0] : "";

        ?>

        <div class="banner-page">

            <script>

                if (jQuery(window).width() >= 700){

                    jQuery( '<img src="<?php echo esc_attr( $img_banner_grande ); ?>" alt="img_banner">' ).prependTo( 'div.banner-page' );

                }else{

                    jQuery( '<img src="<?php echo esc_attr( $img_banner_small ); ?>" alt="img_banner_phone">' ).prependTo( 'div.banner-page' );

                }

            </script>

        </div>

        <?php

    }

}

if ( ! function_exists( 'mysstore_banner_explorar_tienda' ) ) {

    /**

     * Funcion para banner de explorar tienda

     */

    function mysstore_banner_explorar_tienda(){

        $img_banner_exp_grande = gettype(wp_get_attachment_image_src( get_field( 'banner_explorar_tienda_grande' ), 'full' )) == "array" ? wp_get_attachment_image_src( get_field( 'banner_explorar_tienda_grande' ), 'full' )[0] : "";

        $img_banner_exp_small = gettype(wp_get_attachment_image_src( get_field( 'banner_explorar_tienda_small' ), 'full' )) == "array" ? wp_get_attachment_image_src( get_field( 'banner_explorar_tienda_small' ), 'full' )[0] : "";

        $url_explorar_tienda = get_field( 'url_explorar_tienda' );

        ?>

        <div class="banner-explorar-tienda">

            <a href="<?php echo esc_url( $url_explorar_tienda ); ?>"></a>

            <script>

                if (jQuery(window).width() >= 700){

                    jQuery( '<img src="<?php echo esc_attr( $img_banner_exp_grande ); ?>" alt="img_banner_explorar">' ).prependTo( 'div.banner-explorar-tienda a' );

                }else{

                    jQuery( '<img src="<?php echo esc_attr( $img_banner_exp_small ); ?>" alt="img_banner_explorar_phone">' ).prependTo( 'div.banner-explorar-tienda a' );

                }

            </script>

        </div>

        <?php

    }

}

if ( ! function_exists( '' ) ) {

    /**

     * 

     */

}

?>