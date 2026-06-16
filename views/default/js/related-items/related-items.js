define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	$(document).ready(function(){

		// each time you click a checkbox to update; loops through all the hidden
		$('.dv_selectfrom_subtypes input[type=checkbox]').click(function(){

			$('#in_selectfrom_subtypes').val("");
			$('.dv_selectfrom_subtypes input[type=checkbox]').each(function(){
				if ( $(this).is(':checked') ) {
					// ugly hack to not render the first comma
					if ( $('#in_selectfrom_subtypes').val() == "") {
						$('#in_selectfrom_subtypes').val( $(this).val() );
					} else {
						$('#in_selectfrom_subtypes').val( $('#in_selectfrom_subtypes').val() + ',' + $(this).val() );
					}
				}
			});
		});
		$('.dv_renderto_subtypes input[type=checkbox]').click(function(){

			$('#in_renderto_subtypes').val("");
			$('.dv_renderto_subtypes input[type=checkbox]').each(function(){
				if ( $(this).is(':checked') ) {
					// ugly hack to not render the first comma
					if ( $('#in_renderto_subtypes').val() == "") {
						$('#in_renderto_subtypes').val( $(this).val() );
					} else {
						$('#in_renderto_subtypes').val( $('#in_renderto_subtypes').val() + ',' + $(this).val() );
					}
				}
			});
		});
	});
});
