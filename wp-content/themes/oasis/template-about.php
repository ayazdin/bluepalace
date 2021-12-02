<?php
/**
 * Template Name: About Us
 *
 * @package Royal Oasis
 * @subpackage Template
 */
get_header();
$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);
?>
    <!-- Page Content-->
    <main class="page-content">
        <section class="bg-gray-lighter">
            <div class="shell text-left">
                <?php echo ct_breadcrumbs();?>
            </div>
        </section>
        <section class="section-top-70 section-bottom-80">
            <div class="shell text-md-left">
            <?php
                while(have_posts()) : the_post();
                    if($inside_page_title == "Yes") {?>
                        <h3><?php the_title();?></h3>
                    <?php }

                    if(has_post_thumbnail()){?>
                        <div class="offset-top-40"><img src="<?php echo get_the_post_thumbnail_url($post->ID) ?>" width="1354" height="795" alt="" class="img-responsive center-block"></div>
                    <?php }?>
                    <div class="range offset-top-40">
                        <div class="cell-md-12">
                            <?php the_content(); ?>
                        </div>

                    </div>
                <?php endwhile;
            ?>
            </div>
        </section>
    </main>
<?php
get_footer();?>