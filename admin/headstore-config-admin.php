<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://headstore.com/
 * @since      1.0.0
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/admin
 * @author     Your Name <info@headstore.com>
 */
class Headstore_Config_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	
	private $option_name_step = 'step_by_step_active';
	
	private $info_multiple_account = 'info_multiple_account';
	
	private $settings; 
	
	private $my_admin_notice_error = '';
	
	private $my_admin_notice_success = '';
	
	private $error_api = '';
	
	private $save_text = '';
	
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->settings = get_option($this->plugin_name);
		$this->save_text = __( 'Save', $this->plugin_name);
		if(!$this->settings) $this->create_settings();

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/headstore-config-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'_share_button', plugin_dir_url( __FILE__ ) . 'css/share-button.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
	 
     
	}
	
    public function headstore_config_menu() {
		
	    $if_step_active = $this->settings[$this->option_name_step];
		
		if($if_step_active == 1){
	 	 
		    global $submenu;
			
		    unset($submenu['edit.php?post_type='.account_meta_data::post_type][10]);
	 
	 	   add_submenu_page('edit.php?post_type='.account_meta_data::post_type, 'First Account', 'First Account', 'edit_posts', basename(__FILE__), array( $this, 'headstore_step_create_account' ));
		
		}
		
	}
	
	public function add_post_type_account() {
		
		global $wp_version;
		$incon = get_site_url().'/wp-content/plugins/headstore-config/images/';
		$incon .=  (version_compare( $wp_version, '3.9' , '<') ) ? 'headstore-icon-blue.png' : 'headstore-icon.png';
		$accounts = __( 'Accounts', $this->plugin_name );
		
		  register_post_type( account_meta_data::post_type,
		    array(
		      'labels' => array(
				'menu_name' =>__( 'Call-Me Button', $this->plugin_name ),
		        'name' => $accounts,
				'all_items' => $accounts,
		        'singular_name' => __( 'Account', $this->plugin_name ),
				'add_new_item' => __( 'Add Additional Account', $this->plugin_name ),
				'edit_item' => __( 'Edit Account', $this->plugin_name ),
				'not_found' =>  __( "No accounts found. You can add a new account using 'Add New'.", $this->plugin_name ),
				'not_found_in_trash' =>  __( "No accounts found in Trash.", $this->plugin_name ),
		      ),
		      'public' => true,
		      'has_archive' => true,
		      'rewrite' => array('slug' => 'hsaccounts'),
			  'show_in_nav_menus' => true,
			  'supports' => array('thumbnail'),
			  'menu_icon' => $incon
		    )
		  );
	}
	
	public function add_meta_box_account(){
		
		add_meta_box( account_meta_data::post_type.'_meta', __( 'HEADSTORE Account Info', $this->plugin_name), array( $this, 'display_meta_form_account' ), account_meta_data::post_type, 'advanced', 'high' );
		
	}
	
	public function display_meta_form_account( $post ) {
		
		echo '<style type="text/css">
			           #message-info-multiple-account,
		               .updated.notice.notice-success {display: none !important;}
					   #post-body #normal-sortables {
					       min-height: 0;
					   }
					   #post-body-content, .edit-form-section {
					       margin-bottom: 0;
					   }
		       </style>';
		
		$current_screen =  get_current_screen();
		
		$message_create = true; 

		if($current_screen->action == 'add') {
			include 'partials/info_add_new_account.php';
		} else {
			include 'partials/info_edit_account.php';
			$message_create = false;
		}
		
		include 'partials/menssage_check_email.php';
 
		$email_account  = get_post_meta( $post->ID, account_meta_data::meta_email, true );
		$token = get_post_meta( $post->ID, account_meta_data::meta_token, true );
		$is_activated = true;
		if(!$token && isset($_GET['action']) && $_GET['action'] == 'edit') $is_activated = false;
		
		if($token) {
			
		    $headstore_api = new Headstore_Api();
	  
		    $experts_list = $headstore_api->get_experts_list($email_account, $token); 
	  
	        $options = '';
			
		    if($experts_list){
			    $options = $this->experts_list_select_options($experts_list);
		    }
		
		}
		
		include 'partials/meta_boxes_account.php';
		
	  
 	   $enabled_buttons = (isset($_GET['action']) && $_GET['action'] == 'edit') ? false : true;		
		
  	   wp_enqueue_script( $this->plugin_name.'_headsore_admin', plugin_dir_url( __FILE__ ) . 'js/headsore_admin.js', array( 'jquery' ), $this->version, false );
  		wp_localize_script(
  			$this->plugin_name.'_headsore_admin', 
  			'hs_values_admin',
  			array(
  				'action_check_user' => 'hs_check_user_ajax',
  				'id_ajaxurl' => site_url('/').'wp-admin/admin-ajax.php',
 				'enabled_buttons' => $enabled_buttons
  			)
  		);
		
 
	}
	
	public function headstore_step_create_account() {
		
		$script_redirect = '<script>location.href="/wp-admin/edit.php?post_type='.account_meta_data::post_type.'";</script>';
		
		$if_redirect = $this->settings[$this->option_name_step];
		 
		if($if_redirect == 0) die($script_redirect);
		
		if (isset($_POST['form-submit'])) {
			
			$create_register = true;
	
			if(empty($_POST['email_account'])){
				
				$this->show_menssage_error(__('Field Email is required',$this->plugin_name)); 
				$create_register = false;
			}
			
			if(empty($_POST['password_account'])){
				
				$this->show_menssage_error(__('Field Password is required',$this->plugin_name)); 
				$create_register = false;
			}
			
			if($create_register) {
				
				$email_account = trim($_POST['email_account']);
				$password_account = trim($_POST['password_account']);
			
				$headstore_api = new Headstore_Api();
			
				$result = $headstore_api->get_account_token($email_account, $password_account);
				
				if(isset($result['error'])){
					
					$this->show_menssage_error($result['error_description']); 
					
				} else {
					
					$post_id = $this->create_post_with_steps($email_account);
			
					if($post_id){
						
						    update_post_meta($post_id, account_meta_data::meta_email, $email_account);
							update_post_meta($post_id, account_meta_data::meta_token, $result['access_token']);
							update_post_meta($post_id, account_meta_data::meta_token_type, $result['token_type']);
							$this->settings[$this->option_name_step] = 0;
							update_option($this->plugin_name, $this->settings);
							die($script_redirect);
					}
			   }
		   }
		}
		
		include 'partials/menssage_check_email.php';
				
		include 'partials/step_create_account.php';
		
		 wp_enqueue_script( $this->plugin_name.'_headsore_admin', plugin_dir_url( __FILE__ ) . 'js/headsore_admin.js', array( 'jquery' ), $this->version, false );
		  		wp_localize_script(
		  			$this->plugin_name.'_headsore_admin', 
		  			'hs_values_admin',
		  			array(
		  				'action_check_user' => 'hs_check_user_ajax',
		  				'id_ajaxurl' => site_url('/').'wp-admin/admin-ajax.php',
		 				'enabled_buttons' => true
		  			)
		  		);
	}
	
	public function hs_post_with_message() {

        $if_step_active =  (isset($this->settings[$this->option_name_step]))? $this->settings[$this->option_name_step] : 1; 
		
		$info_multiple_account = (isset($this->settings[$this->info_multiple_account]))? $this->settings[$this->info_multiple_account] : 1 ;
		
		

		if ( $if_step_active == 1) add_action( 'admin_notices', array( $this, 'steps_message' ) );
		
		if ( $info_multiple_account == 1) add_action( 'admin_notices', array( $this, 'hs_message_info_multiple_account' ) );
			
	}
		
	public function steps_message() {
	
	   if(isset($_GET['page']) && $_GET['page'] == 'headstore-config-admin.php') return;	
		
	   $href = $this->url_create_post_with_steps();
       include 'partials/post_with_steps_message.php';
	   
	   wp_enqueue_script( $this->plugin_name.'_share_button', plugin_dir_url( __FILE__ ) . 'js/ShareButton.min.js', array( 'jquery' ), $this->version, false );
	   wp_enqueue_script( $this->plugin_name.'_add_share_button', plugin_dir_url( __FILE__ ) . 'js/add_share_button.js', array( 'jquery' ), $this->version, false );
	   wp_localize_script(
			$this->plugin_name.'_share_button', 
			'add_share_button',
			array(
				'url' => 'https://www.headstore.com',
				'comment' => __( 'Monetize your know-how with paid audio or video communication. People can call you for advice and you get paid per minute.', $this->plugin_name ),
				
			)
		);
	   wp_enqueue_script( $this->plugin_name.'_message_dissmis', plugin_dir_url( __FILE__ ) . 'js/message_dissmis.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name.'_message_dissmis', 
			'values',
			array(
				'action' => 'hs_message_dismiss_ajax',
				'id_ajaxurl' => site_url('/').'wp-admin/admin-ajax.php',
	 			'name_msj' =>  $this->option_name_step,
				'div_msj' => 'message-first-account',
			)
		);
			
	}
	
	public function save_post_headstore_account($post_id){
		
		if(empty($post_id)) return;
		
		if (wp_is_post_revision( $post_id ) ) return;
		
		if(!isset($_POST['post_type']) || $_POST['post_type'] != account_meta_data::post_type) return;	
		
		if(empty($_POST['email_account'])){
			add_filter( 'redirect_post_location', array( $this, 'hs_add_notice_error_email_account' ), 99 );
			return;
		}
		
		$email_account = trim($_POST['email_account']);
		
		update_post_meta($post_id, account_meta_data::meta_email, $email_account);

	    remove_action( 'save_post', array( $this, 'save_post_headstore_account' ), 10, 1 );
 	   
	    $my_post = array(
 	         'ID'           => $post_id,
 	         'post_title'   => $email_account,
 	     );
	     
		 wp_update_post( $my_post );
		
		 add_action( 'save_post',  array( $this, 'save_post_headstore_account' ), 10, 1  );
		
		if(empty($_POST['password_account'])){
			add_filter( 'redirect_post_location', array( $this, 'hs_add_notice_error_password_account' ), 99 );
			return;
		}

		$password_account = trim($_POST['password_account']);
		
		$headstore_api = new Headstore_Api();
	
		$result = $headstore_api->get_account_token($email_account, $password_account);
		
		if(isset($result['error'])){
			
			delete_post_meta($post_id, account_meta_data::meta_token);
			delete_post_meta($post_id, account_meta_data::meta_token_type);
			$this->error_api = urlencode($result['error_description']);
			add_filter( 'redirect_post_location', array( $this, 'hs_add_notice_error_api' ), 99 );
			return;
		}
		
		update_post_meta($post_id, account_meta_data::meta_token, $result['access_token']);
		update_post_meta($post_id, account_meta_data::meta_token_type, $result['token_type']);
		
		add_filter( 'redirect_post_location', array( $this, 'hs_add_notice_succeeded' ), 99 );
	}
	
	public function register_widget_headstore() {
		 register_widget( 'Call_Me_Button' );
	}
	
	public function hs_get_experts_ajax(){
		
		if (!isset($_POST['Keys'])) {
	  
	 	    print_r(json_encode(array("response" => 'error',
	 	    	                      "message" => __('no keys', $this->plugin_name))));
			exit;
	
		} 
		
		$vars = $_POST['Keys'][0];
		$email = $vars['email'];
		$token = $vars['token'];
	  
	    $headstore_api = new Headstore_Api();
	  
	    $experts_list = $headstore_api->get_experts_list($email, $token); 
	  
	    if(!$experts_list){
			
	 	    print_r(json_encode(array("response" => 'error',
	 	    	                      "message" => __('The user does not have experts.', $this->plugin_name))));
									  
		    exit;
	    }
		
		$options = $this->experts_list_select_options($experts_list);
		
 	    print_r(json_encode(array("response" => 'success',
 	    	                      "experts_list" => $options)));
        exit;
		
	}
	
	private function experts_list_select_options($experts_list, $webToken_selected = null){
		
		if(!$experts_list) return '';
		
		$options = '';
		foreach( $experts_list['expertsAndGroups'] as $group) {
			$webToken = $group['webToken'];
			$description = $group['shortDescription'];
			$type = $group['dataFrom'];
			$options .= '<option data-type="'.$type.'" value="'.$webToken.'"';
			if($webToken_selected !=null && $webToken_selected == $webToken) $options .= ' selected';
			$options .= '>'.$description.'</option>';
		 }
		 
		 return $options;
	}
	
	private function url_create_post_with_steps() {
		return get_home_url().'/wp-admin/edit.php?post_type='.account_meta_data::post_type.'&page=headstore-config-admin.php';
	}
		
	private function create_post_with_steps($post_title){
		
		remove_action( 'save_post', array( $this, 'save_post_headstore_account' ), 10, 1 );
		
		$user_id = get_current_user_id();
			
		$args = array('comment_status' => 'closed',
					  'post_author' => $user_id,
					  'post_status' => 'publish',
					  'post_title' => $post_title,
					  'post_type' => account_meta_data::post_type);
			
		$post_id = wp_insert_post($args);
		
		add_action( 'save_post',  array( $this, 'save_post_headstore_account' ), 10, 1  );
		
		return $post_id;

	}
	
	private function create_settings($option = '', $value = ''){
		
		$option_name_step_value = 1;
		
		if($this->option_name_step == $option)  $option_name_step_value = $value;
		
		$this->settings = array( $this->option_name_step => $option_name_step_value);
		
		update_option($this->plugin_name, $this->settings);

	}
	
	private function show_menssage_error($message) {
		include 'partials/show_menssage_error.php';
	}

	public function hs_add_notice_error_email_account( $location ) {
	   remove_filter( 'redirect_post_location', array( $this, 'hs_add_notice_error_email_account' ), 99 );
	   return add_query_arg( array( 'hs_message' => '1' ), $location );
    }
	
	public function hs_add_notice_error_password_account( $location ) {
	   remove_filter( 'redirect_post_location', array( $this, 'hs_add_notice_error_password_account' ), 99 );
	   return add_query_arg( array( 'hs_message' => '2' ), $location );
    }
	
	public function hs_add_notice_error_api( $location ) {
	   remove_filter( 'redirect_post_location', array( $this, 'hs_add_notice_error_api' ), 99 );
	   return add_query_arg( array( 'hs_message' => '3', 'error_api' => $this->error_api ), $location );
    }
	
	public function hs_add_notice_succeeded( $location ) {
	   remove_filter( 'redirect_post_location', array( $this, 'hs_add_notice_succeeded' ), 99 );
	   return add_query_arg( array( 'hs_message' => '0' ), $location );
    }
	
	public function my_admin_notices_save_post() {
		
	    if ( ! isset( $_GET['hs_message'] ) ) {
	        return;
		}
		
		$hs_message = $_GET['hs_message'];
		
		switch ($hs_message) {
		    case 0:
		        $message = __("Congratulations! You successfully connected your HEADSTORE account with this Wordpress plugin. Now you can place 'Call-Me Buttons' as",$this->plugin_name);
				$message .= ' <a href="'.get_site_url().'/wp-admin/widgets.php"  >'.__( 'widgets', $this->plugin_name).'</a> ';
				$message .= __("in the sidebar or directly in the WYSIWYG-editor",$this->plugin_name);
		        break;
		    case 1:
		        $message = __('Field Email is required',$this->plugin_name);
		        break;
		    case 2:
		        $message = __('Field Password is required',$this->plugin_name);
		        break;
		    case 3:
			    $message = '';
			    if (isset( $_GET['error_api'])) {
			       $message = __('Your password or username is wrong. Try again or click on the link below if you forgotten your password.',$this->plugin_name);
				}
		        break;
		    default:
		       $message = __('Error', $this->plugin_name);
		}
		  
	    if($hs_message == 0){
	   	    include 'partials/show_menssage_succeeded.php';
	    } else {
	        include 'partials/show_menssage_error.php';
	    }
		 
	}

	public function hs_add_button_mce() {

		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		
			add_filter( 'mce_external_plugins', array($this, 'hs_mce_plugin') );
			add_filter( 'mce_buttons', array($this, 'hs_mce_button') );
	   }
	}
	
	public function hs_mce_button( $buttons ) {
		array_push( $buttons, '|', 'headstore_button' );
		return $buttons;
	}

	public function hs_mce_plugin( $plugins ) {
		
		$headstore_post = new Headstore_post(); 
		
		$posts = $headstore_post->get_all_hs_accounts_active();
		
		$options_users = '';  
		
		$options_experts_list = '';
		
		if($posts) {
	 
			$hiddens = '';   
			
			$i = 0;
			
		    foreach( $posts as $post) {
				
			  $post_metas = $headstore_post->get_post_metas_hs_accounts($post->ID);
			  
			  $meta_email = $post_metas[account_meta_data::meta_email];
			  
			  $meta_token = $post_metas[account_meta_data::meta_token];
			  
			  $selected = '';
			  
			  if($i == 0) {
				  
				  $headstore_api = new Headstore_Api();
				  
				  $experts_list = $headstore_api->get_experts_list($meta_email, $meta_token); 
				  
				  $options_experts_list = $this->experts_list_select_options($experts_list);;  
				 
			  }

			  $options_users .=  '<option data-token='.$i.' value="'.$meta_email.'">'.$post->post_title.'</option>';
			  
			  $hiddens .= '<input type="hidden" id="hs_token_'.$i.'" value="'.$meta_token.'">';

			  $i++;
		    
			}
				
		}
		
		wp_enqueue_script( $this->plugin_name.'_mce_button', plugin_dir_url( __FILE__ ) . 'js/generate_shortcode_button.js', array( 'jquery' ), $this->version, false );
	
		wp_localize_script(
			$this->plugin_name.'_mce_button', 
			'values',
			array(
				'label_username' => __( 'Account:', $this->plugin_name ),
				'label_expert' => __( 'Expert and group :', $this->plugin_name ),
				'label_campaign' => __( 'Give your "Call-Me Button" an identifier (optional):', $this->plugin_name ),
			     'label_campaign_input_title' => __("If you have multiple 'Call-Me Buttons' the Campaign ID lets you identify which one is in use. For example if you use the same button on several sites, you can determine which site the call came from.", $this->plugin_name),
				 'label_username_input_title' => __('If you have multiple HEADSTORE accounts, you can chose one here.', $this->plugin_name),
				'label_insert_button' =>  __( 'Insert ', $this->plugin_name ),
				'label_design' =>  __( 'Design:', $this->plugin_name ),
				'shortcode_name' => shortcode_names::hs_call_me,
				'hs_token_hiddens' => $hiddens,
				'options_users' => $options_users,
				'options_experts_list' => $options_experts_list,
				'id_ajaxurl' => site_url('/').'wp-admin/admin-ajax.php',
				'label_expert_input_title' => __( 'Chose one of your groups. You can create new ones logging in with your account on https://app.headstore.com', $this->plugin_name ),
				'label_design_input_title' =>  __( 'Chose one design', $this->plugin_name ),
				'label_expert_subinfo' =>  __('It can take a few seconds to load your experts after the account has been chosen.', $this->plugin_name),
			)
		);
	
		global $wp_version;
		$url = plugin_dir_url( __FILE__ ) . 'js/';
		$url .=  (version_compare( $wp_version, '3.9' , '<') ) ? 'tinymce_3.8.js' : 'tinymce_3.9.js';
		$plugins['headstore'] = $url;
		
		return $plugins;
	}
	
	public function change_publish_button( $translation, $text, $domain ) {

		if (account_meta_data::post_type == get_post_type() && $domain == 'default' && ($text == 'Publish' || $text == 'Update')){
			return $this->save_text;
		}
		
		

		return $translation;
	}
	
	public function remove_row_options($actions, $post ) {
		
		if( $post->post_type == account_meta_data::post_type ) {
				unset( $actions['view'] );
				unset($actions['inline hide-if-no-js']);
		}
		
	    return $actions;

	}
	
	public function remove_bulk_actions() {
		
		add_filter( 'bulk_actions-edit-'.account_meta_data::post_type, '__return_empty_array' );
	
	}
	
	public function headstore_posts_columns($columns) {
		
		unset( $columns['date'] );
		$columns['title'] = __( 'Account', $this->plugin_name);
		$columns['status']= __( 'Connected with HEADSTORE', $this->plugin_name);
		return $columns;
		
	}
	
	function remove_months_dropdown_results( $months, $post_type ) {
		
		if($post_type != account_meta_data::post_type) return;
	    
		echo '<style type="text/css">
			           .button {display: none !important;}
		       </style>';
	    
		return array();
	}
	
	public function hs_message_dismiss_ajax() {
		
		if (!isset($_POST['Keys'])) {
	  
	 	    print_r(json_encode(array("response" => 'error',
	 	    	                      "message" => __('No keys', $this->plugin_name))));
			exit;
	
		} 
		
		$vars = $_POST['Keys'][0];
		$name_msj = $vars['name_msj'];
		
		switch ($name_msj) {
		    case $this->option_name_step:
		        $this->settings[$this->option_name_step] = 0;
		        break;
		    default:
		      break;
		}
	
		update_option($this->plugin_name, $this->settings);
		
 	    print_r(json_encode(array("response" => 'success',
 	    	                      "message" => 'success')));
        exit;
		
	}
		
	public function hs_message_info_multiple_account() {
		
		
		if(isset($_GET['page']) &&  $_GET['page'] == 'headstore-config-admin.php') return;	
		
	   if(!isset($_GET['post_type']) || $_GET['post_type'] != account_meta_data::post_type) return;	
		
       include 'partials/info_multiple_account.php';
	   
	}
	
	public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="'. site_url('/').'wp-admin/edit.php?post_type=headstore_account">' . __( 'Settings', $this->plugin_name) . '</a>',
			'faq' => '<a href="https://wordpress.org/plugins/headstore-call-button/faq/" target="_blank">' . __( 'FAQ', $this->plugin_name) . '</a>',
		);

		return array_merge(  $links, $action_links );
	}
	
	public function hs_check_user_ajax() {
		
		if (!isset($_POST['Keys'])) {
	  
	 	    print_r(json_encode(array("response" => 'error',
	 	    	                      "message" => __('No keys', $this->plugin_name))));
			exit;
	
		} 
		
		$vars = $_POST['Keys'][0];
		$email = $vars['email'];
		
		
		$headstore_db = new Headstore_DB();
		
		$count =  $headstore_db->email_exist($email);
		
		if($count > 0) {
			
	 	    print_r(json_encode(array("response" => 'error',
	 	    	                      "message" => __("This HEADSTORE account is already connected to the WordPress plugin. All the experts and their 'Call-Me Buttons' can already be accessed though the already connected account.", $this->plugin_name))));
			exit;
			
		}
		
 	    print_r(json_encode(array("response" => 'success',
 	    	                      "message" =>  __('The email available', $this->plugin_name))));
        exit;
		
	}
	
	public function hs_post_updated_messages( $bulk_messages, $bulk_counts ) {

	    $bulk_messages[account_meta_data::post_type] = array(
	        'updated'   => _n( '%s account updated.', '%s accounts updated.', $bulk_counts['updated'], $this->plugin_name ),
	        'locked'    => _n( '%s account not updated, somebody is editing it.', '%s accounts not updated, somebody is editing them.', $bulk_counts['locked'] , $this->plugin_name),
	        'deleted'   => _n( '%s account permanently deleted.', '%s accounts permanently deleted.', $bulk_counts['deleted'], $this->plugin_name ),
	        'trashed'   => _n( '%s account moved to the Trash.', '%s accounts moved to the Trash.', $bulk_counts['trashed'], $this->plugin_name ),
	        'untrashed' => _n( '%s account restored from the Trash.', '%s accounts restored from the Trash.', $bulk_counts['untrashed'] , $this->plugin_name),
	    );

	    return $bulk_messages;

	}
	
	public function headstore_posts_columns_data($column, $post_id) { 
		
		switch ( $column ) {
				case 'status':
				
				     $meta_token = get_post_meta( $post_id, account_meta_data::meta_token, true );
					 
					 if($meta_token){
						 
						_e('Yes', $this->plugin_name);
					 	
					 } else {
						 
						 _e('No', $this->plugin_name);
					 	
					 }
					
					break;

			    default:
			      break;
	   }
	    
	}
	

}