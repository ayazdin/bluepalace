<?php
/**
 * Post Meta
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
$tags = get_the_tags();
 
 ?>

<div class="post-meta">
    <small class="marB0"><span class="meta-user"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span> <span class="meta-cat"><i class="fa fa-briefcase"></i> <?php $cat = get_the_category(); $cat = $cat[0]; ?><a href="<?php echo home_url(); ?>/?cat=<?php echo esc_html($cat->cat_ID); ?>"><?php echo sc_html($cat->cat_name); ?></a></span> <span class="meta-comments"><i class="fa fa-comment"></i> <a href="<?php comments_link(); ?>"><?php comments_number('0 Comments','1 Comment','% Comments'); ?></a></span> <?php if(empty($tags)) { /* display nothing */ } else { ?><span class="meta-tags"><i class="fa fa-tag"></i> <?php the_tags(); ?></span><?php } ?></small>
</div>