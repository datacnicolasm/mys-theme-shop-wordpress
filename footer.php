<?php
/**
 * The template for displaying the footer.
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<footer id="footer-site" class="footer-tag-container" role="contentinfo">
		<div class="footer-container">

			<?php
			/**
			 * Function theme mysstore_footer_content_ecommerce
			 *
			 * @hooked mysstore_footer_open_widget         - 5
			 * @hooked mysstore_footer_widgets             - 10
			 * @hooked mysstore_footer_close_widget        - 15
			 * @hooked mysstore_footer_menu_redes_sociales - 20
			 * @hooked mysstore_footer_button_top          - 25
			 * @hooked mysstore_footer_politicas           - 30
			 * @hooked mysstore_footer_creditos            - 35
			 */
			do_action( 'mysstore_footer_content_ecommerce' );
			?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
