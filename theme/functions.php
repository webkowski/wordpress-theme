<?php
/**
 * sbktwn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sbktwn
 */

if ( ! defined( 'SBKTWN_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'SBKTWN_VERSION', '1.0.0' );
}

if ( ! function_exists( 'sbktwn_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function sbktwn_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on sbktwn, use a find and replace
		 * to change 'sbktwn' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'sbktwn', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'sbktwn' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'sbktwn_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Add responsive embeds and block editor styles.
		 */
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style-editor.css' );
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'sbktwn_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sbktwn_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sbktwn_content_width', 640 );
}
add_action( 'after_setup_theme', 'sbktwn_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sbktwn_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'sbktwn' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'sbktwn' ),
			'before_widget' => '<section id="%1$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'sbktwn_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sbktwn_scripts() {
	wp_enqueue_style( 'sbktwn-style', get_stylesheet_uri(), array(), SBKTWN_VERSION );
	wp_enqueue_script( 'sbktwn-script', get_template_directory_uri() . '/js/script.min.js', array(), SBKTWN_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sbktwn_scripts' );

/**
 * Add the block editor class to TinyMCE.
 *
 * This allows TinyMCE to use Tailwind Typography styles with no other changes.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function sbktwn_tinymce_add_class( $settings ) {
	$settings['body_class'] = 'block-editor-block-list__layout';
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'sbktwn_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

function sbktwn_has_gallery($post_id = false) {
  if (!$post_id) {
      global $post;
  } else {
      $post = get_post($post_id);
  }
  return ( strpos($post->post_content,'[gallery') !== false); 
}


/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */ 
   function round_num($num, $to_nearest) {
    /*Round fractions down*/
    return floor($num/$to_nearest)*$to_nearest;
 }
  
 /* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).*/
 function sbktwn_pagination($before = '', $after = '') {  
     global $wpdb, $wp_query;
     $pagenavi_options = array();
     $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
     $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
     $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
     $pagenavi_options['first_text'] = ('First Page');
     $pagenavi_options['last_text'] = ('Last Page');
     $pagenavi_options['next_text'] = '&raquo;';
     $pagenavi_options['prev_text'] = '&laquo;';
     $pagenavi_options['dotright_text'] = '...';
     $pagenavi_options['dotleft_text'] = '...';
     $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
     $pagenavi_options['always_show'] = 0;
     $pagenavi_options['num_larger_page_numbers'] = 0;
     $pagenavi_options['larger_page_numbers_multiple'] = 5;
      
     //If NOT a single Post is being displayed 
     if (!is_single()) {
         $request = $wp_query->request;
         //intval — Get the integer value of a variable
         $posts_per_page = intval(get_query_var('posts_per_page'));
         //Retrieve variable in the WP_Query class. 
         $paged = intval(get_query_var('paged'));
         $numposts = $wp_query->found_posts;
         $max_page = $wp_query->max_num_pages;
          
         //empty — Determine whether a variable is empty
         if(empty($paged) || $paged == 0) {
             $paged = 1;
         }
          
         $pages_to_show = intval($pagenavi_options['num_pages']);
         $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
         $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
         $pages_to_show_minus_1 = $pages_to_show - 1;
         $half_page_start = floor($pages_to_show_minus_1/2);
         //ceil — Round fractions up
         $half_page_end = ceil($pages_to_show_minus_1/2);
         $start_page = $paged - $half_page_start;
          
         if($start_page <= 0) {
             $start_page = 1;
         }
          
         $end_page = $paged + $half_page_end;
         if(($end_page - $start_page) != $pages_to_show_minus_1) {
             $end_page = $start_page + $pages_to_show_minus_1;
         }
         if($end_page > $max_page) {
             $start_page = $max_page - $pages_to_show_minus_1;
             $end_page = $max_page;
         }
         if($start_page <= 0) {
             $start_page = 1;
         }
          
         $larger_per_page = $larger_page_to_show*$larger_page_multiple;
         //round_num() custom function - Rounds To The Nearest Value.
         $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
         $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
         $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
         $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
          
         if($larger_start_page_end - $larger_page_multiple == $start_page) {
             $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
             $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
         }   
         if($larger_start_page_start <= 0) {
             $larger_start_page_start = $larger_page_multiple;
         }
         if($larger_start_page_end > $max_page) {
             $larger_start_page_end = $max_page;
         }
         if($larger_end_page_end > $max_page) {
             $larger_end_page_end = $max_page;
         }
         if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
             /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
             $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
             $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
             echo $before.'<div class="text-xs text-slate-400 border-slate-500 flex gap-2">'."\n";
              
             if(!empty($pages_text)) {
                 //echo '<span class="pages">'.$pages_text.'</span>';
             }
             //Displays a link to the previous post which exists in chronological order from the current post. 
             previous_posts_link(sprintf('<div class="border border-solid w-6 h-6 flex justify-center items-center">%s</div>',$pagenavi_options['prev_text']));
              
             if ($start_page >= 2 && $pages_to_show < $max_page) {
                 $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                 //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote). 
                 //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                 echo '<a href="'.esc_url(get_pagenum_link()).'" class="first single_page border border-solid w-6 h-6 flex justify-center items-center" title="'.$first_page_text.'">1</a>';
                 if(!empty($pagenavi_options['dotleft_text'])) {
                     echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                 }
             }
              
             if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                 for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                     $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                     echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page border border-solid w-6 h-6 flex justify-center items-center " title="'.$page_text.'">'.$page_text.'</a>';
                 }
             }
              
             for($i = $start_page; $i  <= $end_page; $i++) {                      
                 if($i == $paged) {
                     $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                     echo '<span class="current single_page border border-solid w-6 h-6 flex justify-center items-center bg-slate-100">'.$current_page_text.'</span>';
                 } else {
                     $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                     echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page border border-solid w-6 h-6 flex justify-center items-center " title="'.$page_text.'">'.$page_text.'</a>';
                 }
             }
              
             if ($end_page < $max_page) {
                 if(!empty($pagenavi_options['dotright_text'])) {
                     echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                 }
                 $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                 echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last single_page border border-solid w-auto h-6 flex justify-center items-center " title="'.$last_page_text.'">'.$max_page.'</a>';
             }
             next_posts_link(sprintf('<div class="border border-solid w-6 h-6 flex justify-center items-center">%s</div>',$pagenavi_options['next_text']), $max_page);
              
             if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                 for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                     $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                     echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page border border-solid w-6 h-6 flex justify-center items-center " title="'.$page_text.'">'.$page_text.'</a>';
                 }
             }
             echo '</div>'.$after."\n";
         }
     }
 }

function sbktwn_previous_post_link () {
  $prev_post = get_adjacent_post(false, '', true);
  if (!empty($prev_post)) {
    echo '<a href="' . get_permalink($prev_post->ID) . '" title="' . $prev_post->post_title . '" class="border border-solid w-6 h-6 flex justify-center items-center">&laquo;</a>';
  }
}

function sbktwn_next_post_link () {
  $next_post = get_adjacent_post(false, '', false);
  if (!empty($next_post)) {
    echo '<a href="' . get_permalink($next_post->ID) . '" title="' . $next_post->post_title . '" class="border border-solid w-6 h-6 flex justify-center items-center">&raquo;</a>';
  }
 }

function sbktwn_content_div( $content ) {
  return '<div class="text-slate-400 text-sm text-left mt-2 px-1 md:px-0">'.$content.'</div>';
}
add_action('the_content','sbktwn_content_div');

function dump($var) {
  echo '<pre>';
  var_dump($var);
  echo '</pre>';
}
// function strip_gallery ($content) {
//   return $content;
//   //return preg_replace ( '/\[gallery(.*?)\]/s' , '' , $content);
// }


//   add_action('the_content', 'strip_gallery', 10);