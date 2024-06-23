/**
 * Este archivo manejará la lógica de los filtros de precios.
 */

import anime from 'animejs/lib/anime.es.js';

/**
 * Actualiza las etiquetas de precios.
 * 
 * @param {*} $minPriceLabel 
 * @param {*} $minPrice 
 * @param {*} $maxPriceLabel 
 * @param {*} $maxPrice 
 */
export function updateLabels($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice) {
    $minPriceLabel.text(Number($minPrice.val()).toLocaleString('es-ES'));
    $maxPriceLabel.text(Number($maxPrice.val()).toLocaleString('es-ES'));
}

/**
 * Maneja los cambios en el precio mínimo.
 * 
 * @param {*} $minPrice 
 * @param {*} $maxPrice 
 * @param {*} $minPriceLabel 
 */
export function handleMinPriceChange($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice) {
    if (parseInt($minPrice.val()) > parseInt($maxPrice.val())) {
        $minPrice.val($maxPrice.val());
    }
    updateLabels($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice);
    anime({
        targets: $minPriceLabel[0],
        translateX: [-10, 0],
        opacity: [0, 1],
        duration: 300,
        easing: 'easeOutQuad'
    });
}

/**
 * Maneja los cambios en el precio máximo.
 * 
 * @param {*} $minPrice 
 * @param {*} $maxPrice 
 * @param {*} $maxPriceLabel 
 */
export function handleMaxPriceChange($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice) {
    if (parseInt($maxPrice.val()) < parseInt($minPrice.val())) {
        $maxPrice.val($minPrice.val());
    }
    updateLabels($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice);
    anime({
        targets: $maxPriceLabel[0],
        translateX: [10, 0],
        opacity: [0, 1],
        duration: 300,
        easing: 'easeOutQuad'
    });
}

/**
 * Actualiza la URL con los valores de precios seleccionados.
 * 
 * @param {*} urlParams 
 * @param {*} $minPrice 
 * @param {*} $maxPrice 
 */
export function updateURLWithPrice(urlParams, $minPrice, $maxPrice) {
    var desde_precio = $minPrice.val().replace(/\./g, '');
    var hasta_precio = $maxPrice.val().replace(/\./g, '');

    // Condicional para restablecer o agregar variable
    if (urlParams.has('price-min') && urlParams.has('price-max')) {
        urlParams.set('price-min', desde_precio);
        urlParams.set('price-max', hasta_precio);
    } else {
        urlParams.append('price-min', desde_precio);
        urlParams.append('price-max', hasta_precio);
    }
}
