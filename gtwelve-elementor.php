<?php
/**
 * Plugin Name: GTwelve Elementor
 * Description: Custom Elementor widgets for G12 pages.
 * Version: 1.0.128
 * Author: G12
 * Text Domain: gtwelve-elementor
 * Requires Plugins: elementor
 * Elementor tested up to: 3.29.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GTWELVE_ELEMENTOR_VERSION', '1.0.128' );
define( 'GTWELVE_ELEMENTOR_FILE', __FILE__ );
define( 'GTWELVE_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GTWELVE_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );

require_once GTWELVE_ELEMENTOR_PATH . 'includes/class-ai-handler.php';
require_once GTWELVE_ELEMENTOR_PATH . 'includes/plugin.php';

add_action( 'plugins_loaded', array( 'GTwelveElementor\\Plugin', 'instance' ) );
