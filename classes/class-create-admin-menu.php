<?php
/**
 * This file will create admin menu page.
 */

class wpdc_Create_Admin_Page {

    public function __construct() {
        add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widget' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'wpdc_dashboard_widget',
            __( 'WP React Dashboard', 'wp-react-dashboard' ),
            [ $this, 'dashboard_widget_content' ]
        );
    }

    public function dashboard_widget_content() {
        echo '<div id="wpdc-admin-app"></div>';
    }

    public function menu_page_template() {
        echo '<div class="wrap"><div id="wpdc-admin-app"></div></div>';
    }

    public function enqueue_scripts() {
        // Enqueue React and your script
        wp_enqueue_script( 'react', 'https://unpkg.com/react@16/umd/react.development.js', [], null, true );
        wp_enqueue_script( 'react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', [], null, true );

        // Enqueue your main script file
        wp_enqueue_script( 'wpdc-admin-script', plugin_dir_url( __FILE__ ) . 'path-to-your-script.js', [ 'react', 'react-dom' ], null, true );

        // Pass data to your script (if needed)
        wp_localize_script( 'wpdc-admin-script', 'wpdc_data', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            // Add any other data you need
        ]);

        // Enqueue your styles
        wp_enqueue_style( 'wpdc-admin-style', plugin_dir_url( __FILE__ ) . 'path-to-your-style.css' );
    }

}
new wpdc_Create_Admin_Page();
