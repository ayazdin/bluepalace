<?php
/*
* meta box for file upload
*/
function masterplan_upload()
{

    // Define the custom attachment for posts
    add_meta_box(
        'wp_masterplan_image',
        'Attachment Masterplan',
        'masterplan_attachment',
        'projects',
        'normal',
        'high'
    );
} // end add_custom_meta_boxes
add_action('add_meta_boxes', 'masterplan_upload');

/*
* callback function for file upload meta box
*/
function masterplan_attachment($object1)
{

    wp_nonce_field(plugin_basename(__FILE__), 'wp_masterplan_image_nonce');
    $master = '<p>';

    $masterplan = (get_post_meta($object1->ID, 'wp_masterplan_image', true));
    $master .= '<p class="description">';
    $master .= 'Upload your Masterplan here.';
    $master .= '</p>';
    $master .= '<input type="file" id="wp_masterplan_image" name="wp_masterplan_image" value="" size="25" />';
    if (isset($masterplan["url"]))
        $master .= '<p>Previous file link: ' . $masterplan["url"] . '</p>';
    echo $master;


} // end wp_masterplan_image

/*
* save the attachment 
*/
function masteplanData($id1)
{
    /* --- security verification --- */
    if (!wp_verify_nonce($_POST['wp_masterplan_image_nonce'], plugin_basename(__FILE__))) {
        return $id1;
    } // end if

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $id1;
    } // end if

    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $id1)) {
            return $id1;
        } // end if
    } else {
        if (!current_user_can('edit_page', $id1)) {
            return $id1;
        } // end if
    } // end if
    /* - end security verification - */

    // Make sure the file array isn't empty
    if (!empty($_FILES['wp_masterplan_image']['name'])) {

        // Setup the array of supported file types. In this case, it's just PDF.
        $supported_types = array('image/jpeg', 'image/gif');

        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES['wp_masterplan_image']['name']));
        $uploaded_type = $arr_file_type['type'];

        // Check if the type is supported. If not, throw an error.
        if (in_array($uploaded_type, $supported_types)) {

            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES['wp_masterplan_image']['name'], null, file_get_contents($_FILES['wp_masterplan_image']['tmp_name']));

            if (isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                add_post_meta($id1, 'wp_masterplan_image', $upload);
                update_post_meta($id1, 'wp_masterplan_image', $upload);
            } // end if/else

        } else {
            wp_die("The file type that you've uploaded is not a jpeg/gif.");
        } // end if/else


    } // end if

} // end masteplanData
add_action('save_post', 'masteplanData');
function masterplan_form()
{
    echo ' enctype="multipart/form-data"';
} // end masterplan_form
add_action('post_edit_form_tag', 'masterplan_form');
