<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @package shortsection-wp-plugin
     * @version 0.1.0
     * This is where you include CSS and JS files using WP enqueue script functions.
	*/

	function ss_plugin_frontend_header(){
		wp_enqueue_style( 'ss_admin_style', SS_PLUGIN_URL . 'assets/styles/main.css' );
	}
	add_action( 'wp_enqueue_scripts', 'ss_plugin_frontend_header' );