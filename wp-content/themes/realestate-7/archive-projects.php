<?php
///**
// *
// *
// * @package WP Pro Real Estate 7
// * @subpackage Template
// */
//
//get_header();
//
//do_action('before_single_listing_header');
//// Header
//echo '<header id="title-header"';
//if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
//echo '>';
//echo '<div class="container">';
//echo '<div class="left">';
//echo '<h5 class="marT0 marB0">';
//esc_html_e('Projects', 'contempo');
//echo '</h5>';
//echo '</div>';
//?>
<!--<div class="breadcrumb breadcrumbs ct-breadcrumbs right muted">-->
<!--    <div class="breadcrumb-trail">-->
<!--        <span class="trail-before"><span class="breadcrumb-title"></span></span>-->
<!--        <a id="bread-home" href="--><?//=get_site_url()?><!--" title="New Routes" rel="home" class="trail-begin">Home</a>-->
<!--        <span class="sep"><i class="fa fa-angle-right"></i></span> <span class="trail-end">Projects</span>-->
<!--    </div>-->
<!--</div>-->
<?php //get_footer(); ?>
<?php
/**
 * Archive Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;

$ct_archive_layout = isset( $ct_options['ct_archive_layout'] ) ? $ct_options['ct_archive_layout'] : '';

$cat_desc = category_description();
$ct_home_featured_num = isset( $ct_options['ct_home_featured_num'] ) ? $ct_options['ct_home_featured_num'] : '';
$ct_home_featured_title = isset( $ct_options['ct_home_featured_title'] ) ? $ct_options['ct_home_featured_title'] : '';
$ct_home_featured_btn = isset( $ct_options['ct_home_featured_btn'] ) ? $ct_options['ct_home_featured_btn'] : '';
$ct_home_featured_order = isset( $ct_options['ct_home_featured_order'] ) ? $ct_options['ct_home_featured_order'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

get_header(); ?>

<!-- Archive Header Image -->
<?php
if(!is_home() || !is_front_page()) {
    echo ct_display_category_image();
}
?>

<?php do_action('before_archive_header'); ?>

<!-- Archive Header -->
<div id="archive-header">
    <div class="dark-overlay">
        <div class="container">
            <h1 class="marT0 marB5">Projects</h1>

        </div>
    </div>
</div>
<!-- //Archive Header -->

<?php do_action('before_archive_content'); ?>

<!-- Main Content Container -->
<div class="container archive marT60 padB60">

    <!-- Posts Loop -->
    <?php
    echo '<div class="col';
    if($ct_archive_layout == 'full-width') { echo ' span_12 first'; } else { echo ' span_12'; }
    echo '">';
    ?>

    <!-- Archive Inner -->
    <div class="archive-inner">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', get_post_format() ); ?>

        <?php endwhile; ?>

            <?php ct_numeric_pagination(); ?>

        <?php else : ?>

            <p class="nomatches"><strong><?php esc_html_e( 'No posts were found which match your search criteria', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Try broadening your search to find more results.', 'contempo' ); ?></p>

        <?php endif; ?>

    </div>
    <!-- //Archive Inner -->

</div>
<!-- //Posts Loop -->

<?php do_action('before_archive_sidebar'); ?>

<?php
/*if($ct_archive_layout != 'full-width') {*/?><!--

<div id="sidebar" class="col span_3">
    <div id="sidebar-inner">
        <aside id="ct_listings-3" class="widget widget_ct_listings left">
            <ul>
                <?php
/*                if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
                    if($ct_options['ct_home_featured_order'] == 'yes') {
                        $args = array(
                            'ct_status'			=> ct_get_taxo_translated(),
                            'post_type'			=> 'listings',
                            'meta_key'			=> '_ct_listing_home_feat_order',
                            'orderby'			=> 'meta_value_num',
                            'order'				=> 'ASC',
                            'posts_per_page'	=> $ct_home_featured_num,
                        );
                    } else {
                        $args = array(
                            'ct_status'			=> ct_get_taxo_translated(),
                            'post_type'			=> 'listings',
                            'posts_per_page'	=> $ct_home_featured_num
                        );
                    }
                } else {
                    if($ct_options['ct_home_featured_order'] == 'yes') {
                        $args = array(
                            'ct_status'			=> __('featured', 'contempo'),
                            'post_type'			=> 'listings',
                            'meta_key'			=> '_ct_listing_home_feat_order',
                            'orderby'   		=> 'meta_value_num',
                            'order'     		=> 'ASC',
                            'posts_per_page'	=> $ct_home_featured_num,
                        );
                    } else {
                        $args = array(
                            'ct_status'			=> __('featured', 'contempo'),
                            'post_type'			=> 'listings',
                            'posts_per_page'	=> $ct_home_featured_num
                        );
                    }
                }

                $wp_query = new wp_query( $args );
                $count = 0; if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
                //$referenceIDOfProperty = get_post_meta($post->ID, "_ct_reference", true);

            */?>
                    <li class="listing standard">
                        <div class="grid-listing-info">
                            <?php /*if(has_post_thumbnail()) { */?>
                                <figure>
                                    <?php /*ct_status(); */?>
                                    <?php /*//ct_property_type_icon(); */?>
                                    <?php /*ct_fav_listing(); */?>
                                    <a <?php /*ct_listing_permalink(); */?>><?php /*ct_first_image_linked(); */?></a>
                                </figure>
                            <?php /*} else { */?>
                                <figure>
                                    <?php /*ct_status(); */?>
                                    <?php /*//ct_property_type_icon(); */?>
                                    <?php /*ct_fav_listing(); */?>
                                    <a <?php /*ct_listing_permalink(); */?>>
                                        <?php
/*                                        $sliderUnSerialized = get_post_meta( $post->ID, '_ct_slider', false );
                                        $sliderArr = unserialize($sliderUnSerialized[0]);
                                        echo '<img src="'.$sliderArr[0].'" alt="">';
                                        */?>
                                    </a>
                                    <?php /*ct_first_image_linked(); */?>
                                </figure>
                            <?php /*} */?>
                            <header>
                                <h5 class="marB0"><a <?php /*ct_listing_permalink(); */?>><?php /*ct_listing_title(); */?></a></h5>
                                <p class="location marB0"><?php /*state(); */?> <?php /*zipcode(); */?></p>
                            </header>
                            <p class="price marB0"><span class="listing-price"><?php /*ct_listing_price(); */?></span></p>
                            <ul class="propinfo marB0">
                                <?php /*ct_propinfo(); */?>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </li>
                    <?php
/*
                    $count++;

                    if($count % 3 == 0) {
                        echo '<div class="clear"></div>';
                    }

                endwhile; endif; wp_reset_postdata(); */?>
            </ul>
        </aside>
    </div>
</div>

--><?php /*}*/

// Clear
echo '<div class="clear"></div>';

do_action('after_archive_sidebar');

echo '</div>';
//Main Content Container

get_footer(); ?>
