/**
 * CT Mobile Menu
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery(function(JQuery){
	JQuery(window).load(function(){
		JQuery('#masthead .sub-menu li a').before('<i class="fa fa-angle-right"></i>');

		JQuery('.mobile-nav ul').removeClass('cbp-tm-menu');
		JQuery('.mobile-nav ul').addClass('cbp-spmenu');
		
		JQuery("<a href='#' id='showLeftPush' class='show-hide'><i id='showLeftPushIcon' class='fa fa-navicon'></i>", {
		}).appendTo("#masthead");		

		var menuLeft = document.getElementById( 'cbp-spmenu' ),
			showLeftPush = document.getElementById( 'showLeftPush' ),
			showLeftPushIcon = document.getElementById( 'showLeftPushIcon' ),
			body = document.body;
			container = document.getElementById( 'wrapper' ),

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toleft' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			classie.toggle( showLeftPushIcon, 'fa-close' );
		};
	
	});
});