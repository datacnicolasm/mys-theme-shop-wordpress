import anime from 'animejs/lib/anime.es.js';

/**
 * Funcion de slider para avisos comerciales
 */
function sliderShop (){
    
    jQuery(document).ready(function( $ ) {

        $('.shop-slider').find('.slider-item span').each((index, element)=>{
            
            var sliderl = '<img class="img-aviso-slider" src="'+$(element).data('sliderl')+'" alt="img_aviso">'

            var sliders = '<img class="img-aviso-slider-phone" src="'+$(element).data('sliders')+'" alt="img_aviso_phone">'

            if (screen.width < 768){
                $(element).parent().append(sliders)
            }else{
                $(element).parent().append(sliderl)
            }

        });
        
        // Selector para los avisos comerciales
        const selectSlider = ".shop-slider .slider-item"
        
        // Array vacio para el conteo de avisos
        var slider = []
        
        // Agregando conteo de avisos
        $(selectSlider).each((index, element)=>{
            slider.push(index);
        });
        
        /**
         * Funcion de cambio de slider
         */
        const nextSlider = function (index){

            // Aviso actual que se oculta
            $($(selectSlider)[index]).css('display','none')

            // Siguiente aviso que se muestra
            if (index == slider.length-1){
                // Cuando termina el carrusel
                $($(selectSlider)[0]).fadeToggle( "slow", "linear" )
            }else{
                // Cuando aun no termina
                $($(selectSlider)[index+1]).fadeToggle( "slow", "linear" )
            }
            
        };

        // Variable de conteo incremental as for
        var i = 0

        // Función para crear el intervalo de tiempo
        setInterval(()=>{

            nextSlider(i) // Función de mostrar siguiente aviso

            if (i == slider.length-1){ // Si es el ultimo aviso
                i = 0
            }else{ // Cuando aun no es el ultimo aviso
                i = i+1
            }

        }, 5000); // Cada 5 segundos
    
    });

}

export default sliderShop;

/*
function sliderShop (){
    
    jQuery(document).ready(function( $ ) {

        console.log($(".navegacion-marcas").html());
    
    });

}

export default sliderShop;
*/