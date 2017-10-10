<?php
/*
Plugin Name: WP More Settings
Plugin URI: https://github.com/smessina/wp-more-settings
Description: Extra configurations for Wordpress
Author: Silvio Messina
Version: 1.0
Author URI: http://silviomessina.com/
*/

function desactivar_comentarios(){
	return false;
}
add_filter('comments_open', 'desactivar_comentarios', 20, 2);
add_filter('pings_open', 'desactivar_comentarios', 20, 2);

/* Desactivar Emojis */
function desactivar_emojicons(){
  // all actions related to emojis
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');

  // filter to remove TinyMCE emojis
  add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
add_action('init', 'desactivar_emojicons');

/* Desactivar <p> y <br> */
//remove_filter('the_content', 'wpautop');
//remove_filter('the_excerpt', 'wpautop');


?>