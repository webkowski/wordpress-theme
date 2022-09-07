<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sbktwn
 */

if ( ! function_exists( 'sbktwn_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function sbktwn_posted_on() {
		$time_string = '<time datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'sbktwn' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-slate-400 text-xs leading-none">' . $time_string . '</a>'
		);

		echo '<span class="leading-none">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'sbktwn_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function sbktwn_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'sbktwn' ),
			'<span><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'sbktwn_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function sbktwn_entry_footer() {
		// Hide category and tag text for pages.
    echo '<div class="text-sm  text-slate-400 flex-inline justify-start gap-2">';

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'sbktwn' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span>' . esc_html__( 'Posted in %1$s', 'sbktwn' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'sbktwn' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span>' . esc_html__( 'Tagged %1$s', 'sbktwn' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() ) ) {
			echo '<span>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span> on %s</span>', 'sbktwn' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}
    echo '</div>';
	}
endif;

if ( ! function_exists( 'sbktwn_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function sbktwn_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
    
    the_post_thumbnail(
      'full',
      array(
        'alt' => the_title_attribute(
          array(
            'echo' => false,
          )
        ),
        'class' => 'max-h-[80vh] object-contain w-auto',
      )
    );
	}
endif;

function sbktwn_remove_blocks() {
  if ( ( is_single() || is_page() ) && in_the_loop() && is_main_query() ) {
    //parse the blocks so they can be run through the foreach loop
    $blocks = parse_blocks( get_the_content() );
    foreach ( $blocks as $block ) {
      //look to see if your block is in the post content -> if yes continue past it if no then render block as normal
      if ( 'core/gallery' === $block['blockName'] ) {
        //continue;
        echo '';
      } else {
        //echo '';
        echo render_block( $block );
      }
    }
  }
}
add_filter( 'the_content', 'sbktwn_remove_blocks');

if ( ! function_exists( 'sbktwn_post_images' ) ) :

  function sbktwn_post_images( $post ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
    }

    $gallery = get_post_gallery($post, false);

    if (has_post_thumbnail() && !$gallery) {
      sbktwn_post_thumbnail();
    }

    if (has_post_thumbnail() && $gallery) {
      $post_thumbnail_id = get_post_thumbnail_id($post->ID);
      $gids = explode( ",", $gallery['ids'] );
      array_unshift($gids, $post_thumbnail_id);
      $post_images = [];
      
      foreach( $gids as $id ) {
        $image = [];
        $image['id'] = $id;
        $image['url'] = wp_get_attachment_url( $id );
        $image['meta'] = wp_get_attachment_metadata( $id );
        array_push($post_images, $image);
      }
      ?>
        <section class="" aria-label="Splide Basic HTML Example">
          <div class="splide__track">
            <ul class="splide__list">
              <?php foreach($post_images as $image) { ?>
                <li class="splide__slide"><?php echo wp_get_attachment_image( $image['id'], 'full', false, array('class' => 'max-h-[80vh] object-contain w-auto') );; ?></li>
              <?php } ?>
            </ul>
          </div>
          <div class="bg-slate-100">
            <div class="splide-progress-bar bg-slate-200 h-1 w-0 transition-[width] duration-400 ease-out"></div>
          </div>
        </section>
      <?php
    }
  }
endif;