var dtDirectoryFeaturedComments = {

	dtInit : function() {

		// Comment gallery prettyphoto

			jQuery('.dtdr_comment_gallery_item').each(function() {
				var attr = jQuery(this).attr('rel');
				if (jQuery('a[rel^="'+attr+'"]').length) {
					jQuery('a[rel^="'+attr+'"]').prettyPhoto({
						hook: 'rel',
						show_title: false,
						deeplinking: false,
						social_tools: false,
				});
				}
			});

		// File Upload

			jQuery('body').on('change', '.dtdr-comment-media-upload', function() {
				var input = jQuery(this),
				inputFiles = input.get(0).files,
				selectedFiles = '';

				selectedFiles = inputFiles[0]['name'];
				if(inputFiles.length > 1) {
					selectedFiles = selectedFiles + ' + ' + (inputFiles.length-1);
				}

				jQuery('.dtdr-comment-media-label').html(selectedFiles);

			});

	}

};


jQuery(document).ready(function() {

	if(!dtdrfrontendobject.elementorPreviewMode) {
		dtDirectoryFeaturedComments.dtInit();
	}

});


( function( $ ) {

	var dtDirectoryFeaturedCommentsJs = function($scope, $){
		dtDirectoryFeaturedComments.dtInit();
	};

    $(window).on('elementor/frontend/init', function(){
		if(dtdrfrontendobject.elementorPreviewMode) {
			elementorFrontend.hooks.addAction('frontend/element_ready/dtdr-widget-sp-featured-comments.default', dtDirectoryFeaturedCommentsJs);
		}
	});

} )( jQuery );