import anime from 'animejs/lib/anime.es.js';

/**
 * Función de carrusel de productos
 */
function sliderProducts (selectorJs){
    
    jQuery(document).ready(function( $ ) {

        // Numero de productos en el carrusel
        var numProducts = 0
        
        if (screen.width < 480) {

            numProducts = 1
            
        } else if(screen.width > 480 && screen.width < 740) {
            
            numProducts = 2

        } else if(screen.width > 740 && screen.width < 980) {

            numProducts = 3

        } else if(screen.width > 980) {

            numProducts = 4

        }

        // String de selector para el carrusel
        const selectCarrusel = selectorJs

        // Tamaño en la pantalla para mostrar los productos
        const widthCarrusel = $(selectCarrusel).parent().width()

        // Array para altura de los productos
        var heightSlider = []

        // Cambio de tamaño del contenedor de los productos
        if ($(document.body).hasClass( "page-template-template-inicioecommerce" )){
            $(selectCarrusel).width(((widthCarrusel/numProducts)+2)*$(selectCarrusel)[0].childElementCount)
        }        

        // Funcion para cada elemento del carrusel
        $(selectCarrusel).children().each((index, element)=>{
            // Establecer ancho de cada producto
            $(element).css("width",widthCarrusel/numProducts)
            // Alimentar heightSlider para altura de los productos
            heightSlider.push($(element).height())
        });

        // Establecer altura para los productos del carrusel
        $(selectCarrusel).children().height(Math.max(...heightSlider))

        // Agregar las flechas en el carrusel
        $(selectCarrusel).parent().prepend('<span class="slick-prev-arrow slick-arrow"><i class="fas fa-chevron-left"></i></span>')
        $(selectCarrusel).parent().append('<span class="slick-next-arrow slick-arrow"><i class="fas fa-chevron-right"></i></span>')

        // Variable semaforo para el carrusel
        var logCambio = true

        // Objeto de primer y ultimo elemento
        var logExtremos = {
            'first': 1,
            'last': 4
        }

        // Click hacia la izquierda
        $(selectCarrusel).parent().find('.slick-prev-arrow').on('click', (e)=>{
            
            if (logCambio && logExtremos.first !== 1){
                anime({
                    targets: $(selectCarrusel)[0],
                    translateX: [$(selectCarrusel).position(),($(selectCarrusel).position().left)+(widthCarrusel/numProducts)],
                    duration: 500,
                    easing: 'easeOutQuart',
                    begin: function(anim) {
                        logCambio = false
                    },
                    complete: function(anim) {
                        logCambio = true
                        logExtremos.first -= 1
                        logExtremos.last -= 1
                    }
                });
            }

        });

        // Click hacia la derecha
        $(selectCarrusel).parent().find('.slick-next-arrow').on('click', (e)=>{

            var isPageInicio = $(document.body).hasClass( "page-template-template-inicioecommerce" )
            
            if (isPageInicio && logCambio && logExtremos.last < $(selectCarrusel)[0].childElementCount){
                anime({
                    targets: $(selectCarrusel)[0],
                    translateX: [$(selectCarrusel).position(),($(selectCarrusel).position().left)-(widthCarrusel/numProducts)],
                    duration: 500,
                    easing: 'easeOutQuart',
                    begin: function(anim) {
                        logCambio = false
                    },
                    complete: function(anim) {
                        logCambio = true
                        logExtremos.first += 1
                        logExtremos.last += 1
                    }
                });
            }

        });

        // Hover de click para mostrar las flechas del carrusel
        $(selectCarrusel).parent().on('mouseenter',
            (e)=>{
                e.preventDefault();
                $(e.currentTarget).find('.slick-arrow').each((i, e)=>{
                    anime({
                        targets: e,
                        opacity: [0,1],
                        duration: 500,
                        easing: 'easeOutQuart',
                    })
                })
            }
        ).on('mouseleave',
            (e)=>{
                e.preventDefault();
                $(e.currentTarget).find('.slick-arrow').each((i, e)=>{
                    anime({
                        targets: e,
                        opacity: [1,0],
                        duration: 500,
                        easing: 'easeOutQuart',
                    })
                })
            }
        )

        // $().on('click', (e)=>{
        //     console.log('e', e)
        // });

    });

}

export default sliderProducts;