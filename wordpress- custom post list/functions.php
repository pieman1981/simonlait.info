<?php

add_action('init', 'add_movie_post_type');    
  
function add_movie_post_type() {  
    $args = array(  
        'label' => __('Movies'),  
        'singular_label' => __('Movie'),  
        'public' => true,  
        'show_ui' => true,  
        'capability_type' => 'post',  
        'hierarchical' => false,  
        'rewrite' => true,  
        'supports' => array('title', 'editor', 'custom-fields')  
    );  
    register_post_type( 'movie' , $args );  
	
	function movie_modify_post_table( $column ) {
		$column['movie_star'] = 'Movie Star';
		return $column;
	}
	add_filter( 'manage_movie_posts_columns', 'movie_modify_post_table',10 );
	
	function movie_modify_post_table_row( $column_name, $post_id ) {
		$custom_fields = get_post_custom( $post_id );
		switch ($column_name) {
			case 'movie_star' :
				echo $custom_fields['Movie Star'][0];
			break;
		}
	}
	add_filter( 'manage_movie_posts_custom_column', 'movie_modify_post_table_row', 10, 2 );
}  
?>