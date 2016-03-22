<?php
/*
 Plugin Name: Wally
 Plugin URI: http://wally.io/
 Description: Ett tillägg för att förbättra tillgänglighet.
 Text Domain: wally
 Domain Path: /lang
 Author: Edvin Brobeck
 Version: 0.31
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );

$plugin_dir = dirname(__FILE__);
$plugin_url = plugins_url() . '/' . basename(__DIR__);

/**
 * Initate updater. Watch private repo for new releases.
 * @param $locations
 *
 * @return mixed
 */
add_action( 'init', '_w_init_autoupdate' );
function _w_init_autoupdate() {
	require_once('classes/class-wally-update.php' );
	new Wally_Update();
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'bootstrap.php';
	Wally_Bootstrap::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'bootstrap.php';
	Wally_Bootstrap::deactivate();
}
register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );


/**
 * Setup translations path
 */
add_action('plugins_loaded', 'wally_load_textdomain');
function wally_load_textdomain() {
	load_plugin_textdomain( 'fw', false, dirname( plugin_basename(__FILE__) )  );
}


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-wally.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
Wally::get_instance();