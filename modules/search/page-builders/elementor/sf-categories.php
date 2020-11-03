<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSfCategories extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-categories';
	}

	public function get_title() {
		return esc_html__( 'Categories','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'chosen', 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'chosen', 'dtdr-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'categories_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

            $this->add_control( 'field_type', array(
                'label'       => esc_html__( 'Field Type','dtdr-lite'),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    ''         => esc_html__('List','dtdr-lite'),
                    'dropdown' => esc_html__('Dropdown','dtdr-lite'),
                ),
                'description' => esc_html__( 'Choose type of field you like to use.','dtdr-lite'),
                'default'      => ''
            ) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text','dtdr-lite'),
				'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'You can provide your own text for placeholder of this item.','dtdr-lite'),
                'condition'   => array( 'field_type' => 'dropdown' ),
				'default'     => ''
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

			$this->add_control( 'default_item_id', array(
				'label'   => esc_html__( 'Default Item Id','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Set item id here, by default it will be set.','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'show_parent_items_alone', array(
				'label'       => esc_html__( 'Show Parent Items Alone','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'child_of', array(
				'label'   => esc_html__( 'Child Of','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.','dtdr-lite'),
				'condition'   => array( 'show_parent_items_alone' =>'false' ),
				'default' => ''
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
		$settings   = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output     = do_shortcode('[dtdr_sf_categories_field '.$attributes.' /]');

		echo $output;

	}

}