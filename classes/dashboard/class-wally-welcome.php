<?php

add_action('wally_modules_init', array('Wally_Welcome', 'init'));
class Wally_Welcome
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
			'wally_settings',
			array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		Wally_Welcome::$options = get_option('wally_settings');
		$plugin_url = Wally::get_instance()->pluginurl ?>

		<div class="wrap dashboard__welcome">

			<?php //if(isset($_GET['activated'])): ?>
			<section class="dashboard__welcome__intro">
				<h1>Välkommen till Wally!</h1>
				<p class="about-text">Wally är ett WordPress-tema som hjälper dig att skapa en tillgänglighetsanpassad webbplats. Här nedanför finns tips på några av Wallys unika funktioner:</p>
			</section>
			<section class="dashboard__hr">
				<h2>Utforska Wallys funktioner</h2>
			</section>
			<section class="dashboard__welcome__boxes--3cols">
				<article class="dashboard__welcome__boxes__box">
					<figure class="dashboard__box__figure">
						<img src="<?php echo $plugin_url ?>/static/img/wally-figure-settings.svg" alt="">
					</figure>
					<h3 class="dashboard__box__h2">Anpassa webbplatsen</h3>
					<p class="dashboard__box__p">På sidan "Anpassa" under menyalternativet "Utseende" kan du göra enklare inställningar för Wallys utseende och disposition.</p>
					<a href="<?php echo admin_url() ?>customize.php?return=%2Fwp-admin%2Fadmin.php%3Fpage%3Dwally_settings_welcome">Anpassa Wally</a>
				</article>
				<article class="dashboard__welcome__boxes__box">
					<figure class="dashboard__box__figure">
						<img src="<?php echo $plugin_url ?>/static/img/wally-figure-modes.svg" alt="">
					</figure>
					<h3 class="dashboard__box__h2">Skapa en sida eller ett inlägg</h3>
					<p class="dashboard__box__p">Med Wallys olika redigeringslägen kan du skapa och redigera innehåll i ett förenklat eller avancerat läge.</p>
					<a href="<?php echo admin_url() ?>post-new.php?post_type=page">Skapa sida</a><br />
					<a href="<?php echo admin_url() ?>post-new.php?post_type=post">Skapa inlägg</a>
				</article>
				<article class="dashboard__welcome__boxes__box">
					<figure class="dashboard__box__figure">
						<img src="<?php echo $plugin_url ?>/static/img/wally-figure-user-modes.svg" alt="">
					</figure>
					<h3 class="dashboard__box__h2">Välj redigeringslägen för användare</h3>
					<p class="dashboard__box__p">Du kan välja förvalt redigeringsläge varje användare av din webbplats.</p>
					<a href="<?php echo admin_url() ?>/profile.php#user-editor-mode">Ändra redigeringsläge för användare</a>
				</article>
			</section>
			<section class="dashboard__hr">
				<h2>Lär dig mer om Wally</h2>
			</section>
			<section class="dashboard__welcome__boxes--2cols">
				<article class="dashboard__welcome__boxes__box">
					<figure class="dashboard__box__figure">
						<img src="<?php echo $plugin_url ?>/static/img/wally-figure-editor-info.svg" alt="">
					</figure>
					<h3 class="dashboard__box__h2">Manual för redaktörer</h3>
					<p class="dashboard__box__p">Läs manualen för redaktörer som vill lära sig mer om hur man jobbar med innehållet i Wally</p>
					<a href="http://www.wally-wp.se/manual/redaktorsmanual" target="_blank">Redaktörsmanual</a>
				</article>
				<article class="dashboard__welcome__boxes__box">
					<figure class="dashboard__box__figure">
						<img src="<?php echo $plugin_url ?>/static/img/wally-figure-developer-info.svg" alt="">
					</figure>
					<h3 class="dashboard__box__h2">Information för utvecklare</h3>
					<p class="dashboard__box__p">Läs mer information för utvecklare som vill bygga vidare på Wally-temat</p>
					<a href="http://www.wally-wp.se/manual/utvecklare" target="_blank">Utvecklarinformation</a>
				</article>
			</section>
		</div>
	<?php }
}