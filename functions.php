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
	remove_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 363,
		'width'       => 500,
		'flex-height' => false,
	) );

	function harc_categories() {
		if ( 'post' == get_post_type() ) {
			$categories_list = get_the_category_list( esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'amalie-lite' ) );
			if ( $categories_list && amalie_categorized_blog() ) {
				printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
					esc_html_x( 'Categories', 'Used before category names.', 'amalie-lite' ),
					$categories_list
				);
			}

			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'amalie-lite' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
					esc_html_x( 'Tags', 'Used before tag names.', 'amalie-lite' ),
					$tags_list
				);
			}
		}
	}
?>