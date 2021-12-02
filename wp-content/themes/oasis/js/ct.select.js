/**
 * CT Custom Select
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery.noConflict();

(function($) {
	$(document).ready(function(){

		/*-----------------------------------------------------------------------------------*/
		/* Add Custom Select */
		/*-----------------------------------------------------------------------------------*/
		
		var $cs = $('select').customSelect();
		
		$('.form-loader').hide();
		$('#advanced_search select, #advanced_search input, .widget #advanced_search').show();
		
	});
	
})(jQuery);