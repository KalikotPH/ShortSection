
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
    }
    add_action( 'init', 'register_features_for_shortsection' );
    #endregion

    #region Shortcodes
    function ss_sf_storebanner() { 
      include_once( SS_PLUGIN_PATH . '/includes/view/blocks/store-focus.php' );
    } 
    add_shortcode('shortsection_storefocus', 'ss_sf_storebanner'); 
    #endregion