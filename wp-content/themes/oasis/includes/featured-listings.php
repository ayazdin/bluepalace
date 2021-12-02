<?php
/*
 * Featured Listings
 *
 * @package Royal Oasis
 * @subpackage Include
 */

global $ct_options;
global $post;

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
    $lang = ICL_LANGUAGE_CODE;
}


$ct_home_featured_num = isset($ct_options['ct_home_featured_num']) ? $ct_options['ct_home_featured_num'] : '';
$ct_home_featured_title = isset($ct_options['ct_home_featured_title']) ? $ct_options['ct_home_featured_title'] : '';
$ct_home_featured_btn = isset($ct_options['ct_home_featured_btn']) ? $ct_options['ct_home_featured_btn'] : '';
$ct_home_featured_order = isset($ct_options['ct_home_featured_order']) ? $ct_options['ct_home_featured_order'] : '';
$ct_search_results_listing_style = isset($ct_options['ct_search_results_listing_style']) ? $ct_options['ct_search_results_listing_style'] : '';


if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
    if ($ct_options['ct_home_featured_order'] == 'yes') {
        $args = array(
            'ct_status' => ct_get_taxo_translated(),
            'post_type' => 'listings',
            'meta_key' => '_ct_listing_home_feat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'posts_per_page' => $ct_home_featured_num,
        );
    } else {
        $args = array(
            'ct_status' => ct_get_taxo_translated(),
            'post_type' => 'listings',
            'posts_per_page' => $ct_home_featured_num
        );
    }
} else {
    if ($ct_options['ct_home_featured_order'] == 'yes') {
        $args = array(
            //'ct_status' => __('featured', 'contempo'),
            'post_type' => 'listings',
            'meta_key' => '_ct_listing_home_feat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'posts_per_page' => $ct_home_featured_num,
        );
    } else {
        $args = array(
            //'ct_status' => __('featured', 'contempo'),
            'post_type' => 'listings',
            'posts_per_page' => $ct_home_featured_num
        );
    }
}
$wp_query = new wp_query( $args );

$count = 0; if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
$referenceIDOfProperty = get_post_meta($post->ID, "_ct_reference", true);
?>
<?php
    if($count==0){
        echo '<div class="range range-condensed text-sm-left">';
    }
    elseif($count==2)
    {
        echo '<div class="range range-condensed text-sm-left offset-top-0">';
    }?>

    <?php if($count<2)
    {
        $col = '6';
    }
    else{
        $col = '4';
    }
    if($count==0 || $count==2){
        $offset = '';
    }
    else{
        $offset = 'offset-top-0';
    }
    ?>
    <div class="cell-sm-<?php echo $col?> <?php echo $offset;?>">
        <?php //echo $count;?>
        <div class="reveal-block thumbnail-variant-1">
            <div class="caption-wrapper">

                <?php
                    if(has_post_thumbnail($post->ID)){?>
                        <img src="<?php echo get_the_post_thumbnail_url($post->ID,'large')?>"  width="960" height="567" alt="<?php ct_listing_title(); ?>"
                             class="img-responsive center-block">
                    <?php }else{?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/post-32.jpg"
                             width="960" height="567" alt="<?php ct_listing_title(); ?>"
                             class="img-responsive center-block">
                    <?php }

                ?>

                <?php
                $status_tags = get_post_meta( $post->ID, '_ct_purpose',true);
                if($status_tags!=''){                ?>
                <div class="caption">
                    <a <?php ct_listing_permalink(); ?> class="label label-primary"><?php echo $status_tags; ?></a>
                </div>
               <?php }?>
            </div>
            <div class="caption-2">
                <h3><?php ct_listing_price(); ?></h3>

                <h3 class="caption-title">
                    <a <?php ct_listing_permalink(); ?> class="text-white"><?php echo wp_trim_words( get_the_title(), 5, null ); ; ?></a></h3>
                <a <?php ct_listing_permalink(); ?> class="btn btn-primary-variant-1">read
                    more</a>
            </div>
        </div>
    </div>

   <?php if($count==1){
       echo '</div>';
    }
    elseif( $count==4)
    {
        echo '</div>';
    }

$count++;
    ?>


<?php
endwhile; endif; wp_reset_postdata();
?>
