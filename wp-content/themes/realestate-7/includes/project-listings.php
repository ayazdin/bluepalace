<?php
/**
 * Project Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

//global $ct_options;
global $post;

//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/*if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
	$lang =  ICL_LANGUAGE_CODE;
}
 
$ct_home_featured_num = isset( $ct_options['ct_home_featured_num'] ) ? $ct_options['ct_home_featured_num'] : '';
$ct_home_featured_title = isset( $ct_options['ct_home_featured_title'] ) ? $ct_options['ct_home_featured_title'] : '';
$ct_home_featured_btn = isset( $ct_options['ct_home_featured_btn'] ) ? $ct_options['ct_home_featured_btn'] : '';
$ct_home_featured_order = isset( $ct_options['ct_home_featured_order'] ) ? $ct_options['ct_home_featured_order'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';*/
?>
<style>
    .masthead .right a {
        color: #fff
    }
    .descProject{
        bottom:50px;
        color: white;
        font-size: 16px;
        line-height: 20px;
        left:0;
        padding:0 20px 0 4%;
        position:absolute;
        right:0;
        text-transform: uppercase;
        z-index:1;
    }

</style>
<header class="masthead">
    <h4 class="left marT0 marB0">Latest Projects</h4>
    <!-- <div class="right"><a href="<?php echo get_site_url() . '/projects' ?>">View More</a></div> -->
    <div class="clear"></div>
</header>
<div class="list">
    <?php
    $args = array(
        'post_type' => 'projects',
        //'posts_per_page' => '4'
    );
    $wp_query = new wp_query($args);
     ?>

    <div class="flexslider">
        <ul class="slides">
            <?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
            $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
            ?>
                <?php
                $location = get_post_meta($post->ID, 'contact_post_location_class', true);
                $developer = get_post_meta($post->ID, 'contact_post_developer_class', true);
                $rooms = get_post_meta($post->ID, 'contact_post_room_class', true);
                $price = get_post_meta($post->ID, 'contact_post_pricefrom_class', true);
                ?>
                <li data-thumb="<?php the_permalink($post->ID)?>">
                    <div class="descProject">

                        <ul class="blackbg">
                            <li><h4><?php ct_listing_title(); ?></h4></li>
                            <?php
                            if (!empty($location)) echo "<li> Location:" . $location . "</li>";
                            echo "<li> Developer:" . $developer . "</li>";

                            if (!empty($rooms)) echo "<li>" . $rooms . "</li>";
                            //if(!empty($price)) echo "Price from $price";
                            ?>
                            <li class=""><a class="btn" href="<?php the_permalink($post->ID)?>">View More...</a></li>
                        </ul>

                    </div>
                    <img src="<?php echo $thumbnail_src[0]?>" title="<?php ct_listing_title(); ?>" />
                </li>
            <?php  endwhile; endif;
            wp_reset_postdata();
            ?>

        </ul>
    </div>
</div>
