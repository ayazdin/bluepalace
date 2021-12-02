<?php
/**
 * Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_Search extends WP_Widget {

   function __construct() {
	   $widget_ops = array('description' => 'This is a search widget.' );
       parent::__construct(false, __('CT Search', 'contempo'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = $instance['title'];

      echo $before_widget;
			if ($title) {
				echo $before_title . $title . $after_title;
			}
      echo '<div class="widget-inner">';
  			get_template_part('searchform');
      echo '</div>';
		echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','contempo'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
      <?php
   }
} 

register_widget('ct_Search');
?>