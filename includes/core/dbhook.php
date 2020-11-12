<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @package shortsection-wp-plugin
     * @version 0.1.0
     * Here is where you add hook to WP to create our custom database if not found.
	*/

	function ss_dbhook_activate(){

		//Initializing wordpress global variable
		global $wpdb;
		
	}
	add_action( 'activated_plugin', 'ss_dbhook_activate');