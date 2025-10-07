<?php
/**
 * Ajustes para mi cuenta en WooCommerce
 *
 * @package    WordPress
 * @author     David Perez <david@close.technology>
 * @copyright  2023 Closemarketing
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mi cuenta.
 *
 * @since 1.8.0
 */
class CMKMN_Product_Category {

	/**
	 * Construct of Class
	 */
	public function __construct() {
		add_action( 'get_header', array( $this, 'cmkmn_product' ) );
	}

	/**
	 * Añade el contenido de la página de producto
	 *
	 * @return void
	 */
	public function cmkmn_product() {

	}
}
new CMKMN_Product_Category();
