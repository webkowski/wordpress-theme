<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sbktwn
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('pb-[10vh] max-w-6xl'); ?>>
	<header>
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="text-slate-500 text-sm text-left py-2">', '</h1>' );
		else :
			the_title( '<h2 class="text-slate-400 text-sm text-left py-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
				<?php
          // print_r('<div>');
          // sbktwn_posted_on();
          // sbktwn_posted_by();
          // print_r('<div>');
				?>
		<?php endif; ?>
	</header>

	<?php sbktwn_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span> "%s"</span>', 'sbktwn' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div>' . esc_html__( 'Pages:', 'sbktwn' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer>
		<?php sbktwn_entry_footer(); ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
