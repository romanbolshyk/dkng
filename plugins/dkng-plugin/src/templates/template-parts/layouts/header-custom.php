<?php
$current_url  = $_SERVER['REQUEST_URI'];
$template_dir = get_template_directory_uri();
$user         = wp_get_current_user();
$name         = $user->user_firstname . ' ' . $user->user_lastname;
$displayname  = $user->display_name;


$udata        = get_userdata( $user->ID );
$registered   = $udata->user_registered;

wp_enqueue_script("jquery");
wp_head();

$upload_dir = wp_upload_dir();

$file_name  = get_user_meta( $user->ID, 'avatar', true );
$fileurl    = $upload_dir['path'] . '/' . $file_name;
$filepath   = $upload_dir['url'] . '/' . $file_name;
$fileurl    = ( file_exists( $fileurl ) ) ? $filepath : "./dist/img/info-img.png";

$body_class = ( ( strpos( $current_url, 'login' ) ) || ( strpos( $current_url, 'contact' ) )  ) ? "profile-page" : '';

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


<body class="<?php echo $body_class;?>" >

<div class="super_container">

    <div class="menu trans_500">
        <div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
            <div class="menu_close_container"><div class="menu_close"></div></div>
                <?php wp_nav_menu( [
                    'container'      => '',
                    'theme_location' => 'primary',
                    'items_wrap'     => '<ul>%3$s</ul>',
                    'walker'         => new My_Walker_Mobile_Menu(),
                ] ); ?>
        </div>
    </div>

    <?php
        $class = ( is_front_page() ) ? "home" : "inner-page";
        $image = ( is_front_page() ) ? "header" : "";
        if ( strpos( $current_url, 'about-us' ) ) {
            $image = "about-top";
        }
        if ( strpos( $current_url, 'services' ) ) {
            $image = "services-hero";
        }
        if ( strpos( $current_url, 'contact' ) ) {
            $class .=  ' profile';
        }
        if ( strpos( $current_url, 'blog' ) ) {
            $class .= ' blog-inner profile';
        }
        else if ( strpos( $current_url, 'login' ) ) {
            $class .= ' profile profile-page';
        }

        if ( is_single() ) {
            $image = "single";
        }

        $logo_image = ( strpos( $current_url, 'services' ) || strpos( $current_url, 'about' ) || is_single() ) ? "logo_white.svg" : "logo_c.svg";
    ?>

    <div class="<?php echo $class;?>">
        <div class="background_image" style="background-image:url(./dist/img/<?php echo $image;?>.png)"></div>

        <!-- Header -->
        <header class="header" id="header">
            <div>
                <div class="header_top">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="header_top_content d-flex flex-row align-items-center justify-content-start">
                                    <div class="logo">
                                        <a href="<?php echo get_site_url();?>">
                                            <img src="./dist/img/<?php echo  $logo_image;?>"/>
                                        </a>
                                    </div>
                                    <div class="header_top_extra d-flex flex-row align-items-center justify-content-start ml-auto">
                                        <div class="header_top_nav">
                                            <ul class="d-flex flex-row align-items-center justify-content-start">
                                                <?php wp_nav_menu( [
                                                    'theme_location' => 'primary',
                                                    'walker'         => new My_Walker_Nav_Menu(),
                                                    'items_wrap'     => '<ul class="d-flex flex-row align-items-center justify-content-start"><li class="a_%2$s_block"></li>%3$s</ul>'
                                                ] ); ?>
<!--                                                <li><a href="--><?php //echo get_site_url();?><!--/about" class="a_about_block">About</a></li>-->
<!--                                                <li><a href="--><?php //echo get_site_url();?><!--/services" class="a_services_block">Services</a></li>-->
<!--                                                <li><a href="--><?php //echo get_site_url();?><!--/blog" class="a_blog_block">Blog</a></li>-->
<!--                                                <li><a href="--><?php //echo get_site_url();?><!--/contact" class="a_contact_block">Contact Us</a></li>-->
<!--                                                <li><a href="--><?php //echo get_site_url();?><!--/login" class="btn btn-primary login ">Login</a></li>-->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="hamburger ml-auto"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>