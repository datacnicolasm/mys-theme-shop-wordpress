<?php
// Scripts y Styles
function mys_scripts_styles()
{
    // Estilo general
    wp_enqueue_style('styleGeneral', get_stylesheet_directory_uri() . '/css/build/main.min.css', array(), '1.0.0');
    
    // Script general
    wp_enqueue_script('hammerJS', "https://hammerjs.github.io/dist/hammer.min.js", array(), '2.0.8');
    wp_enqueue_script('scriptGeneral', get_stylesheet_directory_uri() . '/js/build/app.min.js', array('jquery', 'jquery-ui-tabs'), '1.0.0');
}
add_action('wp_enqueue_scripts', 'mys_scripts_styles');

require 'inc/mysstore-template-hooks.php';
require 'inc/woocommerce/mysstore-woocommerce-template-hooks.php';
/**
 * Clases de widgets
 */
add_filter('big_image_size_threshold', '__return_false');
class info_contacto_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'contacto_footer_widget',
            // widget name
            __('CONTACTO', ' mysecommerce'),
            // widget description
            array(
                'description' => __('Información de contacto y ubicacion de la serviteca.', 'mysecommerce'),
                'classname'   => 'contacto_footer_widget',
            )
        );
    }
    public function widget($args, $instance)
    {
        $direccion  = apply_filters('widget_text',  empty($instance['mys_woo_direccion']) ? '' : $instance['mys_woo_direccion'],  $instance);
        $telefono1 = apply_filters('widget_text',  empty($instance['mys_woo_telefono1']) ? '' : $instance['mys_woo_telefono1'],  $instance);
        $telefono2 = apply_filters('widget_text',  empty($instance['mys_woo_telefono2']) ? '' : $instance['mys_woo_telefono2'],  $instance);
        $email = apply_filters('widget_text',  empty($instance['mys_woo_email']) ? '' : $instance['mys_woo_email'],  $instance);
        $title = apply_filters('widget_title', $args['widget_name'], $args);
        // Before widget tag
        echo $args['before_widget'];
        // Widget
?>
        <div class="comp-footer">
            <div class="ext title-footer">
                <p><?php echo $title ?></p>
            </div>
            <div class="ext">
                <div class="space"></div>
            </div>
        </div>
    <?php
        // After widget tag
        echo $args['after_widget'];
    }
    public function form($instance)
    {
        // Valores por defecto
        $instance = wp_parse_args((array) $instance, array(
            'demowp_demo_title' => '',
            'mys_woo_direccion' => '',
            'mys_woo_telefono1' => '',
            'mys_woo_telefono2' => '',
            'mys_woo_email' => '',
        ));

        // Si existen datos en la bsae de datos los recogemos para mostrarlos
        $mys_woo_direccion = !empty($instance['mys_woo_direccion']) ? $instance['mys_woo_direccion'] : '';
        $mys_woo_telefono1 = !empty($instance['mys_woo_telefono1']) ? $instance['mys_woo_telefono1'] : '';
        $mys_woo_telefono2 = !empty($instance['mys_woo_telefono2']) ? $instance['mys_woo_telefono2'] : '';
        $mys_woo_email = !empty($instance['mys_woo_email']) ? $instance['mys_woo_email'] : '';

        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_direccion') . '" class="demowp_campotexto_label">' . __('Dirección', 'mysecommerce') . '</label>';
        echo ' <input type="text" id="' . $this->get_field_id('mys_woo_direccion') . '" name="' . $this->get_field_name('mys_woo_direccion') . '" class="widefat" placeholder="' . esc_attr__('Dirección', 'mysecommerce') . '" value="' . esc_attr($mys_woo_direccion) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_telefono1') . '" class="demowp_campotexto_label">' . __('Telefono 1', 'mysecommerce') . '</label>';
        echo ' <input type="text" id="' . $this->get_field_id('mys_woo_telefono1') . '" name="' . $this->get_field_name('mys_woo_telefono1') . '" class="widefat" placeholder="' . esc_attr__('Telefono 1', 'mysecommerce') . '" value="' . esc_attr($mys_woo_telefono1) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_telefono2') . '" class="demowp_campotexto_label">' . __('Telefono 2', 'mysecommerce') . '</label>';
        echo ' <input type="text" id="' . $this->get_field_id('mys_woo_telefono2') . '" name="' . $this->get_field_name('mys_woo_telefono2') . '" class="widefat" placeholder="' . esc_attr__('Telefono 2', 'mysecommerce') . '" value="' . esc_attr($mys_woo_telefono2) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_email') . '" class="demowp_campotexto_label">' . __('Email', 'mysecommerce') . '</label>';
        echo ' <input type="text" id="' . $this->get_field_id('mys_woo_email') . '" name="' . $this->get_field_name('mys_woo_email') . '" class="widefat" placeholder="' . esc_attr__('Email', 'mysecommerce') . '" value="' . esc_attr($mys_woo_email) . '">';
        echo '</p>';
    }
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['mys_woo_direccion'] = !empty($new_instance['mys_woo_direccion']) ? strip_tags($new_instance['mys_woo_direccion']) : '';
        $instance['mys_woo_telefono1'] = !empty($new_instance['mys_woo_telefono1']) ? strip_tags($new_instance['mys_woo_telefono1']) : '';
        $instance['mys_woo_telefono2'] = !empty($new_instance['mys_woo_telefono2']) ? strip_tags($new_instance['mys_woo_telefono2']) : '';
        $instance['mys_woo_email'] = !empty($new_instance['mys_woo_email']) ? strip_tags($new_instance['mys_woo_email']) : '';
        return $instance;
    }
};
class button_place_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'button_place_widget',
            // widget name
            __('BOTONES UBICACION', ' mysecommerce'),
            // widget description
            array(
                'description' => __('Botones para ubicar en aplicaciones la serviteca.', 'mysecommerce'),
                'classname'   => 'button_place_widget',
            )
        );
    }
    public function widget($args, $instance)
    {
        $url_waze = apply_filters('widget_text',  empty($instance['mys_woo_waze']) ? '' : $instance['mys_woo_waze'],  $instance);
        $url_maps = apply_filters('widget_text',  empty($instance['mys_woo_google_maps']) ? '' : $instance['mys_woo_google_maps'],  $instance);
    ?>
        <a href="<?php echo $url_waze ?>" class="logo-ubicacion logo-waze" target="_blank">
        </a>
        <a href="<?php echo $url_maps ?>" class="logo-ubicacion logo-maps" target="_blank">
        </a>
    <?php
    }
    public function form($instance)
    {
        //Creando variables
        $instance = wp_parse_args((array) $instance, array(
            'mys_woo_waze' => '',
            'mys_woo_google_maps' => '',
        ));
        //Mostrando valores de base de datos
        $mys_woo_waze = !empty($instance['mys_woo_waze']) ? $instance['mys_woo_waze'] : '';
        $mys_woo_google_maps = !empty($instance['mys_woo_google_maps']) ? $instance['mys_woo_google_maps'] : '';
        //Como se mostrara en el wordpress admin
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_waze') . '" class="demowp_campotexto_label">' . __('URL botón WAZE', 'mysecommerce') . '</label>';
        echo '<input type="url" id="' . $this->get_field_id('mys_woo_waze') . '" name="' . $this->get_field_name('mys_woo_waze') . '" class="widefat" placeholder="' . esc_attr__('URL', 'mysecommerce') . '" value="' . esc_attr($mys_woo_waze) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_google_maps') . '" class="demowp_campotexto_label">' . __('URL botón GOOGLE MAPS', 'mysecommerce') . '</label>';
        echo '<input type="url" id="' . $this->get_field_id('mys_woo_google_maps') . '" name="' . $this->get_field_name('mys_woo_google_maps') . '" class="widefat" placeholder="' . esc_attr__('URL', 'mysecommerce') . '" value="' . esc_attr($mys_woo_google_maps) . '">';
        echo '</p>';
    }
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['mys_woo_waze'] = !empty($new_instance['mys_woo_waze']) ? strip_tags($new_instance['mys_woo_waze']) : '';
        $instance['mys_woo_google_maps'] = !empty($new_instance['mys_woo_google_maps']) ? strip_tags($new_instance['mys_woo_google_maps']) : '';
        return $instance;
    }
};
class horarios_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'horarios_widget',
            // widget name
            __('HORARIO DE ATENCIÓN', ' mysecommerce'),
            // widget description
            array(
                'description' => __('Horarios de atencion de la serviteca.', 'mysecommerce'),
                'classname'   => 'horarios_widget',
            )
        );
    }
    public function widget($args, $instance)
    {
        $horarioDias1 = apply_filters('widget_text',  empty($instance['mys_woo_horarios_dias_1']) ? '' : $instance['mys_woo_horarios_dias_1'],  $instance);
        $horarioHoras1 = apply_filters('widget_text',  empty($instance['mys_woo_horarios_horas_1']) ? '' : $instance['mys_woo_horarios_horas_1'],  $instance);
        $horarioDias2 = apply_filters('widget_text',  empty($instance['mys_woo_horarios_dias_2']) ? '' : $instance['mys_woo_horarios_dias_2'],  $instance);
        $horarioHoras2 = apply_filters('widget_text',  empty($instance['mys_woo_horarios_horas_2']) ? '' : $instance['mys_woo_horarios_horas_2'],  $instance);
        $title = apply_filters('widget_title', $args['widget_name'], $args);
    ?>
        <div class="comp-footer widget">
            <div class="ext title-footer">
                <p><?php echo $title ?></p>
            </div>
            <div class="ext">
                <div class="space"></div>
            </div>
        </div>
    <?php
    }
    public function form($instance)
    {
        //Creando variables
        $instance = wp_parse_args((array) $instance, array(
            'mys_woo_horarios_dias_1' => '',
            'mys_woo_horarios_horas_1' => '',
            'mys_woo_horarios_dias_2' => '',
            'mys_woo_horarios_horas_2' => '',
        ));
        //Mostrando valores de base de datos
        $mys_woo_horarios_dias_1 = !empty($instance['mys_woo_horarios_dias_1']) ? $instance['mys_woo_horarios_dias_1'] : '';
        $mys_woo_horarios_horas_1 = !empty($instance['mys_woo_horarios_horas_1']) ? $instance['mys_woo_horarios_horas_1'] : '';
        $mys_woo_horarios_dias_2 = !empty($instance['mys_woo_horarios_dias_2']) ? $instance['mys_woo_horarios_dias_2'] : '';
        $mys_woo_horarios_horas_2 = !empty($instance['mys_woo_horarios_horas_2']) ? $instance['mys_woo_horarios_horas_2'] : '';
        //Como se mostrara en el wordpress admin
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_horarios_dias_1') . '" class="demowp_campotexto_label">' . __('Días de horario 1', 'mysecommerce') . '</label>';
        echo '<input type="text" id="' . $this->get_field_id('mys_woo_horarios_dias_1') . '" name="' . $this->get_field_name('mys_woo_horarios_dias_1') . '" class="widefat" placeholder="' . esc_attr__('Días de horario 1', 'mysecommerce') . '" value="' . esc_attr($mys_woo_horarios_dias_1) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_horarios_horas_1') . '" class="demowp_campotexto_label">' . __('Horas de horario 1', 'mysecommerce') . '</label>';
        echo '<input type="text" id="' . $this->get_field_id('mys_woo_horarios_horas_1') . '" name="' . $this->get_field_name('mys_woo_horarios_horas_1') . '" class="widefat" placeholder="' . esc_attr__('Días de horario 1', 'mysecommerce') . '" value="' . esc_attr($mys_woo_horarios_horas_1) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_horarios_dias_2') . '" class="demowp_campotexto_label">' . __('Días de horario 2', 'mysecommerce') . '</label>';
        echo '<input type="text" id="' . $this->get_field_id('mys_woo_horarios_dias_2') . '" name="' . $this->get_field_name('mys_woo_horarios_dias_2') . '" class="widefat" placeholder="' . esc_attr__('Días de horario 1', 'mysecommerce') . '" value="' . esc_attr($mys_woo_horarios_dias_2) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_horarios_horas_2') . '" class="demowp_campotexto_label">' . __('Días de horario 2', 'mysecommerce') . '</label>';
        echo '<input type="text" id="' . $this->get_field_id('mys_woo_horarios_horas_2') . '" name="' . $this->get_field_name('mys_woo_horarios_horas_2') . '" class="widefat" placeholder="' . esc_attr__('Horas de horario 1', 'mysecommerce') . '" value="' . esc_attr($mys_woo_horarios_horas_2) . '">';
        echo '</p>';
    }
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['mys_woo_horarios_dias_1'] = !empty($new_instance['mys_woo_horarios_dias_1']) ? strip_tags($new_instance['mys_woo_horarios_dias_1']) : '';
        $instance['mys_woo_horarios_horas_1'] = !empty($new_instance['mys_woo_horarios_horas_1']) ? strip_tags($new_instance['mys_woo_horarios_horas_1']) : '';
        $instance['mys_woo_horarios_dias_2'] = !empty($new_instance['mys_woo_horarios_dias_2']) ? strip_tags($new_instance['mys_woo_horarios_dias_2']) : '';
        $instance['mys_woo_horarios_horas_2'] = !empty($new_instance['mys_woo_horarios_horas_2']) ? strip_tags($new_instance['mys_woo_horarios_horas_2']) : '';
        return $instance;
    }
};
class medios_pago_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'medios_pago_widget',
            // widget name
            __('MEDIOS DE PAGO', ' mysecommerce'),
            // widget description
            array(
                'description' => __('Medios de pago aceptados en la serviteca.', 'mysecommerce'),
                'classname'   => 'medios_pago_widget',
            )
        );
    }
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $args['widget_name'], $args);
    ?>
        <div class="comp-footer">
            <div class="ext title-footer">
                <p><?php echo $title ?></p>
            </div>
            <div class="ext">
                <div class="space"></div>
            </div>
            <div class="content-footer pay">
                <br>
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <div><span id="siteseal">
                        <script async="" type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=8Zq67tFvEXNSGczdL64AAVHLTOFhpLqNFY7QVkMvo5wmYNJbYnAFvsqKdQzB"></script>
                    </span></div>
            </div>
        </div>
    <?php
    }
    public function form($instance)
    {
        //Como se mostrara en el wordpress admin
        echo '<p>' . __('No es mosible modificar esta seccion', 'mysecommerce') . '</p>';
    }
};
class catalogos_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'catalogos_widget',
            // widget name
            __('CATÁLOGO', ' mysecommerce'),
            // widget description
            array(
                'description' => __('Catalogos de otras marcas.', 'mysecommerce'),
                'classname'   => 'catalogos_widget',
            )
        );
    }
    public function widget($args, $instance)
    {
        $url_cat_hepco = apply_filters('widget_text',  empty($instance['mys_woo_url_hepco']) ? '' : $instance['mys_woo_url_hepco'],  $instance);
        $url_cat_wunderlich1 = apply_filters('widget_text',  empty($instance['mys_woo_url_wunderlich1']) ? '' : $instance['mys_woo_url_wunderlich1'],  $instance);
        $url_cat_wunderlich2 = apply_filters('widget_text',  empty($instance['mys_woo_url_wunderlich2']) ? '' : $instance['mys_woo_url_wunderlich2'],  $instance);
        $title = apply_filters('widget_title', $args['widget_name'], $args);
    ?>
        <div class="comp-footer">
            <div class="ext title-footer">
                <p><?php echo $title ?></p>
            </div>
            <div class="ext">
                <div class="space"></div>
            </div>
            <div class="content-footer">
                <br>
                <table class="button-catalogo">
                    <tbody>
                        <tr>
                            <td class="img-button btn-hepco">
                                <a href="<?php echo $url_cat_hepco ?>" target="_blank" rel="noopener"></a>
                            </td>
                            <td class="acces">
                                <a href="<?php echo $url_cat_hepco ?>" target="_blank" rel="noopener">HEPCO &amp; BECKER</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="button-catalogo">
                    <tbody>
                        <tr>
                            <td class="img-button btn-wunderlich">
                                <a href="<?php echo $url_cat_wunderlich1 ?>" target="_blank" rel="noopener"></a>
                            </td>
                            <td class="acces">
                                <a href="<?php echo $url_cat_wunderlich1 ?>" target="_blank" rel="noopener">WUNDERLICH ON/OFF</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="button-catalogo">
                    <tbody>
                        <tr>
                            <td class="img-button btn-wunderlich">
                                <a href="<?php echo $url_cat_wunderlich2 ?>" target="_blank" rel="noopener"></a>
                            </td>
                            <td class="acces">
                                <a href="<?php echo $url_cat_wunderlich2 ?>" target="_blank" rel="noopener">WUNDERLICH BOXER</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    <?php
    }
    public function form($instance)
    {
        //Creando variables
        $instance = wp_parse_args((array) $instance, array(
            'mys_woo_url_hepco' => '',
            'mys_woo_url_wunderlich1' => '',
            'mys_woo_url_wunderlich2' => '',
        ));
        //Mostrando valores de base de datos
        $mys_woo_url_hepco = !empty($instance['mys_woo_url_hepco']) ? $instance['mys_woo_url_hepco'] : '';
        $mys_woo_url_wunderlich1 = !empty($instance['mys_woo_url_wunderlich1']) ? $instance['mys_woo_url_wunderlich1'] : '';
        $mys_woo_url_wunderlich2 = !empty($instance['mys_woo_url_wunderlich2']) ? $instance['mys_woo_url_wunderlich2'] : '';
        //Como se mostrara en el wordpress admin
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_url_hepco') . '" class="demowp_campotexto_label">' . __('URL botón catálogo', 'mysecommerce') . '</label>';
        echo '<input type="url" id="' . $this->get_field_id('mys_woo_url_hepco') . '" name="' . $this->get_field_name('mys_woo_url_hepco') . '" class="widefat" placeholder="' . esc_attr__('URL', 'mysecommerce') . '" value="' . esc_attr($mys_woo_url_hepco) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_url_wunderlich1') . '" class="demowp_campotexto_label">' . __('URL botón catálogo', 'mysecommerce') . '</label>';
        echo '<input type="url" id="' . $this->get_field_id('mys_woo_url_wunderlich1') . '" name="' . $this->get_field_name('mys_woo_url_wunderlich1') . '" class="widefat" placeholder="' . esc_attr__('URL', 'mysecommerce') . '" value="' . esc_attr($mys_woo_url_wunderlich1) . '">';
        echo '</p>';
        echo '<p>';
        echo ' <label for="' . $this->get_field_id('mys_woo_url_wunderlich2') . '" class="demowp_campotexto_label">' . __('URL botón catálogo', 'mysecommerce') . '</label>';
        echo '<input type="url" id="' . $this->get_field_id('mys_woo_url_wunderlich2') . '" name="' . $this->get_field_name('mys_woo_url_wunderlich2') . '" class="widefat" placeholder="' . esc_attr__('URL', 'mysecommerce') . '" value="' . esc_attr($mys_woo_url_wunderlich2) . '">';
        echo '</p>';
    }
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['mys_woo_url_hepco'] = !empty($new_instance['mys_woo_url_hepco']) ? strip_tags($new_instance['mys_woo_url_hepco']) : '';
        $instance['mys_woo_url_wunderlich1'] = !empty($new_instance['mys_woo_url_wunderlich1']) ? strip_tags($new_instance['mys_woo_url_wunderlich1']) : '';
        $instance['mys_woo_url_wunderlich2'] = !empty($new_instance['mys_woo_url_wunderlich2']) ? strip_tags($new_instance['mys_woo_url_wunderlich2']) : '';
        return $instance;
    }
};
function hstngr_register_widget()
{
    register_widget('info_contacto_widget');
    register_widget('button_place_widget');
    register_widget('horarios_widget');
    register_widget('medios_pago_widget');
    register_widget('catalogos_widget');
};
/**
 * Registro de widgets para footer
 */
add_action('widgets_init', 'hstngr_register_widget');

/**
 * Registro de menus adicionales
 */
register_nav_menu("nav-marcas", "Menu de marcas"); //Menu de marcas de header
register_nav_menu("nav-social", "Menu de redes sociales"); //Menu de redes sociales de footer
/**
 * Remover meta data de productos
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
/**
 * Duplicar descripcion de categoria
 */
add_action('woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 40);
add_action('woocommerce_after_shop_loop', 'woocommerce_product_archive_description', 40);