<?php
/**
 * Plugin Name: Dynamics Sync Lite 
 * Description: Sync WordPress user profile with Dynamics 365 contact data.
 * Version:     1.0.0
 * Author:      Kaveri
 *
 * @package DynamicsSyncLiteFinal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DSL_PLUGIN_VERSION', '1.0.0' );

require_once plugin_dir_path( __FILE__ ) . 'includes/admin-setting.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-api-client.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

function dsl_create_custom_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dsl_contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        contactid VARCHAR(100) NOT NULL,
        firstname VARCHAR(100),
        lastname VARCHAR(100),
        phone VARCHAR(50),
        address TEXT,
        update_count INT DEFAULT 1,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY contactid (contactid)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'dsl_create_custom_table');

/**
 * Enqueue scripts for AJAX functionality.
 */
function dsl_enqueue_ajax_script() {
	wp_enqueue_script(
		'dsl-contact-form',
		plugin_dir_url( __FILE__ ) . 'js/dsl-contact-form.js',
		array( 'jquery' ),
		DSL_PLUGIN_VERSION,
		true
	);

	wp_enqueue_style(
		'dsl-contact-form-style',
		plugin_dir_url( __FILE__ ) . 'css/dsl-contact-form.css',
		array(),
		DSL_PLUGIN_VERSION
	);

	wp_localize_script(
		'dsl-contact-form',
		'dsl_ajax_obj',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'dsl_update_contact_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'dsl_enqueue_ajax_script' );
