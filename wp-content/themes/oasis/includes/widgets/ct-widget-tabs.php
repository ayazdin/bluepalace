<?php
/**
 * Tabs
 *
 * @package WP Pro Real Estate 7
 * @subpackage Widget
 */

class ct_Tabs extends WP_Widget {

   function __construct() {
       $widget_ops = array( 'description' => 'It contains the Latest Posts, Recent comments and a Tag cloud.' );
       parent::__construct(false, $name = __( 'CT Tabs', 'contempo' ), $widget_ops);
   }


   function widget($args, $instance) {
       extract( $args );

       $number = @$instance['number']; if ($number == '') $number = 5;
       $order = @$instance['order']; if ($order == '') $order = "latest";
       $latest = @$instance['latest'];
       $comments = @$instance['comments'];
       $tags = @$instance['tags'];
       $pop = isset( $pop ) ? esc_attr( $pop ) : '';
       ?>

    <?php echo $before_widget; ?>

            <ul class="tabs">
                <?php if ( $order == "latest" && !$latest == "on") { ?><li class="latest"><a href="#tab-latest"><i class="fa fa-clock-o"></i></a></li>
                <?php } elseif ( $order == "comments" && !$comments == "on") { ?><li class="comments"><a href="#tab-comm"><i class="fa fa-comment"></i></a></li>
                <?php } elseif ( $order == "tags" && !$tags == "on") { ?><li class="tags"><a href="#tab-tags"><i class="fa fa-tag"></i></a></li>
                <?php } ?>
                <?php if ($order <> "latest" && !$latest == "on") { ?><li class="latest"><a href="#tab-latest"><i class="fa fa-clock-o"></i></a></li><?php } ?>
                <?php if ($order <> "comments" && !$comments == "on") { ?><li class="comments"><a href="#tab-comm"><i class="fa fa-comment"></i></a></li><?php } ?>
                <?php if ($order <> "tags" && !$tags == "on") { ?><li class="tags"><a href="#tab-tags"><i class="fa fa-tag"></i></a></li><?php } ?>
            </ul>
            
              <div class="clear"></div>

            <div class="inside">

              <?php if ( $order == "latest" && !$latest == "on") { ?>
                <ul id="tab-latest" class="list">
                    <?php if ( function_exists( 'ct_widget_tabs_latest') ) ct_widget_tabs_latest($number); ?>
                </ul>
              <?php } elseif ( $order == "comments" && !$comments == "on") { ?>
              <ul id="tab-comm" class="list">
                    <?php if ( function_exists( 'ct_widget_tabs_comments') ) ct_widget_tabs_comments($number); ?>
              </ul>
              <?php } elseif ( $order == "tags" && !$tags == "on") { ?>
                <div id="tab-tags" class="list">
                  <div class="pad10">
                    <?php wp_tag_cloud( 'smallest=12&largest=20' ); ?>
                  </div>
                </div>
                <?php } ?>

                <?php if (!$pop == "on") { ?>
                <ul id="tab-pop" class="list">
                    <?php if ( function_exists( 'ct_widget_tabs_popular') ) ct_widget_tabs_popular($number); ?>
                </ul>
                <?php } ?>
                <?php if ($order <> "latest" && !$latest == "on") { ?>
                <ul id="tab-latest" class="list">
                    <?php if ( function_exists( 'ct_widget_tabs_latest') ) ct_widget_tabs_latest($number); ?>
                </ul>
                <?php } ?>
                <?php if ($order <> "comments" && !$comments == "on") { ?>
                <ul id="tab-comm" class="list">
                    <?php if ( function_exists( 'ct_widget_tabs_comments') ) ct_widget_tabs_comments($number); ?>
                </ul>
                <?php } ?>
                <?php if ($order <> "tags" && !$tags == "on") { ?>
                <div id="tab-tags" class="list">
                  <div class="pad10">
                    <?php wp_tag_cloud( 'smallest=12&largest=20' ); ?>
                  </div>
                </div>
                <?php } ?>

            </div>

        <?php echo $after_widget; ?>
         <?php
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
     
     $number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
     $order = isset( $instance['order'] ) ? esc_attr( $instance['order'] ) : '';
     $latest = isset( $instance['latest'] ) ? esc_attr( $instance['latest'] ) : '';
     $comments = isset( $instance['comments'] ) ? esc_attr( $instance['comments'] ) : '';
     $tags = isset( $instance['tags'] ) ? esc_attr( $instance['tags'] ) : '';

       ?>
       <p>
         <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts:', 'contempo' ); ?>
         <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
         </label>
       </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'First Visible Tab:', 'contempo' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>">
                <option value="latest" <?php if($order == "latest"){ echo "selected='selected'";} ?>><?php _e( 'Latest', 'contempo' ); ?></option>
                <option value="comments" <?php if($order == "comments"){ echo "selected='selected'";} ?>><?php _e( 'Comments', 'contempo' ); ?></option>
                <option value="tags" <?php if($order == "tags"){ echo "selected='selected'";} ?>><?php _e( 'Tags', 'contempo' ); ?></option>
            </select>
        </p>
       <p><strong>Hide Tabs:</strong></p>
     <p>
         <input id="<?php echo $this->get_field_id( 'latest' ); ?>" name="<?php echo $this->get_field_name( 'latest' ); ?>" type="checkbox" <?php if($latest == 'on') echo 'checked="checked"'; ?>><?php _e( 'Latest', 'contempo' ); ?></input>
     </p>
     <p>
         <input id="<?php echo $this->get_field_id( 'comments' ); ?>" name="<?php echo $this->get_field_name( 'comments' ); ?>" type="checkbox" <?php if($comments == 'on') echo 'checked="checked"'; ?>><?php _e( 'Comments', 'contempo' ); ?></input>
     </p>
     <p>
         <input id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" type="checkbox" <?php if($tags == 'on') echo 'checked="checked"'; ?>><?php _e( 'Tags', 'contempo' ); ?></input>
       </p>
       <?php
   }

}
register_widget( 'ct_Tabs' );


/*-----------------------------------------------------------------------------------*/
/* ctTabs - Javascript */
/*-----------------------------------------------------------------------------------*/

// Add Javascript
add_action( 'wp_footer','ct_widget_tabs_js' );

function ct_widget_tabs_js(){
?>
<script>
  jQuery(document).ready(function(){

    var tag_cloud_class = '#tagcloud';
    var tag_cloud_height = jQuery( '#tagcloud').height();
    jQuery( '.tabs').each(function(){
      jQuery(this).children( 'li').children( 'a:first').addClass( 'selected' );
    });
    jQuery( '.inside > *').hide();
    jQuery( '.inside > *:first-child').show();

    jQuery( '.tabs li a').click(function(evt){

      var clicked_tab_ref = jQuery(this).attr( 'href' );

      jQuery(this).parent().parent().children( 'li').children( 'a').removeClass( 'selected' )
      jQuery(this).addClass( 'selected' );
      jQuery(this).parent().parent().parent().children( '.inside').children( '*').hide();

      jQuery( '.inside ' + clicked_tab_ref).fadeIn(500);

       evt.preventDefault();
    })
  })
</script>
<?php
}

/*-----------------------------------------------------------------------------------*/
/* ctTabs - Latest Posts */
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'ct_widget_tabs_latest')) {
  function ct_widget_tabs_latest( $posts = 5, $size = 45 ) {
    global $post;
    $latest = get_posts( 'ignore_sticky_posts=1&numberposts='. $posts .'&orderby=post_date&order=desc' );
    foreach($latest as $post) :
      setup_postdata($post);
  ?>
  <li>
      <div class="pad10">
          <?php if(has_post_thumbnail()) { ?>
            <div class="col span_3">
              <?php the_post_thumbnail('thumb'); ?>
            </div>
          <?php } ?>
          <div class="col <?php if(has_post_thumbnail()) { echo 'span_9'; } else { echo 'span_12'; } ?>">
              <h5 class="marB5"><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
              <span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
          </div>
            <div class="clear"></div>
        </div>
  </li>
  <?php endforeach;
  }
}

/*-----------------------------------------------------------------------------------*/
/* ctTabs - Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists( 'ct_widget_tabs_comments')) {
  function ct_widget_tabs_comments( $posts = 5, $size = 35 ) {
    global $wpdb;

    $comments = get_comments( array( 'number' => $posts, 'status' => 'approve' ) );
    if ( $comments ) {
      foreach ( (array) $comments as $comment) {
      $post = get_post( $comment->comment_post_ID );
      ?>
        <li class="recentcomments">
          <div class="pad10">
            <span class="right"><?php echo get_avatar( $comment, '40' ); ?></span>
            <h5><a href="<?php echo get_comment_link($comment->comment_ID); ?>" title="<?php echo wp_filter_nohtml_kses($comment->comment_author); ?> <?php _e( 'on', 'contempo' ); ?> <?php echo $post->post_title; ?>"><?php echo wp_filter_nohtml_kses($comment->comment_author); ?>: <?php echo stripslashes(substr( wp_filter_nohtml_kses( $comment->comment_content ), 0, 50 )); ?>&hellip;</a></h5>
          </div>
        </li>
      <?php
      }
    }
  }
}

?>