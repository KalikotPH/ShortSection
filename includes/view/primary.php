
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

      function cm_check_if_selected($current, $value) {
        if($current == $value) {
          echo 'selected="selected"';
        } else {
          echo '';
        }
      }

      function cd_meta_box_cb()  
      {  
        $selected = get_post_meta(get_the_ID(), "online_shop_platform", true);
?>
          <select id="online_shop_platform" name="online_shop_platform" class="" style="width: 20%;" 
            value="<?= get_post_meta(get_the_ID(), "online_shop_platform", true) ?>">
            <option value="SHOPEE" <?php cm_check_if_selected("SHOPEE", $selected) ?>>SHOPEE</option>
            <option value="LAZADA" <?php cm_check_if_selected("LAZADA", $selected) ?>>LAZADA</option>
          </select>
          <input name="online_shop_link" id="online_shop_link" type="text" value="<?= get_post_meta(get_the_ID(), "online_shop_link", true) ?>" size="40" 
            aria-required="true" placeholder="Paste Online Shop Link" style="width: 70%;">
<?php
      }

      function cd_meta_box_add()
      {
        add_meta_box( 'cm_short_section_save', 'Online Store Details', 'cd_meta_box_cb', 'ss_sf_list', 'normal', 'high' );
      } 
      add_action( 'add_meta_boxes', 'cd_meta_box_add' );

    }
    add_action( 'init', 'register_features_for_shortsection' );
    #endregion

    /**
     * Save the metabox data
     */
    function cm_short_section_save() {

      global $post;
  
      if(isset($_POST["online_shop_platform"])) {
        update_post_meta($post->ID, 'online_shop_platform', $_POST["online_shop_platform"]);
      }
          
      if(isset($_POST["online_shop_link"])) {
        update_post_meta($post->ID, 'online_shop_link', $_POST["online_shop_link"]);
      }  
      
    }
    add_action( 'save_post', 'cm_short_section_save');

    #region Shortcodes
    function ss_sf_storebanner() { 
      include_once( SS_PLUGIN_PATH . '/includes/view/blocks/store-focus.php' );
    } 
    add_shortcode('shortsection_storefocus', 'ss_sf_storebanner'); 
    #endregion