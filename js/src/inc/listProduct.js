import anime from 'animejs/lib/anime.es.js';

function setProduct (){
    
    jQuery(document).ready(function( $ ) {

        var logProduct = document.getElementsByClassName('content-item-product');
        
        if(logProduct.length > 0){

            // $(document.body).on('added_to_cart', (e, fragments, cart_hash, thisbutton)=>{
            //     console.log(thisbutton);
            // })

            $('.content-item-product').on('mouseenter', (event)=>{
                
                anime({
                    targets: $(event.currentTarget).find('a.product-thumbnail-link img')[0],
                    scale: [1,1.2],
                    duration: 1000,
                    easing: 'easeOutQuart',
                })
            }).on('mouseleave', (event_)=>{

                anime({
                    targets: $(event_.currentTarget).find('a.product-thumbnail-link img')[0],
                    scale: [1.2,1],
                    duration: 1000,
                    easing: 'easeOutQuart',
                })
            });
        
        }
    });

}

export default setProduct;