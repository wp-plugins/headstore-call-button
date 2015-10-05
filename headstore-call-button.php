<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://headstore.com/
 * @since             1.0.0
 * @package           Headstore_Config
 *
 * @wordpress-plugin
 * Plugin Name:       Headstore Call-Me Button
 * Plugin URI:        http://headstore.com
 * Description:       Headstore is a plugin for paid video communication. You can place a "Call-Me Button" on your page and "sell your knowledge" directly through the browser.
 * Version:           1.0.0
 * Author:            Headstore AG
 * Author URI:        http://headstore.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       headstore-call-button
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_headstore_config() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/headstore-call-button-activator.php';
	Headstore_Config_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_headstore_config() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/headstore-call-button-deactivator.php';
	Headstore_Config_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_headstore_config' );
register_deactivation_hook( __FILE__, 'deactivate_headstore_config' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/headstore-call-button.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_headstore_config() {

	$plugin = new Headstore_Config();
	$plugin->run();

}
run_headstore_config();
