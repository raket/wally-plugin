<?php

/**
 *  Bootstrap Unyson Framework
 */
if(!defined('FW')):
	require_once($plugin_dir . '/lib/unyson/framework/bootstrap.php');
	function _filter_disable_shortcodes($to_disable) {
		$to_disable[] = 'calendar';
//	    $to_disable[] = 'contact_form';
//		$to_disable[] = 'icon';
//		$to_disable[] = 'icon_box';
		$to_disable[] = 'widget_area';
//		$to_disable[] = 'map';
		$to_disable[] = 'testimonials';
		$to_disable[] = 'notification';
		$to_disable[] = 'demo_disabled';
//		$to_disable[] = 'call_to_action';
//		$to_disable[] = 'special_heading';
		$to_disable[] = 'team_member';
		return $to_disable;
	}
	add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_disable_shortcodes');

	add_action( 'admin_menu', function() {
		remove_menu_page('fw-extensions');
	}, 100 );

endif;

class Wally {

	/** @var Wally */
	private static $instance = null;

	protected $loader;
	protected $plugin_slug;
	protected $version;

	protected $actions;
	protected $filters;

	public $plugindir;
	public $pluginurl;

	private function __construct() {

		$this->plugin_slug = 'wally-plugin';
		$this->version = '0.1';

		$this->_load_modules();

		$this->_initialize_css();
		$this->_initialize_js();

		$this->_initialize_hooks();

		$this->_localize();

		$this->plugindir = plugin_dir_path(__DIR__);
		$this->pluginurl = trailingslashit(plugins_url('wally'));

	}

	public static function get_instance() {
		if(Wally::$instance === null) {
			Wally::$instance = new Wally();
		}
		return Wally::$instance;
	}

	private function _load_modules() {

		$dir = plugin_dir_path(__FILE__);

		require_once($dir . 'widgets/class-facebook-feed.php');
		require_once($dir . 'widgets/class-twitter-widget.php');
		require_once($dir . 'widgets/class-articles-widget.php');

		require_once($dir . 'dashboard/class-wally-dashboard.php');
		require_once($dir . 'dashboard/class-wally-welcome.php');
		require_once($dir . 'dashboard/class-wally-contact-details.php');
		require_once($dir . 'dashboard/class-wally-social-media.php');
		require_once($dir . 'dashboard/class-wally-sitemap.php');

		require_once($dir . 'class-wally-editor.php');
		require_once($dir . 'class-wally-profile-settings.php');
		require_once($dir . 'class-admin-mode.php');

		do_action('wally_modules_init');

	}

	private function _initialize_hooks() {

		/**
		 * Set URI path for unyson for static file referrals.
		 */
		add_filter('fw_framework_directory_uri', function(){
			return plugin_dir_url(__FILE__) . '../lib/unyson/framework';
		});

		/**
		 * Append /extensions folder to possible extension locations. Allows extending framework.
		 */
		add_filter('fw_extensions_locations', function($locations) {
			$locations[ dirname(__DIR__) . '/lib/extensions' ] = plugin_dir_url( __DIR__ ) . 'lib/extensions';
			return $locations;
		});

		add_filter( 'custom_menu_order', '__return_true' );
		add_filter( 'menu_order', function($menu_order) {
			return array(
				'index.php',
				'separator1',
				'edit.php',
				'edit.php?post_type=page',
				'edit.php?post_type=survey',
				'edit-comments.php',
				'separator2'
			);
		});

		/**
		 * Don't link images by default.
		 */
		update_option('image_default_link_type','none');
	}

	public function _localize() {
		add_action( 'plugins_loaded', function() {
			load_plugin_textdomain( 'fw', false, dirname( plugin_basename( __FILE__ ) ) . '/../lib/unyson/languages/');
		});
	}

	public function _initialize_js(){

		add_filter('mce_external_plugins', function ($plugin_array) {
			$plugin_array['fw'] =  plugin_dir_url(__FILE__) . '../static/js/wally.js';
			return $plugin_array;
		});

		add_action( 'admin_enqueue_scripts',  function() {

			wp_register_script( 'wally_editor_modes',  plugin_dir_url(__FILE__) . '../static/js/editor-modes.js');
			wp_register_script( 'wally_general',  plugin_dir_url(__FILE__) . '../static/js/general.js');

			wp_enqueue_script( 'wally_editor_modes', false, false, false, true);
			wp_enqueue_script( 'wally_general', false, false, false, true);
		});

		add_action('after_wp_tiny_mcehooks', function() {
			wp_register_script( 'wally_general',  plugin_dir_url(__FILE__) . '../static/js/general.js');
			wp_enqueue_script( 'wally_general', false, false, false, true);
		});


	}

	public function _initialize_css(){
		add_action( 'admin_enqueue_scripts',  function() {
			wp_register_style( 'wally_wp_admin_css', plugin_dir_url(__FILE__) . '../static/css/admin.css');
			wp_enqueue_style( 'wally_wp_admin_css' );
		}, 100);
	}

}