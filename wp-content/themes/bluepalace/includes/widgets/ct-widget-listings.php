<?php
/**
 * Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_Listings extends WP_Widget {

	function __construct() {
	   $widget_ops = array('description' => 'Display your latest listings.' );
	   parent::__construct(false, __('CT Listings', 'contempo'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$number = $instance['number'];
		$taxonomy = $instance['taxonomy'];
		$tag = $instance['tag'];
		$viewalltext = $instance['viewalltext'];
		$viewalllink = $instance['viewalllink'];
	?>
		<?php echo $before_widget; ?>
		<?php if ($title) { echo $before_title . $title . $after_title; }

		echo '<ul>';

		global $ct_options;
		$ct_search_results_listing_style = isset( $ct_options['ct_search_results_listing_style'] ) ? $ct_options['ct_search_results_listing_style'] : '';

		global $post;
		global $wp_query;

        wp_reset_postdata();
		
		$args = array(
            'post_type' => 'listings', 
            'order' => 'DSC',
			$taxonomy => $tag,
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
		            <?php ct_first_image_linked_widget(); ?>
		        </figure>
		        <?php } ?>
		        <div class="grid-listing-info">
		            <header>
		                <h5 class="marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h5>
		                <p class="location marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p>
		            </header>
		            <p class="price marB0"><?php ct_listing_price(); ?></p>
		            <ul class="propinfo marB0">
		            	<?php ct_propinfo(); ?>
		            </ul>
		            <?php ct_brokered_by(); ?>
                    <div class="clear"></div>
            </li>

        <?php endwhile; endif; wp_reset_postdata(); ?>
		
		<?php echo '</ul>'; ?>
        
           <?php if($viewalltext) { ?>
               <p id="viewall"><a class="read-more right" href="<?php echo esc_url($viewalllink); ?>"><?php echo esc_html($viewalltext); ?> <em>&rarr;</em></a></p>
           <?php } ?>
		
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
		
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
		$taxonomy = isset( $instance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : '';
		$tag = isset( $instance['tag'] ) ? esc_attr( $instance['tag'] ) : '';
		$viewalltext = isset( $instance['viewalltext'] ) ? esc_attr( $instance['viewalltext'] ) : '';
		$viewalllink = isset( $instance['viewalllink'] ) ? esc_attr( $instance['viewalllink'] ) : '';
		
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
				foreach (get_object_taxonomies( 'listings', 'objects' ) as $tax => $value) { ?>
                <option value="<?php echo $tax; ?>" <?php if($taxonomy == $tax){ echo "selected='selected'";} ?>><?php echo $tax; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
		   <label for="<?php echo $this->get_field_id('tag'); ?>"><?php esc_html_e('Tag:','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('tag'); ?>"  value="<?php echo $tag; ?>" class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('viewalltext'); ?>"><?php esc_html_e('View All Link Text','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('viewalltext'); ?>"  value="<?php echo $viewalltext; ?>" class="widefat" id="<?php echo $this->get_field_id('viewalltext'); ?>" />
		</p>
        <p>
		   <label for="<?php echo $this->get_field_id('viewalllink'); ?>"><?php esc_html_e('View All Link URL','contempo'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('viewalllink'); ?>"  value="<?php echo $viewalllink; ?>" class="widefat" id="<?php echo $this->get_field_id('viewalllink'); ?>" />
		</p>
		<?php
	}
} 

register_widget('ct_Listings');
?>