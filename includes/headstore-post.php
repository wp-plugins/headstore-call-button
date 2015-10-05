<?php

 
class Headstore_post {

	
	public function __construct() {

	}
	
	public function get_all_hs_accounts_active(){
		
	    $args = array(
			'numberposts'       => -1,
	 		'post_type'        => account_meta_data::post_type,
			'meta_key'         => account_meta_data::meta_token,
	 		'post_status'      => 'publish');
		
	     $posts = get_posts( $args ); 
		 
		 return $posts;
		
	}
	
	public function get_post_metas_hs_accounts($post_id = 0){
		
		$meta_email = get_post_meta( $post_id, account_meta_data::meta_email, true );
		$meta_token = get_post_meta( $post_id, account_meta_data::meta_token, true );
		$meta_token_type= get_post_meta( $post_id, account_meta_data::meta_token_type, true );
		
		if(!$meta_email) $meta_email = '';
		if(!$meta_token) $meta_token = '';
		if(!$meta_token_type) $meta_token_type = '';
		
	    return array( account_meta_data::meta_email => $meta_email, 
	                  account_meta_data::meta_token => $meta_token,	
		              account_meta_data::meta_token_type => $meta_token_type);
		
	}

}
