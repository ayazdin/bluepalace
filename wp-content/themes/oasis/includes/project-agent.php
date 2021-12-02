<?php
/**
 * Created by PhpStorm.
 * User: Sujan
 * Date: 28/11/2016
 * Time: 2:14 PM
 */
/*
* meta box for file upload
*/
function agent_for_project()
{

    // Define the custom attachment for posts
    add_meta_box(
        'agent_image',
        'Agent',
        'agent_attachment',
        'projects'
    );
} // end add_custom_meta_boxes
add_action('add_meta_boxes', 'agent_for_project');

/*
* callback function for file upload meta box
*/
function agent_attachment($object1)
{

    wp_nonce_field(plugin_basename(__FILE__), 'agent_image_nonce');
    $agenthtml = '';
//get data if present
    $agent = (get_post_meta($object1->ID, 'agent_image', true));
    $agent_title = (get_post_meta($object1->ID, 'agent_name', true));
    $agent_email = (get_post_meta($object1->ID, 'agent_email', true));
    $agent_phone = (get_post_meta($object1->ID, 'agent_phone', true));

    $settings = array('media_buttons' => false, 'textarea_rows' => '5');
    $editor_id = 'agent_description';
    $content = get_post_meta($object1->ID, $editor_id, true);
    $agenthtml .= '<p>';
    $agenthtml .= '<input type="text" name="agent_name" placeholder="Enter Agent Title Here" value="'.$agent_title.'">';
    $agenthtml .= "</p>";
    $agenthtml .= '<p>';
    $agenthtml .= '<input type="text" name="agent_email" placeholder="Enter Agent Email Here" value="'.$agent_email.'">';
    $agenthtml .= "</p>";
    $agenthtml .= '<p>';
    $agenthtml .= '<input type="text" name="agent_phone" placeholder="Enter Agent Phone Here" value="'.$agent_phone.'">';
    $agenthtml .= "</p>";
    $agenthtml .= wp_editor($content, $editor_id, $settings);
    $agenthtml .= '<p class="description">';
    $agenthtml .= 'Upload your agent image here.';
    $agenthtml .= '</p>';
    $agenthtml .= '<input type="file" id="agent_image" name="agent_image" value="" size="25" />';
    if (isset($agent["url"]))
        $agenthtml .= '<p>Previous file link: ' . $agent["url"] . '</p>';

    echo $agenthtml;


} // end agent_image

/*
* save the attachment
*/
function agentData($idagent)
{
    /* --- security verification --- */
    if (!wp_verify_nonce($_POST['agent_image_nonce'], plugin_basename(__FILE__))) {
        return $idagent;
    } // end if

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $idagent;
    } // end if

    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $idagent)) {
            return $idagent;
        } // end if
    } else {
        if (!current_user_can('edit_page', $idagent)) {
            return $idagent;
        } // end if
    } // end if
    /* - end security verification - */

    // Make sure the file array isn't empty
    if (!empty($_FILES['agent_image']['name'])) {

        // Setup the array of supported file types. In this case, it's just PDF.
        $supported_types = array('image/jpeg', 'image/gif');

        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES['agent_image']['name']));
        $uploaded_type = $arr_file_type['type'];

        // Check if the type is supported. If not, throw an error.
        if (in_array($uploaded_type, $supported_types)) {

            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES['agent_image']['name'], null, file_get_contents($_FILES['agent_image']['tmp_name']));

            if (isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                add_post_meta($idagent, 'agent_image', $upload);
                update_post_meta($idagent, 'agent_image', $upload);
            } // end if/else

        } else {
            wp_die("The file type that you've uploaded is not a jpeg/gif.");
        } // end if/else


    } // end if
    $new_agent_description_meta_value = (isset($_POST['agent_description']) ? ($_POST['agent_description']) : '');

    $agent_description_meta_key = 'agent_description';

    $agent_description_meta_value = get_post_meta($idagent, $agent_description_meta_key, true);
    if ($new_agent_description_meta_value && '' == $agent_description_meta_value)
        add_post_meta($idagent, $agent_description_meta_key, $new_agent_description_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_agent_description_meta_value && $new_agent_description_meta_value != $agent_description_meta_value)
        update_post_meta($idagent, $agent_description_meta_key, $new_agent_description_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_agent_description_meta_value && $agent_description_meta_value)
        delete_post_meta($idagent, $agent_description_meta_key, $agent_description_meta_value);
//agent title
$new_agent_agent_title_meta_value = (isset($_POST['agent_name']) ? ($_POST['agent_name']) : '');

    $agent_agent_title_meta_key = 'agent_name';

    $agent_agent_title_meta_value = get_post_meta($idagent, $agent_agent_title_meta_key, true);
    if ($new_agent_agent_title_meta_value && '' == $agent_agent_title_meta_value)
        add_post_meta($idagent, $agent_agent_title_meta_key, $new_agent_agent_title_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_agent_agent_title_meta_value && $new_agent_agent_title_meta_value != $agent_agent_title_meta_value)
        update_post_meta($idagent, $agent_agent_title_meta_key, $new_agent_agent_title_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_agent_agent_title_meta_value && $agent_agent_title_meta_value)
        delete_post_meta($idagent, $agent_agent_title_meta_key, $agent_agent_title_meta_value);

//agent email
$new_agent_agent_email_meta_value = (isset($_POST['agent_email']) ? ($_POST['agent_email']) : '');

    $agent_agent_email_meta_key = 'agent_email';

    $agent_agent_email_meta_value = get_post_meta($idagent, $agent_agent_email_meta_key, true);
    if ($new_agent_agent_email_meta_value && '' == $agent_agent_email_meta_value)
        add_post_meta($idagent, $agent_agent_email_meta_key, $new_agent_agent_email_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_agent_agent_email_meta_value && $new_agent_agent_email_meta_value != $agent_agent_email_meta_value)
        update_post_meta($idagent, $agent_agent_email_meta_key, $new_agent_agent_email_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_agent_agent_email_meta_value && $agent_agent_email_meta_value)
        delete_post_meta($idagent, $agent_agent_email_meta_key, $agent_agent_email_meta_value);

//agent phone
$new_agent_agent_phone_meta_value = (isset($_POST['agent_phone']) ? ($_POST['agent_phone']) : '');

    $agent_agent_phone_meta_key = 'agent_phone';

    $agent_agent_phone_meta_value = get_post_meta($idagent, $agent_agent_phone_meta_key, true);
    if ($new_agent_agent_phone_meta_value && '' == $agent_agent_phone_meta_value)
        add_post_meta($idagent, $agent_agent_phone_meta_key, $new_agent_agent_phone_meta_value, true);

    /* If the new meta value does not match the old value, update it. */
    elseif ($new_agent_agent_phone_meta_value && $new_agent_agent_phone_meta_value != $agent_agent_phone_meta_value)
        update_post_meta($idagent, $agent_agent_phone_meta_key, $new_agent_agent_phone_meta_value);

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ('' == $new_agent_agent_phone_meta_value && $agent_agent_phone_meta_value)
        delete_post_meta($idagent, $agent_agent_phone_meta_key, $agent_agent_phone_meta_value);


} // end agentData
add_action('save_post', 'agentData');
function agent_form()
{
    echo ' enctype="multipart/form-data"';
} // end agent_form
add_action('post_edit_form_tag', 'agent_form');
