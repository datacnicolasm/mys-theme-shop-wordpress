/**
 * Este archivo manejará la lógica de disponibilidad.
 */

/**
 * Asegura que solo se pueda marcar una opción de disponibilidad a la vez.
 */
export function handleAvailabilityChange() {
    const $ = jQuery;

    $('input[name="disponibilidad"]').change(function () {
        $('input[name="disponibilidad"]').not(this).prop('checked', false);
    });
}
