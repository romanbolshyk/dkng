<?php

get_header('custom');

$slider_block        = get_field( 'home_slider_block');
$video_block1        = get_field( 'video_block_home');
$video_block2        = get_field( 'video_block_presentation');
$materialna_baza_block  = get_field( 'materialna_baza_block');
$block3              = get_field( 'block3');
$vidguk_block        = get_field( 'vidguk_block');

$object              = new \Dkng\Wp\Ogoloshennya();
$object1             = new \Dkng\Wp\Novyny();
$announces           = $object->get_announces();
$news                = $object1->get_news( 6 );

$video_block         = get_field( 'video_block');
$philosophy_block    = get_field( 'philosophy_block');

$video_module_title  = get_field( 'video_module_title', 'option' );
$video_module_link   = get_field( 'video_module_link',  'option' );

?>

<?php if ( !empty( $slider_block ) ) { ?>
    <div class="home_container">
        <div class="container">
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
                    <div class="white-element mb-100">
                        <div class="row">
                            <h3><?php echo $video_block2['title'];?></h3>
                            <p><?php echo $video_block2['video_text'];?></p>
                        </div>
                    </div>
                    <div class="white-element mb-100">
                        <div class="row">
                            <?php require_once 'template-parts/home_page/articles_section.php';?>
                        </div>
                    </div>
                    <div class="white-element mb-100 page-template-podcast">
                        <div class="row">
                            <div class="podcast_block-list">
                                <div class="container">
                                    <h3>Список оголошень.</h3>
                                    <?php foreach ( $announces as $announce ) {
                                        $excerpt = get_the_excerpt( $announce );
                                        ?>
                                        <div class="podcast_block-item" data-num="1">
                                            <div class="podcast_block-item-image">
                                                <img src="./dist/img/ogoloshennya.jpeg" alt="podcast image" style="height: 100%;">
                                            </div>
                                            <div class="podcast_block-item-text">
                                                <div class="podcast_block-item-top-text">
                                                    <?php echo get_the_date( 'Y-m-d', $announce );?>
                                                </div>
                                                <h4 class="podcast_block-item-t">
                                                    <a href="<?php echo get_permalink( $announce )?>">
                                                        <?php echo get_the_title( $announce );?>
                                                    </a>
                                                </h4>

                                                <div class="podcast_block-item-desc">
                                                    <p><?php echo $excerpt;?></p>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="white-element mb-100">
                        <div class="row">
                            <?php require_once 'template-parts/home_page/courses_section.php';?>
                        </div>
                    </div>
                    <div class="white-element mb-100">
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

                <div class="col-12 col-lg-5">
                    <div class="white-element right-holder-video">
                        <div class="row video_module_block" id="video_module player3">
                            <div class="col-12">
                                <?php require_once 'template-parts/home_page/video_section.php';?>
                            </div>
                        </div>
                    </div>

                    <div class="white-element right-holder">
                        <div class="row">
                            <?php require_once 'template-parts/home_page/things_to_do_section.php';?>
                        </div>
                    </div>

                    <div class="white-element webinars-holder">
                        <div class="row1">
                            <h3><?php echo $materialna_baza_block['title'];?></h3>
                            <?php echo $materialna_baza_block['video_text'];?>
                        </div>
                    </div>
                    <div class="white-element webinars-holder">
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
                </div>
            </div>
<!--            <div class="row">-->
<!--                <div class="col-12">-->
<!--                    --><?php //include 'template-parts/home_page/home_dashboard_campaigns.php';?>
<!--                </div>-->
<!--            </div>-->
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
