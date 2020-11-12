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

  	class SS_Globals {

        public static function date_stamp(){
            return date("Y-m-d h:i:s");
        }

        public static function get_wp_featured_image($postID){
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'single-post-thumbnail' );
            if(is_array($image) > 0) {
                return $image[0];
            } else {
                return SS_PLUGIN_URL . "assets/img/default-preview.jpg";
            }
        }

        public static function get_post_thumbnail_id( $post_id = null ) {
            $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
            return get_post_meta( $post_id, '_thumbnail_id', true );
        }

        /**
         * Retrieve Post Thumbnail.
         *
         * @since 2.9.0
         *
         * @param int $post_id Optional. Post ID.
         * @param string $size Optional. Image size. Defaults to 'post-thumbnail'.
         * @param string|array $attr Optional. Query string or array of attributes.
         *
        */
        function get_the_post_thumbnail_url( $post = null, $size = 'post-thumbnail' ) {
    	        $post_thumbnail_id = get_post_thumbnail_id( $post );

    	        if ( ! $post_thumbnail_id ) {
    	                return false;
    	        }

    	        return wp_get_attachment_image_url( $post_thumbnail_id, $size );
    	}

        public static function Generate_Featured_Image( $image_url, $post_id  ){
            $upload_dir = wp_upload_dir();
            $image_data = file_get_contents($image_url);
            $filename = basename($image_url);
            if(wp_mkdir_p($upload_dir['path']))
              $file = $upload_dir['path'] . '/' . $filename;
            else
              $file = $upload_dir['basedir'] . '/' . $filename;
            file_put_contents($file, $image_data);

            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
            $res2= set_post_thumbnail( $post_id, $attach_id );
        }
    }