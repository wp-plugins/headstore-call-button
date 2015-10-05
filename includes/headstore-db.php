<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://headstore.com/
 * @since      0.4.1
 *
 * @package    Headstore_Config
 * @subpackage Headstore_Config/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.4.1
 * @package    Headstore_Config
 * @subpackage Headstore_Config/includes
 * @author     Your Name <info@headstore.com>
 */
class Headstore_DB {
	 
	public function __construct() {

	}
	
	public function email_exist($email) {
		global $wpdb;
		$query = $wpdb->prepare('SELECT COUNT(*)
			                     FROM '.$wpdb->prefix.'postmeta 
								 WHERE meta_key=%s AND
								       meta_value=%s ', 
								 account_meta_data::meta_email,
								 $email);
								 
		$do_select = $wpdb->get_var($query);
		return $do_select;
	}

}
