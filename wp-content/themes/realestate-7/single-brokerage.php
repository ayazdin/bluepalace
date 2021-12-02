<?php
/**
 * Brokerage Single Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_brokerage_email = get_post_meta($post->ID, "_ct_brokerage_email", true);
$ct_brokerage_phone = get_post_meta($post->ID, "_ct_brokerage_phone", true);
$ct_brokerage_fax = get_post_meta($post->ID, "_ct_brokerage_fax", true);
$ct_brokerage_street_address = get_post_meta($post->ID, "_ct_brokerage_street_address", true);
$ct_brokerage_address_two = get_post_meta($post->ID, "_ct_brokerage_address_two", true);
$ct_brokerage_city = get_post_meta($post->ID, "_ct_brokerage_city", true);
$ct_brokerage_state = get_post_meta($post->ID, "_ct_brokerage_state", true);
$ct_brokerage_zip = get_post_meta($post->ID, "_ct_brokerage_zip", true);
$ct_brokerage_country = get_post_meta($post->ID, "_ct_brokerage_country", true);

$ct_brokerage_twitter = get_post_meta($post->ID, "_ct_brokerage_twitter", true);
$ct_brokerage_facebook = get_post_meta($post->ID, "_ct_brokerage_facebook", true);
$ct_brokerage_linkedin = get_post_meta($post->ID, "_ct_brokerage_linkedin", true);
$ct_brokerage_gplus = get_post_meta($post->ID, "_ct_brokerage_gplus", true);

$ct_agent_layout = isset( $ct_options['ct_agent_layout'] ) ? $ct_options['ct_agent_layout'] : '';
$ct_brokerage_reviews = isset( $ct_options['ct_brokerage_reviews'] ) ? $ct_options['ct_brokerage_reviews'] : '';

get_header();

do_action('before_brokerage_header');

echo '<!-- Page Header -->';
echo '<header id="title-header">';
	echo '<div class="container">';
		echo '<div class="left">';
			echo '<h5 class="marT0 marB0">';
				esc_html_e('Brokerage', 'contempo');
			echo '</h5>';
		echo '</div>';
		echo ct_breadcrumbs();
		echo '<div class="clear"></div>';
	echo '</div>';
echo '</header>';
echo '<!-- //Page Header -->';

?>

<?php do_action('before_brokerage_content'); ?>

	<div class="brokerage-single container marT30 padB60">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

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

		<div class="col span_12 first">

			<!-- Brokerage -->
			<div class="brokerage brokerage-wrap marT20 marB40">

				<?php if(has_post_thumbnail()) {
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

					echo '<figure class="col span_3 first">';
				        echo '<img class="brokerage-img" src="' . $feat_image . '" />';
				    echo '</figure>';
				} ?>

	            <div class="brokerage-info col span_9">
	                <h3><?php the_title(); ?></h3>
	                <h5 class="muted brokerage-address"><?php $postID = get_the_ID(); ct_brokerage_address($postID); ?></h5>

	                <div class="brokerage-bio col span_8 first">
	                	<p><?php the_content(); ?></p>
	                	<ul class="social marT20 marL0">
                            <?php if ($ct_brokerage_twitter) { ?><li class="twitter"><a href="<?php echo esc_url($ct_brokerage_twitter); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                            <?php if ($ct_brokerage_facebook) { ?><li class="facebook"><a href="<?php echo esc_url($ct_brokerage_facebook); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                            <?php if ($ct_brokerage_linkedin) { ?><li class="facebook"><a href="<?php echo esc_url($ct_brokerage_linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                            <?php if ($ct_brokerage_gplus) { ?><li class="google"><a href="<?php echo esc_url($ct_brokerage_gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                        </ul>
	                </div>

	                 <ul class="col span_4">
		                <?php if($ct_brokerage_phone) { ?><li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($ct_brokerage_phone); ?></span></span></li><?php } ?>
		                <?php if($ct_brokerage_fax) { ?><li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($ct_brokerage_fax); ?></span></li><?php } ?>
		                <?php if($ct_brokerage_email) { ?><li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a class="brokerage-contact" href="#"><?php esc_html_e('Email', 'contempo'); ?></a></span></li><?php } ?>
	            	</ul>
	            </div>
	        </div>
	        <!-- //Brokerage -->

	        <?php endwhile; endif; wp_reset_postdata(); ?>
            
		        <div class="clear"></div>

	        <?php do_action('before_brokerage_listings'); ?>

	        <ul class="tabs">
                <li class="brokerage-listings"><a href="#tab-listings"><i class="fa fa-newspaper-o"></i> <?php _e('Listings', 'contempo'); ?></a></li>
                <li class="brokerage-agents"><a href="#tab-agents"><i class="fa fa-users"></i> <?php _e('Agents', 'contempo'); ?></a></li>
                <li class="brokerage-map"><a href="#tab-map"><i class="fa fa-map-marker"></i> <?php _e('Map', 'contempo'); ?></a></li>
                <?php if($ct_brokerage_reviews == 'yes') { ?>
	                <li class="brokerage-reviews"><a href="#tab-reviews"><i class="fa fa-star-o"></i> <?php _e('Reviews', 'contempo'); ?></a></li>
                <?php } ?>
            </ul>
            
              <div class="clear"></div>

            <div class="inside">

				<!-- Listings -->
				<div id="tab-listings">
					<?php
		                $ct_agents = get_post_meta($post->ID, "_ct_agents", true);
		                
		                sort($ct_agents);

		                if($ct_agents != '') {
		                	$ct_brokerage_agents_ordered = implode(', ', $ct_agents);
		                }

		                $args = array(
		                    'post_type' => 'listings',
							'posts_per_page' => -1,
		                    'author__in' => $ct_brokerage_agents_ordered
		                );
						query_posts($args);

						get_template_part( 'layouts/grid');

		            ?>
	            </div>
	            <!-- //Listings -->

	            <!-- Agents -->
	            <div id="tab-agents">
		            <?php

		            $args = array(
						'order'		=> 'DESC',
						'orderby'	=> 'display_name',
						'include'	=> $ct_brokerage_agents_ordered
					);

				    $wp_user_query = new WP_User_Query($args);

				    $agents = $wp_user_query->get_results();

				    if($agents) { ?>

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

				    	<?php 
				    	echo '<ul class="agents-list">';
					    foreach ($agents as $agent) {
					        
					        $curauth = get_userdata($agent->ID);
		                    $author_id = get_the_author_meta('ID');
		                    $user_link = get_author_posts_url($curauth->ID);
		                    $email = $curauth->user_email;

					        if($curauth->isagent == 'yes') {

						        if($curauth->user_email) { ?>

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
		                                <?php if($ct_agent_layout == 'agent-grid') { echo '<h4>'; } else { echo '<h3>'; } ?><a href="<?php echo esc_url(home_url()); ?>/?author=<?php echo esc_html($curauth->ID); ?>" title="<?php echo esc_html($curauth->display_name); ?>"><?php echo esc_html($curauth->display_name); ?></a><?php if($ct_agent_layout == 'agent-grid') { echo '</h4>'; } else { echo '</h3>'; } ?>
		                                <?php if ($curauth->title) { ?><h5 class="muted position"><?php echo esc_html($curauth->title); ?></h5><?php } ?>

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
						    <?php }
					    }
					    echo '</ul>';
					} else { ?>
						<p class="nomatches"><strong><?php esc_html_e( 'This brokerage currently has no active agents.', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Check back soon.', 'contempo' ); ?></p>
					<?php } ?>
	            </div>
	            <!-- //Agents -->

	            <!-- Map -->
	            <div id="tab-map">
	            	<?php 
	            	$ct_brokerage_address = $ct_brokerage_street_address . ', ' . $ct_brokerage_address_two . ', ' . $ct_brokerage_city . ', ' . $ct_brokerage_state . ', ' . $ct_brokerage_zip;
	            	if($ct_brokerage_country != '') {
	            		$ct_brokerage_address .= ', ' . esc_html($ct_brokerage_country);
	            	} ?>

		            <?php ct_brokerage_single_map($ct_brokerage_address); ?>
	            </div>

	            <?php if($ct_brokerage_reviews == 'yes') { ?>
	            <!-- Reviews -->
				<div id="tab-reviews">
					<?php
		                echo '<div id="listing-reviews">';
                        echo '<h4 class="border-bottom marB18">';
                            comments_number( __('No Reviews', 'contempo'), __('1 Review', 'contempo'), __( '% Reviews', 'contempo') );
                        echo '</h4>';

                        get_template_part('comments');
                    echo '</div>';
		            ?>
	            </div>
	            <!-- //Reviews -->
	            <?php } ?>

	        </div>

            <?php do_action('after_brokerage_listings'); ?>

		</div>
            
            <div class="clear"></div>
        
</div>

<?php get_footer(); ?>