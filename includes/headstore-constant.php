<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://headstore.com/
 * @since      1.0.0
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
 * @since      1.0.0
 * @package    Headstore_Config
 * @subpackage Headstore_Config/includes
 * @author     Your Name <info@headstore.com>
 */

abstract class account_meta_data {
	const post_type = 'headstore_account';
	const meta_email = 'headstore_account_email';
    const meta_token = 'headstore_account_token';
	const meta_token_type = 'headstore_account_type';
}

abstract class session_vars_name {
	const save_post_error = 'save_post_error';
	const save_post_succeeded = 'save_post_succeeded';
}

abstract class shortcode_names {
	const hs_call_me = 'hs_call_me';
}

abstract class widget_call_me_fields {
	const title = 'title';
	const username = 'username';
	const expert = 'expert';
	const design = 'design';
	const campaign = 'campaign';
	const type = 'type';
}

abstract class hs_backend {
	const domain = 'dev1.headstore.com';
}
