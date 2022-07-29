<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sbktwn
 */

?>



<header id="masthead" class="w-full flex flex-row justify-between items-center fixed py-1 px-2">

  <h1 class="mr-auto px-3"></h1>

  <div class="px-1 h-8 uppercase flex justify-center items-center gap-2">

    <nav id="site-navigation" class="flex flex-row list-none">
		  <button aria-controls="primary-menu" aria-expanded="false" class="hidden"><?php esc_html_e( 'Primary Menu', 'sbktwn' ); ?></button>
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu',
          'items_wrap'     => '<ul id="%1$s" class="%2$s flex items-center text-xs space-x-1 text-slate-400">%3$s</ul>'
        )
      );
      ?>
	  </nav><!-- #site-navigation -->	
    <div class="flex gap-1 text-slate-500 text-sm">
      <?php
      the_custom_logo();
      if ( is_front_page() ) :
        ?>
        <h1><?php bloginfo( 'name' ); ?></h1>
        <?php
      else :
        ?>
        <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <?php
      endif;
      $sbktwn_description = get_bloginfo( 'description', 'display' );
      if ( $sbktwn_description || is_customize_preview() ) :
        ?>
			  <p><?php echo $sbktwn_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		  <?php endif; ?>
    </div>
	</div>

	
</header><!-- #masthead -->
