<?php
$current_url  = $_SERVER['REQUEST_URI'];
$template_dir = get_template_directory_uri();
$user         = wp_get_current_user();
$name         = $user->user_firstname . ' ' . $user->user_lastname;
$displayname  = $user->display_name;

$udata        = get_userdata( $user->ID );
if ( !empty( $udata ) ) {
    $registered   = $udata->user_registered;
}

$upload_dir = wp_upload_dir();

$file_name  = get_user_meta( $user->ID, 'avatar', true );
//$fileurl    = $upload_dir['path'] . '/' . $file_name;
//$filepath   = $upload_dir['url'] . '/' . $file_name;
$fileurl      = $upload_dir['basedir'] . '/' . $file_name;
$filepath     = $upload_dir['baseurl'] . '/' . $file_name;
$fileurl    = ( file_exists( $fileurl ) ) ? $filepath : "./dist/img/info-img.png";

global $post;
$looged_in  = ( is_user_logged_in() ) ? 'yes' : 'no';

/*
$id_post    = get_the_ID();
$post_image = !empty( $id_post ) ? get_the_post_thumbnail_url( $id, 'medium' ) : '';
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5B5XRPG');</script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-155268703-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-155268703-1');
    </script>

    <title><?php wp_title(''); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo $template_dir; ?>/">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $template_dir; ?>/favicon.ico">
    <link rel="icon" type="image/x-icon"  href="<?php echo $template_dir; ?>/favicon.ico">
    <?php wp_head(); ?>
    <script>
        (function (jQuery) {
            window.$ = jQuery.noConflict();
        })(jQuery);
    </script>
</head>

<body  <?php body_class();?>>

    <script> (function(){ var s = document.createElement('script'); var h = document.querySelector('head') || document.body; s.src = 'https://acsbapp.com/apps/app/dist/js/app.js'; s.async = true; s.onload = function(){ acsbJS.init({ statementLink : '', footerHtml : '', hideMobile : false, hideTrigger : false, disableBgProcess : false, language : 'en', position : 'left', leadColor : '#00C7C7', triggerColor : '#00C7C7', triggerRadius : '50%', triggerPositionX : 'left', triggerPositionY : 'bottom', triggerIcon : 'people', triggerSize : 'bottom', triggerOffsetX : 20, triggerOffsetY : 20, mobile : { triggerSize : 'small', triggerPositionX : 'left', triggerPositionY : 'bottom', triggerOffsetX : 20, triggerOffsetY : 20, triggerRadius : '20' } }); }; h.appendChild(s); })(); </script>


    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5B5XRPG"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="super_container">
        <div class="preloader">
            <div class="preloader__row">
                <div class="preloader__item"></div>
                <div class="preloader__item"></div>
            </div>
        </div>
        <div class="menu trans_500">
            <div class="menu_content d-flex flex-column align-items-center justify-content-center text-center">
                <div class="menu_close_container"><div class="menu_close"></div></div>
                    <?php wp_nav_menu( array(
                        'container'       => '',
                        'theme_location'  => 'primary',
                        'items_wrap'      => '<ul class="mobile_menu">%3$s</ul>',
    //                    'walker'         => new My_Walker_Mobile_Menu(),
                         'walker'         => new My_Walker_Mobile_Header_Menu(),
                    ) ); ?>
            </div>
        </div>
        <?php

            $class  = ( is_front_page() ) ? "home" : "inner-page";
            $image  = ( is_front_page() ) ? "header.png" : "";
            $mobile = '';

        ?>

        <!-- <div class="header_blocl <?php echo $class;?> without_banner"> -->
            <!-- Header -->
            <!-- <header class="header <?php echo $mobile;?>" id="header" data-logged="<?php echo $looged_in;?>" data-base="<?php echo site_url(); ?>">
                <div>
                    <div class="header_top">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="header_top_content d-flex flex-row align-items-center justify-content-start">
                                        <div class="logo">
                                            <a href="<?php echo get_site_url();?>">
                                                <img src="./dist/img/<?php echo $logo_image;?>" alt="logo" class="logo-desktop"/>
                                                <img src="./dist/img/<?php echo $logo_mobile;?>" alt="logo-mobile" class="logo-mobile"/>
                                            </a>
                                        </div>
                                        <div class="header_top_extra d-flex flex-row align-items-center justify-content-start ml-auto">
                                            <div class="header_top_nav">
                                                <ul class="d-flex flex-row align-items-center justify-content-start">
                                                    <?php wp_nav_menu( array(
                                                        'theme_location' => 'primary',
                                                        'walker'         => new My_Walker_Nav_Menu(),
                                                        'items_wrap'     => '<ul class="d-flex flex-row align-items-center justify-content-start"><li class="a_%2$s_block"></li>%3$s</ul>'
                                                    ) ); ?>
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
            </header> -->
        <!-- </div> -->




<div class="c-header">
    <div class="c-header__bg">
        <div class="c-header__top container">           
            <div class="c-header__top--left">
                <div class="c-header__logo">
                    <img src="https://www.dkng.net.ua/templates/nafta/images/logo2020.png" alt="logo">
                </div>

                <div class="c-header__name">
                    <h2 class="c-header__title">ДРОГОБИЦЬКИЙ ФАХОВИЙ КОЛЕДЖ НАФТИ І ГАЗУ</h2>
                    <h2 class="c-header__subtitle">DROGOBYCH APPLIED COLLEGE OF OIL AND GAS</h2>
                </div>
            </div>       
        
            <div class="c-header__info">
                <div class="c-header__info--item">
                    <span>e-mail:</span>
                    <span>dkng@ukr.net</span>
                </div>

                <div class="c-header__info--item">
                    <span>skype:</span>
                    <span>dkng_drohobych</span>
                </div>

                <div class="c-header__info--item">
                    <span>тел.:</span>
                    <span>+38 0324438969</span>
                </div>

                <div class="c-header__info--item">
                    <span>приймальна комісія:</span>
                    <span>+38 0681245325</span>
                </div>

                <div class="c-header__social">
                    <a href="#" target="_blank" class="c-header__social--item">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>

                    <a href="#" target="_blank" class="c-header__social--item">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>

                    <a href="#" target="_blank" class="c-header__social--item">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="c-header__menu">
        <div class="c-header__nav-toggle js-burger"></div>

        <div class="c-header__menu--overlay js-close-nav"></div>

        <nav>
            <span class="c-header__menu--close js-close-nav">✕</span>

            <?php wp_nav_menu( array(
                'theme_location' => 'primary',
                'walker'         => new My_Walker_Nav_Menu(),
                'items_wrap'     => '<ul><li class="a_%2$s_block"></li>%3$s</ul>'
            ) ); ?>
        </nav>

        <div class="c-header__search">
            <div class="c-header__search--btn js-search-open">
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>

            <form class="c-header__search--form js-search-form">
                <input type="text" placeholder="Search">
                
                <div class="c-header__search--btn js-search-close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </form>
        </div>  
    </div>
</div>