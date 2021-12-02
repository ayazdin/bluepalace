<?php
/**
 * Flickr
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */
 
class ct_flickr extends WP_Widget {

	function __construct() {
		$widget_ops = array('description' => 'This Flickr widget populates photos from a Flickr ID.' );
		parent::__construct(false, __('CT Flickr', 'contempo'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];
		$size = $instance['size'];
		
		echo $before_widget;
		echo $before_title; ?>
		<?php esc_html_e('Photos on flickr','contempo'); ?>
        <?php echo $after_title; ?>
        <div class="widget-inner">
            
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_html($number); ?>&amp;display=<?php echo esc_html($sorting); ?>&amp;&amp;layout=x&amp;source=<?php echo esc_html($type); ?>&amp;<?php echo esc_html($type); ?>=<?php echo esc_html($id); ?>&amp;size=<?php echo esc_html($size); ?>"></script>        
        
        </div>
	   <?php			
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {

		$id = isset( $instance['id'] ) ? esc_attr( $instance['id'] ) : '';
		$number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : ''; 
		$type = isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : ''; 
		$sorting = isset( $instance['sorting'] ) ? esc_attr( $instance['sorting'] ) : ''; 
		$size = isset( $instance['size'] ) ? esc_attr( $instance['size'] ) : '';  
	   
		?>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php esc_html_e('Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):','contempo'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
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
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php esc_html_e('Type:','contempo'); ?></label>
            <select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
                <option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php esc_html_e('User', 'contempo'); ?></option>
                <option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php esc_html_e('Group', 'contempo'); ?></option>            
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sorting'); ?>"><?php esc_html_e('Sorting:','contempo'); ?></label>
            <select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
                <option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php esc_html_e('Latest', 'contempo'); ?></option>
                <option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php esc_html_e('Random', 'contempo'); ?></option>            
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php esc_html_e('Size:','contempo'); ?></label>
            <select name="<?php echo $this->get_field_name('size'); ?>" class="widefat" id="<?php echo $this->get_field_id('size'); ?>">
                <option value="s" <?php if($size == "s"){ echo "selected='selected'";} ?>><?php esc_html_e('Square', 'contempo'); ?></option>
                <option value="m" <?php if($size == "m"){ echo "selected='selected'";} ?>><?php esc_html_e('Medium', 'contempo'); ?></option>
                <option value="t" <?php if($size == "t"){ echo "selected='selected'";} ?>><?php esc_html_e('Thumbnail', 'contempo'); ?></option>
            </select>
        </p>
		<?php
	}
} 

register_widget('ct_flickr');
?>