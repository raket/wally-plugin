<?php
// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action('wally_modules_init', array('Wally_Customizer', 'init'));
class Wally_Customizer
{

	public function __construct()
	{
		add_action('customize_register', array($this, '_initialize_customizer'));
	}

	public static function init() {
		$module = __CLASS__;
		new $module;
	}

	public function _initialize_customizer($wp_customize) {
		$transfer = false;
		if ($wp_customize->get_setting('fw_options[color_theme]')) {
			$wp_customize->get_setting('fw_options[color_theme]')->transport = 'postMessage';
			$transfer = true;
		}

		if($transfer){
			add_action( 'customize_preview_init', function() {
				wp_enqueue_script(
					'wally-customizer',
					plugins_url() . '/' . basename(__DIR__) . '/static/js/theme-customizer.js',
					array( 'jquery','customize-preview' ),
					fw()->theme->manifest->get_version(),
					true
				);
			} );
		}
	}

}