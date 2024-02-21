import anime from 'animejs/lib/anime.es.js';

function cartShop (){
    
    jQuery(document).ready(function( $ ) {

        var logAnimation = true

        $('.container-buscador-cart .car-header-sect').on('mouseenter', (e)=>{

            e.preventDefault();

            if(logAnimation){
                var element = $(e.currentTarget).find('.widget_shopping_cart')[0]

                var heightElement = $(e.currentTarget).find('.widget_shopping_cart_content').height()

                anime({
                    targets: element,
                    height: [0,heightElement+10],
                    opacity: [0,1],
                    duration: 1000,
                    easing: 'easeOutQuart',
                    complete: (anim)=>{
                        logAnimation = false
                    }
                })
            }
        });

        $('.widget_shopping_cart').on('mouseleave',(event_)=>{

            event_.preventDefault();

            if(logAnimation == false){
                anime({
                    targets: event_.currentTarget,
                    height: 0,
                    opacity: [1,0],
                    duration: 1000,
                    easing: 'easeOutQuart',
                    complete: (anim)=>{
                        logAnimation = true
                    }
                })
            }
        });

        $(document.body).on('added_to_cart', (e, fragments, cart_hash, thisbutton)=>{

            var tag = document.createElement("p");

            var tagButton = document.createElement("p");

            $(tag).html(fragments['a.footer-cart-contents'])

            $('#carrito-header-web').find('.count-items-car').html($(tag.children[0].children[0]).html().toString())

            var message = '<div class="woocommerce-message mys-message-added" '
            message += 'role="alert"'
            message += 'style="width: '+$('.col-full').width()+'px;"'
            message += '><a href="'
            message += tag.children[0].href
            message += '" class="button wc-forward">Ver carrito</a> <strong>'
            message += $(thisbutton[0]).attr('aria-label').split('“')[1].split('”')[0]
            message += ' - Ref. ' + $(thisbutton[0]).data('product_sku').toString()
            message += '</strong> se ha añadido a tu carrito.</div>'

            $('.col-full').find('.mys-message-added').remove()
            
            $('.col-full').append(message)

            var message_ = $('.col-full').find('.mys-message-added')[0]

            anime({
                targets: message_,
                opacity: [0,1],
                duration: 1100,
                easing: 'easeOutQuart',
                complete: (anim)=>{
                    
                    anime({
                        targets: message_,
                        opacity: [1,0],
                        duration: 1100,
                        delay: 15000,
                        easing: 'easeOutQuart',
                        complete: (anim)=>{
                            $(message_).remove()
                        }
                    })

                }
            })
        });

        $(document.body).on('removed_from_cart', (e,  fragments, cart_hash, thisbutton)=>{

            var tag = document.createElement("p");
            $(tag).html(fragments['a.footer-cart-contents'])
            $('#carrito-header-web').find('.count-items-car').html($(tag.children[0].children[0]).html().toString())

            var element = $(e.currentTarget).find('.widget_shopping_cart')[0]
            var heightElement = $(e.currentTarget).find('.widget_shopping_cart_content').height()

            anime({
                targets: element,
                height: heightElement+10,
                duration: 500,
                easing: 'easeOutQuart',
            })

        });
    
    });

}

export default cartShop;
