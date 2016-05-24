<?php
// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action('wally_modules_init', array('Wally_Dashboard', '_init'));
class Wally_Dashboard
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	public static $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action('admin_menu', array( $this, '_add_dashboard_menu' ));
		add_action('admin_init', array($this, '_redirect_to_welcome'));
	}

	public static function _init() {
		$class = __CLASS__;
		new $class;
	}

	public function _redirect_to_welcome() {
		if(get_option('wally_do_activation_redirect')) {
			delete_option('wally_do_activation_redirect');
			if(!isset($_GET['activate-multi']))
			{
				wp_redirect(admin_url('admin.php?page=wally_settings&activated=true'));
				exit;
			}
		}
	}

	/**
	 * Add options page
	 */
	public function _add_dashboard_menu()
	{
		add_menu_page(
			'Wally',
			'Wally',
			'manage_options', // is null for now as we dont want a "main" page
			'wally_settings',
//			array( $this, '_add_dashboard_page' ),
			false,
			Wally::get_instance()->pluginurl . 'static/img/logo-white.svg'
		);
	}

}