/*
* Core
* 
* @package CT Social
* @subpackage JavaScript
*
*/

// Fade opacity on images when hovered
jQuery(".widget_ct_social a img").hover(function() {
	jQuery(this).stop().animate({opacity: "0.7"}, 'fast');
},
function() {
	jQuery(this).stop().animate({opacity: "1"}, 'fast');
});