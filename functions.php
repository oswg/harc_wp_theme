<?php
	function harc_enqueue_styles() {
		wp_enqueue_style('parent-styles', get_template_directory_uri() .'/style.css');
		wp_enqueue_style('child-styles', get_stylesheet_directory_uri() . '/style.css' );
	}

	function order_by_date_and_session($query) {
		if ( is_page() ) { return $query; }
		if ( ! is_admin() && $query->is_main_query() ) {
			$meta_query = array(
				'date_q' => array(
					'key' => 'date',
					'compare' => 'EXISTS'
				),
				'session_q' => array(
					'key' => 'session',
					'type' => 'NUMERIC',
					'compare' => 'EXISTS'
				),
			);
			if ( $query->is_category() ) {
				$direction = 'ASC';
			} else {
				$direction = 'DESC';
			}

			$order_by = array(
				'date_q' => $direction,
				'session_q' => $direction
			);
			
			$query->set( 'meta_query', $meta_query );
			$query->set( 'orderby', $order_by );
			$query->set( 'posts_per_page', 15 );
		}
	}

	add_action('pre_get_posts', 'order_by_date_and_session');
	add_action( 'wp_enqueue_scripts', 'harc_enqueue_styles' );
?>