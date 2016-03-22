<?php

add_action('wally_modules_init', array('Wally_Welcome', 'init'));
class Wally_Welcome
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
	}

	public static function init() {
		$module = __CLASS__;
		new $module;
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		add_submenu_page(
			'wally_settings',
			'Välkommen',
			'Välkommen',
			'manage_options',
			'wally_settings_welcome',
			array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		$this->options = get_option('wally_settings'); ?>


		<div class="wrap about">

		<?php if(isset($_GET['activated'])): ?>
				<h1>Välkommen till Wally</h1>
				<div class="about-text">Tack för att du installerat Wally-tillägget! Wally gör det enklare att formatera ditt innehåll och anpassa din webbplats.</div>
		<?php else: ?>
				<h1>Välkommen till Wally</h1>
				<div class="about-text">Här kommer en välkomsttext visas, för att förklara funktionerna i Wally tydligare.</div>
		<?php endif ?>

		</div>


	<?php }

}