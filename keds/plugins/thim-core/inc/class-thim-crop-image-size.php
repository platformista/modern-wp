<?php
/**
 * Simple but effectively resizes images on the fly. Doesn't upsize, just downsizes like how WordPress likes it.
 * If the image already exists, it's served. If not, the image is resized to the specified size, saved for
 * future use, then served.
 *
 * @author  Benjamin Intal - Gambit Technologies Inc
 * @see     https://wordpress.stackexchange.com/questions/53344/how-to-generate-thumbnails-when-needed-only/124790#124790
 * @see     http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 */

if ( ! function_exists( 'func_otf_regen_thumbs_media_downsize' ) ) {
	/**
	 * The downsizer. This only does something if the existing image size doesn't exist yet.
	 *
	 * @param   $out  boolean false
	 * @param   $id   int Attachment ID
	 * @param   $size mixed The size name, or an array containing the width & height
	 *
	 * @return  mixed False if the custom downsize failed, or an array of the image if successful
	 */
	function func_otf_regen_thumbs_media_downsize( $out, $id, $size ) {
		// If image size exists let WP serve it like normally
		// Image attachment doesn't exist
		if ( is_admin() ) {
			return false;
		}
		if ( is_string( $size ) ) {
			return false;
		} elseif ( is_array( $size ) ) {
			$att_img = wp_get_attachment_image_src( $id, 'full' );
			if ( $att_img ) {
				$imagePath  = get_attached_file( $id );
				$crop       = array_key_exists( 2, $size ) ? $size[2] : true;
				$new_width  = $size[0];
				$new_height = $size[1];

				// If crop is false, calculate new image dimensions
				if ( ! $crop ) {
					if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
						add_filter( 'jetpack_photon_override_image_downsize', '__return_true' );
						$trueData = wp_get_attachment_image_src( $id, 'large' );

					} else {
						$trueData = wp_get_attachment_image_src( $id, 'large' );
					}
					if ( $trueData[1] > $trueData[2] ) {
						// Width > height
						$ratio      = $trueData[1] / $size[0];
						$new_height = round( $trueData[2] / $ratio );
						$new_width  = $size[0];
					} else {
						// Height > width
						$ratio      = $trueData[2] / $size[1];
						$new_height = $size[1];
						$new_width  = round( $trueData[1] / $ratio );
					}
				}
				// This would be the path of our resized image if the dimensions existed
				$imageExt  = pathinfo( $imagePath, PATHINFO_EXTENSION );
				$imagePath = preg_replace( '/^(.*)\.' . $imageExt . '$/', sprintf( '$1-%sx%s.%s', $new_width, $new_height, $imageExt ), $imagePath );

				// If it already exists, serve it
				if ( file_exists( $imagePath ) ) {
					return array( dirname( $att_img[0] ) . '/' . basename( $imagePath ), $new_width, $new_height, $crop );
				}

				$imagedata = wp_get_attachment_metadata( $id );
				// Resize somehow failed
				if ( $imagedata['width'] < $new_width && $imagedata['height'] < $new_height ) {
					return false;
				}
				// If not, resize the image...
				$resized = image_make_intermediate_size(
					get_attached_file( $id ),
					$size[0],
					$size[1],
					$crop
				);
				// Resize somehow failed
				if ( ! $resized ) {
					return false;
				}
				// Get attachment meta so we can add new size
				// Save the new size in WP so that it can also perform actions on it
				$imagedata['sizes'][$size[0] . 'x' . $size[1]] = $resized;
				wp_update_attachment_metadata( $id, $imagedata );

				// Then serve it
				return array( dirname( $att_img[0] ) . '/' . $resized['file'], $resized['width'], $resized['height'], $crop );
			}
		}

		return false;
	}

	add_filter( 'image_downsize', 'func_otf_regen_thumbs_media_downsize', 20, 3 );
}
