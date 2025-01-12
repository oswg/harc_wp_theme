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
				$query->set( 'cat', -128 );
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

	function list_child_categories($parent_category_slug) {
	    // Get the ID of the parent category by slug
	    $parent_category = get_category_by_slug($parent_category_slug);
	    if (!$parent_category) {
	        return; // Parent category not found
	    }
	    $parent_category_id = $parent_category->term_id;

	    // Get the child categories of the parent category
	    $args = array(
	        'parent' => $parent_category_id,
	        'hide_empty' => false // Set to true to hide categories without posts
	    );
	    $child_categories = get_categories($args);

	    // Check if the parent category has child categories
	    if ($child_categories) {
	        echo '<ul>';
	        foreach ($child_categories as $child_category) {
	            // Generate the URL to the category
	            $category_link = get_category_link($child_category->term_id);
	            // Display the category link
	            echo '<li><a href="' . esc_url($category_link) . '">' . esc_html($child_category->name) . '</a></li>';
	        }
	        echo '</ul>';
	    } else {
	        echo 'No child categories found.';
	    }
	}

// Usage: Call this function with the parent category slug where you want to display the list
// Example: list_child_categories('parent-category-slug');
?>