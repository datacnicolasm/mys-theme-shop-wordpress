import sliderShop from './inc/sliderShop';
import sliderProducts from './inc/sliderProducts';
import setProduct from './inc/listProduct';
import cartShop from './inc/cartHeader';
import menuPhone from './inc/navPhone'

jQuery(document).ready(function ($) {

    sliderShop()
    sliderProducts('.productos-nuevos .carrusel-productos-mys')
    sliderProducts('.productos-oferta .carrusel-productos-mys')
    sliderProducts('.productos-destacados .carrusel-productos-mys')
    setProduct();
    cartShop();
    menuPhone();

    $(".product-tabs-info #tabs").tabs();

    $("#pa_talla").change((event) => {

    });

    $('.summary-servicio-section').find('.tab-summary-tag div').on('click', (event_) => {
        event_.preventDefault()

        $('.summary-servicio-section').find('.content-summary').slideToggle('slow');
    })

    $("div.single_variation").remove();

    $("select#pa_talla").on("change", function (event, element) {

        if ($("select#pa_talla").val()) {
            var attribute_pa_talla = $("select#pa_talla").val();

            var id_product = $("span#data-wc").data("productwc");

            var dataSend = {
                action: 'consulta_precio_variacion',
                token: ajax_object.token,
                id_product: id_product,
                attribute_pa_talla: attribute_pa_talla
            }

            $.ajax({
                url: ajax_object.url,
                method: 'post',
                dataType: 'json',
                data: dataSend,
                success: function (data) {

                    // Codigo de referencia
                    var sku_html = '<span><strong>Referencia:</strong> ' + data.data.sku + '</span>';
                    $("p.product-sku").html(sku_html);

                    // Disponibilidad de la referencia
                    if (data.data.is_in_stock) {
                        var stock_html = '<span class="disponible">DISPONIBLE</span>';
                    } else {
                        var stock_html = '<span class="agotado">AGOTADO</span>';
                    }
                    $("div.tag-stock-product").html(stock_html);

                    //Precio de la referencia
                    if (data.data.display_price == data.data.display_regular_price) {
                        var price_html = data.data.display_price_html
                    } else {
                        var price_html = '<div class="precio-oferta">';
                        price_html += '<div class="regular-price-sale">'
                        price_html += '<span class="regular-price"><del>' + data.data.display_regular_price_html + '</del></span>'
                        price_html += '<span class="portj-price">' + Math.round(((data.data.display_regular_price / data.data.display_price) - 1) * 100) + '%</span>'
                        price_html += '</div>'
                        price_html += '<div class="sale-price-product">'
                        price_html += data.data.display_price_html
                        price_html += '</div>';
                        price_html += '</div>';
                    }
                    $("div.price-product").html(price_html)
                },
                error: function (xhr, status) {
                    console.log("Error");
                }
            });

        }
    })

});

