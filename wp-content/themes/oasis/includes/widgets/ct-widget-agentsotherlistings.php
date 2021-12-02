<?php
/**
 * Agents Other Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_AgentsOtherListings extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => 'Display your agents other listings, can only be used in the Listing Single sidebar as it relies on listing information to function properly.' );
		parent::__construct(false, __('CT Agents Other Listings', 'contempo'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		$taxonomy = $instance['taxonomy'];
		$tag = $instance['tag'];
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . esc_html($title) . $after_title; }
		echo '<ul>';

		global $ct_options;
		$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

		global $post;
		$author = get_the_author_meta('ID');
		$args = array(
            'post_type' => 'listings', 
            'order' => 'DSC',
			$taxonomy => $tag,
			'author' => $author,
			'post__not_in' => array( $post->ID ),
            'posts_per_page' => $number,
            'tax_query' => array(
            	array(
				    'taxonomy'  => 'ct_status',
				    'field'     => 'slug',
				    'terms'     => 'ghost', // exclude media posts in the news-cat custom taxonomy
				    'operator'  => 'NOT IN'
			    ),
            )
		);

		$wp_query = new wp_query( $args ); 
            
        if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
        
            <li class="listing <?php echo $ct_search_results_listing_style; ?>">
				<?php if(has_post_thumbnail()) { ?>
	           	<figure>
		            <?php
		            	$status_tags = strip_tags( get_the_term_list( $wp_query->post->ID, 'ct_status', '', ' ', '' ) );
		            	if($status_tags != ''){
							echo '<h6 class="snipe ';
									$status_terms = get_the_terms( $wp_query->post->ID, 'ct_status', array() );
									if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ){
									    foreach ( $status_terms as $term ) {
									    	echo esc_html($term->slug) . ' ';
									    }
									}
								echo '">';
								echo '<span>';
									echo esc_html($status_tags);
								echo '</span>';
							echo '</h6>';
						}
					?>
		            <?php ct_property_type_icon(); ?>
	                <?php ct_fav_listing(); ?>
		            <?php ct_first_image_linked(); ?>
		        </figure>
		        <?php } ?>
		        <div class="grid-listing-info">
		            <header>
		                <h5 class="marT0 marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
		                <?php
			                $city = strip_tags( get_the_term_list( $wp_query->post->ID, 'city', '', ', ', '' ) );
							$state = strip_tags( get_the_term_list( $wp_query->post->ID, 'state', '', ', ', '' ) );
							$zipcode = strip_tags( get_the_term_list( $wp_query->post->ID, 'zipcode', '', ', ', '' ) );
							$country = strip_tags( get_the_term_list( $wp_query->post->ID, 'country', '', ', ', '' ) );
						?>
		                <p class="location marB0"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
		            </header>
		            <p class="price marB0"><?php ct_listing_price(); ?></p>
		            <div class="propinfo">
		                <ul class="marB0">
							<?php
							global $ct_options;

							$ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';

							$beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
						    $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

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
							    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
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

							    if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
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
						    
						    if(get_post_meta($post->ID, "_ct_lotsize", true)) {
						        if(get_post_meta($post->ID, "_ct_sqft", true)) {
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
						    }
							?>
	                    </ul>
                    </div>
                    <?php ct_brokered_by(); ?>
		        </div>
            </li>

        <?php endwhile; endif; wp_reset_postdata(); ?>
		
		<?php echo '</ul>'; ?>
		
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
	   
		$taxonomies = array (
			'property_type' => 'property_type',
			'beds' => 'beds',
			'baths' => 'baths',
			'status' => 'status',
			'city' => 'city',
			'state' => 'state',
			'zipcode' => 'zipcode',
			'additional_features' => 'additional_features'
		);
		
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
		$taxonomy = isset( $instance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : '';
		$tag = isset( $instance['tag'] ) ? esc_attr( $instance['tag'] ) : '';
		
		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Number:','contempo'); ?></label>
            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php esc_html_e('Taxonomy:','contempo'); ?></label>
            <select name="<?php echo $this->get_field_name('taxonomy'); ?>" class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>">
                <?php
				foreach ($taxonomies as $tax => $value) { ?>
                <option value="<?php echo $tax; ?>" <?php if($taxonomy == $tax){ echo "selected='selected'";} ?>><?php echo $tax; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
		   <label for="<?php echo $this->get_field_id('tag'); ?>"><?php esc_html_e('Tag:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('tag'); ?>"  value="<?php echo $tag; ?>" class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" />
		</p>
		<?php
	}
} 

register_widget('ct_AgentsOtherListings');
?>