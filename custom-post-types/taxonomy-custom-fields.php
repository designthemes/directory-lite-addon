<?php

if( !class_exists('DTDirectoryLiteTaxonomyCustomFields') ) {

	class DTDirectoryLiteTaxonomyCustomFields {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_filter ( 'dtdr_taxonomies', array ( $this, 'dtdr_update_taxonomies' ), 10, 1 );

			$taxonomies = apply_filters( 'dtdr_taxonomies', array () );

			foreach($taxonomies as $taxonomy => $taxonomy_label) {
				add_action ( $taxonomy.'_add_form_fields', array ( $this, 'dtdr_add_taxonomy_form_fields' ), 10, 2 );
				add_action ( 'created_'.$taxonomy, array ( $this, 'dtdr_save_taxonomy_form_fields' ), 10, 2 );
				add_action ( $taxonomy.'_edit_form_fields', array ( $this, 'dtdr_update_taxonomy_form_fields' ), 10, 2 );
				add_action ( 'edited_'.$taxonomy, array ( $this, 'dtdr_updated_taxonomy_form_fields' ), 10, 2 );
			}

		}

		function dtdr_update_taxonomies($taxonomies) {

			$amenity_singular_label      = apply_filters( 'amenity_label', 'singular' );
			$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );

			$taxonomies['dtdr_listings_category'] = esc_html__('Category','dtdr-lite');
			$taxonomies['dtdr_listings_ctype']    = sprintf( esc_html__('%1$s','dtdr-lite'), $contracttype_singular_label );
			$taxonomies['dtdr_listings_amenity']  = sprintf( esc_html__('%1$s','dtdr-lite'), $amenity_singular_label );

			return $taxonomies;

		}

		function dtdr_add_taxonomy_form_fields ( $taxonomy ) {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			echo '<div class="form-field term-group">
					<label for="taxonomy-image">'.esc_html__('Image','dtdr-lite').'</label>
					<div class="dtdr-upload-media-items-container">
						<input name="dtdr-taxonomy-image-url" type="hidden" class="uploadfieldurl" readonly value=""/>
						<input name="dtdr-taxonomy-image-id" type="hidden" class="uploadfieldid" readonly value=""/>
						<input type="button" value="'.esc_html__( 'Add Image','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview with-image-holder" />
						'.dtdr_adminpanel_image_preview('').'
					</div>
					<p>'.esc_html__('This image will be used for "Taxonomy" shortcodes.','dtdr-lite').'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-icon-image">'.esc_html__('Icon Image','dtdr-lite').'</label>
					<div class="dtdr-upload-media-items-container">
						<input name="dtdr-taxonomy-icon-image-url" type="hidden" class="uploadfieldurl" readonly value=""/>
						<input name="dtdr-taxonomy-icon-image-id" type="hidden" class="uploadfieldid" readonly value=""/>
						<input type="button" value="'.esc_html__( 'Add Image','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview with-image-holder" />
						'.dtdr_adminpanel_image_preview('').'
					</div>
					<p>'.sprintf( esc_html__('This icon image will be used in "Taxonomy" shortcodes, %1$s listing & Maps.','dtdr-lite'), $listing_singular_label ).'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-icon">'.esc_html__('Icon','dtdr-lite').'</label>
					<input type="text" name="dtdr-taxonomy-icon" value="">
					<p>'.esc_html__('This icon will be used for both "Taxonomy" shortcodes & Maps.','dtdr-lite').'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-icon-color">'.esc_html__( 'Icon Color','dtdr-lite').'</label>
					<input name="dtdr-taxonomy-icon-color" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="" />
					<p>'.esc_html__('This icon color will be used for both "Taxonomy" shortcodes & Maps.','dtdr-lite').'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-background-color">'.esc_html__( 'Background Color','dtdr-lite').'</label>
					<input name="dtdr-taxonomy-background-color" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="" />
					<p>'.sprintf( esc_html__('This background color will be used in "Taxonomy" shortcodes, %1$s listing & Maps.','dtdr-lite'), $listing_singular_label ).'</p>
				</div>';

			echo '<div class="form-field term-group">
					<label for="taxonomy-text-color">'.esc_html__( 'Text Color','dtdr-lite').'</label>
					<input name="dtdr-taxonomy-text-color" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="" />
					<p>'.sprintf( esc_html__('This text color will be used in "Taxonomy" shortcodes & %1$s listing.','dtdr-lite'), $listing_singular_label ).'</p>
				</div>';

		}

		function dtdr_save_taxonomy_form_fields ( $term_id, $tt_id ) {

			if( isset( $_POST['dtdr-taxonomy-image-url'] ) ){
				$image_url = sanitize_text_field( $_POST['dtdr-taxonomy-image-url'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-image-url', $image_url, true );
			}

			if( isset( $_POST['dtdr-taxonomy-image-id'] ) ){
				$image_id = sanitize_text_field( $_POST['dtdr-taxonomy-image-id'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-image-id', $image_id, true );
			}

			if( isset( $_POST['dtdr-taxonomy-icon-image-url'] ) ){
				$image_url = sanitize_text_field( $_POST['dtdr-taxonomy-icon-image-url'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-icon-image-url', $image_url, true );
			}

			if( isset( $_POST['dtdr-taxonomy-icon-image-id'] ) ){
				$image_id = sanitize_text_field( $_POST['dtdr-taxonomy-icon-image-id'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-icon-image-id', $image_url, true );
			}

			if( isset( $_POST['dtdr-taxonomy-icon'] ) ){
				$icon = sanitize_text_field( $_POST['dtdr-taxonomy-icon'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-icon', $icon, true );
			}

			if( isset( $_POST['dtdr-taxonomy-icon-color'] ) ){
				$icon_color = sanitize_text_field( $_POST['dtdr-taxonomy-icon-color'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-icon-color', $icon_color, true );
			}

			if( isset( $_POST['dtdr-taxonomy-background-color'] ) ){
				$background_color = sanitize_text_field( $_POST['dtdr-taxonomy-background-color'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-background-color', $background_color, true );
			}

			if( isset( $_POST['dtdr-taxonomy-text-color'] ) ){
				$text_color = sanitize_text_field( $_POST['dtdr-taxonomy-text-color'] );
				add_term_meta( $term_id, 'dtdr-taxonomy-text-color', $text_color, true );
			}

		}

		function dtdr_update_taxonomy_form_fields ( $term, $taxonomy ) {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-image">'.esc_html__('Image','dtdr-lite').'</label>
					</th>
					<td>';
						$image_url = get_term_meta( $term->term_id, 'dtdr-taxonomy-image-url', true );
						$image_id = get_term_meta( $term->term_id, 'dtdr-taxonomy-image-id', true );
					echo '<div class="dtdr-upload-media-items-container">
							<input name="dtdr-taxonomy-image-url" type="hidden" class="uploadfieldurl" readonly value="'.esc_attr( $image_url ).'"/>
							<input name="dtdr-taxonomy-image-id" type="hidden" class="uploadfieldid" readonly value="'.esc_attr( $image_id ).'"/>
							<input type="button" value="'.esc_html__( 'Add Image','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview with-image-holder" />
							<input type="button" value="'.esc_html__('Remove Image','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
							'.dtdr_adminpanel_image_preview($image_url).'
						</div>
						<p>'.esc_html__('This image will be used for "Taxonomy" shortcodes.','dtdr-lite').'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-icon-image">'.esc_html__('Icon Image','dtdr-lite').'</label>
					</th>
					<td>';
						$image_url = get_term_meta( $term->term_id, 'dtdr-taxonomy-icon-image-url', true );
						$image_id = get_term_meta( $term->term_id, 'dtdr-taxonomy-icon-image-id', true );
					echo '<div class="dtdr-upload-media-items-container">
							<input name="dtdr-taxonomy-icon-image-url" type="hidden" class="uploadfieldurl" readonly value="'.esc_attr( $image_url ).'"/>
							<input name="dtdr-taxonomy-icon-image-id" type="hidden" class="uploadfieldid" readonly value="'.esc_attr( $image_id ).'"/>
							<input type="button" value="'.esc_html__( 'Add Image','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview with-image-holder" />
							<input type="button" value="'.esc_html__('Remove Image','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
							'.dtdr_adminpanel_image_preview($image_url).'
						</div>
						<p>'.sprintf( esc_html__('This icon image will be used in "Taxonomy" shortcodes, %1$s listing & Maps.','dtdr-lite'), $listing_singular_label ).'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-icon">'.esc_html__('Icon','dtdr-lite').'</label>
					</th>
					<td>';
						$icon = get_term_meta ( $term->term_id, 'dtdr-taxonomy-icon', true );
						echo '<input type="text" name="dtdr-taxonomy-icon" value="'.esc_attr( $icon ).'">
						<p>'.esc_html__('This icon will be used for both "Taxonomy" shortcodes & Maps.','dtdr-lite').'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-icon-color">'.esc_html__('Icon Color','dtdr-lite').'</label>
					</th>
					<td>';
						$icon_color = get_term_meta ( $term->term_id, 'dtdr-taxonomy-icon-color', true );
						echo '<input name="dtdr-taxonomy-icon-color" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.esc_attr( $icon_color ).'" />
						<p>'.esc_html__('This icon color will be used for both "Taxonomy" shortcodes & Maps.','dtdr-lite').'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="background-color">'.esc_html__('Background Color','dtdr-lite').'</label>
					</th>
					<td>';
						$background_color = get_term_meta ( $term->term_id, 'dtdr-taxonomy-background-color', true );
						echo '<input name="dtdr-taxonomy-background-color" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.esc_attr( $background_color ).'" />
						<p>'.sprintf( esc_html__('This background color will be used in "Taxonomy" shortcodes, %1$s listing & Maps.','dtdr-lite'), $listing_singular_label ).'</p>
					</td>
				</tr>';

			echo '<tr class="form-field term-group-wrap">
					<th scope="row">
						<label for="taxonomy-text-color">'.esc_html__('Text Color','dtdr-lite').'</label>
					</th>
					<td>';
						$text_color = get_term_meta ( $term->term_id, 'dtdr-taxonomy-text-color', true );
						echo '<input name="dtdr-taxonomy-text-color" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.esc_attr( $text_color ).'" />
						<p>'.sprintf( esc_html__('This text color will be used in "Taxonomy" shortcodes & %1$s listing.','dtdr-lite'), $listing_singular_label ).'</p>
					</td>
				</tr>';

		}

		function dtdr_updated_taxonomy_form_fields ( $term_id, $tt_id ) {

			//Don't update on Quick Edit
			if (defined('DOING_AJAX') ) {
				return $post_id;
			}

			if( isset( $_POST['dtdr-taxonomy-image-url'] ) && '' !== $_POST['dtdr-taxonomy-image-url'] ){
				$image_url = $_POST['dtdr-taxonomy-image-url'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-image-url', sanitize_text_field( $image_url ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-image-url', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-image-id'] ) && '' !== $_POST['dtdr-taxonomy-image-id'] ){
				$image_id = $_POST['dtdr-taxonomy-image-id'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-image-id', sanitize_text_field( $image_id ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-image-id', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-icon-image-url'] ) && '' !== $_POST['dtdr-taxonomy-icon-image-url'] ){
				$image_url = $_POST['dtdr-taxonomy-icon-image-url'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon-image-url', sanitize_text_field( $image_url ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon-image-url', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-icon-image-id'] ) && '' !== $_POST['dtdr-taxonomy-icon-image-id'] ){
				$image_id = $_POST['dtdr-taxonomy-icon-image-id'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon-image-id', sanitize_text_field( $image_id ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon-image-id', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-icon'] ) && '' !== $_POST['dtdr-taxonomy-icon'] ){
				$icon = $_POST['dtdr-taxonomy-icon'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon', sanitize_text_field( $icon ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-icon-color'] ) && '' !== $_POST['dtdr-taxonomy-icon-color'] ){
				$icon_color = $_POST['dtdr-taxonomy-icon-color'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon-color', sanitize_text_field( $icon_color ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-icon-color', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-background-color'] ) && '' !== $_POST['dtdr-taxonomy-background-color'] ){
				$background_color = $_POST['dtdr-taxonomy-background-color'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-background-color', sanitize_text_field( $background_color ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-background-color', '' );
			}

			if( isset( $_POST['dtdr-taxonomy-text-color'] ) && '' !== $_POST['dtdr-taxonomy-text-color'] ){
				$text_color = $_POST['dtdr-taxonomy-text-color'];
				update_term_meta ( $term_id, 'dtdr-taxonomy-text-color', sanitize_text_field( $text_color ) );
			} else {
				update_term_meta ( $term_id, 'dtdr-taxonomy-text-color', '' );
			}

		}


	}

	DTDirectoryLiteTaxonomyCustomFields::instance();

}

?>