<?php
add_action('wp_loaded', array('Raket_Admin_Mode', '_init'));
class Raket_Admin_Mode {

    private $current_user;
    private $current_mode_state;
    private $mode_state_key;
    private $mode_simple_state;
    private $mode_advanced_state;

    public function __construct() {

        $current_user = wp_get_current_user();
        $this->current_user = $current_user->ID;

        $this->mode_state_key = 'raket_admin_mode_current';
        $this->mode_simple_state = 'enkelt';
        $this->mode_advanced_state = 'avancerat';
        $this->current_mode_state = $this->get_current_user_admin_mode();

        // Create widgets
        add_action( 'wp_dashboard_setup', array( $this, 'create_admin_dashboard_widget' ) );
        add_action( 'admin_bar_menu', array($this, 'create_admin_bar_menu'), 100);

        // If in simple mode, do actions to hide stuff
        if($this->current_mode_state == $this->mode_simple_state){
            add_action( 'wp_dashboard_setup', array( $this, 'hide_admin_dashboard_widgets' ) );
            add_action( 'admin_menu', array( $this, 'hide_admin_menu_pages' ), 100 );
            add_action( 'admin_menu', array( $this, 'create_admin_menu_pages' ) );
            add_action( 'wp_before_admin_bar_render', array( $this, 'remove_toolbar_menus' ) );
        }

        if(isset($_GET['raket_switch_mode']) && $_GET['raket_switch_mode'] == 1){
            $this->switch_current_user_admin_mode();
            wp_redirect( remove_query_arg('raket_switch_mode'), 301 ); exit;
        }

    }

    public static function _init() {
        $class = __CLASS__;
        new $class;
    }

    public function get_current_user_admin_mode(){
        $mode = get_user_meta($this->current_user, $this->mode_state_key, true);
        return (!$mode || $mode == $this->mode_simple_state) ? $this->mode_simple_state : $this->mode_advanced_state;
    }

    private function switch_current_user_admin_mode(){
        $new_mode = ($this->current_mode_state == $this->mode_simple_state) ? $this->mode_advanced_state : $this->mode_simple_state;
        update_user_meta($this->current_user, $this->mode_state_key, $new_mode);
    }

    public function create_admin_dashboard_widget(){

        // Mode switcher widget
        wp_add_dashboard_widget('admin_mode_dashboard_widget', 'Administrationsläge', function(){
            echo "Den här webbplatsen har många funktioner som du kanske inte kommer att använda så ofta. Den här rutan ger dig möjligheten att växla mellan två lägen, ett enkelt och ett avancerat.";
            echo "<br /><br />";
            echo "Om du inte är sidans administratör, eller inte känner dig riktigt säker i WordPress rekomenderar vi att du använder det enklare läget.";
            echo "<br /><br />";
            echo "Du är just nu i <strong>" .$this->get_current_user_admin_mode(). " administrationsläge</strong>.";
            echo "<p align='right'><a href='?raket_switch_mode=1' alt='' title='' class='button action'>Ändra läge</a></p>";
        });
    }

    public function hide_admin_dashboard_widgets(){

        global $wp_meta_boxes;
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['sdf_dashboard_widget']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);


    }

    public function hide_admin_menu_pages(){

	    global $menu;
//	    dd($menu);

        // Remove pages
//        remove_menu_page( 'edit.php' );
        remove_menu_page( 'users.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'options-general.php' );
	    remove_menu_page( 'options-media.php' );
//        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'seo' );
        //remove_menu_page( 'gf_edit_forms' );

        remove_menu_page( 'update-core.php' );
        remove_menu_page( 'edit.php?post_type=acf-field-group' );
        remove_menu_page( 'eml-taxonomies-options' );
        remove_menu_page( 'wpseo_dashboard' );

	    remove_menu_page( 'fw-extensions' );
	    remove_menu_page( 'w3tc_dashboard' );

        remove_submenu_page ( 'index.php', 'update-core.php' );

    }

    public function create_admin_menu_pages(){
        //add_menu_page( __('Menus'), __('Menus'), 'manage_options', 'nav-menus.php', '', 'dashicons-editor-justify', 25 );
    }

    public function create_admin_bar_menu() {
        /** @var $wp_admin_bar WP_Admin_Bar */
        global $wp_admin_bar;
        $wp_admin_bar->add_node(array(
            'id' => 'raket_admin_mode',
            'title' => '<i class="ab-icon dashicons-layout" style="font-size: 16px; float: left; height: 20px; line-height: 24px"></i> Ändra administrationsläge',
            'href' => add_query_arg('raket_switch_mode', 1)
        ));
    }

    public function remove_toolbar_menus() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu( 'new-post' );
        $wp_admin_bar->remove_menu( 'wpseo-menu' );
        $wp_admin_bar->remove_menu( 'blog-1-c' );
        $wp_admin_bar->remove_menu( 'blog-2-c' );
        $wp_admin_bar->remove_menu( 'blog-3-c' );
        $wp_admin_bar->remove_menu( 'blog-4-c' );
        $wp_admin_bar->remove_menu( 'blog-5-c' );
    }
}
//add_action('wp_loaded','load_admin_mode_class');
