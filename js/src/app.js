import sliderShop from './inc/sliderShop';
import sliderProducts from './inc/sliderProducts';
import setProduct from './inc/listProduct';
import cartShop from './inc/cartHeader';
import menuPhone from './inc/navPhone'

jQuery(document).ready(function( $ ) {

    sliderShop()
    sliderProducts('.productos-nuevos .carrusel-productos-mys')
    sliderProducts('.productos-oferta .carrusel-productos-mys')
    sliderProducts('.productos-destacados .carrusel-productos-mys')
    setProduct();
    cartShop();
    menuPhone();

    $( ".product-tabs-info #tabs" ).tabs();

    $('.summary-servicio-section').find('.tab-summary-tag div').on('click', (event_)=>{
        event_.preventDefault()

        $('.summary-servicio-section').find('.content-summary').slideToggle('slow');
    })

});

