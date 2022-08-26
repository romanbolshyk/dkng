<?php
/*
// Social block
$social = new \Dkng\Wp\Social();
//$social->get_access_token_with_code( 11 );
$facebook_login_link = $social->get_facebook_url();
$code = ( !empty( $_GET['code'] ) ) ?  $_GET['code'] : 0;
//if ( !empty( $_GET['code'] ) ) {
//    $social->get_access_token_with_code( $_GET['code'] );
//}
//$social->facebook_sharing();
//$social->facebook_sharing1();
*/

$current_url  = $_SERVER['REQUEST_URI'];
$template_dir = get_template_directory_uri();
$user         = wp_get_current_user();
$name         = $user->user_firstname . ' ' . $user->user_lastname;
$displayname  = $user->display_name;

$position     =  get_field( 'position','user_' . $user->ID );
$company_name =  get_field( 'name',    'user_' . $user->ID );
$phone        =  get_field( 'phone',   'user_' . $user->ID );
$email        =  get_field( 'email',   'user_' . $user->ID );
$email        =  ( !empty( $email ) ) ? $email : $user->user_email;
$fb_link      =  get_field( 'facebook_link', 'user_' . $user->ID );
$tw_link      =  get_field( 'twitter_link',  'user_' . $user->ID );
$lkdn_link    =  get_field( 'linkedin_link', 'user_' . $user->ID );
$ytb_link     =  get_field( 'youtube_link',  'user_' . $user->ID );
$meet_link    =  get_field( 'meeting_calendar_link',  'user_' . $user->ID );
$sendgrid_step      = get_field( 'sendgrid_step',  'user_' . $user->ID );
$sendgrid_step      = !empty( $sendgrid_step ) ? (int)$sendgrid_step : 1;

$sendgrid_domain_id = get_field( 'sendgrid_domain_id',  'user_' . $user->ID );
$sendgrid_domain_id = !empty( $sendgrid_domain_id ) ? (int)$sendgrid_domain_id : 0;

$sendgrid_sender_id = get_field( 'sendgrid_sender_id',  'user_' . $user->ID );
$sendgrid_sender_id = !empty( $sendgrid_sender_id ) ? (int)$sendgrid_sender_id : 0;

$sendgrid_city    = get_field( 'sendgrid_city',     'user_' . $user->ID );
$sendgrid_country = get_field( 'sendgrid_country',  'user_' . $user->ID );
$sendgrid_country = ( !empty( $sendgrid_country ) ) ? $sendgrid_country : "United States";

$wealthbox_api_key = get_field( 'wealthbox_api_key', 'user_' . $user->ID );
$wealthbox_api_key = ( !empty( $wealthbox_api_key ) ) ? $wealthbox_api_key : "";

$article_disclosure = get_field( 'disclaimer', 'user_' . $user->ID );
$article_disclosure = ( !empty( $article_disclosure ) ) ? $article_disclosure : "";

$email_disclosure   = get_field( 'email_disclosure', 'user_' . $user->ID );
$email_disclosure   = ( !empty( $email_disclosure ) ) ? $email_disclosure : "";

$sendgrid_address = get_field( 'sendgrid_address',  'user_' . $user->ID );
$address          = get_field( 'address',           'user_' . $user->ID );

$user_timezone    = get_field( 'user_timezone', 'user_'.$user->ID );
$default_timezone = get_option('timezone_string');
$user_timezone    = !empty( $user_timezone ) ? $user_timezone : $default_timezone;

$valid_timezone   = false;
$user_timezone    = !empty( $valid_timezone ) ? $user_timezone : $default_timezone;
$date_format      = new DateTime( "now", new DateTimeZone( $user_timezone ) );
$date_format      = $date_format->format('Y-m-d H:i:s');

$sendgrid_data    = get_field( 'sendgrid_data',  'user_' . $user->ID );
$sendgrid_data    = ( !empty( $sendgrid_data ) ) ? json_decode( $sendgrid_data, true ) : "";

$custom_site  =  get_field( 'custom_site',   'user_' . $user->ID );
$subscribers  =  get_users( array ( 'role'=>'subscriber' ) );
//$colleagues   =  array();

$udata        = get_userdata( $user->ID );
$registered   = $udata->user_registered;

$upload_dir   = wp_upload_dir();
$file_name    = get_user_meta( $user->ID, 'avatar', true );
$fileurl      = $upload_dir['basedir'] . $file_name;
$filepath     = $upload_dir['baseurl'] .  $file_name;
$fileurl      = ( file_exists( $fileurl ) && !empty( $file_name ) ) ? $filepath : "./dist/img/avatar.png";

$looged_in    = ( is_user_logged_in() ) ? 'yes' : 'no';

$completed_courses  = get_user_meta( $user->ID, 'completed_courses' );
$count_completed    = ( !empty( $completed_courses[0] ) ) ? count( $completed_courses[0] ) : 0;
$courses            = new WP_Query( array( 'post_type' => 'courses',  'posts_per_page' => -1  ) );

$current_time       = current_time('Y-m');
$get_downloads      = get_user_meta( $user->ID, $current_time, true );
$get_downloads      = ( !empty( $get_downloads ) ) ? count( $get_downloads ) : 0;
//$downloads_left     = 5 - (int)$get_downloads;
$downloads_left     = (int)$get_downloads;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php wp_title(''); ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?php echo $template_dir; ?>/">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $template_dir; ?>/fav.ico">
        <link rel="icon" type="image/x-icon"  href="<?php echo $template_dir; ?>/fav.ico">
        <?php wp_head(); ?>
        <script>
            (function (jQuery) {
                window.$ = jQuery.noConflict();
            })(jQuery);
        </script>
    </head>
    <body <?php body_class();?> data-timezone="<?php echo $user_timezone;?>" data-default-timezone="<?php echo $default_timezone;?>" data-time-backend="<?php echo $date_format;?>">


        <div class="preloader">
            <div class="preloader__row">
                <div class="preloader__item"></div>
                <div class="preloader__item"></div>
            </div>
        </div>
        <div class="super_container" >

            <div class="dashboard-page">

                <header class="header white-header" id="header" data-logged="<?php echo $looged_in;?>">
                    <div>
                        <div class="header_top">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-1 col-sm-1 d-block d-md-none d-flex align-items-center justify-content-center flex-row first_header order-2 order-sm-1">
                                        <div class="hamburger-left mr-auto"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-md dashboard_top_content logo-holder d-flex flex-column flex-sm-row align-items-center justify-content-md-start justify-content-left min-left second_header order-1 order-sm-2">
                                        <a href="<?php echo get_site_url(); ?>/admin-dashboard/">
                                            <img src="./dist/img/logo_new.svg" id="logo_style_image" alt="logo">
                                        </a>
                                        <p id="welcome_p"><?php echo esc_html__( "Welcome", "dkng" ) .', ' . $user->user_nicename;?></p>
                                    </div>
                                    <div class="col-11 col-sm col-md third_header order-3">

                                        <div class="row dashboard_top_content d-flex flex-row align-items-center justify-content-end">
                                            <div class="col-10 col-md-12 col-lg-12 border-left d-flex flex-row align-items-center justify-content-end">

                                                <div class="search">
                                                    <?php echo do_shortcode('[wd_asp id=1]'); ?>
                                                </div>
                                                <div class="sv-notifications js-notifications">
                                                    <div class="sv-notifications__alert">
                                                        <span class="sv-notifications__counter">
                                                            <?php
                                                            if ( $left_notifications > 0  ) {
                                                                echo $left_notifications;
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>


                                                </div>

                                                <div class="sv-user border-left d-flex flex-row align-items-center justify-content-end">
                                                    <?php if ( is_user_logged_in() ) { ?>
                                                        <img src="<?php echo $fileurl;?>" alt="oval" class="logo_main logo_main_style "/>
                                                        <div class="name-holder">
                                                            <p class="bold"><?php echo $user->user_nicename; ?></p>
                                                            <p><?php echo $name;?></p>
                                                        </div>
                                                        <a class="user-info" href="#"><i class="fa fa-angle-down"></i></a>
                                                    <?php  } else { ?>
                                                        <h3>
                                                            <a href="<?php echo get_site_url();?>/advisorlogin">
                                                                <?php echo esc_html__( "Log in", "dkng" );?>
                                                            </a>
                                                        </h3>
                                                    <?php } ?>
                                                    </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

            </div>

            <div class="main-content">
                <div class="left-menu pr-0">
                    <div class="menu_left_close">
                        <i class="fa fa-times"></i>
                    </div>
                    <ul class="main_tabs">
                        <li class="nav-item">
                            <a class="home_tab nav-link d-flex flex-row justify-content-start align-items-center"
                                href="<?php echo get_site_url(); ?>/admin-dashboard">
                                <i class="fa fa-home"></i> <?php echo __( "Home", "dkng" );?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center content_tab"
                                href="<?php echo get_site_url(); ?>/admin-content">
                                <i class="fa fa-newspaper-o" style="margin-left: -3px; font-size: 16px"></i> <?php echo __( "Articles", "dkng" );?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center training_tab"
                                href="<?php echo get_site_url(); ?>/admin-training">
                                <i class="fa fa-book"></i> <?php echo __( "Coaching", "dkng" );?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center campaigns_tab"
                               href="<?php echo get_site_url(); ?>/admin-campaigns">
                                <i class="fa fa-user"></i> <?php echo __( "Campaigns", "dkng" );?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center template_tab"
                               href="<?php echo get_site_url(); ?>/admin-template">
								<i class="fa fa-file-text"></i> <?php echo __( "Resources", "dkng" );?>
                            </a>
                        </li>
						<li class="nav-item pr-0">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center manage_tab"
                               href="<?php echo get_site_url(); ?>/admin-campaigns/?page=all_leads">
								<i class="fa fa-list-ul"></i> <?php echo __( "Manage Lists", "dkng" );?>
                            </a>
                        </li>
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link d-flex flex-row justify-content-start align-items-center template_tab"-->
<!--                               href="--><?php //echo get_site_url(); ?><!--/admin-template">-->
<!--								<i class="fa fa-file-text"></i> --><?php //echo do_shortcode('[wd_asp id=1]');?>
<!--                            </a>-->
<!--                        </li>-->
                    </ul>

                    <div class="logo_bottom">
                        <a href="<?php echo get_site_url(); ?>"><img src="./dist/img/icon-logo_io.png" alt="logo"></a>
                    </div>
                </div>
            <div class="right-content">
