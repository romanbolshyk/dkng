<?php
$post         = get_post( get_the_ID() );
$author_id    = (int)$post->post_author;

$phone        =  get_field( 'phone',         'user_' . $author_id );
$email        =  get_field( 'email',         'user_' . $author_id );
$office       =  get_field( 'office',        'user_' . $author_id );
$toll_free    =  get_field( 'toll-free',     'user_' . $author_id );
$fax          =  get_field( 'fax',           'user_' . $author_id );
$email_footer =  get_field( 'email_footer',  'user_' . $author_id );
$address      =  get_field( 'address',       'user_' . $author_id );
$address2     =  get_field( 'address2',      'user_' . $author_id );
$town         =  get_field( 'town',          'user_' . $author_id );
$state        =  get_field( 'state',         'user_' . $author_id );
$postal       =  get_field( 'postal',        'user_' . $author_id );
$days         =  get_field( 'days',          'user_' . $author_id );
$disclaimer   =  get_field( 'disclaimer',    'user_' . $author_id );
$fb_link      =  get_field( 'facebook_link', 'user_' . $author_id );
$tw_link      =  get_field( 'twitter_link',  'user_' . $author_id );
$lkdn_link    =  get_field( 'linkedin_link', 'user_' . $author_id );
$ytb_link     =  get_field( 'youtube_link',  'user_' . $author_id );
$custom_site  =  get_field( 'custom_site',   'user_' . $author_id );
$custom_site  =  !empty( $custom_site ) ? $custom_site : get_site_url();

$upload_dir   = wp_upload_dir();
$file_name    = get_user_meta( $author_id, 'avatar', true );
$fileurl      = $upload_dir['basedir'] . '/' . $file_name;
$filepath     = $upload_dir['baseurl'] . '/' . $file_name;
$fileurl      = ( file_exists( $fileurl ) && !empty( $file_name ) ) ? $filepath : get_template_directory_uri() . "/dist/img/avatar.png";
?>
    <div class="footer dark">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="<?php echo $custom_site;?>">
                        <img src="<?php echo $fileurl;?>" alt="logo-white" style="max-width: 200px; height: 100px;"/>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="info-box col-12 col-md-4">
                    <p> Phone: <?php echo $phone;?><br/></p>
                    <p> Email:  <a href="mailto:<?php echo $email;?>" class="email_footer_ea"><?php echo $email;?></a></p>
                </div>
                <div class="col-12 col-md-8">
                    <p class="small footer_ea_p"><?php echo $disclaimer;?></p>
                </div>
            </div>
            <div class="row related-edited-articles-sharing">
                <div class="link-box col-12 socials">
                    <?php //echo do_shortcode("[addtoany url='". get_the_permalink( get_the_ID() ) ."']"); ?>
                    <?php if ( !empty( $fb_link ) ) { ?>
                        <a class="social-link share-button" href="<?php echo $fb_link;?>" target="_blank">
                            <i class="fa fa-facebook-f"></i>
                        </a>
                    <?php } ?>
                    <?php if ( !empty( $tw_link ) ) { ?>
                        <a class="social-link share-button" href="<?php echo $tw_link;?>" target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a>
                    <?php } ?>
                    <?php if ( !empty( $lkdn_link ) ) { ?>
                        <a class="social-link share-button" href="<?php echo $lkdn_link;?>" target="_blank">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="footer-bottom col-12 px-0 d-flex flex-row justify-content-start align-items-center">
                    <div class="col-12 col-md-6">
                        <p class="copyright"><?php echo __( "Copyright © 2018 Seven Group. All rights reserved.", "dkng" );?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <ul class="w-100 d-flex flex-row justify-content-end align-items-center">
                            <li><a href="#"><?php echo __( "PRIVACY POLICY", "dkng" );?></a></li>
                            <li><a href="#"><?php echo __( "TERMS OF USE", "dkng" );?></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php wp_footer(); ?>

</body>
</html>
