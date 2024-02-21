<?php
/**
 * Template de pagina para inicio de E-commerce
 * Template name: Inicio E-commerce
 */

get_header(); ?>

	<div id="cont-primary" class="contentenedor-area-site">
		<main class="ecommerce-main-cont" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			do_action( 'mysstore_inicio_ecommerce' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
