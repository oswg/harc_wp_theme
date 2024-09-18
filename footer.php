<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package Amalie
 * @since Amalie 1.0
 */
?>
<?php if( get_theme_mod( 'hide_copyright' ) == '') { ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<p>&copy; 2021-<?php echo date('Y'); ?> High Altitude Receiving Center, Stephen Tyman, and Jeremy Weiland</p>
			<small>This Wordpress site layout is based on the Amalie Lite theme.</small>
	    </div>
		<!-- .site-info -->
	</footer><!-- .site-footer -->
<?php } // end if ?>
	
	</div><!-- .site-content -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>