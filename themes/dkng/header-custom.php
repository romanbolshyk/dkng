<?php
$template_dir = get_template_directory_uri();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo get_the_title( )?></title>
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

    <link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

</head>

<body  <?php body_class();?>>

    <div class="header_container">
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
                         'walker'         => new My_Walker_Mobile_Header_Menu(),
                    ) ); ?>
            </div>
        </div>

        <div class="c-header">
            <div class="c-header__bg" style="background: url(<?php echo get_field('header_background', 'option')?>) 100% 100%;  background-size: contain;">
                <div class="c-header__top container">
                    <div class="c-header__top--left">
                        <div class="c-header__logo">
                            <a href="<?php echo home_url();?>">
                                <img src="<?php echo get_field('logo_image', 'option') ;?>" alt="logo">
                            </a>
                        </div>

                        <div class="c-header__name">
                            <h2 class="c-header__title"><?php echo strtoupper( get_field('logo_text', 'option') );?></h2>
                            <h2 class="c-header__subtitle"><?php echo strtoupper( get_field('logo_text_english', 'option') );?></h2>
                        </div>
                    </div>

                    <div class="c-header__info">
                        <div class="c-header__info--item">
                            <span>e-mail:</span>
                            <span><?php echo get_field('email', 'option') ;?></span>
                        </div>

                        <div class="c-header__info--item">
                            <span>skype:</span>
                            <span><?php echo get_field('skype', 'option') ;?></span>
                        </div>

                        <div class="c-header__info--item">
                            <span>тел.:</span>
                            <span><?php echo get_field('phone', 'option') ;?></span>
                        </div>

                        <div class="c-header__info--item">
                            <span>приймальна комісія:</span>
                            <span><?php echo get_field('commision_phone', 'option') ;?></span>
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
                <div class="c-header__menu--container container">
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

                        <div class="c-header__search--form js-search-form">
                            <?php echo do_shortcode('[wpdreams_ajaxsearchpro id=1]'); ?>

                            <div class="c-header__search--btn js-search-close">
                               <i class="fa fa-times" aria-hidden="true"></i>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>