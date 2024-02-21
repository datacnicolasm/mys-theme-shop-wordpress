<?php
/**
 * Template de pagina para inicio de E-commerce
 * Template name: Pruebas PHP
 */
 
get_header(); ?>

	<div id="cont-primary" class="contentenedor-area-site">
		<main class="ecommerce-main-cont" role="main">
		    
            <?php
            
            $serverName = "45.169.253.67,8358";
            $connectionInfo = array( "Database"=>"Motos_Emp010", "UID"=>"MotosUser", "PWD"=>"MotosQ1w2e3r4*/*");
            
            try {
                
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
            
                if( $conn ) {
                     echo "Conexión establecida.<br />";
                }else{
                    echo "<pre>";
                    var_dump(sqlsrv_errors());
                    echo "</pre>";
                    
                    die();
                }
                
            } catch (Exception $e) {
                echo "<pre>";
                var_dump($e->getMessage());
                echo "</pre>";
            }
            
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();