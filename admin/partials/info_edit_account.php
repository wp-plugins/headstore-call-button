<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<div id="message-info-add-account" class="notice hs-notice">

		<?php _e( 'To edit your account or add and delete experts, please go to', $this->plugin_name); ?> <a href="https://<?php echo hs_backend::domain; ?>/" class="hs-link" target="_blank"><?php _e( 'the HEADSTORE website', $this->plugin_name); ?></a> <br>
		<?php _e( 'Important: If you want to change the email address or password of your HEADSTORE account, it must first be changed on', $this->plugin_name); ?> <a href="https://<?php echo hs_backend::domain; ?>/" class="hs-link" target="_blank"><?php _e( 'HEADSTORE', $this->plugin_name); ?></a> <?php _e( 'and then updated below.', $this->plugin_name); ?> 
		 
</div>
