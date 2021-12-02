<?php
/**
 * Testimonials
 *
 * @package WP Consultant
 * @subpackage Widget
 */
 
class ct_Testimonials extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'Display your testimonials.' );
	   parent::__construct(false, __('CT Testimonials', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
	extract( $args );
	$title = $instance['title'];
	$number = $instance['number'];
	?>
		<?php echo $before_widget; ?>
        <ul class="right">
            <li><a class="prev test" href="#"><i class="fa fa-chevron-left"></i></a></li>
            <li><a class="next test" href="#"><i class="fa fa-chevron-right"></i></a></li>
        </ul>
		<?php if ($title) { echo $before_title . $title . $after_title; }
		echo '<div class="clear"></div>';
		echo '<ul class="testimonials">';
		global $post;
		$args = array(
			'post_type' => 'testimonial',
			'posts_per_page' => $number,
		);
		$query = new WP_Query($args);
            
        if ( have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
        
            <li>
                <p class="marB10"><?php the_content(); ?>
                <h6 class="marB0"><em><?php the_title(); ?></em></h6>
            </li>

        <?php endwhile; endif; wp_reset_query(); ?>
		
		<?php echo '</ul>'; ?>
		
		<?php echo $after_widget; ?>   
    <?php
   }

   function update($new_instance, $old_instance) {                
	   return $new_instance;
   }

   function form($instance) {
   
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
		
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
		<?php
	}
} 

register_widget('ct_Testimonials');
?>