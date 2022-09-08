<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package sbktwn
 */

 /**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function sbktwn_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'sbktwn_pingback_header' );

function sbktwn_meta_tags_header() {
  if (is_singular()) {
    $post = get_post();
    printf('<meta name="title" content="%s">', $post->post_title);
  } else {
    printf('<meta name="title" content="%s">', get_bloginfo( 'name' ));
  }
  printf('<meta name="description" content="%s">', get_bloginfo( 'description' ));
}
add_action( 'wp_head', 'sbktwn_meta_tags_header');

function sbktwn_og_tags_header() {
  $post = get_post();
 
  if (is_singular()) {
    echo '<meta property="og:type" content="website">';
    printf('<meta property="og:url" content="%s">', get_permalink($post->ID));
    printf('<meta property="og:title" content="%s">', $post->post_title);
    printf('<meta property="og:description" content="%s">', $post->post_excerpt);
    printf('<meta property="og:image" content="%s">', get_the_post_thumbnail_url($post));
    
    echo('<meta property="twitter:card" content="summary_large_image">');
    printf('<meta property="twitter:url" content="%s">', get_permalink($post->ID));
    printf('<meta property="twitter:title" content="%s">', $post->post_title);
    printf('<meta property="twitter:description" content="%s">', $post->post_excerpt);
    printf('<meta property="twitter:image" content="%s">', get_the_post_thumbnail_url($post));
  } else {
    printf('<meta property="og:url" content="%s">', get_bloginfo( 'url' ));
    printf('<meta property="og:url" content="%s">', get_bloginfo( 'name' ));
    printf('<meta property="og:description" content="%s">', get_bloginfo( 'description' ));
    printf('<meta property="og:image" content="%s">', get_the_post_thumbnail_url($post));

    printf('<meta property="twitter:url" content="%s">', get_bloginfo( 'url' ));
    printf('<meta property="twitter:title" content="%s">', get_bloginfo( 'name' ));
    printf('<meta property="twitter:description" content="%s">', get_bloginfo( 'description' ));
    printf('<meta property="twitter:image" content="%s">', get_the_post_thumbnail_url($post));
  }
}
add_action( 'wp_head', 'sbktwn_og_tags_header');