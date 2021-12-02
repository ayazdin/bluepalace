<?php
/**
 * Template Name: Brokerages
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_brokerage_layout = isset( $ct_options['ct_brokerage_layout'] ) ? $ct_options['ct_brokerage_layout'] : '';

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$top_page_margin = get_post_meta($post->ID, "_ct_top_page_margin", true);

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

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

<div class="container marT60 padB60">

    <article class="col span_12">

        <?php the_content(); ?>

        <?php endwhile; endif; ?>

        <ul>
            <?php

            $args = array(
                'post_type'         => 'brokerage',
                'posts_per_page'    => -1
            );
            $wp_query = new wp_query( $args ); 
            
            $count = 0; if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();


            $ct_brokerage_email = get_post_meta($post->ID, "_ct_brokerage_email", true);
            $ct_brokerage_phone = get_post_meta($post->ID, "_ct_brokerage_phone", true);
            $ct_brokerage_fax = get_post_meta($post->ID, "_ct_brokerage_fax", true);

            $ct_brokerage_twitter = get_post_meta($post->ID, "_ct_brokerage_twitter", true);
            $ct_brokerage_facebook = get_post_meta($post->ID, "_ct_brokerage_facebook", true);
            $ct_brokerage_linkedin = get_post_meta($post->ID, "_ct_brokerage_linkedin", true);
            $ct_brokerage_gplus = get_post_meta($post->ID, "_ct_brokerage_gplus", true);

            ?>   

                <?php if($ct_brokerage_email != '') { ?>

                    <script>    
                        jQuery(document).ready(function() {
                            jQuery("#listingscontact").validationEngine({
                                ajaxSubmit: true,
                                ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-agent.php",
                                ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
                                success :  false,
                                failure : function() {}
                            });
                        });
                    </script>

                    <!-- Brokerage Contact Modal -->
                    <div id="overlay" class="contact-modal">
                        <div id="modal">
                            <div id="modal-inner">
                                <a href="#" class="close"><i class="fa fa-close"></i></a>
                                <form id="listingscontact" class="formular" method="post">
                                    <fieldset class="col span_12">
                                        <select id="ctsubject" name="ctsubject">
                                            <option><?php esc_html_e('Tell me more about a property', 'contempo'); ?></option>
                                            <option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
                                            <option><?php esc_html_e('General Questions', 'contempo'); ?></option>
                                        </select>
                                            <div class="clear"></div>
                                        <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

                                        <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

                                        <input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

                                        <textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="6" cols="10"></textarea>

                                        <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($brokerage_email) ?>" />
                                        <input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
                                        <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

                                        <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
                                    </fieldset>
                                        <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- //Brokerage Contact Modal -->
                <?php } ?>

                    <!-- Brokerage -->
                    <li class="brokerage brokerage-wrap <?php echo $ct_brokerage_layout; ?> <?php if($ct_brokerage_layout == 'brokerage-grid') { echo 'col span_3'; } ?>">
                        <?php if(has_post_thumbnail()) {
                            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                            <figure class="col <?php if($ct_brokerage_layout == 'brokerage-grid') { echo 'span_12'; } else { echo 'span_3'; } ?> first">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img class="brokerage-img" src="<?php echo $feat_image; ?>" />
                                </a>
                            </figure>
                        <?php } ?>
                        <div class="agent-info col <?php if($ct_brokerage_layout == 'brokerage-grid') { echo 'span_12'; } else { echo 'span_9'; } ?>">
                            <?php if($ct_brokerage_layout == 'agent-grid') { echo '<h4>'; } else { echo '<h3>'; } ?><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><?php if($ct_brokerage_layout == 'agent-grid') { echo '</h4>'; } else { echo '</h3>'; } ?>
                            <h5 class="muted brokerage-address"><?php $postID = get_the_ID(); ct_brokerage_address($postID); ?></h5>

                            <?php if($ct_brokerage_layout != 'brokerage-grid') { ?>
                            <div class="agent-bio col span_8 first">
                                <p><?php the_content(); ?></p>
                                <ul class="social marT20 marL0">
                                    <?php if ($ct_brokerage_twitter) { ?><li class="twitter"><a href="<?php echo esc_url($ct_brokerage_twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                    <?php if ($ct_brokerage_facebook) { ?><li class="facebook"><a href="<?php echo esc_url($ct_brokerage_facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                    <?php if ($ct_brokerage_linkedin) { ?><li class="facebook"><a href="<?php echo esc_url($ct_brokerage_linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                    <?php if ($ct_brokerage_gplus) { ?><li class="google"><a href="<?php echo esc_url($ct_brokerage_gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                </ul>
                            </div>
                            <?php } ?>

                            <script>
                            jQuery(document).ready(function() {
                                jQuery(".agent-contact-<?php echo esc_html($curauth->ID); ?>").click(function() {
                                    jQuery("#overlay.contact-modal-<?php echo esc_html($curauth->ID); ?>").addClass('open');
                                });

                                jQuery(".close").click(function() {
                                    jQuery("#overlay.contact-modal-<?php echo esc_html($curauth->ID); ?>").removeClass('open');
                                    jQuery(".formError").hide();
                                });
                            });
                            </script>

                            <ul class="col <?php if($ct_brokerage_layout == 'brokerage-grid') { echo 'span_12'; } else { echo 'span_4'; } ?>">
                                <?php if($ct_brokerage_phone) { ?><li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($ct_brokerage_phone); ?></span></span></li><?php } ?>
                                <?php if($ct_brokerage_fax) { ?><li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($ct_brokerage_fax); ?></span></li><?php } ?>
                                <?php if($ct_brokerage_email) { ?><li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a class="brokerage-contact" href="#"><?php esc_html_e('Email', 'contempo'); ?></a></span></li><?php } ?>
                            </ul>
                                <div class="clear"></div>

                            <?php if($ct_brokerage_layout == 'brokerage-grid') { ?>
                            <div class="agent-bio col span_12 first">
                                <ul class="social marT20 marL0">
                                    <?php if ($ct_brokerage_twitter) { ?><li class="twitter"><a href="<?php echo esc_url($ct_brokerage_twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                    <?php if ($ct_brokerage_facebook) { ?><li class="facebook"><a href="<?php echo esc_url($ct_brokerage_facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                    <?php if ($ct_brokerage_linkedin) { ?><li class="facebook"><a href="<?php echo esc_url($ct_brokerage_linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                    <?php if ($ct_brokerage_gplus) { ?><li class="google"><a href="<?php echo esc_url($ct_brokerage_gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                </ul>
                            </div>
                            <?php } ?>

                            <?php if($ct_brokerage_layout != 'brokerage-grid') { ?>
                            <div class="view-listings">
                                <a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('View', 'contempo'); ?></a>
                            </div>
                            <?php } ?>
                        </div>
                            <div class="clear"></div>
                    </li>
                    <!-- //Brokerage --> 

            <?php endwhile; else : ?>

                <p><?php _e('No Brokerages Found.', 'contempo'); ?></p>
            
            <?php endif; ?>
        </ul>
        
            <div class="clear"></div>

    </article>

        <div class="clear"></div>

</div>

<?php get_footer(); ?>