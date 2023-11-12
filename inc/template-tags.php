<?php
/**
 * Custom template tags for Amalie
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Amalie
 * @since Amalie 1.0
 */

if ( ! function_exists( 'amalie_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Amalie 1.0
 */
function amalie_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'amalie-lite' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'amalie-lite' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'amalie-lite' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'amalie_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Amalie 1.0
 */
function amalie_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'amalie-lite' ) );
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', esc_html_x( 'Format', 'Used before post format.', 'amalie-lite' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

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

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			esc_html_x( 'Full size', 'Used before full size attachment link.', 'amalie-lite' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'amalie-lite' ), esc_html__( '1 Comment', 'amalie-lite' ), esc_html__( '% Comments', 'amalie-lite' ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'amalie_entry_date' ) ) :
/**
 * Returns HTML with time information for current post
 */
function amalie_entry_date() {
$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( esc_html__( 'Permalink to %s', 'amalie-lite' ), the_title_attribute( 'echo=0' ) ) ),
		$time_string
	);
}
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @since Amalie 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function amalie_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'amalie_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'	 => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'	 => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'amalie_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so amalie_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so amalie_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in {@see amalie_categorized_blog()}.
 *
 * @since Amalie 1.0
 */
function amalie_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'amalie_categories' );
}
add_action( 'edit_category', 'amalie_category_transient_flusher' );
add_action( 'save_post',	 'amalie_category_transient_flusher' );

if ( ! function_exists( 'amalie_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since Amalie 1.0
 */
function amalie_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'amalie_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Amalie 1.0
 *
 * @see get_url_in_content()
 *
 * @return string The Link format URL.
 */
function amalie_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

if ( ! function_exists( 'amalie_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since Amalie 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function amalie_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( esc_html__( 'Continue reading %s', 'amalie-lite' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'amalie_excerpt_more' );
endif;
/**
 * Front Page Featured Page
 */
function amalie_featured_page() {
	$featured_page_1 = esc_attr( get_theme_mod( 'amalie_featured_page_one_front_page_first_block', '0' ) );
	if ( 0 == $featured_page_1 ) {
		return;
	}
?>
	<div class="block-one">
		<div class="page hfeed site">
			<?php for ( $page_number = 1; $page_number <= 1; $page_number++ ) : ?>
				<?php if ( 0 != ${'featured_page_' . $page_number} ) : // Check if a featured page has been set in the customizer ?>
						<?php
							// Create new argument using the page ID of the page set in the customizer
							$featured_page_args = array(
								'page_id' => ${'featured_page_' . $page_number},
							);
							// Create a new WP_Query using the argument previously created
							$featured_page_query = new WP_Query( $featured_page_args );
						?>
						<?php while ( $featured_page_query->have_posts() ) : $featured_page_query->the_post(); ?>
							<?php get_template_part( 'content', 'page' ); ?>
						<?php
							endwhile;
							wp_reset_postdata();
						?>
				<?php endif; ?>
			<?php endfor; ?>
		</div><!-- .featured-page-wrapper -->
	</div><!-- #quaternary -->
<?php
}
if ( ! function_exists( 'amalie_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Amalie Lite 1.1.
 */
function amalie_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;