<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://headstore.com/
 * @since      1.0.0
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/public
 * @author     Your Name <info@headstore.com>
 */
class Headstore_Config_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	   global $wp_styles;

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/headstore-config-public.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name.'-css-ie', plugin_dir_url( __FILE__ ) . 'css/headstore-config-ie.css', array(), $this->version, 'all' );
		$wp_styles->add_data( $this->plugin_name.'-css-ie', 'conditional', 'IE' );
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, '//app.headstore.com/callme/callme.js', array( 'jquery' ), $this->version, false );

	}
	
	public function add_shortcodes() {
	    
		add_shortcode(shortcode_names::hs_call_me, array( $this, 'shortcode_hs_call_me' ));
	}
	
	public function shortcode_hs_call_me($attrs) {
		
		if (!isset($attrs['group_or_expert_id']) || !isset($attrs['design'])) return;
		ob_start();
		$campaign_id = (isset($attrs['campaign'])) ? $attrs['campaign'] : ''; 
		$type = $attrs['type'];
		$group_or_expert_id = $attrs['group_or_expert_id'];
		$design = $attrs['design'];
		include 'partials/iframe_call_me.php';
		$content = ob_get_clean();
		return $content;
	}

}
