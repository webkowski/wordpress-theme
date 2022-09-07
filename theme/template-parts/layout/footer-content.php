<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sbktwn
 */
?>
<footer class="flex flex-col md:flex-row justify-between px-8 py-2 text-xs bg-white gap-2 text-slate-300 w-full fixed left-0 bottom-0 items-center">
  <?php
    if (function_exists('sbktwn_pagination')) { 
      sbktwn_pagination();
    }
    if ( is_singular() ) {
  ?>
    <div class="flex flex-row gap-2">
      <?php
        if (function_exists('sbktwn_previous_post_link')) {
          sbktwn_previous_post_link();
        }
        if (function_exists('sbktwn_next_post_link')) {
          sbktwn_next_post_link();
        }
      ?>
    </div>
    <?php } ?>
	Copyright 2002 - 2022 Piotr Łepkowski
</footer>
