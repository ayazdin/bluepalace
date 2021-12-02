<?php 
// Register Custom Post Type
function floor_plan() {

	$labels = array(
		'name'                  => _x( 'Floor Plan', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Floor Plan', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Floor Plan', 'text_domain' ),
		'name_admin_bar'        => __( 'Floor Plan', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Floor Plan', 'text_domain' ),
		'description'           => __( 'Floor Plan Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		// 'show_ui'               => true,
		// 'show_in_menu'          => true,
		'menu_position'         => 5,
        'rewrite'               => array( 'slug' => 'floorplan' ),
		// 'show_in_admin_bar'     => true,
		// 'show_in_nav_menus'     => true,
		// 'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		// 'publicly_queryable'    => true,
		'capability_type'       => 'post'
	);
	register_post_type( 'floorplan', $args );

}
add_action( 'init', 'floor_plan', 0 );

/*
*	Custom Taxanomy
*/
function floorplan_taxonomy() {
  $labels = array(
    'name' => _x( 'Category', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Category' ),
    'all_items' => __( 'All Category' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Category' ),
  );

// Now register the taxonomy

  register_taxonomy('team_cat',array('floorplan'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'floorplans' ),
  ));

}
add_action( 'init', 'floorplan_taxonomy', 0 );

/**
 * Adds a meta box to the post editing screen
 */



add_filter( 'rwmb_meta_boxes', 'your_prefix_meta_boxes' );
function your_prefix_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __('Banner','textdomain'),
        'post_types' => 'floorplan',
        'fields'     => array(
            array(
                'id'   => 'bannerUpload',
                'name' => __( 'Files', 'textdomain' ),
                'type' => 'file_upload',
            ),
        ),
    );
    $meta_boxes[] = array(
        'title'      => __( 'Section 1', 'textdomain' ),
        'post_types' => 'floorplan',
        'fields'     => array(
            array(
                'id'   => 'name',
                'name' => __( 'Name', 'textdomain' ),
                'type' => 'text',
            ),
            array(
                'id'   => 'filesUpload',
                'name' => __( 'Files', 'textdomain' ),
                'type' => 'file_upload',
            ),
        ),
    );
    $meta_boxes[] = array(
        'title'      => __( 'Section 2', 'textdomain' ),
        'post_types' => 'floorplan',
        'fields'     => array(
            array(
                'id'   => 'name2',
                'name' => __( 'Name', 'textdomain' ),
                'type' => 'text',
            ),
            array(
                'id'   => 'filesUpload2',
                'name' => __( 'Files', 'textdomain' ),
                'type' => 'file_upload',
            ),
        ),
    );
    $meta_boxes[] = array(
        'title'      => __( 'Section 3', 'textdomain' ),
        'post_types' => 'floorplan',
        'fields'     => array(
            array(
                'id'   => 'name3',
                'name' => __( 'Name', 'textdomain' ),
                'type' => 'text',
            ),
            array(
                'id'   => 'filesUpload3',
                'name' => __( 'Files', 'textdomain' ),
                'type' => 'file_upload',
            ),
        ),
    );
    return $meta_boxes;
}

/*-----------------------------------------------------------------------------------------*/
//Add Metabox
/*add_action('add_meta_boxes', 'add_upload_file_metaboxes');

function add_upload_file_metaboxes() {
    add_meta_box( 'swp_file_upload', __( 'Section 1', 'prfx-textdomain' ), 'swp_file_upload', 'floorplan' );

    // add_meta_box('swp_file_upload', 'File Upload', 'swp_file_upload', 'floorplan', 'floorplan', 'floorplan');
}


function swp_file_upload() {
    global $post;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="podcastmeta_noncename" id="podcastmeta_noncename" value="'.
    wp_create_nonce(plugin_basename(__FILE__)).
    '" />';
    global $wpdb;
    $strFile = get_post_meta($post -> ID, $key = 'podcast_file', true);
    $media_file = get_post_meta($post -> ID, $key = '_wp_attached_file', true);
    if (!empty($media_file)) {
        $strFile = $media_file;
    } ?>


    <script type = "text/javascript">

        // Uploading files
        var file_frame;
    jQuery('#upload_image_button').live('click', function(podcast) {

        podcast.preventDefault();

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false // Set to true to allow multiple files to be selected
        });

        // When a file is selected, run a callback.
        file_frame.on('select', function(){
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();

            // here are some of the variables you could use for the attachment;
            //var all = JSON.stringify( attachment );      
            //var id = attachment.id;
            //var title = attachment.title;
            //var filename = attachment.filename;
            var url = attachment.url;
            //var link = attachment.link;
            //var alt = attachment.alt;
            //var author = attachment.author;
            //var description = attachment.description;
            //var caption = attachment.caption;
            //var name = attachment.name;
            //var status = attachment.status;
            //var uploadedTo = attachment.uploadedTo;
            //var date = attachment.date;
            //var modified = attachment.modified;
            //var type = attachment.type;
            //var subtype = attachment.subtype;
            //var icon = attachment.icon;
            //var dateFormatted = attachment.dateFormatted;
            //var editLink = attachment.editLink;
            //var fileLength = attachment.fileLength;

            var field = document.getElementById("podcast_file");

            field.value = url; //set which variable you want the field to have
        });

        // Finally, open the modal
        file_frame.open();
    });

    </script>



    <div>

        <table>
        <tr valign = "top">
        <td>
        <input type = "text"
    name = "podcast_file"
    id = "podcast_file"
    size = "70"
    value = "<?php echo $strFile; ?>" />
        <input id = "upload_image_button"
    type = "button"
    value = "Upload">
        </td> </tr> </table> <input type = "hidden"
    name = "img_txt_id"
    id = "img_txt_id"
    value = "" />
        </div>     <?php
    function admin_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }

    function admin_styles() {
        wp_enqueue_style('thickbox');
    }
    add_action('admin_print_scripts', 'admin_scripts');
    add_action('admin_print_styles', 'admin_styles');
}


//Saving the file
function save_podcasts_meta($post_id, $post) {
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce($_POST['podcastmeta_noncename'], plugin_basename(__FILE__))) {
        return $post -> ID;
    }
    // Is the user allowed to edit the post?
    if (!current_user_can('edit_post', $post -> ID))
        return $post -> ID;
    // We need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    $podcasts_meta['podcast_file'] = $_POST['podcast_file'];
    // Add values of $podcasts_meta as custom fields

    foreach($podcasts_meta as $key => $value) {
        if ($post -> post_type == 'revision') return;
        $value = implode(',', (array) $value);
        if (get_post_meta($post -> ID, $key, FALSE)) { // If the custom field already has a value it will update
            update_post_meta($post -> ID, $key, $value);
        } else { // If the custom field doesn't have a value it will add
            add_post_meta($post -> ID, $key, $value);
        }
        if (!$value) delete_post_meta($post -> ID, $key); // Delete if blank value
    }
}
add_action('save_post', 'save_podcasts_meta', 1, 2); // save the custom fields*/