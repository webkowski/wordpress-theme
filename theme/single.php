<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sbktwn
 */

get_header();
?>

	<main id="primary" class="container md:px-8 ">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content/content', get_post_type() );

			if ( comments_open() || get_comments_number() ) :
				// comments_template();
			endif;

		endwhile;
		?>

	</main>

<?php
get_sidebar();
get_footer();
