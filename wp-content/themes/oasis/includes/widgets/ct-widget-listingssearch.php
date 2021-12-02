<?php
/**
 * Listings Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_ListingsSearch extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'Display the listings search.' );
	   parent::__construct(false, __('CT Listings Search', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );
	
	$title = $instance['title'];

	global $ct_options;

    $ct_home_adv_search_fields = isset( $ct_options['ct_home_adv_search_fields']['enabled'] ) ? $ct_options['ct_home_adv_search_fields']['enabled'] : '';
    $ct_enable_adv_search_page = isset( $ct_options['ct_enable_adv_search_page'] ) ? $ct_options['ct_enable_adv_search_page'] : '';
    $ct_adv_search_page = isset( $ct_options['ct_adv_search_page'] ) ? $ct_options['ct_adv_search_page'] : '';
	
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }

        echo '<div class="widget-inner">'; ?>
        
            <form id="advanced_search" name="search-listings" action="<?php echo home_url(); ?>">

               <?php
        
                if ($ct_home_adv_search_fields) :
                
                foreach ($ct_home_adv_search_fields as $field=>$value) {
    
                    switch($field) {
                        
                    // Type            
                    case 'type' : ?>
                        <div class="left">
                            <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
                            <?php ct_search_form_select('property_type'); ?>
                        </div>
                    <?php
                    break;
                    
                    // City
                    case 'city' : ?>
                    <div class="left">
                        <label for="ct_city"><?php _e('City', 'contempo'); ?></label>
                        <?php ct_search_form_select('city'); ?>
                    </div>
                    <?php
                    break;
                    
                    // State            
                    case 'state' : ?>
                        <div class="left">
                            <?php
                            global $ct_options;
                            $ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';

                            if($ct_state_or_area == 'area') { ?>
                                <label for="ct_state"><?php _e('Area', 'contempo'); ?></label>
                            <?php } elseif($ct_state_or_area == 'suburb') { ?>
                                <label for="ct_state"><?php _e('Suburb', 'contempo'); ?></label>
                            <?php } else { ?>
                                <label for="ct_state"><?php _e('State', 'contempo'); ?></label>
                            <?php } ?>
                            <?php ct_search_form_select('state'); ?>
                        </div>
                    <?php
                    break;
                    
                    // Zipcode            
                    case 'zipcode' : ?>
                        <div class="left">
                            <?php
                            global $ct_options;
                            $ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? $ct_options['ct_zip_or_post'] : '';

                            if($ct_zip_or_post == 'postcode') { ?>
                                <label for="ct_zipcode"><?php _e('Postcode', 'contempo'); ?></label>
                            <?php } else { ?>
                                <label for="ct_zipcode"><?php _e('Zipcode', 'contempo'); ?></label>
                            <?php } ?>
                            <?php ct_search_form_select('zipcode'); ?>
                        </div>
                    <?php
                    break;

                    // Country            
                    case 'country' : ?>
                        <div class="left">
                            <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
                            <?php ct_search_form_select('country'); ?>
                        </div>
                    <?php
                    break;

                    // Community            
                    case 'type' : ?>
                        <div class="left">
                            <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
                            <?php ct_search_form_select('community'); ?>
                        </div>
                    <?php
                    break;
                    
                    // Beds            
                    case 'beds' : ?>
                        <div class="left">
                            <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
                            <?php ct_search_form_select('beds'); ?>
                        </div>
                    <?php
                    break;
                    
                    // Baths            
                    case 'baths' : ?>
                        <div class="left">
                            <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
                            <?php ct_search_form_select('baths'); ?>
                        </div>
                    <?php
                    break;
                    
                    // Status            
                    case 'status' : ?>
                        <div class="left">
                            <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
                            <?php ct_search_form_select('ct_status'); ?>
                        </div>
                    <?php
                    break;
                    
                    // Additional Features            
                    case 'additional_features' : ?>
                        <div class="left">
                            <label for="ct_additional_features"><?php _e('Addtional Features', 'contempo'); ?></label>
                            <?php ct_search_form_select('additional_features'); ?>
                        </div>
                    <?php
                    break;

                    // Community          
                    case 'community' : ?>
                        <div class="left">
                            <?php
                            global $ct_options;
                            $ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

                            if($ct_community_neighborhood_or_district == 'neighborhood') { ?>
                                <label for="ct_community"><?php _e('Neighborhood', 'contempo'); ?></label>
                            <?php } elseif($ct_community_neighborhood_or_district == 'district') { ?>
                                <label for="ct_community"><?php _e('District', 'contempo'); ?></label>
                            <?php } else { ?>
                                <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
                            <?php } ?>
                            <?php ct_search_form_select('community'); ?>
                        </div>
                    <?php
                    break;
                    
                    // Price From            
                    case 'price_from' : ?>
                        <div class="left">
                            <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                            <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                        </div>
                    <?php
                    break;
                    
                    // Price To            
                    case 'price_to' : ?>
                        <div class="left">
                            <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                            <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                        </div>
                    <?php
                    break;

                    // Sq Ft From            
                    case 'sqft_from' : ?>
                        <div class="left">
                            <label for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
                            <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                        </div>
                    <?php
                    break;
                    
                    // Sq Ft To            
                    case 'sqft_to' : ?>
                        <div class="left">
                            <label for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
                            <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                        </div>
                    <?php
                    break;

                    // Lot Size From            
                    case 'lotsize_from' : ?>
                        <div class="left">
                            <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
                            <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                        </div>
                    <?php
                    break;
                    
                    // Lot Size To            
                    case 'lotsize_to' : ?>
                        <div class="left">
                            <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
                            <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                        </div>
                    <?php
                    break;
                    
                    // MLS            
                    case 'mls' : ?>
                        <div class="left">
                            <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
                            <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
                        </div>
                    <?php
                    break;

                    // Number of Guests            
                    case 'numguests' : ?>
                        <div class="left">
                            <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
                            <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
                        </div>
                    <?php
                    break;

                    }
                
                } endif; ?>
                
                    <div class="clear"></div>
                
                <input type="hidden" name="search-listings" value="true" />
                <?php
    		        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    		        if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {

    		            $lang =  ICL_LANGUAGE_CODE;

    		            //echo '<input type="hidden" name="lang" value="' . $lang . '" />';
    		        }
    		    ?>
                <input id="submit" class="btn marB0" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />

                <?php if($ct_enable_adv_search_page == 'yes' && $ct_adv_search_page != '') { ?>
                <div class="left">
                    <a class="btn more-search-options" href="<?php echo home_url(); ?>/?page_id=<?php echo esc_html($ct_adv_search_page); ?>"><?php _e('More Search Options', 'contempo'); ?></a>
                </div>
                <?php } ?>

                <div class="left makeloading"><i class="fa fa-circle-o-notch fa-spin"></i></div>

            </form>

        </div>
		
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		?>
		<p>
		   <label class="muted" for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<?php
	}
} 

register_widget('ct_ListingsSearch');
?>