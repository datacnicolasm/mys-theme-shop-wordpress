/**
 * Este archivo será el archivo central que importará y utilizará las funciones de los otros archivos.
 */
import { updateURLWithFilters, markAvailabilityCheckbox, markDescuentoCheckbox } from './filters.js';
import { updateLabels, handleMinPriceChange, handleMaxPriceChange, updateURLWithPrice } from './price.js';
import { handleAvailabilityChange } from './availability.js';
import { handleDescuentoChange } from './descuento.js';

jQuery(document).ready(function ($) {
    const $minPrice = $('#min-price');
    const $maxPrice = $('#max-price');
    const $minPriceLabel = $('#min-price-label');
    const $maxPriceLabel = $('#max-price-label');

    // Inicializar los valores de las etiquetas
    updateLabels($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice);

    // Manejar cambios en los precios
    $minPrice.on('input', function () {
        handleMinPriceChange($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice);
    });

    $maxPrice.on('input', function () {
        handleMaxPriceChange($minPriceLabel, $minPrice, $maxPriceLabel, $maxPrice);
    });

    // Manejar cambios en la disponibilidad
    handleAvailabilityChange();

    // Manejar cambios en el descuento
    handleDescuentoChange();

    // Marcar el checkbox correcto de disponibilidad al cargar la página
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const disponibilidad = urlParams.get('disponibilidad');
    markAvailabilityCheckbox(disponibilidad);

    // Marcar el checkbox correcto de descuento al cargar la pagina
    const descuento = urlParams.get('descuento');
    markDescuentoCheckbox(descuento)

    // Aplicar filtros al hacer clic en el botón
    $('#apply-filter').on('click', function () {
        const baseURL = window.location.origin + window.location.pathname;
        const urlParams = new URLSearchParams(window.location.search);

        updateURLWithPrice(urlParams, $minPrice, $maxPrice);
        updateURLWithFilters(urlParams);

        const newURL = `${baseURL}?${urlParams.toString()}`;
        window.location.href = newURL;
    });

    // Restaurar filtros al hacer clic en el botón
    $('#restore-filter').on('click', function () {
        const baseURL = window.location.origin + window.location.pathname;
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('price-min') && urlParams.has('price-max')) {
            urlParams.delete('price-min');
            urlParams.delete('price-max');
        }

        if (urlParams.has('marca[]')) {
            urlParams.delete('marca[]');
        }

        if (urlParams.has('linea[]')) {
            urlParams.delete('linea[]');
        }

        if (urlParams.has('marcas-moto[]')) {
            urlParams.delete('marcas-moto[]');
        }

        if (urlParams.has('lineas-moto[]')) {
            urlParams.delete('lineas-moto[]');
        }

        if (urlParams.has('tallas[]')) {
            urlParams.delete('tallas[]');
        }
        
        if (urlParams.has('generos[]')) {
            urlParams.delete('generos[]');
        }

        if (urlParams.has('colores[]')) {
            urlParams.delete('colores[]');
        }

        const newURL = `${baseURL}?${urlParams.toString()}`;
        window.location.href = newURL;
    });

    // Toggle filtros para celular
    $('#toggle-filtros').on('click', function(){
        $('.content-archive-productos').find('.filtros-tienda').toggle();
    });
});
