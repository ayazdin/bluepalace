<?php
/**
 * Post Author Info
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 ?>

<div id="authorinfo" class="marT30 marB20">
	<div class="col span_2 first">
	    <a href="<?php the_author_meta('url'); ?>"><?php echo get_avatar( get_the_author_meta('email'), '80' ); ?></a>
    </div>
    <div class="col span_10">
	    <h5 class="marB10"><?php esc_html_e('By', 'contempo'); ?>: <a href="<?php the_author_meta('url'); ?>"><?php the_author(); ?></a></h5>
	    <p><?php the_author_meta('description'); ?></p>
    </div>
        <div class="clear"></div>
</div>