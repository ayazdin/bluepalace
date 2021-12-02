<?php
/**
 * Agent Contact Modal
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;

?>
    
<div id="overlay">
    <div id="modal">
    	<div id="modal-inner">
	        <a href="#" class="close"><?php esc_html_e('Close', 'contempo'); ?></a>
	        
	        <form id="listingscontact" class="formular" method="post">
                <fieldset>
	                <select id="ctinquiry" name="ctinquiry">
						<option><?php esc_html_e('Tell me more about this property', 'contempo'); ?></option>
						<option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
					</select>
						<div class="clear"></div>
                    <input type="text" name="name" id="name" class="validate[required,custom[onlyLetter]] text-input" value="<?php esc_html_e('Name', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Name', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Name', 'contempo'); ?>';" />
                    
                    <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" value="<?php esc_html_e('Email', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Email', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Email', 'contempo'); ?>';" />
                    
                    <input type="text" name="ctphone" id="ctphone" class="text-input" value="<?php esc_html_e('Phone', 'contempo'); ?>" onfocus="if(this.value=='<?php esc_html_e('Phone', 'contempo'); ?>')this.value = '';" onblur="if(this.value=='')this.value = '<?php esc_html_e('Phone', 'contempo'); ?>';" />
                    
                    <textarea class="validate[required,length[2,500]] text-input" name="message" id="message" rows="5" cols="10"></textarea>
                    
                    <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
                    <input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_listing_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
                    <input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />
                    <input type="hidden" id="ctsubject" name="ctsubject" value="<?php echo esc_html($subject); ?>" />
                    
                    <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
                </fieldset>
            </form>
        </div>
    </div>
</div>