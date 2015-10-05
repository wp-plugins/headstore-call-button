<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://headstore.com/
 * @since      1.0.0
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Headstore_Config
 * @subpackage Headstore_Config/includes
 * @author     Your Name <info@headstore.com>
 */
class Headstore_Config {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'headstore-call-button';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/headstore-call-button-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/headstore-call-button-i18n.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/headstore-constant.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/headstore-api.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/headstore-post.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/widgets/call_me_button.php';
		
	    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/headstore-db.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/headstore-call-button-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/headstore-call-button-public.php';

		$this->loader = new Headstore_Config_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Headstore_Config_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Headstore_Config_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'headstore_config_menu' );
		$this->loader->add_action( 'init', $plugin_admin, 'add_post_type_account' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_meta_box_account' );
		$this->loader->add_action( 'admin_print_styles', $plugin_admin, 'hs_post_with_message' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_post_headstore_account', 10, 1);
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'my_admin_notices_save_post');
		$this->loader->add_action( 'wp_ajax_hs_get_experts_ajax', $plugin_admin, 'hs_get_experts_ajax');
		$this->loader->add_action( 'wp_ajax_nopriv_hs_get_experts_ajax', $plugin_admin, 'hs_get_experts_ajax');
		$this->loader->add_action( 'widgets_init', $plugin_admin, 'register_widget_headstore');
		$this->loader->add_action( 'admin_init', $plugin_admin, 'hs_add_button_mce');
		$this->loader->add_action( 'admin_init', $plugin_admin, 'remove_bulk_actions');
		$this->loader->add_action( 'post_row_actions', $plugin_admin, 'remove_row_options', 10, 2);
		$this->loader->add_filter( 'gettext', $plugin_admin, 'change_publish_button', 10, 3);
		$this->loader->add_filter( 'manage_'.account_meta_data::post_type.'_posts_columns', $plugin_admin, 'headstore_posts_columns');
		$this->loader->add_filter( 'months_dropdown_results', $plugin_admin, 'remove_months_dropdown_results', 10, 2);
		$this->loader->add_action( 'wp_ajax_hs_message_dismiss_ajax', $plugin_admin, 'hs_message_dismiss_ajax');
		$this->loader->add_action( 'wp_ajax_nopriv_hs_message_dismiss_ajax', $plugin_admin, 'hs_message_dismiss_ajax');
		$this->loader->add_filter( 'plugin_action_links_headstore-call-button/headstore-call-button.php', $plugin_admin, 'plugin_action_links');
		$this->loader->add_action( 'wp_ajax_hs_check_user_ajax', $plugin_admin, 'hs_check_user_ajax');
		$this->loader->add_action( 'wp_ajax_nopriv_hs_check_user_ajax', $plugin_admin, 'hs_check_user_ajax');
		$this->loader->add_filter( 'bulk_post_updated_messages', $plugin_admin, 'hs_post_updated_messages', 10, 2);
		$this->loader->add_action( 'manage_'.account_meta_data::post_type.'_posts_custom_column', $plugin_admin, 'headstore_posts_columns_data', 10, 2);
		
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Headstore_Config_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'add_shortcodes' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
