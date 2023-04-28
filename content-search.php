<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package Amalie
 * @since Amalie 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php amalie_post_thumbnail(); ?>

	<header class="entry-header">
		<div class="subtitle">
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'circle', true); ?></span>
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'event', true); ?>: Session <?php echo get_post_meta(get_the_ID(), 'session', true); ?></span>
			<span class="subtitle-line">
				<?php $raw_date_value = get_post_meta(get_the_ID(), 'date', true);
				$date = date_create($raw_date_value);
				echo date_format($date, 'l, F j, Y'); ?>
			</span>
		</div>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<div class="subtitle-mobile">
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'circle', true); ?></span>
			<span class="subtitle-line"><?php echo get_post_meta(get_the_ID(), 'event', true); ?>: Session <?php echo get_post_meta(get_the_ID(), 'session', true); ?></span>
			<span class="subtitle-line">
				<?php $raw_date_value = get_post_meta(get_the_ID(), 'date', true);
				$date = date_create($raw_date_value);
				echo date_format($date, 'l, F j, Y'); ?>
			</span>
		</div>
		
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<div class="excerpt-permalink">
			<a href="<?php the_permalink(); ?>">Go to the transcript.</a>
		</div>
	</div><!-- .entry-summary -->

	<?php if ( 'post' == get_post_type() ) : ?>

		<footer class="entry-footer">
			<?php amalie_entry_meta(); ?>
			<?php edit_post_link( esc_html__( 'Edit', 'amalie-lite' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-footer -->

	<?php else : ?>

		<?php edit_post_link( esc_html__( 'Edit', 'amalie-lite' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

	<?php endif; ?>

</article><!-- #post-## -->