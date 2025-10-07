<?php
/**
 * Loads Block
 *
 * @package    WordPress
 * @author     David Perez <david@closemarketing.es>
 * @copyright  2020 Closemarketing
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'close_register_blocks' );
/**
 * Regiters block
 *
 * @return void
 */
function close_register_blocks() {
	$assets_file = include_once CMKMN_PATH . 'includes/blocks/register/build/index.asset.php';

	wp_register_script(
		'close-register-block',
		plugins_url( './build/index.js', __FILE__ ),
		$assets_file['dependencies'],
		CMKMN_VERSION,
		true
	);

	register_block_type(
		'close/register',
		array(
			'editor_script' => 'close-register-block',
		)
	);
}
