/**
 * CT Mega Menu
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

(function($){
	
 	if( $("body").hasClass("nav-menus-php") ){

		var form = (' \
			<p class="rt-mega-menu description-wide"> \
			<label>Multi-Column Menu \
			<input class="rt-multi-column-menu widefat code" type="checkbox"></label></p> \
		');

		var form_checked = (' \
			<p class="rt-mega-menu description-wide"> \
			<label>Multi-Column Menu \
			<input class="rt-multi-column-menu widefat code" checked type="checkbox"></label></p> \
		');

		var column_count = (' \
			<p class="rt-mega-menu description-wide hidden-field column-item-size"> \
			<label>Column Item Size \
			<input class="rt-multi-column-item-size widefat code" value="column-item-size-value" type="text" /></label></p> \
		');


		$(".menu-item-settings").each(function(){
			
			classNames = $(this).find(".edit-menu-item-classes").val();

			if( classNames.search(/multicolumn-/i) > -1 ){
				$(this).find(".field-move").before(form_checked);

				//find the stored column size 
				classNames_split = classNames.split(" ");
				stored_column_count = ""; 

				for (i = 0; i < classNames_split.length; i++ ) { 
					if( classNames_split[i].search(/multicolumn-/i) > -1 ){ 
						stored_column_count_array = classNames_split[i].split("-");
						stored_column_count = stored_column_count_array[stored_column_count_array.length-1];
					} 				
				}

				$(this).find(".field-move").before(column_count.replace(/column-item-size-value/i, stored_column_count).replace(/hidden-field/i, ""));  

			}else{
				$(this).find(".field-move").before(form);
				$(this).find(".field-move").before(column_count.replace(/column-item-size-value/i, "3")); 
			}

		}); 


		$('.submit-add-to-menu').on('click', function() {  
			$(document).ajaxStop(function() {

				$(".menu-item.pending").each(function(){
					if( $(this).find(".rt-multi-column-menu").length < 1 ){
						$(this).find(".field-move").before(form);
						$(this).find(".field-move").before(column_count.replace(/column-item-size-value/i, "3")); 
					} 
				});				

			});
		});

		$(document.body).on('click', '.rt-multi-column-menu', function() {   

			var css_field = $(this).parents(".menu-item-settings").find(".edit-menu-item-classes");
			var css_class_value = css_field.val();

			var column_count_holder = $(this).parents(".rt-mega-menu:eq(0)").next(".rt-mega-menu"); 
			var column_count = column_count_holder.find(".rt-multi-column-item-size");


			if( $(this).attr("checked") ){

				css_field.val( $.trim(css_class_value) + " multicolumn-" + column_count.val() ); 
				column_count_holder.removeClass("hidden-field");

			}else{
				var classNames = css_class_value.split(" ");
				var newclassNames = "";

				for (i = 0; i < classNames.length; i++ ) { 

					if( classNames[i].search(/multicolumn-/i) > -1 ) { //found & deleted
						newclassNames += "";
					}else{
						newclassNames += classNames[i];
					}

				}		
				column_count_holder.addClass("hidden-field");
				css_field.val( $.trim(newclassNames) );  
			} 

		});


		$(document.body).on('keyup mouseleave', '.rt-multi-column-item-size', function() {   
 
			var css_field = $(this).parents(".menu-item-settings").find(".edit-menu-item-classes");
			var css_class_value = css_field.val();
			var new_classNames = "";

			//find the stored column size from string  
			classNames_split = css_class_value.split(" "); 

			for (i = 0; i < classNames_split.length; i++ ) { 
				if( classNames_split[i].search(/multicolumn-/i) > -1 ){ 

					new_classNames += " " + "multicolumn-" + $(this).val();
				}else{

					new_classNames += " " + classNames_split[i];
				}
			}

			css_field.val($.trim(new_classNames));
		});		

 	}

})(jQuery);