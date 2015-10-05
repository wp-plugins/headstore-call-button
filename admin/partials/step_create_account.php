<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://headstore.com/
 * @since      1.0.0
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<div id="headstore-firts-account">
    <h2><?php  _e( 'Connect to HEADSTORE', $this->plugin_name); ?></h2>
        <?php _e('A HEADSTORE account is required to earn money directly to your bank account.',$this->plugin_name); ?> <br>
		
    <form id="form-headstore-firts-accoun" method="POST" >
		
		<input type="hidden" name="form-submit" value="submit">

			
	       <h3><?php _e('Create a new HEADSTORE account:',$this->plugin_name); ?></h3>
		   <?php _e("If you don't have a HEADSTORE account, please create a new account.",$this->plugin_name); ?><br>
		   <?php _e("You will be redirected to the HEADSTORE website in a new page.",$this->plugin_name); ?><br>
		   <?php _e("If you need help, please read the",$this->plugin_name); ?> <a href="https://wordpress.org/plugins/headstore-call-button/faq/"  class="hs-link" target="_blank">  <?php _e( 'FAQ', $this->plugin_name);?></a>  <?php _e("regrarding the question 'How can I create a HEADSTORE account?' and follow these steps.",$this->plugin_name); ?> <br>
		   <?php _e("After creating an account please return to this page and login in below.",$this->plugin_name); ?>
		   	<p class="submit">
		   		<a href="https://app.headstore.com/#signup" class="button-primary hs-link" target="_blank"><?php _e( 'Create', $this->plugin_name); ?></a>
		   	</p>
           <p> 
			<h3><?php _e('Login to an existing HEADSTORE account:',$this->plugin_name); ?></h3>
			<label for=""><?php _e('Email',$this->plugin_name); ?></label><br/>
			<input type="text"  id="email_account" name="email_account"  class=""/><span id="hs_spinner_email" class="spinner"></span> <br>
		
			<label for=""><?php _e('Password',$this->plugin_name); ?></label><br/>
			<input type="password" name="password_account"  class=""/>
	        </p>
		    <a href="https://app.headstore.com/#password-reset-request/" class="hs-link" target="_blank"><?php _e('Forgot your password?',$this->plugin_name); ?></a>  

           
			<p>
	            <input id="button-submit" name="button-submit" type="submit" class="button-primary button" value="<?php _e( 'Login', $this->plugin_name); ?>" tabindex="3">
			</p>
    </form>
	

</div>

