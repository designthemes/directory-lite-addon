<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSfFeatures extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-features';
	}

	public function get_title() {
		return esc_html__( 'Features','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'jquery-ui', 'chosen', 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'jquery-ui-slider', 'chosen', 'dtdr-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'features_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

            $this->add_control( 'tab_id', array(
                'label'   => esc_html__( 'Tab Id','dtdr-lite'),
                'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Provide tab id for features item that you want to use in search form. Without this tab id shortcode doesn\'t work.','dtdr-lite'),
                'default' => ''
            ) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type','dtdr-lite'),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'range'    => esc_html__('Range','dtdr-lite'),
                    'list'     => esc_html__('List','dtdr-lite'),
                    'dropdown' => esc_html__('Dropdown','dtdr-lite'),
                ),
                'description' => esc_html__('Choose field type that you like to use for this feature item.','dtdr-lite'),
                'default'      => 'range'
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text','dtdr-lite'),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.','dtdr-lite'),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
			) );

            $this->add_control( 'min_value', array(
				'label'   => esc_html__( 'Minimum Value','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Set minimum value range.','dtdr-lite'),
                'condition'   => array( 'field_type' => 'range' ),
				'default' => 1
            ) );

            $this->add_control( 'max_value', array(
				'label'   => esc_html__( 'Maximum Value','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Set maximum value range.','dtdr-lite'),
                'condition'   => array( 'field_type' => 'range' ),
				'default' => 100
            ) );

            $this->add_control( 'dropdownlist_options', array(
				'label'   => esc_html__( 'Dropdown Options','dtdr-lite'),
				'type'    => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Add dropdown options in comma separated values.','dtdr-lite'),
                'condition'   => array( 'field_type' => array ('dropdown', 'list') ),
				'default' => ''
			) );
            
			$this->add_control( 'dropdown_type', array(
				'label'       => esc_html__( 'Dropdown Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''         => esc_html__('Single','dtdr-lite'),
					'multiple' => esc_html__('Multiple','dtdr-lite'),
				),
                'description' => esc_html__( 'Choose type of dropdown you like to use.','dtdr-lite'),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'      => ''
            ) );
            
            $this->add_control( 'item_unit', array(
				'label'   => esc_html__( 'Item Unit','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can provide item unit for your label here.','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'ajax_load', array(
				'label'       => esc_html__( 'Ajax Load','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_sf_features_field '.$attributes.' /]');

		echo $output;

	}

}