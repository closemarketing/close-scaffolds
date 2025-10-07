<?php
/**
 * Plugin Name: {{PLUGIN_NAME}}
 * Plugin URI:  https://close.marketing
 * Description: {{PLUGIN_DESCRIPTION}}
 * Version:     {{VERSION}}
 * Author:      {{PLUGIN_AUTHOR}}
 * Author URI:  https://close.marketing
 * Text Domain: {{TEXT_DOMAIN}}
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires Plugins: gp-premium, generateblocks, frontblocks, simple-image-sizes
 *
 * @package     WordPress
 * @author      {{PLUGIN_AUTHOR}}
 * @copyright   {{CURRENT_YEAR}} Closemarketing
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      {{PREFIX}}_
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

define( '{{CONSTANT_NAME}}_VERSION', '{{VERSION}}' );
define( '{{CONSTANT_NAME}}_PLUGIN', __FILE__ );
define( '{{CONSTANT_NAME}}_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( '{{CONSTANT_NAME}}_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', '{{PREFIX}}_plugin_init' );
/**
 * Load localization files
 *
 * @return void
 */
function {{PREFIX}}_plugin_init() {
	load_plugin_textdomain( '{{TEXT_DOMAIN}}', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

// Admin Custom Login.
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/custom-login/class-ccaa-admin.php';

// Post Types.
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/post-types/cpt-testimonios.php';
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/post-types/cpt-empresas.php';

/*
// Blocks.
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/blocks/register/index.php';
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/blocks-meta/titles/block.php';
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/blocks-meta/testimonios/block.php';
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/blocks-meta/empresas/block.php';
require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/blocks-meta/opiniones/block.php';
*/

// Shortcodes.
//require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/shortcodes/shortcode-one.php';

// WooCommerce.
// require_once {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/woocommerce/loader.php';

// Theme.

add_filter( 'stylesheet_directory', '{{PREFIX}}_filter_stylesheet_directory', 10, 3 );
/**
 * Adds stylesheet directory support
 *
 * @param string $stylesheet_dir Directorio de la hoja de estilos.
 * @param string $stylesheet Nombre de la hoja de estilos.
 * @param string $theme_root Directorio del tema.
 * @return string
 */
function {{PREFIX}}_filter_stylesheet_directory( $stylesheet_dir, $stylesheet, $theme_root ) {
	$stylesheet_dir = {{CONSTANT_NAME}}_PLUGIN_PATH . 'includes/theme';
	return $stylesheet_dir;
}
