<?php
global $ct_options;
?>
<!-- Page Footer-->
<footer class="page-footer">
    <div class="range range-condensed section-center-20 text-sm-left offset-top-0">
        <div class="range section-80 text-md-left">
            <div class="cell-md-2 text-left">
                <h5>General</h5>
                <?php wp_nav_menu('Footer General'); ?>
            </div>
            <div class="cell-md-3 text-left">
                <h5>Residential</h5>
                <?php wp_nav_menu('Footer General'); ?>
            </div>
            <div class="cell-md-3 text-left">
                <h5>Useful Links</h5>
                <?php wp_nav_menu('Footer General'); ?>
            </div>
            <div class="cell-md-4 con-info text-left">
                <h5>Contact Us</h5>
                <ul>
                    <li>
                        <div class="con-left">Tel :</div>
                        <div class="con-right">(971) 4 399 8470</div>
                    </li>
                    <li>
                        <div class="con-left">Fax :</div>
                        <div class="con-right">(971) 4 368 6286</div>
                    </li>
                    <li>
                        <div class="con-left">Address :</div>
                        <div class="con-right">
                            P.O Box 49729 <br>
                            Business Bay,<br>
                            Churchill Tower Office, 602<br>
                            Dubai, United Arab Emirates
                        </div>
                    </li>
                    <li>
                        <div class="con-left">Email:</div>
                        <div class="con-right"><a href="mailto:info@royaloasis.co.ae">info@royaloasis.co.ae</a></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="range range-condensed section-center-20 text-sm-left offset-top-0">
        <hr>
    </div>
    <div class="range range-condensed section-center-20 text-sm-left offset-top-0">
        <div class="range section-button-10 range-xs-middle">
        <div class="range section-bottom-10 range-xs-middle">
            <div class="cell-sm-6 text-sm-right cell-sm-push-1">
                <?php
                if($ct_options['ct_header_social'] == "yes") {
                    $ct_social_new_tab = isset( $ct_options['ct_social_new_tab'] ) ? esc_html( $ct_options['ct_social_new_tab'] ) : '';
                    $facebook = isset( $ct_options['ct_fb_url'] ) ? esc_url( $ct_options['ct_fb_url'] ) : '';
                    $twitter = isset( $ct_options['ct_twitter_url'] ) ? esc_url( $ct_options['ct_twitter_url'] ) : '';
                    $googleplus = isset( $ct_options['ct_googleplus_url'] ) ? esc_url( $ct_options['ct_googleplus_url'] ) : '';
                    $youtube = isset( $ct_options['ct_youtube_url'] ) ? esc_url( $ct_options['ct_youtube_url'] ) : '';
                    $linkedin = isset( $ct_options['ct_linkedin_url'] ) ? esc_url( $ct_options['ct_linkedin_url'] ) : '';
                    $dribbble = isset( $ct_options['ct_dribbble_url'] ) ? esc_url( $ct_options['ct_dribbble_url'] ) : '';
                    $pinterest = isset( $ct_options['ct_pinterest_url'] ) ? esc_url( $ct_options['ct_pinterest_url'] ) : '';
                    $instagram = isset( $ct_options['ct_instagram_url'] ) ? esc_url( $ct_options['ct_instagram_url'] ) : '';
                    $github = isset( $ct_options['ct_github_url'] ) ? esc_url( $ct_options['ct_github_url'] ) : '';
                    $contact = isset( $ct_options['ct_contact_url'] ) ? esc_url( $ct_options['ct_contact_url'] ) : '';
                ?>
                    <ul class="list-inline">
                        <?php if($facebook != '') { ?>
                            <li><a href="<?php echo esc_url($facebook); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?> class="icon icon-sm text-primary fa-facebook"></a></li>
                        <?php } ?>
                        <?php if($twitter != '') { ?>
                            <li><a href="<?php echo esc_url($twitter); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?> class="icon icon-sm text-primary fa-twitter"></a></li>
                        <?php } ?>
                        <?php if($googleplus != '') { ?>
                            <li><a href="<?php echo esc_url($googleplus); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?> class="icon icon-sm text-primary fa-google-plus"></a></li>
                        <?php } ?>
                        <?php if($linkedin != '') { ?>
                            <li><a href="<?php echo esc_url($linkedin); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?>><i class="fa fa-linkedin"></i></a></li>
                        <?php } ?>
                        <?php if($youtube != '') { ?>
                            <li><a href="<?php echo esc_url($youtube); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?>><i class="fa fa-youtube-square"></i></a></li>
                        <?php } ?>
                        <?php if($dribbble != '') { ?>
                            <li><a href="<?php echo esc_url($dribbble); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?>><i class="fa fa-dribbble"></i></a></li>
                        <?php } ?>
                        <?php if($pinterest != '') { ?>
                            <li><a href="<?php echo esc_url($pinterest); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?>><i class="fa fa-pinterest"></i></a></li>
                        <?php } ?>
                        <?php if($instagram != '') { ?>
                            <li><a href="<?php echo esc_url($instagram); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?>><i class="fa fa-instagram"></i></a></li>
                        <?php } ?>
                        <?php if($github != '') { ?>
                            <li><a href="<?php echo esc_url($github); ?>" <?php if($ct_social_new_tab == 'yes') { echo 'target="_blank"'; } ?>><i class="fa fa-github"></i></a></li>
                        <?php } ?>
                        <li><a href="https://www.snapchat.com/add/royaloasisreal" target="_blank"><i class="fa fa-snapchat"></i></a></li>
                        <?php if($contact != '') { ?>
                            <li><a href="<?php echo esc_url($contact); ?>"><i class="fa fa-envelope"></i></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <!--<ul class="list-inline">
                    <li><a href="#" class="icon icon-sm text-primary fa-facebook"></a></li>
                    <li><a href="#" class="icon icon-sm text-primary fa-twitter"></a></li>
                    <li><a href="#" class="icon icon-sm text-primary fa-google-plus"></a></li>
                </ul>-->
            </div>
            <div class="cell-sm-6 text-sm-left offset-top-20 offset-sm-top-0">
                <p class="small">&#169;<span id="copyright-year"></span>
                    Royal Oasis Real Estate Group - All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- Modal-->
<div id="loginModal" role="dialog" class="modal fade">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" data-dismiss="modal" class="close mdi mdi-window-close"></button>
                <!-- Nav tabs-->
                <ul role="tablist" class="nav nav-tabs nav-tabs-custom">
                    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>
                    <li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Register</a></li>
                </ul>
                <!-- Tab panes-->
                <div class="tab-content offset-top-20">
                    <div id="login" role="tabpanel" class="fade in tab-pane active">
                        <form method="post" class="offset-top-40 rd-mailform text-left">
                            <div class="form-group">
                                <label for="login-name" class="form-label">User name</label>
                                <input id="login-name" type="text" name="name" data-constraints="@Required" class="form-control">
                            </div>
                            <div class="form-group offset-top-7">
                                <label for="login-password" class="form-label">Password</label>
                                <input id="login-password" type="password" name="password" data-constraints="@Required" class="form-control">
                            </div>
                            <div class="offset-top-20 text-center text-sm-left">
                                <button type="submit" class="btn btn-block btn-primary">login</button>
                            </div>
                        </form>
                    </div>
                    <div id="register" role="tabpanel" class="fade in tab-pane">
                        <form method="post" class="offset-top-40 rd-mailform text-left">
                            <div class="form-group">
                                <label for="register-name" class="form-label">User name</label>
                                <input id="register-name" type="text" name="name" data-constraints="@Required" class="form-control">
                            </div>
                            <div class="form-group offset-top-7">
                                <label for="register-email" class="form-label">Email</label>
                                <input id="register-email" type="email" name="email" data-constraints="@Email @Required" class="form-control">
                            </div>
                            <div class="offset-top-20 text-center text-sm-left">
                                <button type="submit" class="btn btn-block btn-primary">register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="registerModal" role="dialog" class="modal fade">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" data-dismiss="modal" class="close mdi mdi-window-close"></button>
                <!-- Nav tabs-->
                <ul role="tablist" class="nav nav-tabs nav-tabs-custom">
                    <li role="presentation"><a href="#login-2" aria-controls="login" role="tab" data-toggle="tab">Login</a></li>
                    <li role="presentation" class="active"><a href="#register-2" aria-controls="register" role="tab" data-toggle="tab">Register</a></li>
                </ul>
                <!-- Tab panes-->
                <div class="tab-content offset-top-20">
                    <div id="login-2" role="tabpanel" class="fade in tab-pane">
                        <form method="post" class="offset-top-40 rd-mailform text-left">
                            <div class="form-group">
                                <label for="login-name-2" class="form-label">User name</label>
                                <input id="login-name-2" type="text" name="name" data-constraints="@Required" class="form-control">
                            </div>
                            <div class="form-group offset-top-7">
                                <label for="login-password-2" class="form-label">Password</label>
                                <input id="login-password-2" type="password" name="password" data-constraints="@Required" class="form-control">
                            </div>
                            <div class="offset-top-20 text-center text-sm-left">
                                <button type="submit" class="btn btn-block btn-primary">login</button>
                            </div>
                        </form>
                    </div>
                    <div id="register-2" role="tabpanel" class="fade in tab-pane active">
                        <form method="post" class="offset-top-40 rd-mailform text-left">
                            <div class="form-group">
                                <label for="register-name-2" class="form-label">User name</label>
                                <input id="register-name-2" type="text" name="name" data-constraints="@Required" class="form-control">
                            </div>
                            <div class="form-group offset-top-7">
                                <label for="register-email-2" class="form-label">Email</label>
                                <input id="register-email-2" type="email" name="email" data-constraints="@Email @Required" class="form-control">
                            </div>
                            <div class="offset-top-20 text-center text-sm-left">
                                <button type="submit" class="btn btn-block btn-primary">register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php wp_footer(); ?>
<!-- Java script-->
<script src="<?php echo get_template_directory_uri();?>/js/core.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/script.js"></script>
</body>
</html>