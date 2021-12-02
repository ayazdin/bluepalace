<?php
/**
 * Featured Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;
global $post;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
	$lang =  ICL_LANGUAGE_CODE;
}
 
$ct_home_featured_num = isset( $ct_options['ct_home_featured_num'] ) ? $ct_options['ct_home_featured_num'] : '';
$ct_home_featured_title = isset( $ct_options['ct_home_featured_title'] ) ? $ct_options['ct_home_featured_title'] : '';
$ct_home_featured_btn = isset( $ct_options['ct_home_featured_btn'] ) ? $ct_options['ct_home_featured_btn'] : '';
$ct_home_featured_order = isset( $ct_options['ct_home_featured_order'] ) ? $ct_options['ct_home_featured_order'] : '';
$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';
?>

<header class="masthead">
	<?php if(!empty($ct_home_featured_title)) { ?>
		<h4 class="marT0 marB0">
			<?php //echo esc_html($ct_home_featured_title); ?>
			Latest for Rent
		</h4>
	<?php } ?>
	<?php /*if($ct_home_featured_btn == 'yes') { ?>
		<?php if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) { ?>
				<a class="view-all right" href="<?php echo home_url(); ?>?ct_ct_status=<?php echo strtolower(ct_get_taxo_translated()); ?>&search-listings=true<?php if($lang) { echo '&lang=' . $lang; } ?>"><?php esc_html_e('View All','contempo'); ?><i class="fa fa-angle-right"></i></a>
			<?php } else { ?>
				<a class="view-all right" href="<?php echo home_url(); ?>?ct_ct_status=featured&search-listings=true<?php if($lang) { echo '&lang=' . $lang; } ?>"><?php esc_html_e('View All','contempo'); ?><i class="fa fa-angle-right"></i></a>
		<?php } ?>
	<?php }*/ ?>
		<div class="clear"></div>
</header>
<ul>
    <?php

		    	$args = array(
					'ct_status'			=> __('active'),
					'meta_query' => array(
						array('key' => '_ct_purpose',
							'value' => 'Rent'
						),
						array(
							'key' => '_ct_featured',
							'value' => '1',
						)
					),
		            'post_type'			=> 'listings',
		            'posts_per_page'	=> $ct_home_featured_num,
					'orderby'     => 'modified',
					'order'       => 'DESC',
		        );


        $wp_query = new wp_query( $args ); 
        
        $count = 0; if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
        $referenceIDOfProperty = get_post_meta($post->ID, "_ct_reference", true);
        ?>
            
        <li class="listing col span_4 <?php echo $ct_search_results_listing_style; ?> <?php if($count % 3 == 0) { echo 'first'; } ?>">
        

        		<?php if(has_post_thumbnail()) { ?>
	            <figure>
	                <?php //ct_status(); ?>
	                <?php //ct_property_type_icon(); ?>
	                <?php ct_fav_listing(); ?>
	                <!--<a <?php /*ct_listing_permalink(); */?>><?php /*ct_first_image_linked(); */?></a>-->
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
						if(!empty($sliderArr)){
							echo '<img class="attachment-large size-large wp-post-image" src="'.$sliderArr[0].'" alt="">';
						}
						else{

							echo '<img class="attachment-large size-large wp-post-image" src="'.get_template_directory_uri().'/images/No_image_available.png'.'" alt="">';
						}
		                ?>
		                </a>
		                <?php //ct_first_image_linked(); ?>
	            	</figure>
	            <?php } ?>

	            <div class="grid-listing-info">
		            <header>
		                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
		                <p class="location muted marB0"><?php //city(); ?><?php state(); ?> <?php zipcode(); ?></p>
	                </header>
	                <p class="price marB0"><span class="left"><?php ct_listing_price(); ?></span><span class="right">REF#: <?=$referenceIDOfProperty?></span></p>
	                <!--<p class="price marB0"><span class="left"><?php /*ct_listing_price(); */?></span><span class="right"><?php /*ct_status();*/?></span></p>-->
		            <div class="propinfo">
		            	<p><?php //echo ct_excerpt(); ?></p>
		                <ul class="marB0">
							<?php ct_propinfo(); ?>
	                    </ul>
                    </div>
                    <?php ct_brokered_by(); ?>
	            </div>
	
        </li>
        
        <?php
		
		$count++;
		
		if($count % 3 == 0) {
			echo '<div class="clear"></div>';
		}
		
		endwhile;
	else:
		echo '<p>No Properties available</p>';
	endif; wp_reset_postdata(); ?>
</ul>
    <div class="clear"></div>