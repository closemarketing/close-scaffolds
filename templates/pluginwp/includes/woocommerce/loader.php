<?php
/**
 * Loader for WooCommerce
 *
 * @package    WordPress
 * @author     David Perez <david@close.technology>
 * @copyright  2023 Closemarketing
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

require_once CMKMN_PLUGIN_PATH . 'includes/woocommerce/class-cart.php';
require_once CMKMN_PLUGIN_PATH . 'includes/woocommerce/class-checkout.php';
require_once CMKMN_PLUGIN_PATH . 'includes/woocommerce/class-myaccount.php';
require_once CMKMN_PLUGIN_PATH . 'includes/woocommerce/class-orders.php';
require_once CMKMN_PLUGIN_PATH . 'includes/woocommerce/class-product.php';
require_once CMKMN_PLUGIN_PATH . 'includes/woocommerce/class-product-cat.php';
