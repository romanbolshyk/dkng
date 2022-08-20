<?php
get_header('custom');

$first_block      = get_field( 'first_block');
$model_block      = get_field( 'model_block');
$philosophy_block = get_field( 'philosophy_block');
$platform_block   = get_field( 'platform_block');
$dashboard_block  = get_field( 'dashboard_block');

$pricing_block    = get_field('pricing_group', 'option');
if ( $pricing_block['interested_block'] ){
    $interested_title  = $pricing_block['interested_block']['title'];
    $interested_button = $pricing_block['interested_block']['button_title'];
    $interested_link   = $pricing_block['interested_block']['button_link'];
}

$contact_forms_ids = ['basic_inquiry', 'business_plus_inquiry', 'business_inquiry'];

?>

    <div class="inner_container services_block platform_block">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <div class="inner_content">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                                <h4><?php if ( $first_block['title'] ) echo  strtoupper( $first_block['title'] );?></h4>

                                <h1><?php if ( $first_block['text'] ) echo  $first_block['text'];?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php if ( $model_block ) { ?>
    <div class="smaller-padding programs">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h5><?php if ( $model_block['title'] ) echo $model_block['title'];?></h5>
                    <h2><?php if ( $model_block['excerpt'] ) echo $model_block['excerpt'];?></h2>
                    <p class="bigger"><?php if ( $model_block['text'] ) echo $model_block['text'];?></p>
                </div>

            </div>
            <div class="row d-flex justify-content-between">

                <?php if ( !empty( $model_block['phases'] ) ) { ?>
                    <?php foreach ( $model_block['phases'] as $i => $phase ) { ?>

                        <div class="col-lg-4 one-program-card">
                            <?php
                            $phase_img_id = get_image_id( $phase['image'] );
                            $phase_img_alt = get_post_meta($phase_img_id, '_wp_attachment_image_alt', TRUE);
                            ?>
                            <img src="<?php if ( $phase['image'] ) echo $phase['image']; ?>" alt="<?php echo esc_attr( $phase_img_alt ); ?>"/>
                            <h4><?php if ( $phase['phase'] ) echo $phase['phase']; ?></h4>
                            <h3><?php if ( $phase['title'] ) echo $phase['title']; ?></h3>
                            <p><?php if ( $phase['text'] ) echo $phase['text']; ?></p>
                        </div>

                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

    <div class="smaller-padding our-philosophy platform-holder">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xs-12 text-center">
                    <h2><?php if ( $platform_block['title'] ) echo $platform_block['title'];?></h2>
                    <p class="bigger <?php if ( $platform_block['video_link'] ) { echo 'p_before_video';}?>"><?php if ( $platform_block['text'] ) echo $platform_block['text'];?></p>
                    <?php if ( $platform_block['video_link'] ) {?>
                        <iframe src="<?php echo esc_url($platform_block['video_link']);?>" width="1110"
                                height="700" frameborder="0"></iframe>
                    <?php };?>
                </div>
            </div>
            <?php if ( !empty( $platform_block['platformes'] ) ) { ?>
                <div class="row">
                    <div class="col">
                        <div class="box full mb-5">
                            <div class="row">
                                <div class="col-xs-12 col-lg-12 text-left">
                                    <h3><?php if ( $platform_block['ready-to-go_content'] ) echo $platform_block['ready-to-go_content'];?></h3>
                                </div>
                            </div>

                            <?php foreach ( $platform_block['platformes'] as $i => $platform ) { ?>
                                <?php if ( ( $i % 2 ) == 0 )  { ?>
                                    <div class="row">
                                <?php  } ?>

                                <div class="col-xs-12 col-lg-6 text-left">
                                    <div class="row">
                                        <div class="col-lg-3 d-flex justify-content-center align-items-start flex-row">
                                            <img src="<?php if ( $platform['image'] ) echo $platform['image'];?>" alt="p-img-1"/>
                                        </div>
                                        <div class="col-lg-9 d-flex justify-content-center align-items-start flex-column">
                                            <h5><?php if ( $platform['title'] ) echo $platform['title'];?></h5>
                                            <p><?php if ( $platform['text'] ) echo $platform['text'];?></p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ( ( $i % 2 ) != 0 ) { ?>
                                    </div>
                                    <br>
                                <?php } ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ( !empty( $platform_block['next_gen_platformes'] ) ) { ?>
                <div class="box full mb-5">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 text-left">
                            <h3><?php if ( $platform_block['next-gen_training'] ) echo $platform_block['next-gen_training'];?></h3>
                        </div>
                    </div>
                    <?php foreach ( $platform_block['next_gen_platformes'] as $i => $platform ) { ?>
                        <?php if ( ( $i % 2 ) == 0 )  { ?>
                            <div class="row">
                        <?php  } ?>
                        <div class="col-xs-12 col-lg-6 text-left">
                            <div class="row">
                                <div class="col-lg-3 d-flex justify-content-center align-items-start flex-row">
                                    <img src="<?php if ( $platform['image'] ) echo $platform['image'];?>" alt="<?php if ( $platform['image'] ) echo $platform['image'];?>"/>
                                </div>
                                <div class="col-lg-9 d-flex justify-content-center align-items-start flex-column">
                                    <h5><?php if ( $platform['title'] ) echo $platform['title'];?></h5>
                                    <p><?php if ( $platform['text'] ) echo $platform['text'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php if ( ( $i % 2 ) != 0 ) { ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ( !empty( $platform_block['progress_tracking_platformes'] ) ) { ?>
                <div class="box full mb-5">
                    <div class="row">
                        <div class="col-xs-12 col-lg-12 text-left">
                            <h3><?php if ( $platform_block['progress_tracking_text'] ) echo $platform_block['progress_tracking_text'];?></h3>
                        </div>
                    </div>
                    <?php foreach ( $platform_block['progress_tracking_platformes'] as $i => $platform ) { ?>
                        <?php if ( ( $i % 2 ) == 0 )  { ?>
                            <div class="row">
                        <?php  } ?>
                        <div class="col-xs-12 col-lg-6 text-left">
                            <div class="row">
                                <div class="col-lg-3 d-flex justify-content-center align-items-start flex-row">
                                    <img src="<?php if ( $platform['image'] ) echo $platform['image'];?>" alt="<?php if ( $platform['image'] ) echo $platform['image'];?>"/>
                                </div>
                                <div class="col-lg-9 d-flex justify-content-center align-items-start flex-column">
                                    <h5><?php if ( $platform['title'] ) echo $platform['title'];?></h5>
                                    <p><?php if ( $platform['text'] ) echo $platform['text'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php if ( ( $i % 2 ) != 0 ) { ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

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

<?php if ( $dashboard_block ) { ?>
    <div class="smaller-padding dashboard services_dashboard bg-color-grey">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h5><?php if ( $dashboard_block['title'] ) echo $dashboard_block['title'];?></h5>
                    <h2><?php if ( $dashboard_block['text'] ) echo $dashboard_block['text'];?></h2>
                </div>

            </div>
            <?php if ( !empty( $dashboard_block['items'] ) ) { ?>
                <div id="slider" class="owl-carousel">

                    <?php foreach ( $dashboard_block['items'] as $i => $platform ) { ?>

                        <div class="item">
                            <div class="row">
                                <div class="col-xs-12 col-lg-7">
                                    <?php
                                    $platform_img_id = get_image_id( $platform['image'] );
                                    $platform_img_alt = get_post_meta($platform_img_id, '_wp_attachment_image_alt', TRUE);
                                    ?>
                                    <img src="<?php if ( $platform['image'] ) echo $platform['image'];?>" alt="<?php echo esc_attr( $platform_img_alt ); ?>"/>
                                </div>
                                <div class="col-xs-12 col-lg-5">
                                    <h3><?php if ( $platform['title'] ) echo $platform['title'];?></h3>
                                    <p><?php if ( $platform['text'] ) echo $platform['text'];?></p>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>
                <div class="row slider-menu sv-slider-menu">
                    <div class="col-xs-12 col-lg-7">
                        <div class="sv-slider-pagination">

                            <div class="slider-menu__dots">
                                <div class="loc_slider_nav prev"><img src="./dist/img/slider-arrow-left.svg" alt="arrow left"/></div>
                                <?php foreach ($dashboard_block['items'] as $i => $platform) : ?>
                                    <div class="dot <?php if ( $i == 0 ) echo 'active';?>"
                                         data-next="<?php echo  $i + 1 < count($dashboard_block['items']) ? $dashboard_block['items'][$i + 1]['title'] : $dashboard_block['items'][0]['title']; ?>"
                                    >
                                        <div></div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="loc_slider_nav next"><img src="./dist/img/slider-arrow-right.svg" alt="arrow right"/></div>

                                <div class="up-next">
                                    <span>Next: </span><?php echo $dashboard_block['items'][1]['title']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php
get_footer('custom');
wp_footer();
