<?php
//if ( !is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/advisorlogin' );
//    exit;
//}


get_header('custom');

$first_block        = get_field( 'first_block');
$social_proof_block = get_field('social_proof_block');
$video_block        = get_field( 'video_block');
$philosophy_block   = get_field( 'philosophy_block');
$platform_block     = get_field( 'the_platform_block');

$pricing_block    = get_field('pricing_group', 'option');
if ( $pricing_block['interested_block'] ){
    $interested_title  = $pricing_block['interested_block']['title'];
    $interested_button = $pricing_block['interested_block']['button_title'];
    $interested_link   = $pricing_block['interested_block']['button_link'];
}

$contact_forms_ids = ['basic_inquiry', 'business_plus_inquiry', 'business_inquiry'];
?>

<?php if ( $first_block ) { ?>
    <div class="home_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content">
                        <div class="col-lg-6 col-sm-12">
                            <h1 style="
              <?php if ( $first_block['title_font_size'] ) echo 'font-size:'.$first_block['title_font_size'].'px;';?>
              <?php if ( $first_block['title_font_weight'] ) echo 'font-weight:'.$first_block['title_font_weight'].';';?>"   ><?php if ( $first_block['first_text'] ) echo $first_block['first_text'];?></h1>
                            <a href="<?php if ( $first_block['first_page_link']['url'] ) echo $first_block['first_page_link']['url'];?>" target="<?php if ( $first_block['first_page_link']['target'] ) echo $first_block['first_page_link']['target'];?>" class="btn btn-primary"><?php if ( $first_block['first_page_link']['title'] ) echo $first_block['first_page_link']['title'];?></a>
                        </div>
                        <div class="video-holder video-holder-home" style="background: url(<?php if ( $first_block['first_image'] ) echo $first_block['first_image'];?>);"><a></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    </div>

<?php if ( $social_proof_block ) : ?>
    <div class="default-padding sv-social-proof">
        <div class="container container-wide">
            <?php if ( !empty( $social_proof_block['title'] ) ) : ?>
                <div class="row">
                    <div class="col-12 col-lg-10 mx-auto text-center">
                        <h2 class="sv-social-proof__title">
                            <span><?php echo $social_proof_block['title'] ?></span>
                        </h2>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( !empty( $social_proof_block['images'] ) ) : ?>
                <div class="row justify-content-center justify-content-sm-start justify-content-lg-center">
                    <?php
                    $images_count = count( $social_proof_block['images'] );
                    foreach ( $social_proof_block['images'] as $k => $image ) : ?>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
                            <div class="sv-social-proof__img">
                                <img src="<?php echo esc_attr( $image['url'] ); ?>"
                                     alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                     class="<?php echo $k === $images_count - 1 ? 'last' : ''; ?>"
                                >
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php if ( $video_block ) { ?>
    <div class="default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center text-lg-left mb-lg-0 mb-4">
                    <div class="home-video-container" >
                        <?php if ( strstr( $video_block['video_link'], 'vimeo' ) ) { ?>
                            <div id="video_module_block"
                                 style='width:640px; height:390px'
                                 data-vimeo-url="<?php echo $video_block['video_link'];?>"
                                 data-video-current-seconds="0">
                            </div>
                        <?php } else { ?>
                            <iframe width="640" height="390" frameborder="0" title="YouTube video player" type="text/html" src="<?php if ( $video_block['video_text'] ) echo $video_block['video_link'];?>"></iframe>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img src="./dist/img/ptrn-seven-color-1.svg" alt="seven icon"/>
                    <h2><?php if ( $video_block['title'] ) echo $video_block['title'];?></h2>
                    <p class="bigger bigger_video_block" ><?php if ( $video_block['video_text'] ) echo $video_block['video_text'];?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ( $philosophy_block ) { ?>
    <div class="default-padding our-philosophy">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2><?php echo __( "Our Philosophy", "dkng" ); ?></h2>
                </div>
            </div>
            <?php if ( $philosophy_block && $philosophy_block['philosophies'] ) {

                foreach ( $philosophy_block['philosophies'] as $i => $philosophy ) {
                    if ( $i > 4 ) break;
                    if ( ( $i % 2 ) == 0 ) { ?>
                        <div class="row">
                    <?php  } ?>

                    <div class="col-lg-6">
                        <?php
                        $philosophy_img_id = get_image_id( $philosophy['image'] );
                        $philosophy_img_alt = get_post_meta($philosophy_img_id, '_wp_attachment_image_alt', TRUE);
                        ?>
                        <img src="<?php if ( $philosophy['image'] )  echo $philosophy['image']; ?>" alt="<?php echo esc_attr( $philosophy_img_alt ); ?>"/>
                        <h3><?php if ( $philosophy['title'] )  echo $philosophy['title']; ?></h3>
                        <p><?php if ( $philosophy['text'] )  echo $philosophy['text']; ?></p>
                    </div>

                    <?php if ( ( $i % 2 ) != 0 ) { ?>
                        </div>
                        <?php
                    }
                }
            } ?>
            <div class="row">
                <div class="col-lg-12">
                    <a href="<?php if ( $philosophy_block['page_link'] ) echo $philosophy_block['page_link'];?>"><?php echo __( "See More", "dkng" );?> <img src="./dist/img/arrow-right.png" alt="arrow right"/></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ( !empty( $pricing_block ) ) { ?>
    <div class="sv-pricing default-padding">
        <div class="sv-pricing__heading">
            <div class="container">
                <div class="row">
                    <div class="col-10 mx-auto text-center">
                        <span><?php echo $pricing_block['subtitle']; ?></span>
                        <h2><?php echo $pricing_block['title']; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                   <?php if($pricing_block['full_width_view'] !== true){ ?>
                        <div class="sv-pricing__content mx-auto">
                        <?php foreach ($pricing_block['pricing_blocks'] as $k => $block) :  ?>
                            <div class="sv-price">
                                <div class="sv-price__header text-center">
                                    <span class="sv-price__subtitle"><?php echo $block['description']; ?></span>
                                </div>
                                <?php if( !empty( $block['best_value'] ) ) : ?>
                                    <p class="sv-price__best">
                                        Best Value
                                    </p>
                                <?php endif; ?>
                                <div class="sv-price__body">
                                    <h3 class="sv-price__title text-center"><?php echo $block['title']; ?></h3>
                                    <p class="sv-price__price text-center"><?php echo $block['price']; ?></p>
                                    <span class="sv-price__payment-repeat text-center"><?php echo $block['payment_every']; ?></span>
                                    <div class="sv-price__button-wrapper">
                                        <a class="sv-price__button js-open-popup text-center" data-form="<?php echo $k + 2; ?>" href="#" rel="nofollow"><?php echo $block['button_title']; ?></a>
                                    </div>
                                    <?php if( !empty( $block['services'] ) ) : ?>
                                        <ul class="sv-price__list">
                                            <?php foreach($block['services'] as $service) : ?>
                                                <li class="sv-price__items">
                                                    <span><?php echo $service['title'] ?></span>
                                                    <ul class="sv-price__list-inner">
                                                        <?php foreach($service['items'] as $item) : ?>
                                                            <li class="sv-price__item"><?php echo $item['item']; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if( !empty( $block['note'] ) ) : ?>
                                        <p class="sv-price__note text-center"><?php echo $block['note']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="sv-contact-popup js-contact-popup" data-id="<?php echo $k + 2; ?>">
                                <h4 class="sv-contact-popup__title">Interested in learning more about the Seven platform?</h4>
                                <form action="" class="sv-contact-popup__form" id="<?php echo $contact_forms_ids[$k] ?>" name="<?php echo $contact_forms_ids[$k] ?>">
                                    <label>Company</label>
                                    <input type="text" name="company"/>

                                    <label>First Name*</label>
                                    <input type="text" name="name"  required/>

                                    <label>Last Name*</label>
                                    <input type="text" name="lastname"  required/>

                                    <label>Email</label>
                                    <input type="email" name="email" required/>

                                    <input type="submit" value="Schedule a call" class="btn btn-primary contact_submit"/>
                                </form>
                                <span class="close-popup">x</span>
                            </div>
                        <?php endforeach; ?>
                        </div>
                        <?php }?>
                        <?php if($pricing_block['full_width_view'] === true){ ?>
                        <div class="sv-pricing__content mx-auto sv-price-new">
                        <?php foreach ($pricing_block['pricing_blocks'] as $k => $block) :  ?>
                            <div class="sv-price ">
                                <div class="sv-price__header text-center">
                                    <span class="sv-price__subtitle"><?php echo $block['description']; ?></span>
                                </div>
                                <?php if( !empty( $block['best_value'] ) ) : ?>
                                    <p class="sv-price__best">
                                        Best Value
                                    </p>
                                <?php endif; ?>
                                <div class="sv-price__body">
                                    <div class="sv-price__body-left">
                                        <p class="sv-price__price text-center"><?php echo $block['price']; ?></p>
                                        <span class="sv-price__payment-repeat text-center"><?php echo $block['payment_every']; ?></span>
                                        <h5 class="sv-price__title text-center"><?php echo $block['title']; ?></h5>
                                    </div>
                                    <div class="sv-price__body-right">
                                        <?php if( !empty( $block['services'] ) ) : ?>
                                            <ul class="sv-price__list">
                                                <?php foreach($block['services'] as $service) : ?>
                                                    <li class="sv-price__items">
                                                        <span><?php echo $service['title'] ?></span>
                                                        <ul class="sv-price__list-inner">
                                                            <?php foreach($service['items'] as $item) : ?>
                                                                <li class="sv-price__item"><?php echo $item['item']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <div class="sv-price__button-wrapper">
                                            <a class="sv-price__button js-open-popup text-center" data-form="<?php echo $k + 2; ?>" href="#" rel="nofollow"><?php echo $block['button_title']; ?></a>
                                        </div>
                                        <?php if( !empty( $block['note'] ) ) : ?>
                                            <p class="sv-price__note text-center"><?php echo $block['note']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="sv-contact-popup js-contact-popup" data-id="<?php echo $k + 2; ?>">
                                <h4 class="sv-contact-popup__title">Interested in learning more about the Seven platform?</h4>
                                <form action="" class="sv-contact-popup__form" id="<?php echo $contact_forms_ids[$k] ?>" name="<?php echo $contact_forms_ids[$k] ?>">
                                    <label>Company</label>
                                    <input type="text" name="company"/>

                                    <label>First Name*</label>
                                    <input type="text" name="name"  required/>

                                    <label>Last Name*</label>
                                    <input type="text" name="lastname"  required/>

                                    <label>Email</label>
                                    <input type="email" name="email" required/>

                                    <input type="submit" value="Schedule a call" class="btn btn-primary contact_submit"/>
                                </form>
                                <span class="close-popup">x</span>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ( !empty( $platform_block ) ) {
    $more_text_platform = $platform_block['more_text']; ?>
    <div class="default-padding platform">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h2><?php if ( $platform_block['title'] ) echo $platform_block['title'];?></h2>
                    <p class="bigger"><?php if ( $platform_block['text'] ) echo $platform_block['text'];?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <?php if ( !empty( $more_text_platform ) ) {
                        foreach ($more_text_platform as $item) { ?>
                            <h3><?php if (!empty($item['title'])) echo $item['title']; ?></h3>
                            <p><?php if (!empty($item['text'])) echo $item['text']; ?></p>
                        <?php }
                    } ?>
                    <a href=" <?php if ( $platform_block['learn_more_link'] ) echo $platform_block['learn_more_link'];?>" class="read-more">
                        <?php if ( $platform_block['learn_more_text'] ) echo $platform_block['learn_more_text'];?>
                        <img src="./dist/img/arrow-right.png" alt="arrow right"/>
                    </a>
                </div>
                <?php
                $platform_img_id = get_image_id( $platform_block['image'] );
                $platform_img_alt = get_post_meta($platform_img_id, '_wp_attachment_image_alt', TRUE);
                ?>
                <img src="<?php if ( $platform_block['image'] ) echo $platform_block['image'];?>" class="position-absolute" alt="<?php echo esc_attr( $platform_img_alt ); ?>"/>
            </div>
        </div>
    </div>
<?php } ?>
<?php
get_footer('custom');
//get_footer();
wp_footer();
