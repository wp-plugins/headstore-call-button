<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://headstore.com/
 * @since      0.4.1
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/admin/partials
 */
?>

<div class="hs-meta-boxes-account">


	<div class="hs-fields-boxes">
		<div class="wrap">
	
		   <?php if($message_create) { ?>
				<h4><?php _e( 'Login to an existing HEADSTORE account:', $this->plugin_name); ?></h4>
				<?php _e( 'If you already have another HEADSTORE account, please enter the email address registered to the account.', $this->plugin_name); ?> 
		   <?php } else { ?>
			   <!--<?php _e( 'The account that you are currently connected with is displayed below.', $this->plugin_name); ?>--> 
		   <?php } ?>
		</div>

		<div class="wrap">
			<label for=""><?php _e( 'Email', $this->plugin_name); ?> </label> <br/>
			<input class="text" type="text" id="email_account" name="email_account" value="<?php echo esc_attr($email_account); ?>" /><span id="hs_spinner_email" class="spinner"></span>
		</div>
 
		<div class="wrap">
		   <label for=""> <?php _e( 'Password', $this->plugin_name ); ?> </label>  <br/>
		   <input class="text" type="password" id="password_account" name="password_account" value="" />  <br>
		    <a href="https://<?php echo hs_backend::domain; ?>/#password-reset-request/" class="hs-link" target="_blank"><?php _e( 'Forgot your password?', $this->plugin_name); ?></a> <br><br>
		   <input name="hs-button-connect" type="button" class="button button-primary button-large" id="hs-button-connect" value="<?php  if($message_create) { _e( 'Connect', $this->plugin_name);} else { _e( 'Reconnect', $this->plugin_name);} ?>"> <!--<?php _e( 'This process can take up to one minute to complete.', $this->plugin_name); ?>--> <br>
   
		 </div>
 
		 <?php if($message_create) { ?>
		 <div class="wrap">
		    <h4><?php _e('Create a new HEADSTORE account:',$this->plugin_name); ?></h4>
		   <?php _e("If you don't have a HEADSTORE account, please create a new account.",$this->plugin_name); ?><br>
		    <!-- <?php _e("You will be redirected to the HEADSTORE website in a new page.",$this->plugin_name); ?><br> -->
		   <?php _e("After creating an account please return to this page and login in above.",$this->plugin_name); ?> <br><br>
		   	<a href="https://<?php echo hs_backend::domain; ?>/#signup" class="button-primary hs-link" target="_blank"><?php _e( 'Create', $this->plugin_name); ?></a>
  
		 </div>
		 <?php } ?>
	</div>
	<!-- 
    <?php if($token) { ?>
		<div class="hs-expert-list">
			 <h3><?php _e( "Expert and group", $this->plugin_name); ?></h3>
			<?php if($experts_list) { ?>
				<select multiple disabled>
				  <?php echo $options;?>
				</select>
		     <?php } else {?>
				 <?php _e( "The account doesn't have experts and groups", $this->plugin_name); ?>
			 <?php } ?>
	   </div>
    <?php } ?>
	 -->
</div>
