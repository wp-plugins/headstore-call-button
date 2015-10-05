<?php

/**
 * Fired during plugin activation
 *
 * @link       http://headstore.com/
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <info@headstore.com>
 */
class Headstore_Config_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	
	public static function activate() {
		
	    $option_name_step = 'step_by_step_active';
		
		 $info_multiple_account = 'info_multiple_account';
	
		 $plugin_name = 'headstore-call-button';
	
		
		$settings = get_option($plugin_name);
		if(!$settings) {
			$settings = array( $option_name_step => 1,
		                        $info_multiple_account => 1);
		} else {
			$settings[$option_name_step] = 1;
			$settings[$info_multiple_account] = 1;
		}
		
		update_option($plugin_name, $settings);

	}

}
