
<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) 
	{
		exit;
	}

    /**
	    * @package shortsection-wp-plugin
      * @version 0.1.0
    */

      #region for pasabay registration post type

      /*
      * Adding a menu to contain the custom post types for frontpage
      */

    // Front Page for custom post type
    function ss_admin_menu_focused_store() {
      add_menu_page('ShortSection','ShortSection','read','ss_sf_section','','dashicons-screenoptions',4);
    }
    add_action( 'admin_menu', 'ss_admin_menu_focused_store' );

      /*
        * Creating a Custom Post type for Features Section
      */

    #region Admin Menu
    function register_features_for_shortsection() {

      $labels_for_storefocus_list = array(
        'name'                => _x( 'Featured Stores', 'Post Type General Name', 'ss_sf_list' ),
        'singular_name'       => _x( 'Featured Store', 'Post Type Singular Name', 'ss_sf_list' ),
        'menu_name'           => __( 'Featured Stores', 'ss_sf_list' ),
        'parent_item_colon'   => __( 'Parent Store', 'ss_sf_list' ),
        'all_items'           => __( 'Featured Stores', 'ss_sf_list' ),
        'view_item'           => __( 'View Store List', 'ss_sf_list' ),
        'add_new_item'        => __( 'New Store', 'ss_sf_list' ),
        'add_new'             => __( 'Add New', 'ss_sf_list' ),
        'edit_item'           => __( 'Edit', 'ss_sf_list' ),
        'update_item'         => __( 'Update', 'ss_sf_list' ),
        'search_items'        => __( 'Search', 'ss_sf_list' ),
        'not_found'           => __( 'Not Found', 'ss_sf_list' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ss_sf_list' ),
      );
      $args_for_storefocus_list = array(
        'label'               => __( 'Store List', 'ss_sf_list' ),
        'description'         => __( 'List of Stores', 'ss_sf_list' ),
        'capability_type'      => 'post',
        'labels'              => $labels_for_storefocus_list,
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
        'public'              => true,
        'show_ui'             => true,
        'publicly_queryable'  => true,
        'show_in_menu'        => 'ss_sf_section',
        
        // This is where we add taxonomies to our CPT
        'taxonomies'          => array( 'category' ),
      );
      register_post_type( 'ss_sf_list', $args_for_storefocus_list );

      function cd_meta_box_cb()  
      {  
        echo 'What you put here, show\'s up in the meta box';     
      }

      function cd_meta_box_add()
      {
        add_meta_box( 'my-meta-box-id', 'Online Store Details', 'cd_meta_box_cb', 'ss_sf_list', 'normal', 'high' );
      } 
      add_action( 'add_meta_boxes', 'cd_meta_box_add' );

    }
    add_action( 'init', 'register_features_for_shortsection' );
    #endregion

    /**
 * Save the metabox data
 */
function cm_short_section_save( $post_id, $post ) {

	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['location'] ) || ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	$events_meta['location'] = esc_textarea( $_POST['location'] );

	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $events_meta as $key => $value ) :

		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}

	endforeach;

}
add_action( 'save_post', 'cm_short_section_save', 1, 2 );

    #region Shortcodes
    function ss_sf_storebanner() { 
      include_once( SS_PLUGIN_PATH . '/includes/view/blocks/store-focus.php' );
    } 
    add_shortcode('shortsection_storefocus', 'ss_sf_storebanner'); 
    #endregion