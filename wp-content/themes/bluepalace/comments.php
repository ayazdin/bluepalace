<?php
/**
 * Comments Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'contempo'); ?></p>
	<?php
		return;
	}
?>

<?php do_action('before_post_comments'); ?>

<!-- Comments -->
<div id="comments-template">

	<div class="comments-wrap">

		<div id="comments">

			<?php if ( have_comments() ) : ?>
				
				<?php if(!is_singular('listings')) { ?>
					<h4 id="comments-number" class="comments-header"><?php comments_number( __('No Responses', 'contempo'), __('1 Comment', 'contempo'), __( '% Comments', 'contempo') );?></h4>
				<?php } ?>

				<ol class="comment-list <?php if(is_singular('listings') || is_singular('brokerage')) { echo 'reviews'; } ?>">
					<?php if(is_singular('listings') || is_singular('brokerage')) {
						wp_list_comments('avatar_size=0');
					} else {
						wp_list_comments('avatar_size=100');
					} ?>
				</ol>
                
                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav id="comment-nav">
                    <div class="nav-previous left"><?php previous_comments_link( __( '&larr; Older Comments', 'contempo' ) ); ?></div>
                    <div class="nav-next right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'contempo' ) ); ?></div>
                </nav>
                <?php endif; ?>

		<?php else : ?>

			<?php if ( pings_open() && !comments_open() ) : ?>

				<p class="comments-closed pings-open"><?php esc_html_e('Comments are closed, but', 'contempo'); ?> <a href="%1$s" title="<?php esc_html_e('Trackback URL for this post', 'contempo'); ?>"><?php esc_html_e('trackbacks', 'contempo'); ?></a> <?php esc_html_e('and pingbacks are open.', 'contempo'); ?></p>

			<?php elseif ( !comments_open() ) : ?>

				<p class="nocomments">
				<?php if(is_singular('listings') || is_singular('brokerage')) { 
					esc_html_e('Reviews are closed.', 'contempo');
				} else {
					esc_html_e('Comments are closed.', 'contempo');
				} ?></p>

			<?php endif; ?>

		<?php endif; ?>

		</div>

		<?php if(is_singular('listings')) {
			if(!is_user_logged_in()) {
				echo '<p class="review-login">You must <a class="login-register" href="#">login/register</a> to post a review.</p>';
			} else {
				comment_form();
			}
		} else {
			comment_form();
		} ?>

	</div>

</div>
<!-- //Comments -->

<?php do_action('after_post_comments'); ?>