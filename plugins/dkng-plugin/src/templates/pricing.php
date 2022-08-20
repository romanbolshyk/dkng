<?php

//if ( is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/admin-dashboard', 301 );
//    exit;
//}

get_header('custom');

$first_block      = get_field( 'first_block');
$benefits_block   = get_field( 'benefits_block');
$sign_up_block    = get_field( 'sign_up_block');
$page             = get_post( get_the_ID() );

$privacy_group    = get_field( 'privacy_policy_group');
$pr_simple_text   = $privacy_group['text'];
$privacy_text     = $privacy_group['privacy_policy_text'];
$privacy_link     = $privacy_group['privacy_policy_link'];
$and_text_privacy = $privacy_group['and_privacy_text'];
$terms_text       = $privacy_group['terms_service_text'];
$terms_link       = $privacy_group['terms_service_link'];


$pricing_block    = get_field('pricing_group', 'option');

$contact_forms_ids = ['basic_inquiry', 'business_inquiry', 'business_plus_inquiry' ];

/*
$levels1          = new RCP_Levels();
$levels           = $levels1->get_levels();
foreach ( $levels as $level ) {
    if ( $level->status  == 'active' ) {
        $price            = (float)$level->price;
    }
}
*/
?>
<?php if ( $first_block ) { ?>
    <div class="inner_container profile sign_up_page" data-price="<?php echo $price;?>" >
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="inner_content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mb-2">
                                <h1><?php if ( $first_block['title'] ) echo $first_block['title'] ;?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <a class="btn btn-signup btn-lg js-scroll-to" data-scroll="#signup" href="<?php echo get_site_url();?>/sign-up#signup">
                                    <?php if ( $first_block['button_text'] ) echo $first_block['button_text'] ;?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    </div>
<?php if ( $first_block['text1'] || $first_block['text2'] ) { ?>
    <div class="smaller-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <p class="bigger"> <?php if ( $first_block['text1'] ) echo $first_block['text1'] ;?></p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <p class="bigger"><?php if ( $first_block['text2'] ) echo $first_block['text2'] ;?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ( $benefits_block ) { ?>
    <div class="smaller-padding programs">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h5><?php if ( $benefits_block['title'] ) echo $benefits_block['title'];?></h5>
                    <h2><?php if ( $benefits_block['text'] ) echo $benefits_block['text'];?></h2>
                </div>
            </div>

            <?php if ( !empty( $benefits_block['services'] ) ) {
                foreach ( $benefits_block['services']  as $i => $service ) { ?>
                    <?php  if ( ( $i % 3 ) == 0 ) { ?>
                        <div class="row d-flex justify-content-between">
                    <?php  } ?>
                    <div class="col-lg-4 one-program-card">
                        <h3><?php if ( $service['title'] ) echo $service['title'];?></h3>
                        <p><?php if ( $service['text'] ) echo $service['text'];?></p>
                    </div>
                    <?php if ( ( ( $i == 2 ) || ( $i == 5 ) ) ) { ?>
                        </div>
                    <?php  } ?>
                    <?php
                }
            } ?>

        </div>
    </div>
<?php } ?>

<?php if ( !empty( $pricing_block ) ) { ?>
    <div class="sv-pricing default-padding" id="signup">
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
<?php }

get_footer('custom');
wp_footer();
