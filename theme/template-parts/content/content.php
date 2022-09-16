<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sbktwn
 */

?>
<?php
  $gallery = get_post_gallery($post, false) || preg_match_all('/<img (.+?)>/', $post->post_content, $matches);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(($gallery ? 'splide' : '') .' w-fill mt-10 md:mt-0 md:h-[calc(100vh_-_88px)] mb-20 md:mt-[40px] md:mb-[40px] flex items-center'); ?>>
  <div>
    <div class="flex md:items-end flex-col md:flex-row">
      <div class="w-auto flex items-start">
        <?php sbktwn_post_images($post)?>
      </div>
      <div class="md:w-[200px] flex items-end md:pl-1">
        <div class="pl-1 pr-1 mt-2 md:mt-0 flex flex-row md:flex-col justify-between flex-1">
          <header>
		        <?php
		          if ( is_singular() ) :
                the_title( '<h1 class="text-slate-400 text-sm text-left leading-none">', '</h1>' );
              else :
                the_title( '<h2 class="text-slate-400 text-sm text-left leading-none"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
              endif;

              if ( 'post' === get_post_type() ) :
			          sbktwn_posted_on();
              endif;
            ?>
	        </header>
          <?php if($gallery) : ?>
            <footer class="flex justify-start items-center gap-2 ">
              <div class="splide__arrows flex">
		            <button class="disabled:opacity-50  splide__arrow--prev border border-solid w-6 h-6 flex justify-center items-center text-slate-400">&laquo;</button>
                <button class="disabled:opacity-50 splide__arrow--next border border-solid w-6 h-6 flex justify-center items-center text-slate-400">&raquo;</button>
              </div>
            </footer>
          <?php endif; ?>
        </div>
      </div>
	  </div>
    <?php the_content('&raquo;'); ?>
	</div>
</article>
