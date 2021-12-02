<?php
/**
 * Template Name: Sitemap
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

get_header();

while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
    // Custom Page Header Background Image
    if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
        echo'<style type="text/css">';
        echo '#single-header { background: url(';
        echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
        echo ') no-repeat center center; background-size: cover;}';
        echo '</style>';
    } ?>

    <!-- Single Header -->
    <div id="single-header">
        <div class="dark-overlay">
            <div class="container">
                <h1 class="marT0 marB0"><?php the_title(); ?></h1>
                <?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
                    <h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- //Single Header -->
<?php } ?>

<?php echo '<div class="container marT60 padB60">'; ?>

        <article class="col span_12">
            
			<?php the_content(); ?>
            
            <?php endwhile; ?>
            
            <section class="marT60">
                <div class="singlecol left">
                    <h5 class="marB10"><?php esc_html_e('Last Twenty Posts', 'contempo'); ?></h5>
                    <ul>
                    <?php		
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 20
                        );
                        $query = new WP_Query($args);
                    
                    while ( $query->have_posts() ) { $query->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php } wp_reset_query(); ?>
                    </ul>                        
                </div>
                
                <div class="singlecol left">
                    <h5 class="marB10"><?php esc_html_e('Pages', 'contempo'); ?></h5>
                    <ul>
                        <?php wp_list_pages( 'depth=0&sort_column=menu_order&title_li=' ); ?>		
                    </ul>
                </div>
                
                <div class="singlecol left">
                    <h5 class="marB10"><?php esc_html_e('Categories', 'contempo'); ?></h5>
                    <ul>
                        <?php wp_list_categories( 'title_li=&hierarchical=0&show_count=1') ?>	
                    </ul>
                </div>
                
                <div class="singlecol left last">
                    <h5 class="marB10"><?php esc_html_e('Posts per category', 'contempo'); ?></h5>
                    <?php
                        $cats = get_categories();
                        foreach ( $cats as $cat ) {
                
                        query_posts( 'cat=' . $cat->cat_ID );
                    ?>
                    <h6 class="marB10"><strong><?php echo esc_html($cat->cat_name); ?></strong></h6>
                    <ul>	
                        <?php while ( have_posts() ) { the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } wp_reset_query(); ?>
                </div> 
            </section>
            
                <div class="clear"></div>

        </article>

<?php 

echo '</div>';

get_footer(); ?>