<?php
// Register Custom Post Type
function custom_post_type()
{

    $labels = array(
        'name' => _x('Projects', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Project', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Projects', 'text_domain'),
        'name_admin_bar' => __('Projects', 'text_domain'),
        'archives' => __('Projects Archives', 'text_domain'),
        'parent_item_colon' => __('Parent Projects:', 'text_domain'),
        'all_items' => __('All Projects', 'text_domain'),
        'add_new_item' => __('Add New Projects', 'text_domain'),
        'add_new' => __('Add Projects', 'text_domain'),
        'new_item' => __('New Projects', 'text_domain'),
        'edit_item' => __('Edit Projects', 'text_domain'),
        'update_item' => __('Update Projects', 'text_domain'),
        'view_item' => __('View Projects', 'text_domain'),
        'search_items' => __('Search Projects', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'set_featured_image' => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image' => __('Use as featured image', 'text_domain'),
        'insert_into_item' => __('Insert into Projects', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this Projects', 'text_domain'),
        'items_list' => __('Projects list', 'text_domain'),
        'items_list_navigation' => __('Projects list navigation', 'text_domain'),
        'filter_items_list' => __('Filter Projects list', 'text_domain'),
    );
    $args = array(
        'label' => __('Project', 'text_domain'),
        'description' => __('projects Description', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail',),
        'taxonomies' => array('post_tag'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('projects', $args);

}

add_action('init', 'custom_post_type', 0);

/**
 * Register meta box(es).
 */
function contact_register_meta_boxes()
{
    add_meta_box('contact_meta_for_post', __('Contacts', 'textdomain'), 'contact_meta_box', 'projects', 'side', 'default');
}

add_action('add_meta_boxes', 'contact_register_meta_boxes');

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function contact_meta_box($object, $box)
{
    wp_nonce_field(basename(__FILE__), 'project_meta_class_nonce');
    ?>
    <p>
        <label for="contact-post-location-class"><?php _e("Location", 'location'); ?></label>
        <br/>
        <input class="widefat" type="text" name="contact-post-location-class" id="contact-post-location-class"
               value="<?php echo esc_attr(get_post_meta($object->ID, 'contact_post_location_class', true)); ?>"
               size="30"/>
    </p>
    <p>
        <label for="contact-post-developer-class"><?php _e("Developer", 'developer'); ?></label>
        <br/>
        <input class="widefat" type="text" name="contact-post-developer-class" id="contact-post-developer-class"
               value="<?php echo esc_attr(get_post_meta($object->ID, 'contact_post_developer_class', true)); ?>"
               size="30"/>
    </p>
    <p>
        <label for="contact-post-room-class"><?php _e("Rooms", 'room'); ?></label>
        <br/>
        <input class="widefat" type="text" name="contact-post-room-class" id="contact-post-room-class"
               value="<?php echo esc_attr(get_post_meta($object->ID, 'contact_post_room_class', true)); ?>" size="30"/>
    </p>
    <p>
        <label for="contact-post-pricefrom-class"><?php _e("Price From", 'pricefrom'); ?></label>
        <br/>
        <input class="widefat" type="text" name="contact-post-pricefrom-class" id="contact-post-pricefrom-class"
               value="<?php echo esc_attr(get_post_meta($object->ID, 'contact_post_pricefrom_class', true)); ?>"
               size="30"/>
    </p>
    <?php
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box($post_id, $post)
{
    /* Verify the nonce before proceeding. */
    if (!isset($_POST['project_meta_class_nonce']) || !wp_verify_nonce($_POST['project_meta_class_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    /* Get the posted data and sanitize it for use as an HTML class. */
    /* $new_meta_value */
    $new_location_meta_value = (isset($_POST['contact-post-location-class']) ? sanitize_text_field($_POST['contact-post-location-class']) : '');
    $new_developer_meta_value = (isset($_POST['contact-post-developer-class']) ? sanitize_text_field($_POST['contact-post-developer-class']) : '');
    $new_room_meta_value = (isset($_POST['contact-post-room-class']) ? sanitize_text_field($_POST['contact-post-room-class']) : '');
    $new_pricefrom_meta_value = (isset($_POST['contact-post-pricefrom-class']) ? sanitize_text_field($_POST['contact-post-pricefrom-class']) : '');

    /* Get the meta key. */
    /* $meta_key */
    $location_meta_key = 'contact_post_location_class';
    $developer_meta_key = 'contact_post_developer_class';
    $room_meta_key = 'contact_post_room_class';
    $pricefrom_meta_key = 'contact_post_pricefrom_class';

    /* Get the meta value of the custom field key. */
    /* $meta_value */
    $location_meta_value = get_post_meta($post_id, $location_meta_key, true);
    $developer_meta_value = get_post_meta($post_id, $developer_meta_key, true);
    $room_meta_value = get_post_meta($post_id, $room_meta_key, true);
    $pricefrom_meta_value = get_post_meta($post_id, $pricefrom_meta_key, true);

    /* If a new meta value was added and there was no previous value, add it. */
    /*LOCATION*/
    if ($new_location_meta_value && '' == $location_meta_value)
        add_post_meta($post_id, $location_meta_key, $new_location_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_location_meta_value && $new_location_meta_value != $location_meta_value)
        update_post_meta($post_id, $location_meta_key, $new_location_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_location_meta_value && $location_meta_value)
        delete_post_meta($post_id, $location_meta_key, $location_meta_value);
    /*DEVELOPER*/
    if ($new_developer_meta_value && '' == $developer_meta_key)
        add_post_meta($post_id, $developer_meta_key, $new_developer_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_developer_meta_value && $new_developer_meta_value != $developer_meta_value)
        update_post_meta($post_id, $developer_meta_key, $new_developer_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_developer_meta_value && $developer_meta_value)
        delete_post_meta($post_id, $developer_meta_key, $developer_meta_value);

    /*ROOM*/
    if ($new_room_meta_value && '' == $room_meta_value)
        add_post_meta($post_id, $room_meta_key, $new_room_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_room_meta_value && $new_room_meta_value != $room_meta_value)
        update_post_meta($post_id, $room_meta_key, $new_room_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_room_meta_value && $room_meta_value)
        delete_post_meta($post_id, $room_meta_key, $room_meta_value);

    /*PRICEFROM*/
    if ($new_pricefrom_meta_value && '' == $pricefrom_meta_value)
        add_post_meta($post_id, $pricefrom_meta_key, $new_pricefrom_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_pricefrom_meta_value && $new_pricefrom_meta_value != $pricefrom_meta_value)
        update_post_meta($post_id, $pricefrom_meta_key, $new_pricefrom_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_pricefrom_meta_value && $pricefrom_meta_value)
        delete_post_meta($post_id, $pricefrom_meta_key, $pricefrom_meta_value);
}

add_action('save_post', 'wpdocs_save_meta_box', 10, 2);

/*
* meta box for file upload
*/
function projects_file_upload()
{

    // Define the custom attachment for posts
    add_meta_box(
        'wp_custom_attachment',
        'Attachment',
        'wp_projects_attachment',
        'projects',
        'normal',
        'high'
    );
} // end add_custom_meta_boxes
add_action('add_meta_boxes', 'projects_file_upload');

/*
* callback function for file upload meta box
*/
function wp_projects_attachment($object)
{

    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
    $html = '<p>';

    $settings = array('media_buttons' => false, 'textarea_rows' => '5');
    $editor_id = 'pdfDesc';
    $content = esc_attr(get_post_meta($object->ID, 'pdfDesc', true));
    $pdfFile = (get_post_meta($object->ID, 'wp_custom_attachment', true));
    $html .= wp_editor($content, $editor_id, $settings);
    $html .= '<p class="description">';
    $html .= 'Upload your PDF here.';
    $html .= '</p>';
    $html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />';
    if (isset($pdfFile["url"]))
        $html .= '<p>Previous file link: ' . $pdfFile["url"] . '</p>';
    echo $html;


} // end wp_custom_attachment

/*
* save the attachment 
*/
function save_custom_meta_data($id)
{

    /* --- security verification --- */
    if (!wp_verify_nonce($_POST['wp_custom_attachment_nonce'], plugin_basename(__FILE__))) {
        return $id;
    } // end if

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $id;
    } // end if

    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } else {
        if (!current_user_can('edit_page', $id)) {
            return $id;
        } // end if
    } // end if
    /* - end security verification - */

    // Make sure the file array isn't empty
    if (!empty($_FILES['wp_custom_attachment']['name'])) {

        // Setup the array of supported file types. In this case, it's just PDF.
        $supported_types = array('application/pdf');

        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
        $uploaded_type = $arr_file_type['type'];

        // Check if the type is supported. If not, throw an error.
        if (in_array($uploaded_type, $supported_types)) {

            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));

            if (isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                add_post_meta($id, 'wp_custom_attachment', $upload);
                update_post_meta($id, 'wp_custom_attachment', $upload);
            } // end if/else

        } else {
            wp_die("The file type that you've uploaded is not a PDF.");
        } // end if/else


    } // end if
    $new_pdfDesc_meta_value = (isset($_POST['pdfDesc']) ? ($_POST['pdfDesc']) : '');

    $pdfDesc_meta_key = 'pdfDesc';

    $pdfDesc_meta_value = get_post_meta($id, $pdfDesc_meta_key, true);
    if ($new_pdfDesc_meta_value && '' == $pdfDesc_meta_value)
        add_post_meta($id, $pdfDesc_meta_key, $new_pdfDesc_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_pdfDesc_meta_value && $new_pdfDesc_meta_value != $pdfDesc_meta_value)
        update_post_meta($id, $pdfDesc_meta_key, $new_pdfDesc_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_pdfDesc_meta_value && $pdfDesc_meta_value)
        delete_post_meta($id, $pdfDesc_meta_key, $pdfDesc_meta_value);


} // end save_custom_meta_data
add_action('save_post', 'save_custom_meta_data');
function update_edit_form()
{
    echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');

/**
 * Adds a meta box to the post editing screen
 */

add_filter('rwmb_meta_boxes', 'projects_floorplan');
function projects_floorplan($projects_floorplan_metabox)
{
    $projects_floorplan_metabox[] = array(
        'title' => __('Floor Plan 1', 'textdomain'),
        'post_types' => 'projects',
        'fields' => array(
            array(
                'id' => 'name',
                'name' => __('Name', 'textdomain'),
                'type' => 'text',
            ),
            array(
                'id' => 'filesUpload',
                'name' => __('Files', 'textdomain'),
                'type' => 'file_upload',
            ),
        ),
    );
    $projects_floorplan_metabox[] = array(
        'title' => __('Floor Plan 2', 'textdomain'),
        'post_types' => 'projects',
        'fields' => array(
            array(
                'id' => 'name2',
                'name' => __('Name', 'textdomain'),
                'type' => 'text',
            ),
            array(
                'id' => 'filesUpload2',
                'name' => __('Files', 'textdomain'),
                'type' => 'file_upload',
            ),
        ),
    );
    $projects_floorplan_metabox[] = array(
        'title' => __('Floor Plan 3', 'textdomain'),
        'post_types' => 'projects',
        'fields' => array(
            array(
                'id' => 'name3',
                'name' => __('Name', 'textdomain'),
                'type' => 'text',
            ),
            array(
                'id' => 'filesUpload3',
                'name' => __('Files', 'textdomain'),
                'type' => 'file_upload',
            ),
        ),
    );
    $projects_floorplan_metabox[] = array(
        'title' => __('Floor Plan 4', 'textdomain'),
        'post_types' => 'projects',
        'fields' => array(
            array(
                'id' => 'name4',
                'name' => __('Name', 'textdomain'),
                'type' => 'text',
            ),
            array(
                'id' => 'filesUpload4',
                'name' => __('Files', 'textdomain'),
                'type' => 'file_upload',
            ),
        ),
    );
    $projects_floorplan_metabox[] = array(
        'title' => __('Floor Plan 5', 'textdomain'),
        'post_types' => 'projects',
        'fields' => array(
            array(
                'id' => 'name5',
                'name' => __('Name', 'textdomain'),
                'type' => 'text',
            ),
            array(
                'id' => 'filesUpload5',
                'name' => __('Files', 'textdomain'),
                'type' => 'file_upload',
            ),
        ),
    );
    $projects_floorplan_metabox[] = array(
        'title' => __('Gallery', 'textdomain'),
        'post_types' => 'projects',
        'fields' => array(
            array(
                'id' => 'gallery',
                'name' => __('Upload', 'textdomain'),
                'type' => 'file_upload',
            ),
        ),
    );
    return $projects_floorplan_metabox;
}

add_action('add_meta_boxes', 'dynamic_add_custom_box');
/*
* meta box for Easy payment plan
*/
/* Do something with the data entered */
add_action('save_post', 'dynamic_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_custom_box()
{
    add_meta_box(
        'dynamic_sectionid',
        __('Easy payment plan', 'myplugin_textdomain'),
        'dynamic_inner_custom_box',
        'projects',
        'normal',
        'high'
    );
}

/* Render the box content */
function dynamic_inner_custom_box($post)
{

    // nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'dynamicMeta_noncename');
    ?>
    <div id="meta_inner">
    <?php

    //GEt the array of saved meta
    $easy_payment_plan = get_post_meta($post->ID, 'easy_payment_plan', true);

    $c = 0;
    //if ( count( $easy_payment_plan ) > 0 ) {
    if (is_array($easy_payment_plan)) {
        foreach ($easy_payment_plan as $easy_plan) {
            if (isset($easy_plan['name']) || isset($easy_plan['easy_plan'])) {
                printf('<p>Easy Plan Name <input type="text" name="easy_payment_plan[%1$s][name]" value="%2$s" /> -- Easy Plan Content : <input type="text" name="easy_payment_plan[%1$s][easy_plan]" value="%3$s" /><input class="button tagadd remove" type="button" value="%4$s"></p>', $c, $easy_plan['name'], $easy_plan['easy_plan'], __('Remove easy_plan'));
                $c = $c + 1;
            }
        }
    }

    ?>
    <span id="here"></span>
    <input class="button tagadd add" type="button" value="<?php _e('Add Easy Plan'); ?>">
    <script>
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            var count = <?php echo $c; ?>;
            $(".add").click(function () {
                count = count + 1;

                $('#here').append('<p> Easy Plan Name <input type="text" name="easy_payment_plan[' + count + '][name]" value="" /> -- Easy Plan Content : <input type="text" name="easy_payment_plan[' + count + '][easy_plan]" value="" /><input class="button tagadd remove" type="button" value="<?php _e('Remove Easy Plan'); ?>">');
                return false;
            });
            $(".remove").live('click', function () {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php
}

/*  saves our custom data when the post is saved */
function dynamic_save_postdata($post_id)
{
    // verify if this is an auto save routine.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // verify Nonce and that the request is valid,
    if (!isset($_POST['dynamicMeta_noncename']))
        return;

    if (!wp_verify_nonce($_POST['dynamicMeta_noncename'], plugin_basename(__FILE__)))
        return;

    $new_easy_floor_plan = (isset($_POST['easy_payment_plan']) ? ($_POST['easy_payment_plan']) : '');

    $new_easy_floor_plan_metaKey = 'easy_payment_plan';

    $easy_floor_plan_meta_value = get_post_meta($post_id, $new_easy_floor_plan_metaKey, true);
    if ($new_easy_floor_plan && '' == $easy_floor_plan_meta_value)
        add_post_meta($post_id, $new_easy_floor_plan_metaKey, $new_easy_floor_plan, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_easy_floor_plan && $new_easy_floor_plan != $easy_floor_plan_meta_value)
        update_post_meta($post_id, $new_easy_floor_plan_metaKey, $new_easy_floor_plan);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_easy_floor_plan && $easy_floor_plan_meta_value)
        delete_post_meta($post_id, $new_easy_floor_plan_metaKey, $easy_floor_plan_meta_value);
}

include 'master-plan.php';
include 'project-agent.php';