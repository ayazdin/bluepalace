/**
 * Gallery
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

function ct_create_slideshow() {
 
	// Remove the HTML tags generated in the gallery.
	jQuery('.single-galleries style').remove();
	jQuery('.gallery br').remove();
 
	// Wrap the gallery
	jQuery('.gallery').addClass('flexslider');
	jQuery('.gallery-row').addClass('slides');
	
	jQuery('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		directionNav: true,
		animationLoop: false,
		slideshow: true,
		itemWidth: 120,
		itemMargin: 0,
		asNavFor: '.gallery'
	});
 
	jQuery('.gallery').flexslider({
		animation: "fade",
		slideshow: true, 
		controlNav: false,
		directionNav: true,
		sync: "#carousel"
	});
}
 
jQuery(window).load(function() {
	jQuery.noConflict();
	ct_create_slideshow();
});