<?php

// Modifying Comments Template

if(!function_exists('dtdr_modifying_comment_template')) {
	function dtdr_modifying_comment_template( $comment_template ) {

		$dtdr_modules = dtdirectorylite_instance()->active_modules;
		$dtdr_modules = (is_array($dtdr_modules) && !empty($dtdr_modules)) ? $dtdr_modules : array ();

		if ( is_singular('dtdr_listings') ) {
			if ( !in_array('comments', $dtdr_modules) ) {
				return DTDR_LITE_PLUGIN_PATH . '/utils/comments.php';
			}
		}

		return $comment_template;

	}
	add_filter('comments_template', 'dtdr_modifying_comment_template');
}

?>