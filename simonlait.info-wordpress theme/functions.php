<?php
if(function_exists('register_sidebar'))
{	
	register_sidebar();
}

if ( function_exists( 'add_image_size' ) ) { 
  add_image_size( 'preview-image', 180, 0, true );
  add_image_size( 'full-image', 1000, 0, false );
}

// Adding custom memnus
function register_my_menus() {   
     register_nav_menus(    
          array( 
            'header-menu' => __( 'Header Menu' )
            )   
     ); 
}
add_action( 'init', 'register_my_menus' );