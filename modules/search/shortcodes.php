<?php
if( !class_exists('DTDirectoryLiteSearchFormShortcodes') ) {

	class DTDirectoryLiteSearchFormShortcodes {

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

			add_shortcode ( 'dtdr_sf_keyword_field', array ( $this, 'dtdr_sf_keyword_field' ) );
			add_shortcode ( 'dtdr_sf_categories_field', array ( $this, 'dtdr_sf_categories_field' ) );
			add_shortcode ( 'dtdr_sf_tags_field', array ( $this, 'dtdr_sf_tags_field' ) );
			add_shortcode ( 'dtdr_sf_ctype_field', array ( $this, 'dtdr_sf_ctype_field' ) );
			add_shortcode ( 'dtdr_sf_features_field', array ( $this, 'dtdr_sf_features_field' ) );
			add_shortcode ( 'dtdr_sf_orderby_field', array ( $this, 'dtdr_sf_orderby_field' ) );
			add_shortcode ( 'dtdr_sf_mls_number_field', array ( $this, 'dtdr_sf_mls_number_field' ) );

			add_shortcode ( 'dtdr_sf_submit_button', array ( $this, 'dtdr_sf_submit_button' ) );

			add_shortcode ( 'dtdr_sf_output_data_container', array ( $this, 'dtdr_sf_output_data_container' ) );

		}

		function dtdr_shortcodeHelper($content = null) {
			$content = do_shortcode ( shortcode_unautop ( $content ) );
			$content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
			$content = preg_replace ( '#<br \/>#', '', $content );
			return trim ( $content );
		}

		function dtdr_sf_keyword_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'placeholder_text' => '',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtdr_sf_keyword_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-keyword-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtdr-with-ajax-load';
				}

				$placeholder_text = esc_html__('Keyword','dtdr-lite');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				$dtdr_sf_keyword = '';
				if(isset($_REQUEST['dtdr_sf_keyword']) && $_REQUEST['dtdr_sf_keyword'] != '') {
					$dtdr_sf_keyword = $_REQUEST['dtdr_sf_keyword'];
				}

				$output .= '<input name="dtdr_sf_keyword" class="dtdr-sf-field dtdr-sf-keyword '.esc_attr($additional_class).'" type="text" value="'.esc_attr($dtdr_sf_keyword).'" placeholder="'.esc_attr($placeholder_text).'" />';
				$output .= '<span></span>';

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_categories_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type'              => '',
						'placeholder_text'        => '',
						'dropdown_type'           => '',
						'ajax_load'               => '',
						'default_item_id'         => '',
						'show_parent_items_alone' => 'false',
						'child_of'                => '',
						'class'                   => '',

					), $attrs, 'dtdr_sf_categories_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-categories-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtdr-with-ajax-load';
				}

				$dtdr_sf_categories = array ();
				if(isset($_REQUEST['dtdr_sf_categories'])) {
					if(is_array($_REQUEST['dtdr_sf_categories']) && !empty($_REQUEST['dtdr_sf_categories'])) {
						$dtdr_sf_categories = $_REQUEST['dtdr_sf_categories'];
					} else if($_REQUEST['dtdr_sf_categories'] != '') {
						$dtdr_sf_categories = explode(',', $_REQUEST['dtdr_sf_categories']);
					}
				} elseif($attrs['default_item_id'] != '') {
					$dtdr_sf_categories = explode(',', $attrs['default_item_id']);
				}

				$placeholder_text = esc_html__('Categories','dtdr-lite');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				if($attrs['field_type'] == 'dropdown') {

					$mulitple_attr = '';
					if($attrs['dropdown_type'] == 'multiple') {
						$mulitple_attr = 'multiple';
					}

					$output .= '<select class="dtdr-sf-field dtdr-sf-categories '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_categories" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
						if($mulitple_attr == '') {
							$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
						}

						$categories_args = array (
							'taxonomy'   => 'dtdr_listings_category',
							'hide_empty' => 1,
						);

						if($attrs['child_of'] != '') {
							$categories_args['child_of'] = $attrs['child_of'];
						} else {
							$categories_args['parent'] = 0;
						}
						$listing_categories = get_categories($categories_args);

						if(is_array($listing_categories) && !empty($listing_categories)) {
							foreach($listing_categories as $listing_category) {
								$selected_attr = '';
								if(in_array($listing_category->term_id, $dtdr_sf_categories)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($listing_category->term_id).'" '.$selected_attr.'>'.esc_html($listing_category->name).'</option>';

								if($attrs['show_parent_items_alone'] != 'true') {

									// Child Items
									$listing_category_childs = get_categories('taxonomy=dtdr_listings_category&hide_empty=1&child_of='.$listing_category->term_id);
									if(is_array($listing_category_childs) && !empty($listing_category_childs)) {
										foreach($listing_category_childs as $listing_category_child) {
											$selected_attr = '';
											if(in_array($listing_category_child->term_id, $dtdr_sf_categories)) {
												$selected_attr = 'selected="selected"';
											}
											$output .= '<option value="'.esc_attr($listing_category_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_category_child->name).'</option>';
										}
									}

								}

							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul>';
						$listing_categories = get_categories('taxonomy=dtdr_listings_category&hide_empty=1');
						if(isset($listing_categories)) {
							foreach($listing_categories as $listing_category) {
								$output .= '<li>
												<input type="checkbox" name="dtdr_sf_categories[]" class="dtdr-sf-field dtdr-sf-categories '.esc_attr($additional_class).'" value="'.esc_attr($listing_category->term_id).'" id="dtdr-sf-category-'.esc_attr($listing_category->term_id).'" '.checked(in_array($listing_category->term_id, $dtdr_sf_categories), true, false).' />
												<label for="dtdr-sf-category-'.esc_attr($listing_category->term_id).'">'.esc_html($listing_category->name).'</label>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_tags_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type' => '',
						'placeholder_text' => '',
						'dropdown_type' => '',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtdr_sf_tags_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-tags-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtdr-with-ajax-load';
				}

				$dtdr_sf_tags = array ();
				if(isset($_REQUEST['dtdr_sf_tags'])) {
					if(is_array($_REQUEST['dtdr_sf_tags']) && !empty($_REQUEST['dtdr_sf_tags'])) {
						$dtdr_sf_tags = $_REQUEST['dtdr_sf_tags'];
					} else if($_REQUEST['dtdr_sf_tags'] != '') {
						$dtdr_sf_tags = explode(',', $_REQUEST['dtdr_sf_tags']);
					}
				}

				$amenity_plural_label = apply_filters( 'amenity_label', 'plural' );

				$placeholder_text = $amenity_plural_label;
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				if($attrs['field_type'] == 'dropdown') {

					$mulitple_attr = '';
					if($attrs['dropdown_type'] == 'multiple') {
						$mulitple_attr = 'multiple';
					}

					$output .= '<select class="dtdr-sf-field dtdr-sf-tags '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_tags" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
						if($mulitple_attr == '') {
							$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
						}
						$listing_tags = get_categories('taxonomy=dtdr_listings_amenity&hide_empty=1');
						if(isset($listing_tags)) {
							foreach($listing_tags as $listing_tag) {
								$selected_attr = '';
								if(in_array($listing_tag->term_id, $dtdr_sf_tags)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($listing_tag->term_id).'" '.$selected_attr.'>'.esc_html($listing_tag->name).'</option>';
							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul>';
						$listing_tags = get_categories('taxonomy=dtdr_listings_amenity&hide_empty=1');
						if(isset($listing_tags)) {
							foreach($listing_tags as $listing_tag) {
								$output .= '<li>
												<input type="checkbox" name="dtdr_sf_tags[]" class="dtdr-sf-field dtdr-sf-tags '.esc_attr($additional_class).'" value="'.esc_attr($listing_tag->term_id).'" id="dtdr-sf-tag-'.esc_attr($listing_tag->term_id).'" '.checked(in_array($listing_tag->term_id, $dtdr_sf_tags), true, false).' />
												<label for="dtdr-sf-tag-'.esc_attr($listing_tag->term_id).'">'.esc_html($listing_tag->name).'</label>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_ctype_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type'              => '',
						'placeholder_text'        => '',
						'dropdown_type'           => '',
						'ajax_load'               => '',
						'default_item_id'         => '',
						'show_parent_items_alone' => 'false',
						'child_of'                => '',
						'class'                   => '',

					), $attrs, 'dtdr_sf_ctype_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-ctype-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtdr-with-ajax-load';
				}

				$dtdr_sf_ctype = array ();
				if(isset($_REQUEST['dtdr_sf_ctype'])) {
					if(is_array($_REQUEST['dtdr_sf_ctype']) && !empty($_REQUEST['dtdr_sf_ctype'])) {
						$dtdr_sf_ctype = $_REQUEST['dtdr_sf_ctype'];
					} else if($_REQUEST['dtdr_sf_ctype'] != '') {
						$dtdr_sf_ctype = explode(',', $_REQUEST['dtdr_sf_ctype']);
					}
				} elseif($attrs['default_item_id'] != '') {
					$dtdr_sf_ctype = explode(',', $attrs['default_item_id']);
				}

				$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );

				$placeholder_text = $contracttype_plural_label;
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}


				if($attrs['field_type'] == 'dropdown') {

					$mulitple_attr = '';
					if($attrs['dropdown_type'] == 'multiple') {
						$mulitple_attr = 'multiple';
					}

					$output .= '<select class="dtdr-sf-field dtdr-sf-ctype '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_ctype" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
						if($mulitple_attr == '') {
							$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
						}

						$ctypes_args = array (
							'taxonomy'   => 'dtdr_listings_ctype',
							'hide_empty' => 1,
						);

						if($attrs['child_of'] != '') {
							$ctypes_args['child_of'] = $attrs['child_of'];
						} else {
							$ctypes_args['parent'] = 0;
						}
						$listing_ctypes = get_categories($ctypes_args);

						if(isset($listing_ctypes)) {
							foreach($listing_ctypes as $listing_ctype) {
								$selected_attr = '';
								if(in_array($listing_ctype->term_id, $dtdr_sf_ctype)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($listing_ctype->term_id).'" '.$selected_attr.'>'.esc_html($listing_ctype->name).'</option>';

								if($attrs['show_parent_items_alone'] != 'true') {

									// Child Items
									$listing_ctype_childs = get_categories('taxonomy=dtdr_listings_ctype&hide_empty=1&child_of='.$listing_ctype->term_id);
									if(is_array($listing_ctype_childs) && !empty($listing_ctype_childs)) {
										foreach($listing_ctype_childs as $listing_ctype_child) {
											$selected_attr = '';
											if(in_array($listing_ctype_child->term_id, $dtdr_sf_ctype)) {
												$selected_attr = 'selected="selected"';
											}
											$output .= '<option value="'.esc_attr($listing_ctype_child->term_id).'" '.$selected_attr.'>'."&emsp;".esc_html($listing_ctype_child->name).'</option>';
										}
									}

								}

							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul>';
						$listing_ctypes = get_categories('taxonomy=dtdr_listings_ctype&hide_empty=1');
						if(isset($listing_ctypes)) {
							foreach($listing_ctypes as $listing_ctype) {
								$output .= '<li>
												<input type="checkbox" name="dtdr_sf_ctype[]" class="dtdr-sf-field dtdr-sf-ctype '.esc_attr($additional_class).'" value="'.esc_attr($listing_ctype->term_id).'" id="dtdr-sf-ctype-'.esc_attr($listing_ctype->term_id).'" '.checked(in_array($listing_ctype->term_id, $dtdr_sf_ctype), true, false).' />
												<label for="dtdr-sf-ctype-'.esc_attr($listing_ctype->term_id).'">'.esc_html($listing_ctype->name).'</label>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_features_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'tab_id'               => '',
						'field_type'           => 'range',
						'placeholder_text'     => '',
						'min_value'            => 1,
						'max_value'            => 100,
						'dropdownlist_options' => '',
						'dropdown_type'        => '',
						'item_unit'            => '',
						'ajax_load'            => '',
						'class'                => '',

					), $attrs, 'dtdr_sf_features_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-features-field-holder '.$attrs['class'].'">';

				if($attrs['tab_id'] != '') {

					$additional_class = '';
					if($attrs['ajax_load'] == 'true') {
						$additional_class = 'dtdr-with-ajax-load';
					}

					// Tab Id

					$dtdr_sf_features_tab_id = $attrs['tab_id'];
					$tab_id_name = '_tab'.$dtdr_sf_features_tab_id;

					$output .= '<input name="dtdr_sf_features_tab_id" class="dtdr-sf-field dtdr-sf-features-tab-id" type="hidden" value="'.esc_attr($dtdr_sf_features_tab_id).'" />';


					// Item Unit

					$item_unit = $attrs['item_unit'];

					$output .= '<input name="dtdr_sf_features_item_unit" class="dtdr-sf-field dtdr-sf-features-item-unit" type="hidden" value="'.esc_attr($item_unit).'" />';


					// Field Type

					$output .= '<input name="dtdr_sf_features_field_type" class="dtdr-sf-field dtdr-sf-features-field-type" type="hidden" value="'.esc_attr($attrs['field_type']).'" />';


					// Extract Values

					$dtdr_sf_features = array ();
					if(isset($_REQUEST['dtdr_sf_features'.$tab_id_name])) {
						if(is_array($_REQUEST['dtdr_sf_features'.$tab_id_name]) && !empty($_REQUEST['dtdr_sf_features'.$tab_id_name])) {
							$dtdr_sf_features = $_REQUEST['dtdr_sf_features'.$tab_id_name];
						} else if($_REQUEST['dtdr_sf_features'.$tab_id_name] != '') {
							$dtdr_sf_features = explode(',', $_REQUEST['dtdr_sf_features'.$tab_id_name]);
						}
					}

					// Dropdown / List Options

					$dropdownlist_options = $attrs['dropdownlist_options'];
					$dropdownlist_options = ($dropdownlist_options != '') ? explode(',', $dropdownlist_options) : array ();

					if($attrs['field_type'] == 'dropdown') {

						if(!empty($dropdownlist_options)) {

							$placeholder_text = '';
							if($attrs['placeholder_text'] != '') {
								$placeholder_text = esc_html($attrs['placeholder_text']);
							}

							$mulitple_attr = '';
							if($attrs['dropdown_type'] == 'multiple') {
								$mulitple_attr = 'multiple';
							}

							$output .= '<select class="dtdr-sf-field dtdr-sf-features '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_features'.$tab_id_name.'" data-placeholder="'.esc_attr($placeholder_text).'" '.esc_attr($mulitple_attr).'>';
								if($mulitple_attr == '') {
									$output .= '<option value="">'.esc_attr($placeholder_text).'</option>';
								}
								if(isset($dropdownlist_options)) {
									foreach($dropdownlist_options as $dropdownlist_option) {
										$selected_attr = '';
										if(in_array($dropdownlist_option, $dtdr_sf_features)) {
											$selected_attr = 'selected="selected"';
										}
										$output .= '<option value="'.esc_attr($dropdownlist_option).'" '.$selected_attr.'>'.esc_html($dropdownlist_option).'</option>';
									}
								}
							$output .= '</select>';

						}

					} else if($attrs['field_type'] == 'list') {

						if(!empty($dropdownlist_options)) {

							$output .= '<ul>';
								if(isset($dropdownlist_options)) {
									foreach($dropdownlist_options as $dropdownlist_option) {
										$output .= '<li>
														<input type="checkbox" name="dtdr_sf_features'.$tab_id_name.'[]" class="dtdr-sf-field dtdr-sf-features '.esc_attr($additional_class).'" value="'.esc_attr($dropdownlist_option).'" id="dtdr-sf-features-'.esc_attr($dropdownlist_option).'" '.checked(in_array($dropdownlist_option, $dtdr_sf_features), true, false).' />
														<label for="dtdr-sf-features-'.esc_attr($dropdownlist_option).'">'.esc_html($dropdownlist_option).'</label>
													</li>';
									}
								}
							$output .= '</ul>';

						}

					} else {

						$dtdr_sf_features_start = $attrs['min_value'];
						if(isset($_REQUEST['dtdr_sf_features'.$tab_id_name.'_start']) && $_REQUEST['dtdr_sf_features'.$tab_id_name.'_start'] != '') {
							$dtdr_sf_features_start = $_REQUEST['dtdr_sf_features'.$tab_id_name.'_start'];
						}

						$dtdr_sf_features_end = $attrs['max_value'];
						if(isset($_REQUEST['dtdr_sf_features'.$tab_id_name.'_end']) && $_REQUEST['dtdr_sf_features'.$tab_id_name.'_end'] != '') {
							$dtdr_sf_features_end = $_REQUEST['dtdr_sf_features'.$tab_id_name.'_end'];
						}

						$output .= '<div class="dtdr-sf-features-slider '.esc_attr($additional_class).'" data-min="'.esc_attr($attrs['min_value']).'" data-max="'.esc_attr($attrs['max_value']).'" data-updated-min="'.esc_attr($dtdr_sf_features_start).'" data-updated-max="'.esc_attr($dtdr_sf_features_end).'"  data-itemunit="'.esc_attr($item_unit).'">';
							$output .= '<div class="dtdr-sf-features-slider-start-handle">'.esc_attr($dtdr_sf_features_start).' '.esc_attr($item_unit).'</div>';
							$output .= '<div class="dtdr-sf-features-slider-end-handle">'.esc_attr($dtdr_sf_features_end).' '.esc_attr($item_unit).'</div>';
							$output .= '<div class="dtdr-sf-features-slider-ranges">';
								$output .= '<div class="dtdr-sf-features-slider-range-min-holder">';
									$output .= '<label>'.esc_html__('Min','dtdr-lite').'</label>';
									$output .= '<div class="dtdr-sf-features-slider-range-min">'.esc_attr($attrs['min_value']).' '.esc_attr($item_unit).'</div>';
								$output .= '</div>';
								$output .= '<div class="dtdr-sf-features-slider-range-max-holder">';
									$output .= '<label>'.esc_html__('Max','dtdr-lite').'</label>';
									$output .= '<div class="dtdr-sf-features-slider-range-max">'.esc_attr($attrs['max_value']).' '.esc_attr($item_unit).'</div>';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';

						$output .= '<input name="dtdr_sf_features'.$tab_id_name.'_start" class="dtdr-sf-field dtdr-sf-features-start" type="hidden" value="'.esc_attr($dtdr_sf_features_start).'" />';
						$output .= '<input name="dtdr_sf_features'.$tab_id_name.'_end" class="dtdr-sf-field dtdr-sf-features-end" type="hidden" value="'.esc_attr($dtdr_sf_features_end).'" />';

					}

				} else {

					$output .= esc_html__('This features shortcode won\'t work without tab id. Please provide tab id.','dtdr-lite');

				}

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_orderby_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'field_type' => '',
						'placeholder_text' => '',
						'alphabetical_order' => 'true',
						'highestrated_order' => 'true',
						'mostreviewed_order' => 'true',
						'mostviewed_order' => 'true',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtdr_sf_orderby_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-orderby-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtdr-with-ajax-load';
				}

				$dtdr_sf_orderby = array ();
				if(isset($_REQUEST['dtdr_sf_orderby'])) {
					if(is_array($_REQUEST['dtdr_sf_orderby']) && !empty($_REQUEST['dtdr_sf_orderby'])) {
						$dtdr_sf_orderby = $_REQUEST['dtdr_sf_orderby'];
					} else if($_REQUEST['dtdr_sf_orderby'] != '') {
						$dtdr_sf_orderby = explode(',', $_REQUEST['dtdr_sf_orderby']);
					}
				}

				$placeholder_text = esc_html__('Order By','dtdr-lite');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				$orderby_items = array ();
				if($attrs['alphabetical_order'] == 'true') {
					$orderby_items['alphabetical'] = esc_html__('Alphabetical','dtdr-lite');
				}
				if($attrs['highestrated_order'] == 'true') {
					$orderby_items['highest-rated'] = esc_html__('Highest Rated','dtdr-lite');
				}
				if($attrs['mostreviewed_order'] == 'true') {
					$orderby_items['most-reviewed'] = esc_html__('Most Reviewed','dtdr-lite');
				}
				if($attrs['mostviewed_order'] == 'true') {
					$orderby_items['most-viewed'] = esc_html__('Most Viewed','dtdr-lite');
				}

				if($attrs['field_type'] == 'dropdown') {

					$output .= '<select class="dtdr-sf-field dtdr-sf-orderby '.esc_attr($additional_class).' dtdr-chosen-select" name="dtdr_sf_orderby">';
						$output .= '<option value="">'.esc_html($placeholder_text).'</option>';
						if(!empty($orderby_items)) {
							foreach($orderby_items as $orderby_item_key => $orderby_item) {
								$selected_attr = '';
								if(in_array($orderby_item_key, $dtdr_sf_orderby)) {
									$selected_attr = 'selected="selected"';
								}
								$output .= '<option value="'.esc_attr($orderby_item_key).'" '.$selected_attr.'>'.esc_html($orderby_item).'</option>';
							}
						}
					$output .= '</select>';

				} else {

					$output .= '<ul class="dtdr-sf-orderby-list '.esc_attr($additional_class).'">';
						if(!empty($orderby_items)) {
							foreach($orderby_items as $orderby_item_key => $orderby_item) {
								$output .= '<li>
												<a data-itemvalue="'.esc_attr($orderby_item_key).'" href="#">'.esc_html($orderby_item).'</a>
											</li>';
							}
						}
					$output .= '</ul>';

				}

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_mls_number_field( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'placeholder_text' => '',
						'ajax_load' => '',
						'class' => '',

					), $attrs, 'dtdr_sf_mls_number_field' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-mls-number-field-holder '.$attrs['class'].'">';

				$additional_class = '';
				if($attrs['ajax_load'] == 'true') {
					$additional_class = 'dtdr-with-ajax-load';
				}

				$placeholder_text = esc_html__('MLS Number','dtdr-lite');
				if($attrs['placeholder_text'] != '') {
					$placeholder_text = esc_html($attrs['placeholder_text']);
				}

				$dtdr_sf_mls_number = '';
				if(isset($_REQUEST['dtdr_sf_mls_number']) && $_REQUEST['dtdr_sf_mls_number'] != '') {
					$dtdr_sf_mls_number = $_REQUEST['dtdr_sf_mls_number'];
				}

				$output .= '<input name="dtdr_sf_mls_number" class="dtdr-sf-field dtdr-sf-mls-number '.esc_attr($additional_class).'" type="text" value="'.esc_attr($dtdr_sf_mls_number).'" placeholder="'.esc_attr($placeholder_text).'" />';
				$output .= '<span></span>';

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_submit_button( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'output_type' => '',
						'separate_page_url' => '',
						'class' => '',

					), $attrs, 'dtdr_sf_submit_button' );


			$output = '';

			$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-submitbutton-field-holder '.$attrs['class'].'">';

				$additional_attr = $execution_class = 'dtdr-execute';
				if($attrs['output_type'] == 'separate-page') {
					$additional_attr = esc_url($attrs['separate_page_url']);
					$execution_class = '';
				}

				$output .= '<a href="#" class="custom-button-style dtdr-submit-searchform '.esc_attr($attrs['class']).' '.esc_attr($execution_class).'" data-outputtype="'.esc_attr($attrs['output_type']).'" data-separatepageurl="'.$additional_attr.'">'.esc_html__('Submit','dtdr-lite').'</a>';

			$output .= '</div>';

			return $output;

		}

		function dtdr_sf_output_data_container( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (

						'type'                   => 'type1',
						'gallery'                => 'featured_image',
						'post_per_page'          => '',
						'columns'                => 1,
						'apply_isotope'          => '',
						'excerpt_length'         => '',
						'features_image_or_icon' => '',
						'features_include'       => '',
						'no_of_cat_to_display'   => 2,
						'apply_equal_height'     => 'false',
						'apply_custom_height'    => 'false',
						'height'                 => '',
						'vc_height'              => '',
						'sidebar_widget'         => 'false',

						'category_ids'           => '',

						'class'                  => '',

					), $attrs, 'dtdr_sf_output_data_container' );


			$output = '';

			$data_attributes = array ();
			array_push($data_attributes, 'data-type="'.esc_attr($attrs['type']).'"');
			array_push($data_attributes, 'data-gallery="'.esc_attr($attrs['gallery']).'"');
			array_push($data_attributes, 'data-postperpage="'.esc_attr($attrs['post_per_page']).'"');
			array_push($data_attributes, 'data-columns="'.esc_attr($attrs['columns']).'"');
			array_push($data_attributes, 'data-applyisotope="'.esc_attr($attrs['apply_isotope']).'"');
			array_push($data_attributes, 'data-excerptlength="'.esc_attr($attrs['excerpt_length']).'"');
			array_push($data_attributes, 'data-featuresimageoricon="'.esc_attr($attrs['features_image_or_icon']).'"');
			array_push($data_attributes, 'data-featuresinclude="'.esc_attr($attrs['features_include']).'"');
			array_push($data_attributes, 'data-noofcattodisplay="'.esc_attr($attrs['no_of_cat_to_display']).'"');
			array_push($data_attributes, 'data-applyequalheight="'.esc_attr($attrs['apply_equal_height']).'"');
			array_push($data_attributes, 'data-categoryids="'.esc_attr($attrs['category_ids']).'"');

			// Custom attributes update from modules
			$dtdr_custom_options = apply_filters('dtdr_sf_output_data_container_data_attrs_from_modules', '', $attrs);
			array_push($data_attributes, 'data-customoptions="'.esc_attr($dtdr_custom_options).'"');


			if(!empty($data_attributes)) {
				$data_attributes_string = implode(' ', $data_attributes);
			}

			if($attrs['apply_custom_height'] == 'true') {
				$attrs['class'] .= " dtdr-content-scroll";
			}

			if($attrs['sidebar_widget'] == 'true') {
				$attrs['class'] .= " dtdr-listings-sidebar-widget";
			}

			$height_attr = '';
			if($attrs['vc_height'] != '') {
				$height_attr = 'style="height:'.$attrs['vc_height'].'px;"';
			}

			$output .= '<div class="dtdr-listing-output-data-container dtdr-search-list-items  '.$attrs['class'].'" '.$height_attr.'>';
				$output .= '<div class="dtdr-listing-output-data-holder" '.$data_attributes_string.'></div>';
				$output .= dtdr_generate_loader_html(false);
			$output .= '</div>';

			return $output;

		}

	}

	DTDirectoryLiteSearchFormShortcodes::instance();

}

?>