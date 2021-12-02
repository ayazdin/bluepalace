<?php
global $ct_options;

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
<!DOCTYPE html>
<html lang="en" class="wide smoothscroll wow-animation">
<head>
    <!-- Site Title-->
   <!-- <title>Home</title>-->
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!--<link rel="icon" href="<?php /*echo get_template_directory_uri();*/?>/images/favicon.ico" type="image/x-icon">-->
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,700,300,400italic">
    <!--<link rel="stylesheet" href="<?php /*echo get_template_directory_uri();*/?>/css/style.css">-->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/custom.css">
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="<?php echo get_template_directory_uri();?>/images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="<?php echo get_template_directory_uri();?>/js/html5shiv.min.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<!-- Page-->
<div class="page text-center">
    <!-- Page Header-->
    <header class="page-header bg-image-01">
        <!-- RD Navbar-->
            <div class="rd-navbar-wrap">
            <nav data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-sm-stick-up-offset="50px" data-md-stick-up-offset="10px" data-lg-stick-up-offset="150px" class="rd-navbar rd-navbar-minimal rd-navbar-transparent">
                <button data-rd-navbar-toggle=".rd-navbar-collapse" class="rd-navbar-collapse-toggle"><span></span></button>
                <div class="rd-navbar-top-panel rd-navbar-collapse">
                    <div class="rd-navbar-inner">
                        <!--<div class="small">Please <a href="#" data-toggle="modal" data-target="#loginModal">login</a> or <a href="#" data-toggle="modal" data-target="#registerModal">register</a> to create a new listing</div>-->
                        <div class="small"></div>

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
                                    <li><a href="<?php echo esc_url($facebook); ?>" target="_blank" class="icon icon-sm text-primary fa-facebook"></a></li>
                                <?php } ?>
                                <?php if($twitter != '') { ?>
                                    <li><a href="<?php echo esc_url($twitter); ?>" target="_blank" class="icon icon-sm text-primary fa-twitter"></a></li>
                                <?php } ?>
                                <?php if($googleplus != '') { ?>
                                    <li><a href="<?php echo esc_url($googleplus); ?>" target="_blank" class="icon icon-sm text-primary fa-google-plus"></a></li>
                                <?php } ?>
                                <?php if($linkedin != '') { ?>
                                    <li><a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                <?php } ?>
                                <?php if($youtube != '') { ?>
                                    <li><a href="<?php echo esc_url($youtube); ?>" target="_blank"><i class="fa fa-youtube-square"></i></a></li>
                                <?php } ?>
                                <?php if($dribbble != '') { ?>
                                    <li><a href="<?php echo esc_url($dribbble); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                                <?php } ?>
                                <?php if($pinterest != '') { ?>
                                    <li><a href="<?php echo esc_url($pinterest); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                                <?php } ?>
                                <?php if($instagram != '') { ?>
                                    <li><a href="<?php echo esc_url($instagram); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                <?php } ?>
                                <?php if($github != '') { ?>
                                    <li><a href="<?php echo esc_url($github); ?>" target="_blank"><i class="fa fa-github"></i></a></li>
                                <?php } ?>
                                <li><a href="https://www.snapchat.com/add/royaloasisreal" target="_blank"><i class="fa fa-snapchat"></i></a></li>
                                <?php if($contact != '') { ?>
                                    <li><a href="<?php echo esc_url($contact); ?>"><i class="fa fa-envelope"></i></a></li>
                                <?php } ?>
                            </ul>
                        <?php }
                        ?>

                    </div>
                </div>
                <div class="rd-navbar-panel">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-inner">
                        <!-- RD Navbar Toggle-->
                        <button data-rd-navbar-toggle=".rd-navbar-nav-wrap" class="rd-navbar-toggle"><span></span></button>
                        <!-- RD Navbar Brand-->
                        <div class="rd-navbar-brand">
                            <a href="<?php echo home_url(); ?>" class="brand-name">


                            <?php if($ct_options['ct_text_logo'] == "yes") { ?>
                                <?php bloginfo('name'); ?>
                            <?php } else{ ?>
                                <?php if(!empty($ct_options['ct_logo']['url'])) { ?>
                                    <img src="<?php echo esc_url($ct_options['ct_logo']['url']); ?>" <?php if(!empty($ct_logo_highres)) { ?>srcset="<?php echo esc_url($ct_logo_highres); ?> 2x"<?php } ?> alt="<?php bloginfo('name'); ?>">
                                <?php } else{?>
                                    <img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="">
                                    <?php }?>
                            <?php  }?>
                            </a>
                        </div>
                        <?php
                        $phone = isset( $ct_options['ct_contact_phone_header'] ) ? $ct_options['ct_contact_phone_header'] : '';
                        ?>
                        <?php if($phone != '') { ?>
                            <div class="rd-navbar-contacts rd-navbar-collapse rd-navbar-collapse-2"><span class="semi-small">Get in touch with us</span>
                                <div><span class="icon fa-phone text-primary"></span><a href="callto:#"><?php echo stripslashes($phone);?></a></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="rd-navbar-nav-wrap">
                    <div class="rd-navbar-inner">
                        <!-- RD Navbar Nav-->
                        <?php ct_nav_right(); ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
        if(is_front_page()){
            ?>
            <div class="homeslider text-md-left">
                <div class="range range-xs-middle">
                   <?php  get_template_part('includes/home-slider');?>
                </div>
            </div>
        <?php }?>
    </header>
