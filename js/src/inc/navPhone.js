function menuPhone (){
    
    jQuery(document).ready(function( $ ) {

        $('#menu-menu-principal-tienda-phone').find('.span-item-parent').addClass('no-select-item');

        $('.span-item-parent').on('click', (event_)=>{

            if (event_.currentTarget.classList.contains('select-item')){

                $(event_.currentTarget).parent().find('.sub-menu-item').slideUp('slow')

                $('.select-item').removeClass('select-item')
                .addClass('no-select-item')

            }else{

                $('.select-item').removeClass('select-item')
                .addClass('no-select-item')
    
                $(event_.currentTarget).addClass('select-item')
                .removeClass('no-select-item');
    
                $('.select-item').parent().find('.sub-menu-item').slideDown('slow');
    
                $('#menu-menu-principal-tienda-phone .no-select-item').parent().find('.sub-menu-item').slideUp('slow')
            }

        });
    
        $('.menu-navegacion-phone button').on('click', (event_)=>{
            event_.preventDefault();

            $('.nav-phone-navegacion').slideToggle('slow')
        });

    });

}

export default menuPhone;