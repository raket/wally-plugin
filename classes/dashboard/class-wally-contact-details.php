<?php

add_action('wally_modules_init', array('Wally_Contact_Details', 'init'));
class Wally_Contact_Details
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
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
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
			'Kontaktinformation',
			'Kontaktinformation',
			'manage_options',
			'wally_settings_contact_details',
			array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		Wally_Contact_Details::$options = get_option('wally_settings_contact_details');

		?>
		<div class="wrap">
			<h1>Temainställningar</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields('wally_settings_contact_details');
				do_settings_sections('wally_settings_contact_details');
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
			'wally_settings_contact_details',
			'wally_settings_contact_details',
			array($this, 'sanitize')
		);

		// Contact details
		add_settings_section(
			'contact_details_section',
			__('Kontaktuppgifter', 'fw'),
			function() {
				print __('De kontaktuppgifter du fyller i här kan sedan visas på webbplatsen i exempelvis sidfoten eller sidhuvudet.', 'fw');
			},
			'wally_settings_contact_details'
		);

		add_settings_field(
			'phone',
			__('Telefonnummer', 'fw'),
			function() {
				printf(
					'<input type="tel" id="phone" name="wally_settings_contact_details[phone]" value="%s" />',
					isset( Wally_Contact_Details::$options['phone'] ) ? esc_attr( Wally_Contact_Details::$options['phone']) : ''
				);
			},
			'wally_settings_contact_details',
			'contact_details_section'
		);

		add_settings_field(
			'email',
			__('E-postadress', 'fw'),
			function() {
				printf(
					'<input type="email" id="email" name="wally_settings_contact_details[email]" value="%s" />',
					isset( Wally_Contact_Details::$options['email'] ) ? esc_attr( Wally_Contact_Details::$options['email']) : ''
				);
			},
			'wally_settings_contact_details',
			'contact_details_section'
		);

		add_settings_field(
			'fax',
			__('Fax', 'fw'),
			function() {
				printf(
					'<input type="fax" id="fax" name="wally_settings_contact_details[fax]" value="%s" />',
					isset( Wally_Contact_Details::$options['fax'] ) ? esc_attr( Wally_Contact_Details::$options['fax']) : ''
				);
			},
			'wally_settings_contact_details',
			'contact_details_section'
		);

		add_settings_field(
			'address',
			__('Adress', 'fw'),
			function() {
				wp_editor(sprintf(
					'%s', isset( Wally_Contact_Details::$options['address'] ) ? Wally_Contact_Details::$options['address'] : ''
				), 'footerAdress', array(
					'textarea_name' => 'wally_settings_contact_details[address]',
					'textarea_rows' => 3,
					'media_buttons' => false,
					'wpautop' => true
				));
			},
			'wally_settings_contact_details',
			'contact_details_section'
		);

		add_settings_field(
			'zip_code',
			__('Postnummer', 'fw'),
			function() {
				printf(
					'<input type="zip_code" id="zip_code" name="wally_settings_contact_details[zip_code]" value="%s" />',
					isset( Wally_Contact_Details::$options['zip_code'] ) ? esc_attr( Wally_Contact_Details::$options['zip_code']) : ''
				);
			},
			'wally_settings_contact_details',
			'contact_details_section'
		);

		add_settings_field(
			'city',
			__('Stad', 'fw'),
			function() {
				printf(
					'<input type="city" id="city" name="wally_settings_contact_details[city]" value="%s" />',
					isset( Wally_Contact_Details::$options['city'] ) ? esc_attr( Wally_Contact_Details::$options['city']) : ''
				);
			},
			'wally_settings_contact_details',
			'contact_details_section'
		);

		// Website description
		add_settings_section(
			'website_description_section',
			__('Webbplatsbeskrivning', 'fw'),
			function() {
				print __('Beskriv din webbplats i några korta meningar. Beskrivningen kan sedan visas på webbplatsen i exempelvis sidfoten eller sidhuvudet.', 'fw');
			},
			'wally_settings_contact_details'
		);

		add_settings_field(
			'website_description',
			__('Webbplatsbeskrivning', 'fw'),
			function() {
				wp_editor(sprintf(
					'%s', isset( Wally_Contact_Details::$options['website_description'] ) ? Wally_Contact_Details::$options['website_description'] : ''
				), 'footerContent', array(
					'textarea_name' => 'wally_settings_contact_details[website_description]',
					'textarea_rows' => 3
				));
			},
			'wally_settings_contact_details',
			'website_description_section'
		);

		// Website description
		add_settings_section(
			'website_description_section',
			__('Webbplatsbeskrivning', 'fw'),
			function() {
				print __('Beskriv din webbplats i några korta meningar. Beskrivningen kan sedan visas på webbplatsen i exempelvis sidfoten eller sidhuvudet.', 'fw');
			},
			'wally_settings_contact_details'
		);

		add_settings_field(
			'website_description',
			__('Webbplatsbeskrivning', 'fw'),
			function() {
				wp_editor(sprintf(
					'%s', isset( Wally_Contact_Details::$options['website_description'] ) ? Wally_Contact_Details::$options['website_description'] : ''
				), 'footerContent', array(
					'textarea_name' => 'wally_settings_contact_details[website_description]',
					'textarea_rows' => 3
				));
			},
			'wally_settings_contact_details',
			'website_description_section'
		);

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
		$new_input = array();
		if( isset( $input['phone'] ) )
			$new_input['phone'] = sanitize_text_field( $input['phone'] );

		if( isset( $input['email'] ) )
			$new_input['email'] = sanitize_email( $input['email'] );

		if( isset( $input['fax'] ) )
			$new_input['fax'] = sanitize_text_field( $input['fax'] );

		if( isset( $input['address'] ) )
			$new_input['address'] = $input['address'];

		if( isset( $input['zip_code'] ) )
			$new_input['zip_code'] = sanitize_text_field( $input['zip_code'] );

		if( isset( $input['city'] ) )
			$new_input['city'] = sanitize_text_field( $input['city'] );

		if( isset( $input['website_description'] ) )
			$new_input['website_description'] = $input['website_description'];

		return $new_input;
	}

}