<?php 
/**
 * Listings Loop
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;
global $paged;
$paged = ct_currentPage();
$count = 0;
$ct_search_results_layout = isset( $ct_options['ct_search_results_layout'] ) ? $ct_options['ct_search_results_layout'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

if ( ! $wp_query->have_posts() ) : ?>
		<div class="clear"></div>
	<?php if(is_author()) { ?>
		<p class="nomatches"><strong><?php esc_html_e( 'This agent currently has no active listings.', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Check back soon.', 'contempo' ); ?></p>
    <?php } elseif( 'brokerage' == get_post_type() ) { ?>
        <p class="nomatches"><strong><?php esc_html_e( 'This brokerage currently has no active listings.', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Check back soon.', 'contempo' ); ?></p>
	<?php } else { ?>
	    <p class="nomatches"><strong><?php esc_html_e( 'No properties were found which match your search criteria', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Try broadening your search to find more results.', 'contempo' ); ?></p>
    <?php } ?>

<?php

	echo '<ul class="marB0">';

	elseif ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

    <li class="listing col span_4 <?php echo $ct_search_results_listing_style; ?> <?php if($ct_search_results_layout == 'sidebyside') { if($count % 2 == 0) { echo 'first'; } } else { if($count % 3 == 0) { echo 'first'; } } ?>">

        <?php do_action('before_listing_grid_img'); ?>
        <?php $referenceIDOfProperty = get_post_meta($post->ID, "_ct_reference", true); ?>

        <?php if(has_post_thumbnail()) { ?>
        <figure>
            <?php //ct_status(); ?>
            <?php //ct_property_type_icon(); ?>
            <?php ct_fav_listing(); ?>
            <?php ct_first_image_linked(); ?>
        </figure>
        <?php } else { ?>
                    <figure>
                        <?php //ct_status(); ?>
                        <?php //ct_property_type_icon(); ?>
                        <?php ct_fav_listing(); ?>
                        <a <?php ct_listing_permalink(); ?>>
                        <?php 
                            $sliderUnSerialized = get_post_meta( $post->ID, '_ct_slider', false );
                            $sliderArr = unserialize($sliderUnSerialized[0]);
                            //echo '<img src="'.$sliderArr[0].'" alt="">';
                            if(!empty($sliderArr)){
							echo '<img class="attachment-large size-large wp-post-image" src="'.$sliderArr[0].'" alt="">';
                                }
                                else{

                                    echo '<img class="attachment-large size-large wp-post-image" src="'.get_template_directory_uri().'/images/No_image_available.png'.'" alt="">';
                                }
                        ?>
                        </a>
                        <?php ct_first_image_linked(); ?>
                    </figure>
                <?php } ?>

        <?php do_action('before_listing_grid_info'); ?>

        <div class="grid-listing-info">
            <header>
                <?php do_action('before_listing_grid_title'); ?>
                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
                <?php do_action('before_listing_grid_address'); ?>
                <p class="location muted marB0">
                <?php
                    $city = strip_tags( get_the_term_list( $post->ID, 'city', '', ', ', '' ) );
                    $state = strip_tags( get_the_term_list( $post->ID, 'state', '', ', ', '' ) );
                    if(!empty($city))
                        echo $city .',';
                    if(!empty($state))
                        echo $state;

                     //city(); ?> <?php //state(); ?> <?php //zipcode(); ?><?php //country();
                     ?>
                </p>
            </header>
            
            <?php do_action('before_listing_grid_price'); ?>
            
            <p class="price marB0"><span class="left"><?php ct_listing_price(); ?></span><span class="right">REF#: <?=$referenceIDOfProperty?></span></p>
	        <!--<p class="price marB0"><span class="left"><?php /*ct_listing_price(); */?></span><span class="right"><?php /*ct_status();*/?></span></p>-->

            <?php do_action('before_listing_grid_propinfo'); ?>
            
            <div class="propinfo">
            	<p><?php //echo ct_excerpt(); ?></p>
                <ul class="marB0">
					<?php ct_propinfo(); ?>
                </ul>
            </div>

            <?php ct_brokered_by(); ?>

        </div>

        <?php do_action('after_listing_grid_info'); ?>
	
    </li>
    
<?php

$count++;

if($ct_search_results_layout == 'sidebyside') {
    if($count % 2 == 0) {
    echo '<div class="clear"></div>';
    }
} else {
    if($count % 3 == 0) {
    echo '<div class="clear"></div>';
    }
}

endwhile; ?>

	</ul>

	<?php ct_numeric_pagination(); ?>

		<div class="clear"></div>

<?php endif; wp_reset_postdata(); ?>