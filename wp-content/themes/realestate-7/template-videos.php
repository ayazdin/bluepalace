<?php
/**
 * Template Name: Videos
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

// global $ct_options;

// $ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
// $ct_listing_single_content_layout = isset( $ct_options['ct_listing_single_content_layout'] ) ? esc_html( $ct_options['ct_listing_single_content_layout'] ) : '';
// $ct_listing_tools = isset( $ct_options['ct_listing_tools'] ) ? esc_html( $ct_options['ct_listing_tools'] ) : '';
// $ct_listing_propinfo = isset( $ct_options['ct_listing_propinfo'] ) ? esc_html( $ct_options['ct_listing_propinfo'] ) : '';
// $ct_listing_agent_info = isset( $ct_options['ct_listing_agent_info'] ) ? esc_html( $ct_options['ct_listing_agent_info'] ) : '';
// $ct_listing_section_nav = isset( $ct_options['ct_listing_section_nav'] ) ? esc_html( $ct_options['ct_listing_section_nav'] ) : '';
// $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
// $ct_multi_floorplan = isset( $ct_options['ct_multi_floorplan'] ) ? esc_html( $ct_options['ct_multi_floorplan'] ) : '';
// $ct_enable_yelp_nearby = isset( $ct_options['ct_enable_yelp_nearby'] ) ? esc_html( $ct_options['ct_enable_yelp_nearby'] ) : '';
// $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';
// $ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? $ct_options['ct_listings_login_register'] : '';
// $ct_disable_google_maps_listing = isset( $ct_options['ct_disable_google_maps_listing'] ) ? $ct_options['ct_disable_google_maps_listing'] : '';

get_header();

if (!empty($_GET['search-listings'])) {
	get_template_part('search-listings');
	return;
}

$cat = get_the_category();

do_action('before_single_listing_header');

// Header
echo '<header id="title-header"';
if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
echo '>';
echo '<div class="container">';
echo '<div class="left">';
echo '<h5 class="marT0 marB0">';
esc_html_e('Recent Videos', 'contempo');
echo '</h5>';
echo '</div>';
echo ct_breadcrumbs();
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';

// Listing Tools
if($ct_listing_tools == 'yes') { ?>

<!-- Listing Tools -->
<!-- <div id="tools">
    <ul class="social marB0">
        <li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
        <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
        <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
        <li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>
        <li class="print"><a class="print" href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
    </ul>
    <span id="tools-toggle"><a href="#"><span id="text-toggle"><?php esc_html_e('Close', 'contempo'); ?></span></a></span>
</div> -->
<!-- //Listing Tools -->

<?php }

do_action('before_single_listing_content'); ?>

<!-- Lead Carousel -->
<?php

if($ct_listing_single_layout == 'listings-two') {

    $listingslides = get_post_meta($post->ID, "_ct_slider", true);

    if(!empty($listingslides)) {
        // Grab Slider custom field images
        $imgattachments = get_post_meta($post->ID, "_ct_slider", true);
    } else {
        // Grab images attached to post via Add Media
        $imgattachments = get_children(
            array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'post_parent' => $post->ID
                ));
    }
    ?>

    <figure id="lead-carousel" <?php if(count($imgattachments) <= 1) { ?>class="single-image"<?php } ?>>
        <?php
        if(count($imgattachments) > 1) { ?>
        <div id="lrg-carousel" class="owl-carousel">
            <?php if(!empty($listingslides)) {
                ct_slider_field_images();
            } else {
                ct_slider_images();
            } ?>
        </div>
        <?php } else { ?>
        <?php ct_property_type_icon(); ?>
        <?php ct_fav_listing(); ?>
        <?php ct_first_image_lrg(); ?>
        <?php } ?>
    </figure>
    <!-- //Lead Carousel -->
    <?php } ?>

    <?php
    $referenceIDOfProperty = "";
    echo '<div class="container">';
    
    
    ?>

    <article class="col <?php if($ct_listing_single_content_layout == 'full-width') { echo 'span_12'; } else { echo 'span_12'; } ?> marB60">

        <?php 
        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        $referenceIDOfProperty = get_post_meta($post->ID, "_ct_reference", true);
        if(!is_user_logged_in() && $ct_listings_login_register == 'yes') {

            echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
            
        } else { ?>

        <!-- FPO Site name -->
        <h4 id="sitename-for-print-only">
           <?php bloginfo('name'); ?>
       </h4>
       <div class="col-sm-8">
           <?php if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        }
        ?>
    </div>   
    <?php?>
    <?php do_action('before_single_listing_location'); ?>

    <!-- Location -->
    <header class="listing-location">
        <div class="snipe-wrap">
            <?php
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if(is_plugin_active('co-authors-plus/co-authors-plus.php')) {
                if ( 2 == count( get_coauthors( get_the_id() ) ) ) { ?>
                <h6 class="snipe co-listing"><span><?php esc_html_e('Co-listing', 'contempo'); ?></span></h6>
                <?php }
            } ?>
            <?php ct_status(); ?>
            <div class="clear"></div>
        </div>
        <!-- <h2 class="marT5 marB0"><?php ct_listing_title(); ?></h2> -->
        <!-- <p class="location marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p> -->
    </header>
    <?php }?>
    
<?php endwhile; endif; ?>
<?php wp_reset_query();
wp_reset_postdata(); ?>
<?php get_template_part('videos');?>

</article>

<?php do_action('before_single_listing_sidebar'); ?>


<?php do_action('after_single_listing_sidebar'); ?>

</div>

<?php get_footer(); ?>