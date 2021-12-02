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

    <li class="listing listing-list col span_12 first">

        <?php do_action('before_listing_list_img'); ?>

        <?php if(has_post_thumbnail()) { ?>
        <figure class="col span_6 first">
            <?php ct_status(); ?>
            <?php ct_property_type_icon(); ?>
            <?php ct_fav_listing(); ?>
            <?php ct_first_image_linked(); ?>
        </figure>
        <?php } ?>

        <?php do_action('before_listing_list_info'); ?>

        <div class="list-listing-info col span_6">
            <div class="list-listing-info-inner">
                <header>
                    <?php do_action('before_listing_list_title'); ?>
                    <h4 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h4>
                    <?php do_action('before_listing_grid_address'); ?>
                    <p class="location muted marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p>
                </header>
                
                <?php do_action('before_listing_list_price'); ?>
                
                <p class="price marB0"><?php ct_listing_price(); ?></p>

                <?php do_action('before_listing_list_propinfo'); ?>
                
                <div class="propinfo">
                    <p class="propinfo-excerpt"><?php echo ct_excerpt(); ?></p>
                    <ul class="marB0">
    					<?php ct_propinfo(); ?>
                    </ul>
                </div>

                <?php ct_brokered_by(); ?>
            </div>
        </div>

        <?php do_action('after_listing_list_info'); ?>
	
    </li>
    
<?php

echo '<div class="clear"></div>';

endwhile; ?>

	</ul>

	<?php ct_numeric_pagination(); ?>

		<div class="clear"></div>

<?php endif; wp_reset_postdata(); ?>