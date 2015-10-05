<?php

class Call_Me_Button extends WP_Widget {
	
	private $plugin_name = 'headstore-call-button';
	private $version = '1.0.0';

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'headstore', 'description' => __('Add a Headstore Call Button.', $this->plugin_name) );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'headstore-widget' );
		
		parent::__construct( 'headstore-widget', __('HEADSTORE Call Button Widget', $this->plugin_name), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		
		echo $before_widget;

		// Display the widget title 
		if ( $title ) echo $before_title . $title . $after_title;	
		
		$design = (isset($instance[widget_call_me_fields::design]))? $instance[widget_call_me_fields::design] : '' ;
		$group_or_expert_id = (isset($instance[widget_call_me_fields::expert]))? $instance[widget_call_me_fields::expert] : '' ;
		$campaign_id = (isset($instance[widget_call_me_fields::campaign]))? $instance[widget_call_me_fields::campaign] : '' ;
		$type = (isset($instance[widget_call_me_fields::type]))?  $instance[widget_call_me_fields::type] : '' ;
		
		include(ABSPATH.'/wp-content/plugins/headstore-call-button/public/partials/iframe_call_me.php');
	
		echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		// form built here!
		$defaults = array( 
		widget_call_me_fields::title => '', 
		widget_call_me_fields::username => '',
		widget_call_me_fields::expert => '',
		widget_call_me_fields::design => 1,
	    widget_call_me_fields::campaign => '',
	    widget_call_me_fields::type => '');
		
		
		
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		
		$headstore_post = new Headstore_post(); 
		
		$posts = $headstore_post->get_all_hs_accounts_active();
		
		
		if($posts) {
			
		    $options_users = '';  
	 
			$hiddens = '';   
			
			$i = 0;
			
		    foreach( $posts as $post) {
				
			  $post_metas = $headstore_post->get_post_metas_hs_accounts($post->ID);
			  
			  $meta_email = $post_metas[account_meta_data::meta_email];
			  
			  $meta_token = $post_metas[account_meta_data::meta_token];
			  
			  $selected = '';
			  
			  if( ($instance[widget_call_me_fields::username] == "" && $i == 0) || ($instance[widget_call_me_fields::username] == $meta_email)) {
			  	
				  $selected = 'selected';
				  
				  $headstore_api = new Headstore_Api();
				  
				  $experts_list = $headstore_api->get_experts_list($meta_email, $meta_token); 
				 
				  /*$options_experts_list = '';  
				  	  
	  			  if($experts_list) {
			 
	  				 foreach( $experts_list['expertsAndGroups'] as $group) {
				 
	  					 $webToken = $group['webToken'];
						 $description = $group['shortDescription'];
						 $type = $group['dataFrom'];
	  					 $options_experts_list .=  '<option  data-type="'.$type.'" value="'.$webToken.'"';
						 if($instance[widget_call_me_fields::expert] == $webToken )$options_experts_list .= ' selected';
						 $options_experts_list .= '>'.$description.'</option>';
	  				 }
				 }*/
				 
			  }

			  $options_users .=  '<option data-token='.$i.' value="'.$meta_email.'" '.$selected.'>'.$post->post_title.'</option>';
			  
			  $hiddens .= '<input type="hidden" id="hs_token_'.$i.'" value="'.$meta_token.'">';

			  $i++;
		    
			}
				
		}
		
		include 'partials/call_me_button_form.php';
		
	   wp_enqueue_script( $this->plugin_name.'_hs_call_me_button', plugin_dir_url( __FILE__ ) . 'js/call_me_button.js', array( 'jquery' ), $this->version, false );
		 
 		wp_localize_script(
 			$this->plugin_name.'_hs_call_me_button', 
 			'values',
 			array(
 				'id_ajaxurl' => site_url('/').'wp-admin/admin-ajax.php',
 			)
 		);
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		
		
		$instance = $old_instance;
		$instance[widget_call_me_fields::title] = strip_tags( $new_instance[widget_call_me_fields::title] );
		$instance[widget_call_me_fields::username] = strip_tags( $new_instance[widget_call_me_fields::username] );
		$instance[widget_call_me_fields::expert] = strip_tags( $new_instance[widget_call_me_fields::expert] );
		//$instance[widget_call_me_fields::design] = strip_tags( $new_instance[widget_call_me_fields::design] );	
		//$instance[widget_call_me_fields::campaign] = strip_tags( $new_instance[widget_call_me_fields::campaign] );
		$instance[widget_call_me_fields::type] = strip_tags( $new_instance[widget_call_me_fields::type] );
		$instance['embed_params_array'] = strip_tags( $new_instance['embed_params_array'] );
		
		
		$instance['dataFrom'] = strip_tags( $new_instance['dataFrom'] );	
		
		$instance['embed_params_array'] = $new_instance['embed_params_array'];	
		
		
		foreach( $instance['embed_params_array'] as $key => $value) { 
		
			if(array_key_exists($key.'2',$instance['embed_params_array'])) 
			{
				if($instance['embed_params_array'][$key.'2'] != "")
				{
					$instance['embed_params_array'][$key] = $instance['embed_params_array'][$key.'2'];
					$instance['embed_params_array'][$key.'2'] = "";
				}
			}	
		}
		return $instance;
		
	}
}
?>