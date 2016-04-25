<?php

add_action('wally_modules_init', array('Wally_Feedback', 'init'));
class Wally_Feedback
{

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
			'Feedback',
			'Feedback',
			'manage_options',
			'wally_settings_feedback',
			array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		$plugin_url = Wally::get_instance()->pluginurl;  ?>

		<div class="wrap dashboard__welcome">

			<section class="dashboard__welcome__intro">
				<h1>Feedback</h1>
				<p class="about-text">Har du buggar, tekniska problem eller feedback på hur Wally fungerar? <a href="http://wally-wp.se/feedback/">Klicka här för att lämna din feedback</a></p>
			</section>
			<section class="dashboard__hr">
				<h2>System</h2>
			</section>
			<section class="dashboard__welcome__boxes">
				<article class="dashboard__welcome__boxes__box">
					<h3 class="dashboard__box__h2">Mitt system</h3>
					<p class="dashboard__box__p">När du lämnar feedback om Wally kan det vara bra att skicka med systeminformation. Kopiera texten i fältet nedan, och klistra sedan in den i feedback-formuläret.</p>
					<textarea disabled style="width: 100%" rows="2"><?php echo sprintf("PHP %s: ", phpversion()) . vsprintf("%01 %s in %s at line %s", error_get_last()) ?>
						<?php print_r($_SERVER['HTTP_USER_AGENT']) ?></textarea>
				</article>

			</section>

		</div>
	<?php }
}