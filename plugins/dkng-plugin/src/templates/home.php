<?php

get_header('custom');

$slider_block        = get_field( 'banner_block');
$slider_block        = $slider_block['home_slider_block'];
$video_block1        = get_field( 'video_block_home');
$video_block2        = get_field( 'video_block_presentation');
$materialna_baza_block  = get_field( 'materialna_baza_block');
$block3              = get_field( 'block3');
$vidguk_block        = get_field( 'vidguk_block');
$cemiykoldzh_block   = get_field( 'cemiykoldzh_block');

$object              = new \Dkng\Wp\Ogoloshennya();
$object1             = new \Dkng\Wp\Novyny();
$announces           = $object->get_ogoloshennya( false, false, 3);
$announces           = $announces->posts;
$novyny              = $object1->get_news( 6 );
$novyny              = $novyny->posts;

$video_block         = get_field( 'video_block');
$philosophy_block    = get_field( 'philosophy_block');

$video_module_title  = get_field( 'video_module_title', 'option' );
$video_module_link   = get_field( 'video_module_link',  'option' );

$args = array(
    'post_type' => array( 'post', 'page', 'ogoloshennya', 'novyny', 'specialities', 'speciality_detail', 'galereya' ),
    'fields'    => 'ids',
    'orderby'   => 'date',
    'order'     => 'DESC',
    'posts_per_page' => 5
);
$the_last_updated_posts = new WP_Query( $args );

?>

<?php if ( !empty( $slider_block ) ) { ?>
    <div class="home_container">
        <div class="container slider_banner_block">
            <div class="row">
                <div class="col">
                    <div class="home_content">
                        <div class="col-lg-6 col-sm-12">
                            <?php echo do_shortcode( $slider_block );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="main-content">
    <div class="right-content">
        <div class="container home-container default-padding">

            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="white-element">
                        <div class="row">
                            <h3><?php echo $video_block2['title'];?></h3>
                            <p><?php  echo apply_filters('the_content', $video_block2['video_text'] );?></p>
                        </div>
                    </div>

                    <div class="white-element page-template-announces">
                        <div class="row">
                            <div class="announces_block-list">
                                <div class="container">
                                    <h3>Список оголошень.</h3>
                                    <?php foreach ( $announces as $announce ) {
                                        $excerpt = get_the_excerpt( $announce );

                                        $img = get_the_post_thumbnail_url( $announce );
                                        $img = !empty( $img ) ? $img  : './dist/img/ogoloshennya.jpeg';
                                        ?>
                                        <div class="announces_block-item" data-num="1">
                                            <div class="announces_block-item-image">
                                                <img src="<?php echo $img;?>" alt="announces image" style="height: 100%;">
                                            </div>
                                            <div class="announces_block-item-text">
                                                <div class="announces_block-item-top-text">
                                                    <?php echo get_the_date( 'Y-m-d', $announce );?>
                                                </div>
                                                <h4 class="announces_block-item-t">
                                                    <a href="<?php echo get_permalink( $announce )?>">
                                                        <?php echo get_the_title( $announce );?>
                                                    </a>
                                                </h4>

                                                <div class="announces_block-item-desc">
                                                    <p><?php echo $excerpt;?></p>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-lg-5  page-template-announces">
                    <div class="white-element right-holder-video">
                        <div class="row video_module_block" id="video_module player3">
                            <div class="col-12">
                                <?php require_once 'template-parts/home_page/video_section.php';?>
                            </div>
                        </div>
                    </div>

                    <div class="white-element right-holder all_updated_posts_block">
                        <div class="row">
                            <?php require_once 'template-parts/home_page/all_updated_posts_section.php';?>
                        </div>
                    </div>

                    <div class="white-element materialna_baza_block">
                        <div class="row1">
                            <h3><?php echo $materialna_baza_block['title'];?></h3>

                            <a href="<?php echo $materialna_baza_block['video_text'];?>">
                                <img class="size-medium wp-image-9905 aligncenter" src="<?php echo $materialna_baza_block['video_image'];?>" alt="" width="300" height="202" />
                            </a>
                        </div>
                    </div>
                    <div class="white-element used_links">
                        <div class="row1">
                            <h3><?php echo $block3['title'];?></h3>
                            <?php if ( !empty( $block3['repeater'] ) ) {
                                foreach ( $block3['repeater'] as $item ) { ?>
                                    <p>
                                        <a href="<?php echo $item['title'];?>" target="_blank" style="font-size: 12.16px;">
                                            <img src="<?php echo $item['video_image'];?>" border="0" alt="" width="214" height="152" style="display: block; margin-left: auto; margin-right: auto;">
                                        </a>
                                    </p>
                                    <hr/>
                                <?php
                                }
                            }?>
                        </div>
                    </div>

                    <div class="white-element home_cemiy_koledzh_block announces_block-list" >
                        <div class="row1">
                            <h3><?php echo $cemiykoldzh_block['title'];?></h3>
                            <?php $id_vidguk = $cemiykoldzh_block['vidguk'];

                            $excerpt            = get_the_excerpt( $id_vidguk );
                            $original_thumbnail = get_the_post_thumbnail_url( $id_vidguk );
                            $grupa              = get_field( 'grupa', $id_vidguk );
                            ?>
                            <div class="announces_block-item" data-num="1">
                                <div class="announces_block-item-image">
                                    <a href="<?php echo get_permalink( $id_vidguk )?>">
                                        <img src="<?php echo $original_thumbnail;?>" alt="logo of people" style="height: 100%;">
                                    </a>
                                </div>
                                <div class="announces_block-item-text">
                                    <div class="announces_block-item-top-text">
                                        <?php echo $grupa;?>
                                    </div>
                                    <h4 class="announces_block-item-t">
                                        <a href="<?php echo get_permalink( $id_vidguk )?>">
                                            <?php echo get_the_title( $id_vidguk );?>
                                        </a>
                                    </h4>

                                    <div class="announces_block-item-desc">
                                        <p><?php echo $excerpt;?></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="white-element vidguk_block">
                        <div class="row1">
                            <h3>
                                <a href="<?php echo $vidguk_block['link_title'];?>" target="_blank">
                                    <?php echo $vidguk_block['title'];?>
                                </a>
                            </h3>
                            <p style="text-align: center;">
                                <a href="<?php echo $vidguk_block['image_link'];?>" target="_blank">
                                    <img src="<?php echo $vidguk_block['image'];?>" border="0" alt="" width="251" height="140">
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="default-padding news_block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php include 'template-parts/home_page/home_dashboard_campaigns.php';?>
            </div>
        </div>
    </div>
</div>


<?php if ( $philosophy_block ) { ?>
    <div class="default-padding our-philosophy">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2><?php echo $philosophy_block['title']; ?></h2>
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
                    <a href="<?php if ( $philosophy_block['page_link'] ) echo $philosophy_block['page_link'];?>"><?php echo $philosophy_block['page_title'];?>
                        <img src="./dist/img/arrow-right.png" alt="arrow right"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
get_footer('custom');
wp_footer();
