<?php
/**
 * Template Name: Agents
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$ct_agent_layout = isset( $ct_options['ct_agent_layout'] ) ? $ct_options['ct_agent_layout'] : '';

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

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

        <form id="agent-live-search" action="" method="post">
            <fieldset>
                <input type="text" class="text-input" id="agent-filter" value="" placeholder="<?php _e('Type an agents name or title here to filter the list.', 'contempo'); ?>" />
            </fieldset>
        </form>

        <script>
            jQuery(document).ready(function($){
                $("#agent-filter").keyup(function(){

                    var filter = $(this).val(), count = 0;

                    $(".agents-list li").each(function(){
                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                            $(this).fadeOut();
                        } else {
                            $(this).show();
                            count++;
                        }
                    });
                    var numberItems = count;
                });
            });
        </script>

        <ul class="agents-list">
            <?php
            if($ct_options['ct_agents_ordering'] == 'yes') {
                $args = array(
                    'orderby'   => 'meta_value_num',
                    'meta_key'  => 'agentorder',
                    'order'     => 'ASC',
                );
            } else {
                $args = array(
                    'orderby'   => 'display_name',
                    'order'     => 'ASC',
                );
            }

            $agent_query = new WP_User_Query($args);

            if (!empty($agent_query->results)) { ?>

                <?php

                foreach ($agent_query->results as $agent) :

                    $curauth = get_userdata($agent->ID);
                    $author_id = get_the_author_meta('ID');
                    $user_link = get_author_posts_url($curauth->ID);
                    $email = $curauth->user_email;
            
                    if($curauth->user_level >= 0 && $curauth->isagent == 'yes') : ?>   

                        <?php if($curauth->user_email) { ?>

                            <script>    
                                jQuery(document).ready(function() {
                                    jQuery(".contact-form-<?php echo esc_html($curauth->last_name); ?>").validationEngine({
                                        ajaxSubmit: true,
                                        ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-agent.php",
                                        ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
                                        success :  false,
                                        failure : function() {}
                                    });
                                });
                            </script>

                            <!-- Agent Contact Modal -->
                            <div id="overlay" class="contact-modal-<?php echo esc_html($curauth->ID); ?> agent-modal">
                                <div id="modal">
                                    <div id="modal-inner">
                                        <a href="#" class="close"><i class="fa fa-close"></i></a>
                                        <form id="listingscontact" class="contact-form-<?php echo esc_html($curauth->last_name); ?> formular" method="post">
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

                                                <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo $email ?>" />
                                                <input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
                                                <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

                                                <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
                                            </fieldset>
                                                <div class="clear"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- //Agent Contact Modal -->
                        <?php } ?>

                        <!-- Agent -->
                        <li class="agent <?php echo $ct_agent_layout; ?> <?php if($ct_agent_layout == 'agent-grid') { echo 'col span_3'; } ?>">
                            <figure class="col <?php if($ct_agent_layout == 'agent-grid') { echo 'span_12'; } else { echo 'span_3'; } ?> first">
                                <a href="<?php echo esc_url(home_url()); ?>/?author=<?php echo esc_html($curauth->ID); ?>" title="<?php echo esc_html($curauth->display_name); ?>">
                                    <?php if($curauth->ct_profile_url) { ?>
                                        <img class="author-img" src="<?php echo esc_html($curauth->ct_profile_url); ?>" />
                                    <?php } else { ?>
                                        <img class="author-img" src="<?php echo get_template_directory_uri() . '/images/user-default.png'; ?>" />
                                    <?php } ?>
                                </a>
                            </figure>
                            <div class="agent-info col <?php if($ct_agent_layout == 'agent-grid') { echo 'span_12'; } else { echo 'span_9'; } ?>">
                                <header>
                                    <?php if($ct_agent_layout == 'agent-grid') { echo '<h4>'; } else { echo '<h3>'; } ?><a href="<?php echo esc_url(home_url()); ?>/?author=<?php echo esc_html($curauth->ID); ?>" title="<?php echo esc_html($curauth->display_name); ?>"><?php echo esc_html($curauth->display_name); ?></a><?php if($ct_agent_layout == 'agent-grid') { echo '</h4>'; } else { echo '</h3>'; } ?>
                                    <?php if ($curauth->title) { ?><h5 class="muted position"><?php echo esc_html($curauth->title); ?></h5><?php } ?>
                                </header>

                                <?php if($ct_agent_layout != 'agent-grid') { ?>
                                <div class="agent-bio col span_8 first">
                                    <p><?php if($curauth->tagline) { ?><strong class="tagline"><?php echo esc_html($curauth->tagline); ?></strong> <?php } ?><?php $bio = $curauth->description; echo nl2br($bio); ?></p>
                                    <ul class="social marT20 marL0">
                                        <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                        <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_html($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                        <?php if ($curauth->linkedinurl) { ?><li class="linkedin"><a href="<?php echo esc_html($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                        <?php if ($curauth->gplus) { ?><li class="google"><a href="<?php echo esc_html($curauth->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
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

                                <ul class="col <?php if($ct_agent_layout == 'agent-grid') { echo 'span_12'; } else { echo 'span_4'; } ?>">
                                    <?php if($curauth->mobile) { ?><li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($curauth->mobile); ?></span></span></li><?php } ?>
                                    <?php if($curauth->office) { ?><li class="row"><span class="muted left"><i class="fa fa-building"></i></span> <span class="right"><?php echo esc_html($curauth->office); ?></span></li><?php } ?>
                                    <?php if($curauth->fax) { ?><li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($curauth->fax); ?></span></li><?php } ?>
                                   <?php if($curauth->user_email) { $email = $curauth->user_email; ?><li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a class="agent-contact-<?php echo esc_html($curauth->ID); ?>" href="#"><?php esc_html_e('Email', 'contempo'); ?></a></span></li><?php } ?>
                                   <?php if($curauth->user_url) {
                                        $ct_user_url = $curauth->user_url;
                                        $ct_user_url = trim($ct_user_url, '/');
                                        // If scheme not included, prepend it
                                        if (!preg_match('#^http(s)?://#', $ct_user_url)) {
                                            $ct_user_url = 'http://' . $ct_user_url;
                                        }

                                        $ct_urlParts = parse_url($ct_user_url);

                                        // remove www
                                        $ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
                                    ?>
                                        <li class="row"><span class="muted left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($curauth->user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
                                    <?php } ?>
                                    <?php if($curauth->brokername) { ?><p class="marB3"><strong><?php echo esc_html($curauth->brokername); ?></strong></p><?php } ?>
                                    <?php if($curauth->brokernum) { ?><p class="marB3"><?php echo esc_html($curauth->brokernum); ?></p><?php } ?>
                                </ul>
                                    <div class="clear"></div>

                                <?php if($ct_agent_layout == 'agent-grid') { ?>
                                <div class="agent-bio col span_12 first">
                                    <ul class="social marT20 marL0">
                                        <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                        <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_html($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                        <?php if ($curauth->linkedinurl) { ?><li class="linkedin"><a href="<?php echo esc_html($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                        <?php if ($curauth->gplus) { ?><li class="google"><a href="<?php echo esc_html($curauth->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>

                                <?php if($ct_agent_layout != 'agent-grid') { ?>
                                <div class="view-listings">
                                    <a class="btn" href="<?php echo esc_url(home_url()); ?>/?author=<?php echo esc_html($curauth->ID); ?>"><?php esc_html_e('View Listings', 'contempo'); ?></a>
                                </div>
                                <?php } ?>
                            </div>
                                <div class="clear"></div>
                        </li>
                        <!-- //Agent --> 
                    
                    <?php endif; ?>
            
                <?php endforeach; ?>

            <?php } else { ?>

                <p><?php _e('No Agents Found.', 'contempo'); ?></p>
            
            <?php } ?>
        </ul>
        
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
        
        <?php endwhile; endif; ?>
        
            <div class="clear"></div>

    </article>

        <div class="clear"></div>

</div>

<?php get_footer(); ?>