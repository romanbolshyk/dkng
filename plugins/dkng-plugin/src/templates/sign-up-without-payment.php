<?php
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

$levels1          = new RCP_Levels();
$levels           = $levels1->get_levels();
foreach ( $levels as $level ) {
    if ( $level->status  == 'active' ) {
        $price    = (float)$level->price;
    }
}
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
                                <a class="btn btn-signup btn-lg" href="<?php echo get_site_url();?>/sign-up-2#signup">
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

    <div class="privacy_block">
        <div class="col-lg-8 offset-lg-2 col-sm-12 case-studies text-center">
            <div class="row">
                <div class="col-12 one-card pxy-20 mt-3 ">
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-start align-items-center flex-row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="privacy" required id="privacyPolicy" >
                                <label class="form-check-label" for="privacyPolicy" style="display: inline-block;font-weight: normal;">
                                    <?php if ( !empty( $pr_simple_text ) ) echo $pr_simple_text;?>
                                    <a class="terms_signup_links" target="_blank" href="<?php if ( !empty( $privacy_link ) ) echo $privacy_link;?>">
                                        <?php if ( !empty( $privacy_text ) ) echo $privacy_text;?>
                                    </a>
                                    <?php if ( $and_text_privacy ) echo $and_text_privacy;?>
                                    <a class="terms_signup_links" target="_blank" href="<?php if ( !empty( $terms_link ) ) echo $terms_link;?>">
                                        <?php if ( !empty( $terms_text ) ) echo $terms_text;?>
                                    </a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-padding our-philosophy form-holder" id="signup" >
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 offset-lg-2 text-center above-footer ">
                    <h5><?php if ( $sign_up_block['title'] ) echo $sign_up_block['title'] ;?></h5>
                    <h2>
                        <?php if ( $sign_up_block['text'] ) echo $sign_up_block['text'] ;?><br/>
                        <span class="no-underline"><?php if ( $sign_up_block['button_text'] ) echo $sign_up_block['button_text'] ;?></span>
                    </h2>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="box pxy-20 sv-sign-up-form-padding-top">
                        <div class="form_shortcode without_payment">
                            <?php echo do_shortcode($page->post_content);?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php
get_footer('custom');
wp_footer();
