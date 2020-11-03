<?php

require_once DTDR_LITE_PLUGIN_PATH . 'settings/settings-utils.php';


function dtdr_settings_options() {

	$tabs = array (
		'general'   => array (
			'label' => esc_html__('General','dtdr-lite'),
			'path' => DTDR_LITE_PLUGIN_PATH . 'settings/settings-general-utils.php'
		),
		'label'     =>  array (
			'label' => esc_html__('Labels','dtdr-lite'),
			'path' => DTDR_LITE_PLUGIN_PATH . 'settings/settings-label-utils.php'
		),
		'permalink' =>  array (
			'label' => esc_html__('Permalink','dtdr-lite'),
			'path' => DTDR_LITE_PLUGIN_PATH . 'settings/settings-permalink-utils.php'
		),
		'archives' =>  array (
			'label' => esc_html__('Archives','dtdr-lite'),
			'path' => DTDR_LITE_PLUGIN_PATH . 'settings/settings-archives-utils.php'
		),
		'skin'      =>  array (
			'label' => esc_html__('Skin','dtdr-lite'),
			'path' => DTDR_LITE_PLUGIN_PATH . 'settings/settings-skin-utils.php'
		),
	);

	$tabs = apply_filters( 'dtdr_settings', $tabs );

	$current = isset( $_GET['parenttab'] ) ? sanitize_text_field($_GET['parenttab']) : 'general';

	dtdr_get_settings_submenus($current, $tabs);
	dtdr_get_settings_tab($current, $tabs);

}

function dtdr_get_settings_submenus($current, $tabs) {

    echo '<h2 class="dtdr-custom-nav nav-tab-wrapper">';
		foreach( $tabs as $key => $tab ) {
			$class = ( $key == $current ) ? 'nav-tab-active' : '';
			echo '<a class="nav-tab '.esc_attr( $class ).'" href="?page=dtdr-settings-options&parenttab='.esc_attr( $key ).'">'.esc_html( $tab['label'] ).'</a>';
		}
    echo '</h2>';

}

function dtdr_get_settings_tab($current, $tabs) {
	require_once $tabs[$current]['path'];
}

?>