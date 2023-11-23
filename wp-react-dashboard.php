<?php
/**
 * Plugin Name: WP React dashboard Widget
 * Author: Dagem Teshome
 * Version: 1.0.0
 * Description: WordPress React dashboard widget.
 * Text-Domain: wp-react-dashboard
 */

if( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

/**
* Define Plugins Contants
*/
define ( 'WPDC_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define ( 'WPDC_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );


/**
 * Loading Necessary Scripts
 */
add_action( 'admin_enqueue_scripts', 'load_scripts' );
function load_scripts() {
    wp_enqueue_script( 'wp-react-dashboard', WPDC_URL . 'dist/bundle.js', [ 'jquery', 'wp-element' ], wp_rand(), true );
    wp_localize_script( 'wp-react-dashboard', 'appLocalizer', [
        'apiUrl' => home_url( '/wp-json' ),
        'nonce' => wp_create_nonce( 'wp_rest' ),
    ] );
}

require_once WPDC_PATH . 'classes/class-create-admin-menu.php';
require_once WPDC_PATH . 'classes/class-create-settings-routes.php';