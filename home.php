<?php
/**
 * PAgina para mostrar las entradas del blog
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

        <?php
        if (have_posts()):
            ?>
            <div class="content-posts">
                <ul class="items-posts">
            <?php
            while(have_posts()): the_post();
                ?>
                <li class="item-post">
                    <div class="content-post">
                        <div class="img-post">
                            <?php echo the_post_thumbnail('medium_large'); ?>
                        </div>
                        <div class="info-content-post">
                            <div class="content-info-post-sect">
                                <div class="title-post">
                                    <h2><?php echo esc_html( the_title() ); ?></h2>
                                </div>
                                <div class="date-post">
                                    <span><?php echo get_the_date(); ?></span>
                                </div>
                                <div class="resumen-post"><?php echo the_excerpt(); ?></div>
                            </div>
                            <div class="buttom-mas-post">
                                <button>
                                    <a href="<?php echo the_permalink(); ?>">LEER MÁS</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            endwhile; // End of the loop.
            ?>
                </ul>
            </div>
            <?php
            do_action( 'mysstore_page_entradas_nav' );
        endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();