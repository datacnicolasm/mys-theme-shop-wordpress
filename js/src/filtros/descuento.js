/**
 * Este archivo manejará la lógica de descuentos.
 */

/**
 * Asegura que solo se pueda marcar una opción de descuento a la vez.
 */
export function handleDescuentoChange() {
    const $ = jQuery;

    $('input[name="descuento"]').change(function () {
        $('input[name="descuento"]').not(this).prop('checked', false);
    });
}
