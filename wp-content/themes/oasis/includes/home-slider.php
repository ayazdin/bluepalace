<?php
global $post;

?>
<div class="cell-lg-12 cell-md-12">
    <!-- Owl Carousel-->
    <div data-items="1" data-dots="true" data-margin="30" data-mouse-drag="false" class="context-dark owl-slider owl-carousel">
        <?php
        $args = array(
            'post_type' => 'projects',
            'posts_per_page' => '4'
        );
        $wp_query = new wp_query($args);
        if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();

            $thumbnail_src = get_the_post_thumbnail_url($post->ID);
            ?>
            <div class="owl-item">
                <div class="slidertitle">
                    <h3><?php ct_listing_title(); ?></h3>
                    <div class="readmore">
                        <a href="<?php the_permalink($post->ID)?>" class="btn btn-primary-variant-1">Read More</a>
                    </div>
                </div>
                <img src="<?php echo $thumbnail_src?>" alt="<?php ct_listing_title(); ?>">
            </div>

        <?php
        endwhile;
        endif;
        wp_reset_postdata();
        ?>

    </div>
</div>
