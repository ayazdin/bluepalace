/**
 * Submit Listing
 * 
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery(document).ready(function($) {

	jQuery(function($) {
		/* Apply Sortable to Gallery Items */
		$( "#sortable" ).sortable({
		  placeholder: "placeholder col span_4 first",
		  revert: 100,
		  opacity: 0.9,
		  cursor: "move"
		});
		$( "#sortable" ).disableSelection();

		
		var fileTypeTitle = fileTypeTitle;

		/* Initialize Uploader */
		var uploader = new plupload.Uploader({
			runtimes : 'html5',
			chunk_size: '200kb',
			browse_button: 'select-images',
			container: 'plupload-container',
			drop_element: 'drag-drop-area',
			url: AdminURL.ajaxUrl + "?action=front_img_upload&_wpnonce="+jQuery('#post_nonce_field').val(),
			max_retries: 3,
			filters: {
				mime_types : [
					{ title : fileTypeTitle, extensions : "jpg,jpeg,gif,png" }
				],
				max_file_size: '10MB',
				prevent_duplicates: true
			}
		});
			uploader.bind('Init', function(up) {
				var uploaddiv = $('#plupload-upload-ui');

				if ( up.features.dragdrop && ! $(document.body).hasClass('mobile') ) {
					uploaddiv.addClass('drag-drop');
					$('#drag-drop-area').bind('dragover.wp-uploader', function(){ // dragenter doesn't fire right :(
						uploaddiv.addClass('drag-over');
					}).bind('dragleave.wp-uploader, drop.wp-uploader', function(){
						uploaddiv.removeClass('drag-over');
					});
				} else {
					uploaddiv.removeClass('drag-drop');
					$('#drag-drop-area').unbind('.wp-uploader');
				}

				if ( up.runtime === 'html4' ) {
					$('.upload-flash-bypass').hide();
				}
			});
		uploader.init();

		uploader.bind('FilesAdded', function(up, files) {
			var html = '';
			var galleryThumb = "";
			plupload.each(files, function(file) {
			galleryThumb += '<li id="file-'+file.id+'" class="col span_4 first ui-sortable-handle"><figure class="gallery-thumb"><span class="featured-img"><a href="#" name="%1%" class="setImageFeatured"><i class="fa fa-star-o"></i></a></span><span class="delete-img"><a href="#" name="%1%" class="remImage"><i class="fa fa-trash"></i></a></span><img src="'+TemplatePath.templateUrl+'/images/upload-placeholder.png"><input type="hidden" value="%1%" id="att_id" name="att_id[]"></figure><span class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span></li>';
			});
			document.getElementById('sortable').innerHTML += galleryThumb;
			uploader.start();
		});
		
		uploader.bind('ChunkUploaded', function(up, file, info) {
			var response = $.parseJSON( info.response );
			var element=jQuery("#file-"+file.id );
			jQuery(element).find('img').attr('src','');
			jQuery(element).find('img').attr('src',response.link);
		});

		/* In case of error */
		uploader.bind('Error', function( up, err ) {
		   alert("Error #" + err.code + ": " + err.message);
		});

		/* If files are uploaded successfully */
		uploader.bind('FileUploaded', function ( up, file, info ) {
			var response = $.parseJSON( info.response );
			if ( response.success ) {
				var element=jQuery("#file-"+file.id );
				jQuery(element).html(function(index,html){ return html.replace(/%1%/g,response.id_att); });
				jQuery(element).find('img').attr('src',response.link);
				jQuery(element).find('.loading').remove();
				element.attr('id',"file-"+response.id_att);
				delete element;
			} else {
				console.log ( response );
			}
		});

		/* Remove Image */
		$('.remImage').live('click', function(event) { // defined event at the function for -> javacsript error: ReferenceError: event is not defined event.preventDefault();
			event.preventDefault();
			var attID = jQuery(this).attr('name');
			var siteurl = document.location.origin;
			$('#file-'+attID).append( "<span class='loading'><i class='fa fa-circle-o-notch fa-spin'></i></span>" );
			jQuery.ajax({
				type: 'post',
				url: AdminURL.ajaxUrl,
				data: {
					action: 'delete_attachment_edit',
					att_ID: jQuery(this).attr('name'),
					_ajax_nonce: jQuery('#post_nonce_field').val(),
					post_type: 'attachment'
				},
				success: function() {
					console.log('#file-'+attID),
					jQuery('#file-'+attID).fadeOut();    
				}
			});
		});
		
		/* Set featured Image */
		$('.setImageFeatured').live('click', function(event) {
			event.preventDefault();
			var attID = jQuery(this).attr('name');
			var element=jQuery(this);
			jQuery('.setImageFeatured .fa-star').each(function(){
				$(this).removeClass('fa-star').addClass('fa-star-o');
			});
			jQuery(element).find('.fa').removeClass('fa-star-o').addClass('fa-star');
			jQuery("#featured_id").val(attID);
		});
	});
});
