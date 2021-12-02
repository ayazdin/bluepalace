<?php
global $ct_options;

$ct_search_title = isset( $ct_options['ct_home_adv_search_title'] ) ? $ct_options['ct_home_adv_search_title'] : '';
$ct_home_adv_search_fields = isset( $ct_options['ct_home_adv_search_fields']['enabled'] ) ? $ct_options['ct_home_adv_search_fields']['enabled'] : '';
$ct_enable_adv_search_page = isset( $ct_options['ct_enable_adv_search_page'] ) ? $ct_options['ct_enable_adv_search_page'] : '';
$ct_adv_search_page = isset( $ct_options['ct_adv_search_page'] ) ? $ct_options['ct_adv_search_page'] : '';

?>

        <h3>Search Properties</h3>
        <form class="offset-top-30 text-left" name ="search-listings" action="<?php echo home_url(); ?>">
        	<div class="range range-condensed text-sm-left">
        	<?php
                if($ct_home_adv_search_fields):
                    foreach($ct_home_adv_search_fields as $field=>$values){

                        switch($field){
                            //type
                            case 'type':?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_city"><?php _e('Property Type', 'contempo'); ?></label>
                                    <?php ct_search_form_select('property_type'); ?>
                                </div>
                            <?php
                                break;

                            //city
                            case 'city' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_city"><?php _e('City', 'contempo'); ?></label>
                                    <?php ct_search_form_select('city'); ?>
                                </div>
                            <?php
                                break;

                            // State
                            case 'state' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <?php
                                    global $ct_options;
                                    $ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';

                                    if($ct_state_or_area == 'area') { ?>
                                        <label class="form-label-static form-label-outside"  for="ct_state"><?php _e('Area', 'contempo'); ?></label>
                                    <?php } elseif($ct_state_or_area == 'suburb') { ?>
                                        <label class="form-label-static form-label-outside"  for="ct_state"><?php _e('Suburb', 'contempo'); ?></label>
                                    <?php } else { ?>
                                        <label class="form-label-static form-label-outside"  for="ct_state"><?php _e('Subcommunity', 'contempo'); ?></label>
                                    <?php } ?>
                                    <?php ct_search_form_select('state'); ?>
                                </div>
                                <?php
                                break;

                            // Zipcode
                            case 'zipcode' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <?php
                                    global $ct_options;
                                    $ct_zip_or_post = isset( $ct_options['ct_zip_or_post'] ) ? $ct_options['ct_zip_or_post'] : '';

                                    if($ct_zip_or_post == 'postcode') { ?>
                                        <label class="form-label-static form-label-outside" for="ct_zipcode"><?php _e('Postcode', 'contempo'); ?></label>
                                    <?php } else { ?>
                                        <label class="form-label-static form-label-outside" for="ct_zipcode"><?php _e('Zipcode', 'contempo'); ?></label>
                                    <?php } ?>
                                    <?php ct_search_form_select('zipcode'); ?>
                                </div>
                                <?php
                                break;

                            // Country
                            case 'country' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_country"><?php _e('Community', 'contempo'); ?></label>
                                    <?php ct_search_form_select('country'); ?>
                                </div>
                                <?php
                                break;

                            // Community
                            case 'type' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_community"><?php _e('Community', 'contempo'); ?></label>
                                    <?php ct_search_form_select('community'); ?>
                                </div>
                                <?php
                                break;

                            // Beds
                            case 'beds' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
                                    <?php ct_search_form_select('beds'); ?>
                                </div>
                                <?php
                                break;

                            // Baths
                            case 'baths' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
                                    <?php ct_search_form_select('baths'); ?>
                                </div>
                                <?php
                                break;

                            // Status
                            case 'status' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_status"><?php _e('Status', 'contempo'); ?></label>
                                    <?php ct_search_form_select('ct_status'); ?>
                                </div>
                                <?php
                                break;

                            // Additional Features
                            case 'additional_features' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_additional_features"><?php _e('Addtional Features', 'contempo'); ?></label>
                                    <?php ct_search_form_select('additional_features'); ?>
                                </div>
                                <?php
                                break;

                            // Community
                            case 'community' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <?php
                                    global $ct_options;
                                    $ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

                                    if($ct_community_neighborhood_or_district == 'neighborhood') { ?>
                                        <label class="form-label-static form-label-outside" for="ct_community"><?php _e('Neighborhood', 'contempo'); ?></label>
                                    <?php } elseif($ct_community_neighborhood_or_district == 'district') { ?>
                                        <label class="form-label-static form-label-outside" for="ct_community"><?php _e('District', 'contempo'); ?></label>
                                    <?php } else { ?>
                                        <label class="form-label-static form-label-outside" for="ct_community"><?php _e('Community', 'contempo'); ?></label>
                                    <?php } ?>
                                    <?php ct_search_form_select('community'); ?>
                                </div>
                                <?php
                                break;

                            // Price From
                            case 'price_from' : ?>
                                <div class="form-group cell-sm-3 priceToHide">
                                    <label class="form-label-static form-label-outside" for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                                </div>
                                <?php
                                break;

                            // Price To
                            case 'price_to' : ?>
                                <div class="form-group cell-sm-3 priceFromHide">
                                    <label class="form-label-static form-label-outside" for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                    <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
                                </div>
                                <?php
                                break;

                            // Sq Ft From
                            case 'sqft_from' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
                                    <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                                </div>
                                <?php
                                break;

                            // Sq Ft To
                            case 'sqft_to' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
                                    <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                                </div>
                                <?php
                                break;

                            // Lot Size From
                            case 'lotsize_from' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
                                    <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                                </div>
                                <?php
                                break;

                            // Lot Size To
                            case 'lotsize_to' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
                                    <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
                                </div>
                                <?php
                                break;

                            // MLS
                            case 'mls' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
                                    <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
                                </div>
                                <?php
                                break;

                            // Number of Guests
                            case 'numguests' : ?>
                                <div class="form-group cell-sm-3 frm-search">
                                    <label class="form-label-static form-label-outside" for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
                                    <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
                                </div>
                                <?php
                                break;

                            // Keyword
                            case 'keyword' : ?>
                            	<div class="cell-sm-2"></div>
                                <div class="form-group cell-sm-8 mar-bot-30">
                                    <input type="text" id="ct_keyword" name="ct_keyword" class="form-control" placeholder="<?php esc_html_e('Enter a street address or keyword', 'contempo'); ?>" />
                                </div>
                                <div class="cell-sm-2"></div>
                                <?php
                                break;




                        }// end of switch
                    }// end of foreach
                endif;// end of ct_home_search_fields
            ?>
            <div class="form-group cell-sm-3 frm-search">
                <label class="form-label-static form-label-outside" for="ct_pricerange"><?php _e('Select Price Range', 'contempo'); ?></label>
                <select name="priceRange" id="priceRangeFromTo" onchange="priceRangeFromTo();">
                    <option value="">Select Price Range</option>
                    <option value="20000-50000">20,000-50,000</option>
                    <option value="50000-80000">50,000-80,000</option>
                    <option value="80000-110000">80,000-110,000</option>
                    <option value="110000-150000">110,000-150,000</option>
                    <option value="150000-180000">150,000-180,000</option>
                    <option value="180000-210000">180,000-210,000</option>
                    <option value="210000-250000">210,000-250,000</option>
                    <option value="250000-300000">250,000-300,000</option>
                    <option value="300000-400000">300,000-400,000</option>
                    <option value="400000-500000">400,000-500,000</option>
                    <option value="500000-750000">500,000-750,000</option>
                    <option value="750000-1000000">750,000-1,000,000</option>
                    <option value="1M">1M and more</option>
                </select>
            </div>

                <input type="hidden" name="search-listings" value="true" />

            <div class="offset-top-4 cell-sm-3 frm-search">
            	<label class="form-label-static form-label-outside"></label>
                <button class="btn btn-block btn-primary">search</button>
            </div>

            <?php if($ct_enable_adv_search_page == 'yes' && $ct_adv_search_page != '') { ?>
                <div class="offset-top-10">
                    <a class="btn btn-block btn-primary" href="<?php echo home_url(); ?>/?page_id=<?php echo esc_html($ct_adv_search_page); ?>"><?php _e('More Search Options', 'contempo'); ?></a>
                </div>
            <?php } ?>
        </div>
        </form>

