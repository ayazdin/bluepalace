<?php
/**
 * Archive Projects Template
 *
 * @package Royal Oasis
 * @subpackage Template
 */
get_header();?>

    <!-- Page Content-->
    <main class="page-content archive-listing">
        <section class="bg-gray-lighter">
            <div class="shell text-left">
                <ol class="breadcrumb">
                    <li><a href="<?php echo home_url();?>">Home</a></li>
                    <li class="active">Projects
                    </li>
                </ol>
            </div>
        </section>
        <section class="section-top-70 section-bottom-80">
            <div class="shell">
                <h3>Projects</h3>

            </div>
            <div class="row offset-top-40">
                <!-- Isotope Filters-->

                <!-- Isotope Content-->
                <div class="col-lg-12 offset-top-30">
                    <?php
                        if(have_posts()):?>
                    <div data-isotope-layout="fitRows" data-isotope-group="gallery" class="isotope">
                        <div class="row row-no-gutter">
                            <?php
                            while(have_posts()):the_post();?>
                                <div  class="col-xs-12 col-sm-6 col-lg-4 isotope-item">
                                    <!-- Thumbnail-->
                                    <div class="thumbnail">
                                        <?php
                                            if(has_post_thumbnail()){
                                                $img = get_the_post_thumbnail_url();
                                            }
                                        else{
                                            $img  = get_template_directory_uri().'/images/post-04.jpg';
                                        }
                                        ?>
                                        <img src="<?php echo $img?>" width="640" height="483" alt="" class="img-responsive center-block">
                                        <div class="caption">
                                            <div class="caption-inner">
                                                <h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                                            </div>
                                            <div><a href="<?php the_permalink() ?>" class="btn"></a></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            ?>
                        </div>
                    </div>
                            <div class="offset-top-30">
                                <!-- Bootstrap Pagination-->
                                <nav>
                                    <?php ct_numeric_pagination(); ?>
                                </nav>
                            </div>
                       <?php
                        endif;
                    ?>

                </div>
            </div>
        </section>
    </main>
<?php get_footer();?>