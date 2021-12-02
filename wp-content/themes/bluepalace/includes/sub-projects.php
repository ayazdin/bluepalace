<?php
/**
 * Related sub listings dependant on tagged community for single-listings.php
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

wp_reset_postdata();

?>

<ul>
    <?php
    global $post;

    $terms = strip_tags( get_the_term_list( $wp_query->post->ID, 'community', '', ', ', '' ) );

	$args = array(
	'post_type' => 'projects',
	'post__not_in' => array($post->ID),
	'showposts'=> 3,
	'tax_query' => array(
		array(
			'taxonomy' => 'community',
			'field'    => 'slug',
			'terms'    => $terms,
		),
	)
);
$query = new WP_Query( $args );

	if( $query->have_posts() ) {

	$count = 0; while ($query->have_posts()) : $query->the_post(); ?>
            
        <li class="project col span_4 <?php echo $ct_search_results_listing_style; ?> <?php if($count % 3 == 0) { echo 'first'; } ?>">

        		<?php if(has_post_thumbnail()) { ?>
	            <figure>
	                <?php //ct_status(); ?>
	                <?php ct_first_image_linked(); ?>
	            </figure>
	            <?php } ?>
	            <div class="grid-listing-info">
		            <header>
		                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
		                <?php
			            	$city = strip_tags( get_the_term_list( $query->post->ID, 'city', '', ', ', '' ) );
							$state = strip_tags( get_the_term_list( $query->post->ID, 'state', '', ', ', '' ) );
							$zipcode = strip_tags( get_the_term_list( $query->post->ID, 'zipcode', '', ', ', '' ) );
							$country = strip_tags( get_the_term_list( $query->post->ID, 'country', '', ', ', '' ) );
						?>
		                <p class="location marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
	                </header>
					<?php
					$price_meta = get_post_meta($query->post->ID, '_ct_price', true);
					if(!empty($price_meta)){
					?>
	                <p class="price marB0"><?php ct_listing_price(); ?></p>
					<?php }?>
		            <div class="propinfo">
		                <ul class="marB0 marL0">
							<?php
							global $ct_options;

							$ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';

							$beds = strip_tags( get_the_term_list( $query->post->ID, 'beds', '', ', ', '' ) );
						    $baths = strip_tags( get_the_term_list( $query->post->ID, 'baths', '', ', ', '' ) );

						    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
						    $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

						    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) { 
						        // Dont Display Bed/Bath
						    } else {
						    	if(!empty($beds)) {
							    	echo '<li class="row beds">';
							    		echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Bed', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-bed"></i>';
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo $beds;
							            echo '</span>';
							        echo '</li>';
							    }else{
							    	echo '<li class="row beds">';
							    		echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Bed', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-bed"></i>';
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo 'N/A';
							            echo '</span>';
							        echo '</li>';
							    }
							    if(!empty($baths)) {
							        echo '<li class="row baths">';
							            echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Baths', 'contempo');
								    		} else {
								    			ct_bath_icon();
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo $baths;
							            echo '</span>';
							        echo '</li>';
							    }else{
							    	echo '<li class="row baths">';
							            echo '<span class="muted left">';
							    			if($ct_use_propinfo_icons != 'icons') {
								    			_e('Baths', 'contempo');
								    		} else {
								    			ct_bath_icon();
								    		}
							    		echo '</span>';
							    		echo '<span class="right">';
							               echo 'N/A';
							            echo '</span>';
							        echo '</li>';
							    }
						    }

						    include_once ABSPATH . 'wp-admin/includes/plugin.php';
							if($ct_listing_reviews == 'yes' || is_plugin_active('comments-ratings/comments-ratings.php')) {
								global $pixreviews_plugin;
								$ct_rating_avg = $pixreviews_plugin->get_average_rating();
								if($ct_rating_avg != '') {
									echo '<li class="row rating">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Rating', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-star"></i>';
								    		}
							            echo '</span>';
							            echo '<span class="right">';
							                 echo $pixreviews_plugin->get_average_rating();
							            echo '</span>';
							        echo '</li>';
							    }
							}

						    include_once ABSPATH . 'wp-admin/includes/plugin.php';
							if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {
							    if((get_post_meta($post->ID, "_ct_rental_guests", true))) {
							        echo '<li class="row guests">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Guests', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-group"></i>';
								    		}
							            echo '</span>';
							            echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_rental_guests", true);
							            echo '</span>';
							        echo '</li>';
							    }

							    if((get_post_meta($post->ID, "_ct_rental_min_stay", true))) {
							        echo '<li class="row min-stay">';
							            echo '<span class="muted left">';
							                if($ct_use_propinfo_icons != 'icons') {
								    			_e('Min Stay', 'contempo');
								    		} else {
								    			echo '<i class="fa fa-calendar"></i>';
								    		}
							            echo '</span>';
							            echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_rental_min_stay", true);
							            echo '</span>';
							        echo '</li>';
							    }
							}
						    
						    if(get_post_meta($post->ID, "_ct_sqft", true)) {
						    	if($ct_use_propinfo_icons != 'icons') {
							        echo '<li class="row sqft">';
							            echo '<span class="muted left">';
							    			ct_sqftsqm();
							    		echo '</span>';
							    		echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_sqft", true);
							            echo '</span>';
							        echo '</li>';
							    } else {
							    	echo '<li class="row sqft">';
							            echo '<span class="muted left">';
											ct_listing_size_icon();
							    		echo '</span>';
							    		echo '<span class="right">';
							                 echo get_post_meta($post->ID, "_ct_sqft", true);
							                 echo ' ' . ct_sqftsqm();
							            echo '</span>';
							        echo '</li>';
							    }
						    }
						    
						    if((get_post_meta($post->ID, "_ct_lotsize", true))) {
						        if((get_post_meta($post->ID, "_ct_sqft", true))) {
						            echo '<li class="row lotsize">';
						        }
						            echo '<span class="muted left">';
						    			if($ct_use_propinfo_icons != 'icons') {
							    			_e('Lot Size', 'contempo');
							    		} else {
							    			echo '<i class="fa fa-arrows-alt"></i>';
							    		}
						    		echo '</span>';
						    		echo '<span class="right">';
						                 echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
						                 ct_acres();
						            echo '</span>';
						            
						        if((get_post_meta($post->ID, "_ct_sqft", true))) {
						            echo '</li>';
						        }
						    } ?>
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
		
		endwhile; wp_reset_postdata();
	} ?>
</ul>
    <div class="clear"></div>