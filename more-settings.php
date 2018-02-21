<?php
/*
	Plugin Name: WP More Settings
	Plugin URI: https://github.com/smessina/wp-more-settings
	Description: Extra configurations for Wordpress
	Author: Silvio Messina
	Version: 1.0
	Author URI: http://silviomessina.com/
*/

/* Desactivar <p> y <br> */
//remove_filter('the_content', 'wpautop');
//remove_filter('the_excerpt', 'wpautop');

function desactivar_comentarios(){
	return false;
}
add_filter('comments_open', 'desactivar_comentarios', 20, 2);
add_filter('pings_open', 'desactivar_comentarios', 20, 2);

/* Desactivar Emojis */
function desactivar_emojicons(){
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');

	add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
add_action('init', 'desactivar_emojicons');

/* Remover query string de archivos estaticos */
function remover_cssjs_ver( $src ) {
	if( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter('style_loader_src', 'remover_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remover_cssjs_ver', 10, 2);

/* Deshabilitar WP REST API */
function deshabilitar_rest_api(){
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('template_redirect', 'rest_output_link_header', 11);
	remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
	add_filter('rest_authentication_errors', function($access) {
		return new WP_Error( 'rest_disabled', __( 'The REST API on this site has been disabled.' ), array( 'status' => rest_authorization_required_code() ) );
	});
}
add_action('init', 'deshabilitar_rest_api');
?>
