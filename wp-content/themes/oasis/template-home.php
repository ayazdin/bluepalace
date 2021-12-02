<?php
/**
 * Template Name: Home
 *
 * @package Royal Oasis
 * @subpackage Template
 */
if (!empty($_GET['search-listings'])) {
    get_template_part('search-listings');
    return;
}
get_header();

$ct_mode = isset( $ct_options['ct_mode'] ) ? esc_html( $ct_options['ct_mode'] ) : '';
$ct_rev_slider = isset( $ct_options['ct_home_rev_slider_alias'] ) ? esc_html( $ct_options['ct_home_rev_slider_alias'] ) : '';
$ct_home_adv_search_style = " search-style-two";//isset( $ct_options['ct_home_adv_search_style'] ) ? $ct_options['ct_home_adv_search_style'] : '';
$ct_hero_search_heading = isset( $ct_options['ct_hero_search_heading'] ) ? esc_html( $ct_options['ct_hero_search_heading'] ) : '';
$ct_hero_search_sub_heading = isset( $ct_options['ct_hero_search_sub_heading'] ) ? esc_html( $ct_options['ct_hero_search_sub_heading'] ) : '';
$ct_cta = isset( $ct_options['ct_cta'] ) ? $ct_options['ct_cta'] : '';
$ct_cta_bg_img = isset( $ct_options['ct_cta_bg_img']['url'] ) ? esc_url( $ct_options['ct_cta_bg_img']['url'] ) : '';
$ct_cta_bg_color = isset( $ct_options['ct_cta_bg_color'] ) ? esc_html( $ct_options['ct_cta_bg_color'] ) : '';
$layout = isset( $ct_options['ct_home_layout']['enabled'] ) ? $ct_options['ct_home_layout']['enabled'] : '';
?>

<!-- Page Content-->
<main class="page-content is-home">
    <section>
        <div class="range range-condensed section-30 section-center-20 text-sm-middle">
            <div class="cell-sm-12 well well-base">
                <?php get_template_part('/includes/advanced-search-ayaz');?>
            </div>
        </div>
    </section>


<?php
    if($layout):
        foreach($layout as $key=>$value){
            switch($key){
                //Featured Listings
                case 'featured_listings':
                    echo '<section>';
                    get_template_part('/includes/featured-listings');
                    echo '</section>';
                break;

                // Call To Action
                /*case 'cta':
                    echo '<section class="rd-parallax">';
                    if(!empty($ct_cta_bg_img)){
                        echo '<div data-speed="0.4" data-type="media" data-url="'.esc_url($ct_cta_bg_img).'" class="rd-parallax-layer"></div>';
                    }else{
                        echo '<div data-speed="0.4" data-type="media" data-url="'.get_template_directory_uri().'/images/background-02.jpg" class="rd-parallax-layer"></div>';
                    }
                    echo '<div data-speed="0" data-type="html" class="rd-parallax-layer">';
                    echo     '<div class="shell section-100 section-lg-top-220 section-lg-bottom-205 context-dark text-md-left">';
                    echo         '<hr class="divider">';
                            echo stripslashes($ct_cta);
                     echo    '</div>';
                    echo '</div>';
                    echo '</section>';
                break;*/
            }
        }
    endif;
?>
</main>
<?php get_footer(); ?>
