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
  	class SS_StoreFocus_List {

        public static function listen(){
            return rest_ensure_response(
                self::list_open()
            );
        }

        public static function list_open(){

			// Initialize WP global variable
			global $wpdb;

			$category = isset($_POST['cat']) ? $_POST['cat'] : "";
			$search = isset($_POST['search']) ? $_POST['search'] : "";

			$args = array(  
				'post_type' => 'ss_sf_list',
				'post_status' => 'publish',
				'orderby' => 'title', 
				'order' => 'DESC', 
				'category_name' => $category,
				's' => $search
			);
		
			$loop = new WP_Query( $args ); 
				
			$posts = $loop->get_posts();   // $posts contains the post objects

			$initialize = false;
			$output = array();
			$counting = 0;

			foreach( $posts as $post ) {    // Pluck the id and title attributes
				$class = $initialize == true ? "" : "active";

				if($initialize == false) {
					$initialize = true;
				}
				
				$output[] = array( 
					'id' => $post->ID, 
					'title' => $post->post_title,
					'class' => $class,
					'position' => $counting,
					'preview' => SS_Globals::get_wp_featured_image($post->ID),
					'address' => $post->post_content,
					'platform' => get_post_meta($post->ID, 'online_shop_platform', true)  == "" ? "LINK" : get_post_meta($post->ID, 'online_shop_platform', true),
					'url' => get_post_meta($post->ID, 'online_shop_link', true) == "" ? "#" : get_post_meta($post->ID, 'online_shop_link', true)
				);

				$counting = $counting + 1;
			}

			// Step 9: Return result
			return array(
				"status" => "success",
				"data" => $output
			);
		}
    }
