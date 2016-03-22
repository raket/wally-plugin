<?php

add_action('wally_modules_init', array('Wally_Social_media', 'init'));
class Wally_Social_media
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
		add_action( 'admin_menu', array( $this, 'add_plugin_page'));
		add_action( 'admin_init', array( $this, 'page_init'));
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
			'Sociala medier',
			'Sociala medier',
			'manage_options',
			'wally_settings_social_media',
			array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		$this->options = get_option('wally_settings_social_media');
		?>
		<div class="wrap">
			<h2>Temainställningar</h2>
			<form method="post" action="options.php">
				<?php
				settings_fields('wally_settings_social_media');
				do_settings_sections('wally_settings_social_media');
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init()
	{
		register_setting(
			'wally_settings_social_media',
			'wally_settings_social_media',
			array($this, 'sanitize')
		);

		// Contact details
		add_settings_section(
			'default', // Use 'default' as we only need one section
			__('Sociala medier', 'fw'),
			function() {
				print __('Här ställer du in allt som berör hur Sociala medier visas på din webbplats.', 'wally');
			},
			'wally_settings_social_media'
		);


		add_settings_field(
			'facebook',
			__('Facebook', 'fw'),
			function() {
				printf(
					'<input type="text" id="facebook" name="wally_settings_social_media[facebook]" value="%s" />',
					isset( $this->options['facebook'] ) ? esc_attr( $this->options['facebook']) : ''
				);
			},
			'wally_settings_social_media'
		);

		add_settings_field(
			'twitter',
			__('Twitter', 'fw'),
			function() {
				printf(
					'<input type="text" id="twitter" name="wally_settings_social_media[twitter]" value="%s" />',
					isset( $this->options['twitter'] ) ? esc_attr( $this->options['twitter']) : ''
				);
			},
			'wally_settings_social_media'
		);

		add_settings_field(
			'youtube',
			__('Youtube', 'fw'),
			function() {
				printf(
					'<input type="text" id="youtube" name="wally_settings_social_media[youtube]" value="%s" />',
					isset( $this->options['youtube'] ) ? esc_attr( $this->options['youtube']) : ''
				);
			},
			'wally_settings_social_media'
		);

		add_settings_field(
			'bambuser',
			__('Bambuser', 'fw'),
			function() {
				printf(
					'<input type="text" id="bambuser" name="wally_settings_social_media[bambuser]" value="%s" />',
					isset($this->options['bambuser']) ? esc_attr( $this->options['bambuser']) : ''
				);
			},
			'wally_settings_social_media'
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 * @return array
	 */
	public function sanitize( $input )
	{
		$new_input = array();

		if(isset( $input['facebook']))
			$new_input['facebook'] = sanitize_text_field( $input['facebook'] );

		if( isset( $input['twitter'] ) )
			$new_input['twitter'] = sanitize_text_field( $input['twitter'] );

		if( isset( $input['youtube'] ) )
			$new_input['youtube'] = sanitize_text_field( $input['youtube'] );

		if( isset( $input['bambuser'] ) )
			$new_input['bambuser'] = sanitize_text_field( $input['bambuser'] );

		return $new_input;
	}

}