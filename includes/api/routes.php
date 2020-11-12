<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
        * @package shortsection-wp-plugin
		* @version 0.1.0
		* This is the primary gateway of all the rest api request.
	*/

    //Require the USocketNet class which have the core function of this plguin.
    require plugin_dir_path(__FILE__) . '/v1/store-focus/class-list.php'; // home feeds

    require plugin_dir_path(__FILE__) . '/v1/class-globals.php'; // globals

    // Init check if USocketNet successfully request from wapi.
    function shortsection_route()
    {
        /*
         * STORE LISTING RESTAPI
        */

            register_rest_route( 'shortsection/v1/stores', 'list', array(
                'methods' => 'POST',
                'callback' => array('SS_StoreFocus_List','listen'),
            ));

    }
    add_action( 'rest_api_init', 'shortsection_route' );
