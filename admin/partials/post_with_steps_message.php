<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

 $message = __( "You have successfully activated the 'Call-Me Button' plugin. Just follow the instructions to add your 'Call-Me button' to your website.", $this->plugin_name);
 
?>


<div id="message-first-account" class="updated" style="padding: 10px">
	<div>
		<div><strong><?php echo $message; ?></strong><share-button></share-button></div>
	</div>
	<p class="submit">
		<a href="<?php echo $href; ?>" class="button-primary" ><?php _e( 'Continue', $this->plugin_name); ?></a>
		<a href="#" id='hs-message-dismiss' class="button-primary" ><?php _e( 'Dismiss', $this->plugin_name); ?></a>
	</p>
	
</div>

 