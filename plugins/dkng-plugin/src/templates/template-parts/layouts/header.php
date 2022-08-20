<?php
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
$tw_link      =  get_field( 'twitter_link', 'user_' . $user->ID );
$lkdn_link    =  get_field( 'linkedin_link', 'user_' . $user->ID );
$ytb_link     =  get_field( 'youtube_link', 'user_' . $user->ID );
$subscribers  =  get_users( array ( 'role'=>'subscriber' ) );
$colleagues   =  array();
foreach ( $subscribers as $subscriber ) {
    $company_subscriber =  get_field( 'name',    'user_' . $subscriber->ID );
    if ( $company_name == $company_subscriber ) {
        $colleagues[] = $subscriber->ID;
    }
}

$udata        = get_userdata( $user->ID );
$registered   = $udata->user_registered;

$completed_courses = get_user_meta( $user->ID, 'completed_courses' );
$count_completed   = ( $completed_courses[0] ) ? count( $completed_courses[0] ) : 0;
$courses           = new WP_Query( array( 'post_type' => 'courses',  'posts_per_page' => -1  ) );
wp_enqueue_script("jquery");
wp_head();

$upload_dir = wp_upload_dir();

$file_name  = get_user_meta( $user->ID, 'avatar', true );
$fileurl    = $upload_dir['path'] . '/' . $file_name;
$filepath   = $upload_dir['url'] . '/' . $file_name;
$fileurl    = ( file_exists( $fileurl ) ) ? $filepath : "./dist/img/info-img.png";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Seven Group</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Seven Group">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?php echo $template_dir; ?>/">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $template_dir; ?>/favicon.ico">
        <link rel="icon" type="image/x-icon"  href="<?php echo $template_dir; ?>/favicon.ico">
    </head>
    <body>
    
        <div class="super_container">

            <div class="dashboard-page">

                <header class="header white-header" id="header">
                    <div>
                        <div class="header_top">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-1 col-sm-3 d-block d-md-none d-flex align-items-center justify-content-center flex-row">
                                        <div class="hamburger-left mr-auto"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="col-2 col-sm col-md dashboard_top_content logo-holder d-flex flex-row align-items-center justify-content-md-start justify-content-left min-left">
                                        <a href="<?php echo get_site_url(); ?>/admin-dashboard/">
                                            <img src="./dist/img/logo_c.svg" id="logo_style_image" >
                                        </a>
                                        <p id="welcome_p"><?php echo esc_html__("Welcome", "dkng");?>, <?php echo $user->user_nicename;?></p>
                                    </div>
                                    <div class="col-7 col-sm col-md">

                                        <div class="row dashboard_top_content d-flex flex-row align-items-center justify-content-end">
                                            <div class="col-10 col-md-8 col-lg-6 border-left d-flex flex-row align-items-center justify-content-end">
                                                <?php if ( is_user_logged_in() ) { ?>
                                                    <img src="<?php echo $fileurl;?>"  alt="oval" class="logo_main logo_main_style "/>
                                                    <div class="name-holder">
                                                        <p class="bold"><?php echo $user->user_nicename; ?></p>
                                                        <p><?php echo $name;?></p>
                                                    </div>
                                                    <a class="user-info" href="#"><i class="fa fa-angle-down"></i></a>
                                                <?php  } else { ?>
                                                    <h3><a href="<?php echo get_site_url();?>/advisorlogin">Log in</a></h3>
                                                <?php } ?>
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
                                        <input type="file" required name="user_image" id="user_image" value="Upload New" >
                                    </div>
                                </form>
                                <img src="./dist/img/loader.gif"  id="loader-image" alt="loader" />
                            </div>
                            <div class="col-12 col-md-8">
                                <h3><?php echo $name; ?></h3>
                                <p><?php echo $company_name; ?></p>
                                <p><?php echo $position;?></p>
                            </div>
                            <div class="col-12 col-md-8">
                                <p><?php echo $email;?></p>
                                <p class="big"><?php echo esc_html__("Connected Accounts", "dkng");?></p>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <a class="social-link" href="<?php echo $lkdn_link;?>"><i class="fa fa-linkedin"></i></a>
                                    <a class="social-link" href="<?php echo $tw_link;?>"><i class="fa fa-twitter"></i></a>
                                    <a class="social-link" href="<?php echo $fb_link;?>"><i class="fa fa-facebook"></i></a>
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
                                        <?php echo $count_completed; ?> <?php echo esc_html__("out of", "dkng");?> <?php echo count($courses->posts); ?>
                                    </span>
                                    <?php echo esc_html__("lessons completed", "dkng");?>
                                </p>
                                <p><?php echo sprintf( 'Joined since %s', date( "Y", strtotime( $registered ) ) );?></p>
                                <p><span class="bold_span"><?php echo count( $colleagues ) -1;?></span> colleagues</p>
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
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#acc-info-1" aria-expanded="false" aria-controls="acc-info-1">
                                                    <?php echo esc_html__("Settings", "dkng");?>
                                                    <i class="fa fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div id="acc-info-1" class="collapse">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12 col-md-9">
                                                        <p class="big"><?php echo $company_name; ?></p>
                                                        <p><?php echo $position;?></p>
                                                        <p><?php echo $phone;?></p>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form id="account-info" method="post">
                                                            <div class="row">
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="name" placeholder="company_name" value="<?php echo $company_name;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="job-title" placeholder="position" value="<?php echo $position;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="email" class="form-control" name="email" placeholder="email" value="<?php echo $email; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="phone" placeholder="phone" value="<?php echo $phone; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="fb_link" placeholder="facebook_link" value="<?php echo $fb_link;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="tw_link" placeholder="twitter link" value="<?php echo $tw_link;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="lnkd_link" placeholder="linkedin link" value="<?php echo $lkdn_link; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="ytb_link" placeholder="youtube link" value="<?php echo $ytb_link; ?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="password" placeholder="Set new password here.">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="first_name" placeholder="First name." value="<?php echo $user->user_firstname;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="text" class="form-control" name="last_name" placeholder="Last name." value="<?php echo $user->user_lastname;?>">
                                                                </div>
                                                                <div class="col-12 col-md-10">
                                                                    <input type="submit" value="Save" class="save_button_profile" >
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <img src="./dist/img/loader.gif"  id="loader" class="loader_style_settings_profile" alt="loader"  />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <div class="col-12 pl-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#acc-info-2" aria-expanded="false" aria-controls="acc-info-2">
                                                    <?php echo esc_html__("Contact us", "dkng");?>
                                                    <i class="fa fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="acc-info-2" class="collapse">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-10">
                                                        <a href="mailto:info@іваів.com" target="_blank" rel="nofollow">info@dsfsd.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p><a href="/privacy-policy/"><?php echo esc_html__("Seven Group 2019 - Privacy Policy - Terms of Service", "dkng");?></a></p>
                    </div>
                    <div class="mt-3">
                        <p><a href="<?php echo wp_logout_url(); ?>"><?php echo esc_html__("Logout", "dkng");?></a></p>
                    </div>
                </div>
            </div>
      
            <div class="main-content">
                <div class="left-menu">
                    <div class="menu_left_close">
                        <div class="menu_close"></div>
                    </div>
                    <ul class="main_tabs">
                        <li class="nav-item">
                            <a class="home_tab nav-link d-flex flex-row justify-content-start align-items-center"
                                href="<?php echo get_site_url(); ?>/admin-dashboard">
                                <i class="fa fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center content_tab"
                                href="<?php echo get_site_url(); ?>/admin-content">
                                <i class="fa fa-list"></i> Content
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-row justify-content-start align-items-center training_tab"
                                href="<?php echo get_site_url(); ?>/admin-training">
                                <i class="fa fa-book"></i> Training
                            </a>
                        </li>
                    </ul>

                    <div class="logo_bottom">
                        <a href="<?php echo get_site_url(); ?>"><img src="./dist/img/icon-logo.png"></a>
                    </div>
                </div>
            <div class="right-content">
