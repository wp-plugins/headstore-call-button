<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<div id="message-info-multiple-account" class="notice hs-notice">

		<?php _e( 'A HEADSTORE account is required to earn money directly to your bank account.', $this->plugin_name); ?> <br>
		<?php _e( 'Each Account is connect to one bank account.', $this->plugin_name); ?> <br>
		<?php _e( 'To receive money in multiple bank accounts, please add additional HEADSTORE accounts.', $this->plugin_name); ?> <br><br>
		<?php _e( 'To add additional experts to one account, please go to', $this->plugin_name); ?>  <a href="https://<?php echo hs_backend::domain; ?>/" class="hs-link" target="_blank"><?php _e( 'the HEADSTORE website', $this->plugin_name); ?></a> <?php _e( 'and login to manage your experts.', $this->plugin_name); ?> <br>
		<?php _e( 'Changes you make on the HEADSTORE website will automatically update on this website.', $this->plugin_name); ?> <br><br>
		<?php _e( 'The connected accounts are listed below with the experts associated with them.', $this->plugin_name); ?> <br>
		<?php _e( 'If you need help, please read the', $this->plugin_name); ?>  <a href="https://wordpress.org/plugins/headstore-call-button/faq/" class="hs-link" target="_blank">  <?php _e( 'FAQ', $this->plugin_name);?></a> <br>
	
</div>
