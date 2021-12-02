/**
 * Base
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery.noConflict();

(function($) {

	"use strict";
	
	$('.flexslider').resize();
	
	/*-----------------------------------------------------------------------------------*/
	/* Main Nav Setup */
	/*-----------------------------------------------------------------------------------*/
	
	//$('#masthead nav.left .sub-menu').before('<i class="fa fa-angle-down"></i>');
	//$('#masthead nav.right .sub-menu').before('<i class="fa fa-angle-down"></i>');
	
	$("#masthead ul.sub-menu").closest("li").addClass("drop");

	$('#masthead .multicolumn > ul > li.menu-item-has-children > a').each(function(){
		if( $(this).attr("href") == "#" || $(this).attr("href") == "" ){
			var $this = $(this);
			$('<span class="col-title">'+$(this).text()+'</span>').insertAfter($this); 
			$this.remove();
		}
	});

	/*-----------------------------------------------------------------------------------*/
	/* Orderby Price */
	/*-----------------------------------------------------------------------------------*/

	$("#ct_orderby").change(function () {
		var val = $(this).val(),
		url = window.location.href,
		clean_url = url.replace('&ct_orderby=priceASC', '').replace('&ct_orderby=priceDESC', '').replace('&ct_orderby=dateASC', '').replace('&ct_orderby=dateDESC', '');
		if(val != '') {
			window.location.href = clean_url + '&ct_orderby=' + val;
		} else {
			window.location.href = clean_url;
		}
		var loc = window.location.href,
		    index = loc.indexOf('#');

		if (index > 0) {
			window.location = loc.substring(0, index);
		}
	});

	/*-----------------------------------------------------------------------------------*/
	/* Header Search Toggle */
	/*-----------------------------------------------------------------------------------*/

	$( "#more-search-options-toggle" ).click(function() {
		$("i.fa-plus-square-o").toggleClass("fa-minus-square-o");
		$('#more-search-options').slideToggle("fast");
	});

	/*-----------------------------------------------------------------------------------*/
	/* Tools Toggle */
	/*-----------------------------------------------------------------------------------*/

	$( "#tools-toggle" ).click(function() {
		$("#text-toggle").text(function(i, text){
			return text === object_name.close_tools ? object_name.open_tools : object_name.close_tools;
		})
		$('#tools ul').toggle("fast");
	});

	/*-----------------------------------------------------------------------------------*/
	/* Map Toggle */
	/*-----------------------------------------------------------------------------------*/

	$(".map-toggle").click(function() {
		$("#text-toggle").text(function(i, text){
	        return text === object_name.close_map ? object_name.open_map : object_name.close_map;
	      })
		$("i.fa-minus-square-o").toggleClass("fa-plus-square-o");
		$("#map-wrap").slideToggle( 200, function() {
		});
	});

	/*-----------------------------------------------------------------------------------*/
	/* Search Toggle */
	/*-----------------------------------------------------------------------------------*/

	$(".search-toggle").click(function() {
		$("#text-toggle").text(function(i, text){
	        return text === object_name.open_search ? object_name.close_search : object_name.open_search;
	      })
		$("i.fa-plus-square-o").toggleClass("fa-minus-square-o");
		$(".advanced-search").slideToggle( 200, function() {
		});
	});

	/*-----------------------------------------------------------------------------------*/
	/* Login/Register & Agent Contact Modal Form */
	/*-----------------------------------------------------------------------------------*/

	$(".login-register").click(function() {
        $("#overlay").addClass('open');
        $('html, body').animate({scrollTop : 0},800);
		return false;
    });

    $(".close").click(function() {
        $("#overlay").removeClass('open');
    });

    $(".ct-registration").click(function() {
		$("#login").slideUp("slow", function() {
			$("#register").slideDown("slow");
		});
	});

    $(".ct-lost-password").click(function() {
		$("#login").slideUp("slow", function() {
			$("#lost-password").slideDown("slow");
		});
	});

	// On Click SignIn It Will Hide Registration Form and Display Login Form
	$(".ct-login").click(function() {
		$("#register").slideUp("slow", function() {
			$("#login").slideDown("slow");
		});
	});

	/*-----------------------------------------------------------------------------------*/
	/* Agent & Brokerage Contact Modal Form */
	/*-----------------------------------------------------------------------------------*/

	$(".agent-contact, .brokerage-contact").click(function() {
        $("#overlay.contact-modal").addClass('open');
    });

    $(".close").click(function() {
        $("#overlay.contact-modal").removeClass('open');
        $(".formError").hide();
    });

    /*-----------------------------------------------------------------------------------*/
	/* Brokerage Contact Modal Form */
	/*-----------------------------------------------------------------------------------*/

	$(".brokerage-contact").click(function() {
        $("#overlay.contact-modal").addClass('open');
    });

    $(".close").click(function() {
        $("#overlay.contact-modal").removeClass('open');
        $(".formError").hide();
    });

	/*-----------------------------------------------------------------------------------*/
	/* Booking Calendar Plugin */
	/*-----------------------------------------------------------------------------------*/
	
	$(".bk_calendar_frame").addClass("col span_6 first");
	$(".bk_calendar_frame").removeAttr("style");
	$(".bk_calendar_frame").css("float", "right");
	$(".controls input").css("width", "100%");
	$(".controls textarea").css("width", "100%");
	$(".control-group").addClass("col span_6");
	$(".control-group").css("margin", "0");
	$(".booking_form_div .btn.btn-primary").css({"border": "none", "background": "#29333d", "text-transform": "uppercase", "text-shadow": "none", "padding": "1.2em 1.8em", "background-image": "none", "position": "relative", "top": "24px", "right": "-16px"});
	$(".booking_form_div .btn.btn-primary").addClass("col span_6 first");

	$(".booking-form-calendar").show();
	$(".booking_form_div").show();

	/*-----------------------------------------------------------------------------------*/
	/* Edit Profile Plugin */
	/*-----------------------------------------------------------------------------------*/

	$("#your-profile h3").addClass("marT0 col span_3 first");
	$("table.form-table").addClass("col span_9");
	$("table.form-table tbody").addClass("col span_12");
	$("#your-profile .description").addClass("muted");
	$(".user-profile-img").addClass("col span_3 first");

	$("#your-profile").show();

	/*-----------------------------------------------------------------------------------*/
	/* WPFP Delete Link */
	/*-----------------------------------------------------------------------------------*/

	$(".saved-listings .wpfp-link, .clear-saved .wpfp-link").addClass("btn");

	$(".wpfp-link.remove-parent:contains('remove')").html("<i class='fa fa-trash-o'></i>"); 

	$(".wpfp-link.remove-parent").show();
	
	/*-----------------------------------------------------------------------------------*/
	/* Add Zoom Class to Default WordPress Gallery */
	/*-----------------------------------------------------------------------------------*/
	
	$(".gallery-icon").addClass("zoom");

	/*-----------------------------------------------------------------------------------*/
	/* Add Btn Class to dsIDXpress Submit */
	/*-----------------------------------------------------------------------------------*/

	$(".advanced-search.dsidxpress .submit").addClass("btn");
	
	/*-----------------------------------------------------------------------------------*/
	/* FitVids */
	/*-----------------------------------------------------------------------------------*/
	
	$("article, .videoplayer").fitVids();

	/*-----------------------------------------------------------------------------------*/
	/* Remove height/width from WP inserted images */
	/*-----------------------------------------------------------------------------------*/

	$('img').removeAttr('width').removeAttr('height');

	/*-----------------------------------------------------------------------------------*/
	/* Remove Text from Status Snipes */
	/*-----------------------------------------------------------------------------------*/

	$('h6.snipe span').text(function(_,txt) {
	    return txt.replace('Featured', '');
	});

	$('h6.snipe span').text(function(_,txt) {
	    return txt.replace('Ghost', '');
	});

	$('h6.snipe span').text(function(_,txt) {
	    return txt.replace('Weekly', '');
	});

	$('h6.snipe span').text(function(_,txt) {
	    return txt.replace('Week', '');
	});

	$('h6.snipe span').text(function(_,txt) {
	    return txt.replace('Daily', '');
	});

	$('h6.snipe span').text(function(_,txt) {
	    return txt.replace('Day', '');
	});

	/* Show once text is replaced */
	$('h6.snipe').show();
	
	/*-----------------------------------------------------------------------------------*/
	/* Testimonials Widget */
	/*-----------------------------------------------------------------------------------*/
	
	$('.widget_ct_testimonials .testimonials').cycle({ 
		fx:     'fade', 
		speed:  'fast', 
		timeout: 0, 
		next:   '.next.test', 
		prev:   '.prev.test' 
	});
	
	/*-----------------------------------------------------------------------------------*/
	/* Testimonials Block */
	/*-----------------------------------------------------------------------------------*/
	
	$('.aq-block-aq_testimonial_block .testimonials').flexslider({
		animation: "fade",
		animationLoop: true,
		animationSpeed: 600,
		slideshowSpeed: 4000,
		directionNav: false,  
		controlNav: false,
		smoothHeight: true,
	});
	
	/*-----------------------------------------------------------------------------------*/
	/* Symple Skillbar Shortcode */
	/*-----------------------------------------------------------------------------------*/
	
	$('.symple-skillbar').each(function(){
		$(this).find('.symple-skillbar-bar').animate({ width: $(this).attr('data-percent') }, 1500 );
	});
	
	/*-----------------------------------------------------------------------------------*/
	/* Initialize FitVids */
	/*-----------------------------------------------------------------------------------*/
	
	$(".container").fitVids();
	
	/*-----------------------------------------------------------------------------------*/
	/* Add class for prev/next icons */
	/*-----------------------------------------------------------------------------------*/
	
	$('.prev-next .nav-prev a').addClass('fa fa-arrow-left');
	$('.prev-next .nav-next a').addClass('fa fa-arrow-right');
	
	/*-----------------------------------------------------------------------------------*/
	/* Add Font Awesome Icon to Sitemap list */
	/*-----------------------------------------------------------------------------------*/
	
	$('.page-template-template-sitemap-php #main-content li a').before('<i class="fa fa-caret-right"></i>');
	
	/*-----------------------------------------------------------------------------------*/
	/* Add last class to every third related item, and every second testimonial */
	/*-----------------------------------------------------------------------------------*/
	
	$("li.related:nth-child(3n+3), .testimonial-home li:nth-child(2n+1)").addClass("last");

	/*-----------------------------------------------------------------------------------*/
	/* Smooth ScrollTo */
	/*-----------------------------------------------------------------------------------*/

	$('.single-listings a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: target.offset().top - 220
				}, 1000);
				return false;
			}
		}
	});
	
	
})(jQuery);

/*-----------------------------------------------------------------------------------*/
/* Social Popups */
/*-----------------------------------------------------------------------------------*/
	
function popup(pageURL,title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}