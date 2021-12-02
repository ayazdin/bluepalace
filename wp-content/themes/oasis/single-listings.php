<?php
/**
 * Single Listings Template
 *
 * @package Royal Oasis
 * @subpackage Template
 */
error_reporting(0);
global $ct_options;
$first_name = '';
$last_name = '';
$author_id = '';
$tagline = '';
$mobile = '';
$office = '';
$fax = '';
$email = '';
$ct_user_url = '';
$twitterhandle = '';
$facebookurl = '';
$linkedinurl = '';
$gplus = '';
$agentImage = '';

$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
$ct_listing_single_content_layout = isset( $ct_options['ct_listing_single_content_layout'] ) ? esc_html( $ct_options['ct_listing_single_content_layout'] ) : '';
$ct_listing_tools = isset( $ct_options['ct_listing_tools'] ) ? esc_html( $ct_options['ct_listing_tools'] ) : '';
$ct_listing_propinfo = isset( $ct_options['ct_listing_propinfo'] ) ? esc_html( $ct_options['ct_listing_propinfo'] ) : '';
$ct_listing_agent_info = isset( $ct_options['ct_listing_agent_info'] ) ? esc_html( $ct_options['ct_listing_agent_info'] ) : '';
$ct_listing_section_nav = isset( $ct_options['ct_listing_section_nav'] ) ? esc_html( $ct_options['ct_listing_section_nav'] ) : '';
$ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
$ct_multi_floorplan = isset( $ct_options['ct_multi_floorplan'] ) ? esc_html( $ct_options['ct_multi_floorplan'] ) : '';
$ct_enable_yelp_nearby = isset( $ct_options['ct_enable_yelp_nearby'] ) ? esc_html( $ct_options['ct_enable_yelp_nearby'] ) : '';
$ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';
$ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? $ct_options['ct_listings_login_register'] : '';
$ct_disable_google_maps_listing = isset( $ct_options['ct_disable_google_maps_listing'] ) ? $ct_options['ct_disable_google_maps_listing'] : '';
$ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : '';
get_header();

$cat = get_the_category();

do_action('before_single_listing_header');
?>
    <!-- Page Content-->
    <main class="page-content single-listing">
        <section class="bg-gray-lighter">
            <div class="shell text-left">
                <?php echo ct_breadcrumbs();?>

            </div>
        </section>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


        <section class="section-top-70 section-bottom-80">
            <div class="shell text-md-left">
                <div class="range">
                    <div class="cell-md-8">
                        <h2><?php ct_listing_title(); ?></h2>
                        <div class="offset-top-40">
                            <?php
                            $listingslides = get_post_meta($post->ID, "_ct_slider", true);
                            if(!empty($listingslides)){?>
                            <!-- Slick Carousel-->
                            <div data-arrows="true" data-loop="false" data-dots="false" data-swipe="true" data-items="1" data-child="#child-carousel" data-for="#child-carousel" class="slick-slider carousel-parent">
                                <?php
                                    foreach($listingslides as $key=>$slider){?>
                                        <div class="item"><img src="<?php echo $slider?>" alt="" width="886" height="670" class="img-responsive"></div>
                                    <?php }
                                ?>

                            </div>
                            <div id="child-carousel" data-for=".carousel-parent" data-arrows="false" data-loop="false" data-dots="false" data-swipe="true" data-items="3" data-xs-items="3" data-sm-items="4" data-md-items="5" data-lg-items="6" data-slide-to-scroll="1" class="slick-slider slick-child">
                                <?php
                                foreach($listingslides as $key=>$thumbslider){?>
                                    <div class="item"><img src="<?php echo $thumbslider?>" alt="" width="140" height="105"></div>
                                <?php }
                                ?>
                            </div>
                           <?php  }
                            elseif(empty($listingslides) && has_post_thumbnail())
                            {?>
                                <div class="singleListImg">
                                    <img src="<?php echo get_the_post_thumbnail_url($post->ID) ?>" alt="">
                                </div>

                            <?php }
                            else{}
                            ?>
                            <!-- Slick Carousel-->
                            
                        </div>
                        <?php do_action('before_single_listing_content'); ?>
                        <h3 class="offset-top-40">Price:<span class="text-base"> <?php ct_listing_price(); ?></span></h3>
                        <hr>
                        <h3 class="offset-top-40">Property Description</h3>
                        <ul class="propinfo marB0">
                        <?php ct_propinfo(); ?>
                            </ul>
                        <hr>

                        <h3>Quick Summary</h3>
                        <?php the_content(); ?>
                        <hr>

                    </div>
                    <div class="cell-md-4">
                        <div class="range range-xs-center">
                            <div class="cell-md-12 cell-sm-10">
                                <div class="well well-rudo">
                                    <?php get_template_part('/includes/advanced-search');?>
                                </div>
                            </div>
                            <?php $terms = $terms = get_the_terms( $post->id, 'community' );
                            if($terms){?>
                                <div class="cell-md-12 cell-sm-10 offset-top-40">
                                    <hr>
                                    <h3>Last Properties</h3>
                                    <?php get_template_part('includes/sub-listings'); ?>
                                </div>
                            <?php }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php endwhile; endif;?>

    </main>
<?php
get_footer(); ?>