<?php

add_action('wally_modules_init', array('Wally_Profile_Settings', 'init'));
class Wally_Profile_Settings
{

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'show_user_profile', array($this, '_add_editor_mode_field'));
		add_action( 'edit_user_profile', array($this, '_add_editor_mode_field'));

		add_action( 'personal_options_update', array($this, '_save_editor_mode_field'));
		add_action( 'edit_user_profile_update', array($this, '_save_editor_mode_field'));

		add_action( 'user_register', array($this, '_w_user_register'));
	}

	public static function init() {
		$module = __CLASS__;
		new $module;
	}

	/**
	 * Set initial value for new users.
	 */
	public function _w_user_register($user_id) {
		if(!in_array('administrator', get_userdata($user_id)->roles, true)) {
			update_user_meta($user_id,'wally_editor_mode', 'easy');
			set_user_setting('editor', 'easy');
		}
	}

	/**
	 * Display field.
	 */
	public function _add_editor_mode_field($user) {
		?>

		<h3><?php _e('Tillgänglighet', 'fw') ?></h3>

		<table class="form-table">
			<tr>
				<th><label for="wally_editor_mode"><?php _e('Redigerarläge', 'fw') ?></label></th>
				<td>

					<?php
					$current = get_the_author_meta( 'wally_editor_mode', $user->ID );
					$modes = array(
						'easy' => __('Enkelt', 'fw'),
						'default' => __('Standard', 'fw'),
						'advanced' => __('Avancerat', 'fw')
					) ?>

					<select name="wally_editor_mode" id="wally_editor_mode">
						<?php foreach($modes as $mode => $label): ?>
							<option value="<?php echo $mode ?>"<?php echo $current == $mode ? ' selected' : '' ?>><?php echo $label ?></option>
						<?php endforeach ?>
					</select>
					<p class="description"><?php _e('Välj vilken typ av layout på inläggsredigeraren som ska vara förvald för denna användare.', 'fw') ?></p>

				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Save field.
	 */
	public function _save_editor_mode_field($user_id) {
		update_user_meta($user_id,'wally_editor_mode', sanitize_text_field($_POST['wally_editor_mode']));
		set_user_setting('editor', sanitize_text_field($_POST['wally_editor_mode']));
	}

}