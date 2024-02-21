<?php

/**

 * Template de landing page de E-commerce

 * Template name: Landing Page

 */



get_header(); ?>



	<div id="cont-primary" class="contentenedor-area-site">

		<main id="main" class="site-main" role="main">



			<?php

			/**

			 * Funciones para la plantilla de landing page Motos y Servitecas de Colombia

			 *

			 * @hooked mysstore_banner_landing_page               - 10

			 * @hooked mysstore_wc_productos_categoria_promocion  - 20

			 * @hooked mysstore_banner_explorar_tienda            - 30

			 */

			do_action( 'mysstore_landing_page' );

			?>



		</main><!-- #main -->

	</div><!-- #primary -->

<?php

get_footer();