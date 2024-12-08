<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Amalie
 * @since Amalie 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		amalie_post_thumbnail();
	?>

	<header class="entry-header">
		<div class="subtitle">
			<?php if ( has_category( 'Training' ) ) { ?>
				<span class="training-label"><i class="fas fa-exclamation-triangle"></i> Training session</span>
			<?php } ?>
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'circle', true); ?></span>
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'event', true); ?></span>
			<span class="subtitle-line">Session <?php echo get_post_meta(get_the_ID(), 'session', true); ?></span>
			<span class="subtitle-line">
				<?php $raw_date_value = get_post_meta(get_the_ID(), 'date', true);
				$date = date_create($raw_date_value);
				echo date_format($date, 'l, F j, Y'); ?>
			</span>
		</div>
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
		<div class="subtitle-mobile">
			<?php if ( has_category( 'Training' ) ) { ?>
				<span class="training-label"><i class="fas fa-exclamation-triangle"></i> Training session</span>
			<?php } ?>
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'circle', true); ?></span>
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'event', true); ?></span>
			<span class="subtitle-line">Session <?php echo get_post_meta(get_the_ID(), 'session', true); ?></span>
			<span class="subtitle-line">
				<?php $raw_date_value = get_post_meta(get_the_ID(), 'date', true);
				$date = date_create($raw_date_value);
				echo date_format($date, 'l, F j, Y'); ?>
			</span>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_category( 'Training' ) ) { ?>
				<p><i class="fas fa-exclamation-triangle"></i> Caveat: This is a session used to training new instruments. As such, please use extra caution in reading, and forgive any errors and mistakes.</p>
			<?php } ?>
		<?php
			/* translators: %s: Name of current post */
			if ( is_single() ) :
				the_content( sprintf(
					esc_html__( 'Continue reading %s', 'amalie-lite' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );
			else :
				the_excerpt();
		?>
			<div class="excerpt-permalink">
				<a href="<?php the_permalink(); ?>">Go to the transcript.</a><i class="fas fa-external-link-alt" style="padding-left: 1rem;"></i>
			</div>
		<?php		
			endif;


			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'amalie-lite' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'amalie-lite' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">
			<?php harc_categories(); ?>
			<?php edit_post_link( esc_html__( 'Edit', 'amalie-lite' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->
	<!-- ?php else : ?>
		<hr / -->
	<?php endif; ?>

</article><!-- #post-## -->