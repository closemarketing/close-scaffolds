<?php
/**
 * PHPStan Bootstrap File
 *
 * @package     {{PLUGIN_NAME}}
 * @author      {{PLUGIN_AUTHOR}}
 * @copyright   {{CURRENT_YEAR}} Closemarketing
 * @license     GPL-2.0+
 */

// Define WordPress constants if not defined.
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/../../' );
}

// Define plugin constants.
if ( ! defined( '{{PREFIX_UPPER}}_VERSION' ) ) {
    define( '{{PREFIX_UPPER}}_VERSION', '{{VERSION}}' );
}

if ( ! defined( '{{PREFIX_UPPER}}_FILE' ) ) {
    define( '{{PREFIX_UPPER}}_FILE', __FILE__ );
}

if ( ! defined( '{{PREFIX_UPPER}}_PATH' ) ) {
    define( '{{PREFIX_UPPER}}_PATH', __DIR__ );
}

if ( ! defined( '{{PREFIX_UPPER}}_URL' ) ) {
    define( '{{PREFIX_UPPER}}_URL', plugin_dir_url( __FILE__ ) );
}

// Load Composer autoload if exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

