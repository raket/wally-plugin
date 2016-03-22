<?php

add_action('wally_modules_init', array('Wally_Sitemap', 'init'));
class Wally_Sitemap
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

		if(array_key_exists('sitemap', $_REQUEST) && $_REQUEST['sitemap'] == 'true') {
			add_action('admin_init', function() {
				$this->generate_sitemap();
				header('Location: ' . remove_query_arg('sitemap'));
			});
		}

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
			'Webbplatskarta',
			'Webbplatskarta',
			'manage_options',
			'wally_settings_sitemap',
			array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		$this->options = get_option('wally_settings_sitemap');
		?>
		<div class="wrap">
			<h2>Webbplatskarta</h2>
			<form method="post" action="<?php echo add_query_arg('sitemap', 'true') ?>">

				<?php if($this->sitemap_exists()): ?>
					<p><?php echo sprintf(__('Webbplatsens webbplatskarta finns för närvarande på <a href="%1$s" target="_blank">%1$s</a>.', 'fw'), get_permalink(get_page_by_path('sitemap')->ID)) ?></p>
				<?php else: ?>

				<p><?php _e('Din webbplats har för närvarande ingen webbplatskarta. Klicka på knappen nedan för att skapa en.') ?></p>
				<input type="submit" class="button primary"<?php echo ($this->sitemap_exists()) ? ' disabled' : '' ?> value="<?php _e('Generera webbplatskarta') ?>">

				<?php endif ?>

			</form>
		</div>
		<?php
	}

	public static function sitemap_exists() {
		$sitemap = get_page_by_path('sitemap');
		return $sitemap && get_page_template_slug($sitemap->ID) === 'sitemap.php';
	}

	public function generate_sitemap() {

		if(!$this->sitemap_exists()) {

			$conflict = get_page_by_path('sitemap');

			wp_insert_post(array(
				'post_title' => __('Webbplatskarta', 'fw'),
				'post_type' => 'page',
				'post_name' => 'sitemap',
				'post_status' => 'publish',
				'page_template' => 'sitemap.php'
			));

			if($conflict) {
				wp_insert_post(array(
					'post_name' => wp_unique_post_slug(
						'sitemap',
						$conflict->ID,
						$conflict->post_status,
						$conflict->post_type,
						$conflict->post_parent
					)
				));
			}
		}
	}

}