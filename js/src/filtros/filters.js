/**
 * Este archivo manejará la lógica de los filtros de marcas y disponibilidad.
 */

/**
 * Esta función actualiza la URL con los filtros seleccionados de marcas y disponibilidad.
 * 
 * @param {*} urlParams 
 */
export function updateURLWithFilters(urlParams) {
    const $ = jQuery;

    // Limpiar las marcas existentes en los parámetros
    urlParams.delete('marca[]');

    // Agregar todas las marcas seleccionadas
    $('input[name="marca[]"]:checked').each(function () {
        urlParams.append('marca[]', $(this).val());
    });

    // Limpiar las marcas existentes en los parámetros
    urlParams.delete('linea[]');

    // Agregar todas las marcas seleccionadas
    $('input[name="linea[]"]:checked').each(function () {
        urlParams.append('linea[]', $(this).val());
    });

    // Limpiar las marcas existentes en los parámetros
    urlParams.delete('marcas-moto[]');

    // Agregar todas las marcas seleccionadas
    $('input[name="marcas-moto[]"]:checked').each(function () {
        urlParams.append('marcas-moto[]', $(this).val());
    });

    // Limpiar las marcas existentes en los parámetros
    urlParams.delete('lineas-moto[]');

    // Agregar todas las marcas seleccionadas
    $('input[name="lineas-moto[]"]:checked').each(function () {
        urlParams.append('lineas-moto[]', $(this).val());
    });

    // Limpiar el parámetro existente de disponibilidad
    urlParams.delete('disponibilidad');

    // Agregar el valor de disponibilidad seleccionado
    $('input[name="disponibilidad"]:checked').each(function () {
        urlParams.append('disponibilidad', $(this).val());
    });

    // Limpiar el parámetro existente de descuento
    urlParams.delete('descuento');

    // Agregar el valor de descuento seleccionado
    $('input[name="descuento"]:checked').each(function () {
        urlParams.append('descuento', $(this).val());
    });

    // Limpiar el parámetro existente de tallas
    urlParams.delete('tallas');

    // Agregar el valor de tallas seleccionado
    $('input[name="tallas[]"]:checked').each(function () {
        urlParams.append('tallas', $(this).val());
    });

    // Limpiar el parámetro existente de colores
    urlParams.delete('colores');

    // Agregar el valor de colores seleccionado
    $('input[name="colores[]"]:checked').each(function () {
        urlParams.append('colores', $(this).val());
    });

    // Limpiar el parámetro existente de generos
    urlParams.delete('generos');

    // Agregar el valor de generos seleccionado
    $('input[name="generos[]"]:checked').each(function () {
        urlParams.append('generos', $(this).val());
    });
}

/**
 * Marca el checkbox de disponibilidad correcto al cargar la página.
 * @param {*} disponibilidad 
 */
export function markAvailabilityCheckbox(disponibilidad) {
    const $ = jQuery;
    // Marcar el checkbox correcto al cargar la página
    if (disponibilidad) {
        $(`input[name="disponibilidad"][value="${disponibilidad}"]`).prop('checked', true);
    }
}

/**
 * Marca el checkbox de descuento correcto al cargar la página.
 * @param {*} descuento 
 */
export function markDescuentoCheckbox(descuento) {
    const $ = jQuery;
    // Marcar el checkbox correcto al cargar la página
    if (descuento) {
        $(`input[name="descuento"][value="${descuento}"]`).prop('checked', true);
    }
}
