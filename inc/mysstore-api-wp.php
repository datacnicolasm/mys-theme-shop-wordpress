<?php

function post_consulta_precio_variacion()
{
    check_ajax_referer('api_token', 'token');

    if (isset($_POST['action'])) {

        $product = wc_get_product(intval($_POST['id_product']));

        foreach ($product->get_available_variations() as $variation) {
            if ($variation["attributes"]["attribute_pa_talla"] == $_POST['attribute_pa_talla']) {
                $data = array(
                    "attribute_pa_talla"            => $variation["attributes"]["attribute_pa_talla"],
                    "display_price"                 => $variation["display_price"],
                    "display_price_html"            => wc_price($variation["display_price"]),
                    "display_regular_price_html"    => wc_price($variation["display_regular_price"]),
                    "display_regular_price"         => $variation["display_regular_price"],
                    "sku"                           => $variation["sku"],
                    "is_in_stock"                   => $variation["is_in_stock"]
                );

                $result = array(
                    "data" => $data
                );
            };
        }

        echo json_encode($result);

        wp_die();
    }
}

add_action('wp_ajax_consulta_precio_variacion', 'post_consulta_precio_variacion');
add_action('wp_ajax_nopriv_consulta_precio_variacion', 'post_consulta_precio_variacion');
