<?php
/**
 * Profile Fields
 *
 * @package WP Pro Real Estate 7
 * @subpackage Admin
 */

if(!function_exists('ct_add_multipart')) {                
    function ct_add_multipart() {
    	echo 'enctype="multipart/form-data"';
    }
}                      
add_action( 'user_edit_form_tag', 'ct_add_multipart' );

function ct_brokerage_select($selected = 0) {
    $posts = get_posts(array('post_type'=> 'brokerage', 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));

    $user_ID = get_current_user_id();
    $ct_brokerage_name = get_the_author_meta('brokeragename', $user_ID);

    echo '<select name="brokeragename" id="brokeragename">';
    echo '<option value="">' . __('Select a Brokerage', 'contempo') . '</option>';
        foreach ($posts as $post) {
            if ($ct_brokerage_name == $post->ID) { $selected = 'selected="selected" '; } else { $selected = ''; }
            echo '<option value="', $post->ID, '"' . esc_html($selected) . '>', $post->post_title, '</option>';
        }
    echo '</select>';
}

/*-----------------------------------------------------------------------------------*/
/* Add Extra Profile Fields */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_extra_user_profile_fields')) {
    function ct_extra_user_profile_fields($user) {

        global $ct_options;

        $ct_agents_assign = isset( $ct_options['ct_agents_assign'] ) ? esc_attr( $ct_options['ct_agents_assign'] ) : '';

        ?>
        <h3><?php esc_html_e("Extra profile information", "contempo"); ?></h3>
         
        <table class="form-table">
            <?php if($ct_agents_assign == 'yes' && current_user_can('manage_options') || $ct_agents_assign == 'no' || $ct_agents_assign == '') { ?>
                <tr>
                    <th><label for="isagent"><?php esc_html_e('Agent', 'contempo'); ?></label></th>
                    <td>
                        <input type="checkbox" name="isagent" id=" isagent " value="yes" <?php if (esc_attr( get_the_author_meta( "isagent", $user->ID )) == "yes") echo "checked"; ?> />  Show on Agents Page
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th><label for="agentorder"><?php esc_html_e('Agent Order', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="agentorder" id="agentorder" value="<?php echo esc_attr( get_the_author_meta( 'agentorder', $user->ID ) ); ?>" class="regular-text" /><br />
                    <p class="description"><?php _e('If user is an agent select the order you would like them displayed on the agents page, e.g. 1, 2, 3, etc&hellip; NOTE: You must also set Real Estate 7 Options > Agents > Manually Order Agents? > to Yes, otherwise the ordering won\'t be applied.', 'contempo'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="ct_profile_img"><?php esc_html_e('Profile Image', 'contempo'); ?></label></th>
                <td>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                    <?php $profile_img = get_the_author_meta('ct_profile_url', $user->ID ); ?>
                    <?php if($profile_img != "") { ?>
                        <img class="user-profile-img" style="border: 1px solid #dfdfdf; margin: 0 0 5px 0; padding: 5px; background: #fff;" src="<?php echo esc_url($profile_img); ?>" width="100" />
                    <?php } ?>
                    <br />
                    <div class="clear"></div>
                    <input name="ct_profile_img" id="ct_profile_img" type="file" /><br />
                    <span class="description"><?php esc_html_e('Please upload a profile picture here, if none is chosen a default image will be used.', 'contempo'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="mobile"><?php esc_html_e('Mobile #', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="mobile" id="mobile" value="<?php echo esc_attr( get_the_author_meta( 'mobile', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="fax"><?php esc_html_e('Fax #', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="fax" id="fax" value="<?php echo esc_attr( get_the_author_meta( 'fax', $user->ID ) ); ?>" class="regular-text" /><br />
            
                </td>
            </tr>
            <tr>
                <th><label for="title"><?php esc_html_e('Title', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="title" id="title" value="<?php echo esc_attr( get_the_author_meta( 'title', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="tagline"><?php esc_html_e('Tagline', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="tagline" id="tagline" value="<?php echo esc_attr( get_the_author_meta( 'tagline', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
        </table>
            
        <h3><?php esc_html_e('Office Information', 'contempo'); ?></h3>
            
        <table class="form-table">
            <tr>
                <th><label for="ct_broker_logo"><?php esc_html_e('Personal Logo', 'contempo'); ?></label></th>
                <td>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
                    <?php $ct_broker_logo = get_the_author_meta('ct_broker_logo', $user->ID ); ?>
                    <?php if($ct_broker_logo != "") { ?>
                        <img class="user-profile-img" style="border: 1px solid #dfdfdf; margin: 0 0 5px 0; padding: 5px; background: #fff;" src="<?php echo esc_url($ct_broker_logo); ?>" width="100" />
                    <?php } ?>
                    <br />
                    <div class="clear"></div>
                    <input name="ct_broker_logo" id="ct_broker_logo" type="file" /><br />
                    <span class="description"><?php esc_html_e('Upload your personal logo here, or if you choose to associate a Brokerage below that logo will be used instead.', 'contempo'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="brokerage_cpt"><?php esc_html_e('Brokerage', 'contempo'); ?></label></th>
                <td>
                    <?php ct_brokerage_select(); ?><br />
                    <span class="description"><?php esc_html_e('Assign a brokerage here, these are pulled from the Brokerage custom post type.', 'contempo'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="office"><?php esc_html_e('Office #', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="office" id="office" value="<?php echo esc_attr( get_the_author_meta( 'office', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="address"><?php esc_html_e('Address', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php esc_html_e('City', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="state"><?php esc_html_e('State or Province', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="postalcode"><?php esc_html_e('Postal Code', 'contempo'); ?></label></th>
                <td>
                    <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr( get_the_author_meta( 'postalcode', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
        </table>
    <?php }
}
add_action( 'show_user_profile', 'ct_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'ct_extra_user_profile_fields' );

/*-----------------------------------------------------------------------------------*/
/* Save Extra Profile Fields */
/*-----------------------------------------------------------------------------------*/

if(!function_exists('ct_save_extra_user_profile_fields')) {
    function ct_save_extra_user_profile_fields($user_id) {

        global $ct_options;
        
        $ct_agents_assign = isset( $ct_options['ct_agents_assign'] ) ? esc_attr( $ct_options['ct_agents_assign'] ) : '';
     
    	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    	
    	// Upload Profile Image   
    	if ( !empty($_FILES['ct_profile_img']['name']) ) {
    		$filename = $_FILES['ct_profile_img'];				
    		$override['test_form'] = false;
    		$override['action'] = 'wp_handle_upload';
    		$uploaded = wp_handle_upload($filename,$override);
    		update_user_meta( $user_id, "ct_profile_url" , $uploaded['url'] );
    		
    		if( !empty($uploaded['error']) ) {
    				die( 'Could not upload image: ' . $uploaded['error'] ); 
    		}        
    	}

        // Upload Custom Logo    
        if ( !empty($_FILES['ct_broker_logo']['name']) ) {
            $filename = $_FILES['ct_broker_logo'];              
            $override['test_form'] = false;
            $override['action'] = 'wp_handle_upload';
            $uploaded = wp_handle_upload($filename,$override);
            update_user_meta( $user_id, "ct_broker_logo" , $uploaded['url'] );
            
            if( !empty($uploaded['error']) ) {
                    die( 'Could not upload image: ' . $uploaded['error'] ); 
            }        
        }
    	
        if($ct_agents_assign == 'yes' && current_user_can('manage_options') || $ct_agents_assign == 'no') {
        	update_user_meta( $user_id, 'isagent', $_POST['isagent'] );
        }
        
        update_user_meta( $user_id, 'brokeragename', $_POST['brokeragename'] );
        update_user_meta( $user_id, 'agentorder', $_POST['agentorder'] );
    	update_user_meta( $user_id, 'mobile', $_POST['mobile'] );
    	update_user_meta( $user_id, 'office', $_POST['office'] );
        update_user_meta( $user_id, 'brokerage', $_POST['brokerage'] );
    	update_user_meta( $user_id, 'fax', $_POST['fax'] );
    	update_user_meta( $user_id, 'title', $_POST['title'] );
    	update_user_meta( $user_id, 'tagline', $_POST['tagline'] ); 
    	update_user_meta( $user_id, 'address', $_POST['address'] );
    	update_user_meta( $user_id, 'city', $_POST['city'] );
    	update_user_meta( $user_id, 'state', $_POST['state'] );
    	update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
    }
}
add_action( 'personal_options_update', 'ct_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'ct_save_extra_user_profile_fields' );

?>