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

$valid_timezone   = isValidTimezoneId( $user_timezone );
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

                <div class="account-info">
                    <div class="bottom-border">
                        <div class="row">
                            <div class="col-10">
                                <h4><?php echo esc_html__("Account Info", "dkng");?></h4>
                            </div>
                            <div class="col-2">
                                <a class="user-info-close" href="#"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="person-holder bottom-border">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <form id="user-image" method="post" enctype="multipart/form-data" >
                                    <img src="<?php echo $fileurl;?>" alt="info-img" id="user_img_style" />
                                    <div class="justify-content-start align-items-left">
                                        <label for="user_image" class="custom-file-upload small">
                                            <i class="fa fa-upload"></i>
                                            <?php echo esc_html__("Upload new", "dkng");?>
                                        </label>
                                        <input type="file" required name="user_image" id="user_image"
                                           value="<?php echo esc_html__("Upload new", "dkng");?>" >
                                    </div>
                                </form>
                                <img src="./dist/img/loader.gif"  id="loader-image" alt="loader" />
                            </div>
                            <div class="col-12 col-md-8">
                                <h3><?php echo $name; ?></h3>
                                <p><?php echo $company_name; ?></p>
                                <p><?php echo $position;?></p>
                                <p><?php echo $email;?></p>
                                <p><?php echo $phone;?></p>
                                <p class="big"><?php echo esc_html__("Connected Accounts", "dkng");?></p>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <a class="social-link" href="<?php echo $lkdn_link;?>"><i class="fa fa-linkedin"></i></a>
                                    <a class="social-link" href="<?php echo $tw_link;?>"><i class="fa fa-twitter"></i></a>
                                    <a class="social-link" href="<?php echo $fb_link;?>"><i class="fa fa-facebook"></i></a>
<!--                                    <button id="loginBtn">Facebook Login</button>-->
                                    <div id="response"></div>
                                    <a class="social-link" href="<?php echo $ytb_link;?>"><i class="fa fa-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="joined-holder bottom-border">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    <span class="bold_span">
                                        <?php echo $count_completed; ?>
                                        <?php echo esc_html__("out of", "dkng");?>
                                        <?php echo count( $courses->posts ); ?>
                                    </span>
                                    <?php echo esc_html__("lessons completed", "dkng");?>
                                </p>
                                <p><?php echo sprintf( 'Joined since %s', date( "Y", strtotime( $registered ) ) );?></p>
                                <?php /*
                                <p><span class="bold_span"><?php echo count( $colleagues ) -1;?></span> colleagues</p>
                                */ ?>
                                <p>
                                    <span class="bold_span"><?php echo $downloads_left;?></span>
                                    <?php echo esc_html__( "content downloads this month", "dkng" );?>
                                </p>

                                <?php $class = ( $sendgrid_step > 3 ) ? "disabled" : "" ?>
                                <p>
                                    <a href="" class="sendgrid_popup_btn <?php echo $class;?>"
                                       data-step="<?php echo $sendgrid_step;?>" data-domain-id="<?php echo $sendgrid_domain_id;?>" data-sender-id="<?php echo $sendgrid_sender_id;?>">
                                        <?php echo esc_html__( "Connect Your Email Domain", "dkng" );?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="settings">
                        <div class="row">
                            <div class="col-12 ">
                                <div class="settings-accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <div class="col-12 pl-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                        data-target="#acc-info-1" aria-expanded="false"
                                                        aria-controls="acc-info-1">
                                                    <?php echo esc_html__("Settings", "dkng");?>
                                                    <i class="fa fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="acc-info-1" class="collapse">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form id="account-info" method="post">
                                                            <div class="row">
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "First Name *", "dkng" );?></label>
                                                                    <input type="text" class="form-control" name="first_name" required
                                                                           placeholder="<?php echo __( "First Name", "dkng" );?>"
                                                                           value="<?php echo $user->user_firstname;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <label for="timezone_string" class="timezone_string_label"><?php echo __( "Timezone", "dkng" );?></label>
                                                                    <select id="timezone_string" name="timezone_string" aria-describedby="timezone-description">
                                                                        <?php echo wp_timezone_choice( $user_timezone, get_user_locale() ); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Last Name *", "dkng" );?></label>
																	<input type="text" class="form-control" name="last_name" required
                                                                           placeholder="<?php echo __( "Last Name", "dkng" );?>"
                                                                           value="<?php echo $user->user_lastname;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Email Sender Name *", "dkng" );?></label>
																	<input type="text" class="form-control" name="name" required
                                                                       placeholder="<?php echo __( "Email Sender Name", "dkng" );?>"
                                                                       value="<?php echo $company_name;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Position *", "dkng" );?></label>
																	<input type="text" class="form-control" name="job-title" required
                                                                       placeholder="<?php echo __( "Position", "dkng" );?>"
                                                                       value="<?php echo $position;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Email *", "dkng" );?></label>
																	<input type="email" class="form-control" name="email" required
                                                                       placeholder="<?php echo __( "Email", "dkng" );?>"
                                                                       value="<?php echo $email; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Phone *", "dkng" );?></label>
																	<input type="text" class="form-control" name="phone" required
                                                                       placeholder="<?php echo __( "Phone", "dkng" );?>"
                                                                       value="<?php echo $phone; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Your Website *", "dkng" );?></label>
																	<input type="text" class="form-control" name="custom_site" required
                                                                       placeholder="<?php echo __( "Your Website", "dkng" );?>"
                                                                       value="<?php echo $custom_site;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Facebook", "dkng" );?></label>
																	<input type="text" class="form-control" name="fb_link"
                                                                       placeholder="<?php echo __( "Facebook", "dkng" );?>"
                                                                       value="<?php echo $fb_link;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Twitter", "dkng" );?></label>
																	<input type="text" class="form-control" name="tw_link"
                                                                       placeholder="<?php echo __( "Twitter", "dkng" );?>"
                                                                       value="<?php echo $tw_link;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Linkedin", "dkng" );?></label>
																	<input type="text" class="form-control" name="lnkd_link"
                                                                       placeholder="<?php echo __( "Linkedin", "dkng" );?>"
                                                                       value="<?php echo $lkdn_link; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "YouTube", "dkng" );?></label>
																	<input type="text" class="form-control" name="ytb_link"
                                                                       placeholder="<?php echo __( "YouTube", "dkng" );?>"
                                                                       value="<?php echo $ytb_link; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <label for="" class="account-info-label"><?php echo __( "Meeting Calendar", "dkng" );?></label>
                                                                    <input type="text" class="form-control" name="meet_link"
                                                                           placeholder="<?php echo __( "Meeting Calendar", "dkng" );?>"
                                                                           value="<?php echo $meet_link; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Legal Company Address", "dkng" );?></label>
																	<input type="text" class="form-control" name="sendgrid_address" required
                                                                           placeholder="<?php echo __( "Legal Company Address", "dkng" );?>"
                                                                           value="<?php echo $sendgrid_address; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "City *", "dkng" );?></label>
																	<input type="text" class="form-control" name="sendgrid_city" required
                                                                           placeholder="<?php echo __( "City", "dkng" );?>"
                                                                           value="<?php echo $sendgrid_city; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Country *", "dkng" );?></label>
																	<input type="text" class="form-control" name="sendgrid_country" required
                                                                           placeholder="<?php echo __( "Country", "dkng" );?>"
                                                                           value="<?php echo $sendgrid_country; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <label for="" class="account-info-label"><?php echo __( "Wealthbox API Key", "dkng" );?></label>
                                                                    <input type="text" class="form-control" name="wealthbox_api_key"
                                                                           placeholder="<?php echo __( "Wealthbox API Key", "dkng" );?>"
                                                                           value="<?php echo $wealthbox_api_key; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <label for="" class="account-info-label"><?php echo __( "Email Signature Address", "dkng" );?></label>
                                                                    <input type="text" class="form-control" name="address" required
                                                                           placeholder="<?php echo __( "Email Signature Address", "dkng" );?>"
                                                                           value="<?php echo $address; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <label for="" class="account-info-label"><?php echo __( "Article Disclosure", "dkng" );?></label>
                                                                    <textarea type="text" class="form-control" name="article_disclosure"
                                                                           placeholder="<?php echo __( "Article Disclosure", "dkng" );?>"><?php echo $article_disclosure; ?></textarea>
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <label for="" class="account-info-label"><?php echo __( "Email Disclosure", "dkng" );?></label>
                                                                    <textarea type="text" class="form-control" name="email_disclosure"
                                                                           placeholder="<?php echo __( "Email Disclosure", "dkng" );?>"><?php echo $email_disclosure; ?></textarea>
                                                                </div>
                                                                <div class="col-12 col-md-10">
																	<label for="" class="account-info-label"><?php echo __( "Set New Password Here", "dkng" );?></label>
																	<input type="text" class="form-control" name="password"
                                                                       placeholder="<?php echo __( "Set New Password Here", "dkng" );?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="submit" value="<?php echo __( "Save", "dkng" );?>"
                                                                       class="save_button_profile" >
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <img src="./dist/img/loader.gif" id="loader"
                                                             class="loader_style_settings_profile" alt="loader"  />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <div class="col-12 pl-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#acc-info-2" aria-expanded="false" aria-controls="acc-info-2">
                                                    <?php echo esc_html__("Contact Us", "dkng");?>
                                                    <i class="fa fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="acc-info-2" class="collapse">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-10">
                                                        <a href="mailto:info@sdsggs.com" target="_blank" rel="nofollow">info@fff.ocom</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="card">
										<div class="card-header" id="headingThree">
											<div class="col-12 pl-0">
												<a href="<?php echo home_url('/history-of-invoices/'); ?>"><?php echo esc_html__("History of Invoices", "dkng");?></a>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p><?php echo esc_html__("Seven Group 2019", "dkng");?> -
                            <a href="/privacy-policy/"><?php echo esc_html__( "Privacy Policy", "dkng" );?></a>
                            -
                            <a href="/privacy-policy/"><?php echo esc_html__( "Terms of Service", "dkng" );?></a>
                        </p>
                    </div>
                    <div class="mt-3">
                        <p>
                            <a href="<?php echo wp_logout_url(); ?>" class="logout_button">
                                <?php echo esc_html__("Logout", "dkng");?>
                            </a>
                        </p>
                    </div>
                </div>
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
