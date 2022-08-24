<?php

$bottom_popup_image    = get_field( 'bottom_popup_image',       'options');
$bottom_popup_image_id = get_image_id($bottom_popup_image);
$bottom_popup_image_alt = get_post_meta($bottom_popup_image_id, '_wp_attachment_image_alt', TRUE);

$bottom_popup_text1    = get_field( 'bottom_popup_text1',       'options');
$bottom_popup_text2    = get_field( 'bottom_popup_text2',       'options');
$bottom_popup_btn_name = get_field( 'bottom_popup_button_name', 'options');
$bottom_popup_btn_link = get_field( 'bottom_popup_button_link', 'options');

$exit_popup_image      = get_field( 'exit_popup_image',             'options');
$exit_popup_image_id = get_image_id($exit_popup_image);
$exit_popup_image_alt = get_post_meta($exit_popup_image_id, '_wp_attachment_image_alt', TRUE);

$exit_popup_text1      = get_field( 'exit_popup_text1',             'options');
$exit_popup_text2      = get_field( 'exit_popup_text2',             'options');
$exit_popup_email_txt  = get_field( 'exit_popup_email_placeholder', 'options');
$exit_popup_btn_name   = get_field( 'exit_popup_button_name',       'options');
$exit_popup_cancel_txt = get_field( 'exit_popup_cancel_text',       'options');

$bottom_popup_image    = !empty( $bottom_popup_image )    ? $bottom_popup_image    : '';
$bottom_popup_text1    = !empty( $bottom_popup_text1 )    ? $bottom_popup_text1    : '';
$bottom_popup_text2    = !empty( $bottom_popup_text2 )    ? $bottom_popup_text2    : '';
$bottom_popup_btn_name = !empty( $bottom_popup_btn_name ) ? $bottom_popup_btn_name : '';
$bottom_popup_btn_link = !empty( $bottom_popup_btn_link ) ? $bottom_popup_btn_link : '';

$exit_popup_image      = !empty( $exit_popup_image )      ? $exit_popup_image      : '';
$exit_popup_text1      = !empty( $exit_popup_text1 )      ? $exit_popup_text1      : '';
$exit_popup_text2      = !empty( $exit_popup_text2 )      ? $exit_popup_text2      : '';
$exit_popup_email_txt  = !empty( $exit_popup_email_txt )  ? $exit_popup_email_txt  : '';
$exit_popup_btn_name   = !empty( $exit_popup_btn_name )   ? $exit_popup_btn_name   : '';
$exit_popup_cancel_txt = !empty( $exit_popup_cancel_txt ) ? $exit_popup_cancel_txt : '';

$logo                  = get_field('logo_image', 'options');
?>

<!-- <div class="footer" style="background: url(<?php echo get_field('header_background', 'option')?>) 100% 100%;  background-size: contain;">
    <div class="default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12 col-md-12">
                    <a href="<?php echo get_site_url();?>"><img src="<?php echo $logo;?>" style="height: 100px;  width: auto;" alt="footer logo" /></a>
                    <p>
                        <?php echo esc_html__("3 Park Avenue, 36th Floor", "dkng");?><br/>
                        <?php echo esc_html__("New York, NY 10016", "dkng");?>
                    </p>
                </div>
                <div class="col-lg-8  col-xs-12 col-md-12 menus_footer">
                    <ul class="d-flex justify-content-between">
                        <li>
                            <span class="a"><?php echo esc_html( "Seven Group", "dkng");?></span>
                            <?php wp_nav_menu( [
                                'container'      => '',
                                'theme_location' => 'seven_group',
                                'items_wrap'     => '<ul>%3$s</ul>',
                                'walker'         => new My_Walker_Mobile_Menu(),
                            ] ); ?>
                        </li>
                        <li>
                            <span class="a"><?php echo esc_html( "Advisors", "dkng");?></span>
                            <?php wp_nav_menu( [
                                'container'      => '',
                                'theme_location' => 'advisors_group',
                                'items_wrap'     => '<ul>%3$s</ul>',
                                'walker'         => new My_Walker_Mobile_Menu(),
                            ] ); ?>
                        </li>
                        <li>
                            <span class="a"><?php echo esc_html( "Resources", "dkng");?></span>
                            <?php wp_nav_menu( [
                                'container'      => '',
                                'theme_location' => 'resources_group',
                                'items_wrap'     => '<ul>%3$s</ul>',
                                'walker'         => new My_Walker_Mobile_Menu(),
                            ] ); ?>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="separator"></div>
                <div class="col-lg-4 col-xs-12 col-md-12">
                    <p class="copyright"><?php echo esc_html__( "Copyright © 2022  Group, LLC. All rights reserved.", "dkng" );?></p>
                </div>
                <div class="separator"></div>
            </div>
        </div>

    </div>
</div> -->





<div class="c-footer" style="background: url(<?php echo get_field('header_background', 'option')?>) 100% 100%;  background-size: contain;">
    <div class="container">
        <div class="c-footer__top">
            <div class="c-footer__left">
                <div class="c-footer__logo">
                    <a href="<?php echo get_site_url();?>">
                        <img src="<?php echo $logo;?>" alt="footer logo" />
                    </a>
                </div>

                <div class="c-footer__info">
                    <span class="c-footer__info--item">
                        82100, Україна, Львівська обл.
                    </span>
                    <span class="c-footer__info--item">
                        м. Дрогобич, вул. Грушевського, 57
                    </span>
                    <span class="c-footer__info--item">
                        тел.: +38 0324438969,
                    </span>
                    <span class="c-footer__info--item">
                        приймальна комісія: +38 0681245325
                    </span>
                    <span class="c-footer__info--item">
                        e-mail: dkng@ukr.net
                    </span>
                    <span class="c-footer__info--item">
                        skype: dkng_drohobych
                    </span>
                </div>
            </div>


            <div class="c-footer__right">
                <div class="c-footer__gallery">
                    <a href="#" class="c-footer__gallery--item">
                        <img src="https://www.dkng.net.ua/images/banners/MON.png" alt="">
                    </a>
                    <a href="#" class="c-footer__gallery--item">
                        <img src="https://www.dkng.net.ua/images/banners/baner2.jpg" alt="">
                    </a>
                    <a href="#" class="c-footer__gallery--item">
                        <img src="https://www.dkng.net.ua/images/banners/baner3.jpg" alt="">
                    </a>
                    <a href="#" class="c-footer__gallery--item">
                        <img src="https://www.dkng.net.ua/images/banners/krasnj.png" alt="">
                    </a>
                </div>
            </div>
        </div>

        <div class="row- c-footer__copyright">
            <div class="separator"></div>

            <span><?php echo esc_html__( "2022 Дрогобицький фаховий коледж нафти і газу / Drogobych Applied College of Oil and Gas", "dkng" );?></span>
        </div>
    </div>   
</div>




<?php wp_footer();?>
</body>
</html>
