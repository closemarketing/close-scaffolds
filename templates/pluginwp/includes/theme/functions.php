<?php
/**
 * Theme Functions
 *
 * @package    WordPress
 * @author     Closemarketing
 * @copyright  {{CURRENT_YEAR}} Closemarketing
 * @version    {{VERSION}}
 */

add_action( 'admin_init', '{{PREFIX}}_remove_google_fonts_array' );
/**
 * Remove Google Fonts from GeneratePress
 *
 * @return void
 */
function {{PREFIX}}_remove_google_fonts_array() {
	add_filter( 'generate_typography_google_fonts', '__return_empty_string', 100 ); // Must be greater than 50.
	add_filter( 'generate_google_fonts_array', '__return_empty_array' );
	add_filter( 'generate_typography_customize_list', '__return_empty_array' );
}

add_action( 'wp_enqueue_scripts', '{{PREFIX}}_theme_scripts', 99 );
/**
 * Loads Scripts
 *
 * @return void
 */
function {{PREFIX}}_theme_scripts() {
	wp_enqueue_style(
		'{{TEXT_DOMAIN}}',
		{{PREFIX_UPPER}}_PLUGIN_URL . 'includes/theme/style.css',
		array(),
		{{PREFIX_UPPER}}_VERSION
	);

	// Optimizacion de carga de estilos.
	wp_dequeue_style( 'generate-fonts' );
	wp_dequeue_style( 'generateblocks-google-fonts' );
}

/**
 * ## Gutenberg
 * --------------------------- */

// GeneratePress Editor.
add_filter(
	'block_editor_settings_all',
	function ( $editor_settings ) {
		$css                         = wp_get_custom_css_post()->post_content ?? '';
		$editor_settings['styles'][] = array( 'css' => $css );

		return $editor_settings;
	}
);

add_filter(
	'generate_editor_styles',
	function ( $editor_styles ) {
		$editor_styles[] = 'style.css';
		$editor_styles[] = 'style-editor.css';

		return $editor_styles;
	}
);
