<?php
if ( is_user_logged_in() ) {
    wp_redirect( get_site_url() . '/admin-dashboard', 301 );
    exit;
}

get_header('custom');
$first_block  = get_field( 'first_block', get_the_ID() );
$page         = get_post( get_the_ID() );
$blocks       = get_field('blocks', get_the_ID() );
?>

        <div class="inner_container profile login_block">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="inner_content">
                            <div class="row">
                                <div class="col-lg-7 col-sm-12">
                                    <h4><?php if ( $first_block['title'] ) echo $first_block['title'];?></h4>
                                    <h1><?php if ( $first_block['text'] ) echo $first_block['text'];?></h1>
                                </div>
                                <div class="col-lg-5 col-sm-12">
                                    <div class="box login_box">
                                        <div class="form_shortcode">
                                            <?php echo do_shortcode( $page->post_content );?>
                                        </div>
                                        <div class="text-center">
                                            <?php echo __( "Not registered", "dkng");?>? <a href="<?php  echo get_site_url();?>/contact"><?php echo __( "Connect with our team", "dkng" );?></a>
                                        </div>
                                        <div class="text-center">
                                            <a href="<?php echo get_site_url();?>/seven-signin/?action=lostpassword"><?php echo __( "Forgot Password", "dkng" );?>?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ( $blocks ) { ?>
        <?php foreach ( $blocks as $i => $block ) {  ?>

            <?php
                $class_left_right =  ( ( $i % 2 ) == 0 ) ? "right" : "left";
                $class_offset     =  ( ( $i % 2 ) == 0 ) ? "" : "offset-lg-6";
            ?>

            <div class="default-padding have-absolute-image login-block">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 <?php echo $class_offset;?>">
                            <h2><?php if ( $block['title'] ) echo $block['title'];?></h2>
                            <p class="bigger"><?php if ( $block['text'] ) echo $block['text'];?></p>
                        </div>
                    </div>
                </div>
                <?php
                $block_url_id = get_image_id($block['image']);
                $block_url_alt = get_post_meta($block_url_id, '_wp_attachment_image_alt', TRUE);
                ?>
                <div class="absolute-image <?php echo $class_left_right;?>">
                    <img src="<?php if ( $block['image'] ) echo $block['image'];?>" alt="<?php echo esc_attr( $block_url_alt ); ?>">
                </div>
            </div>

        <?php } ?>
    <?php } ?>
<?php
get_footer('custom');
wp_footer();
