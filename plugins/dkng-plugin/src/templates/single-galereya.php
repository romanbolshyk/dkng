<?php

get_header( 'custom' );

?>
<?php while ( have_posts() ) : the_post();
    $post_id   = get_the_ID();
    $type      = get_the_terms( $post_id, "galereya-category");
    $type      = $type[0]->slug;

    $in_photos = get_field( 'photos', $post_id );

    ?>

    <div class="inner_container  single-gallery gallery_photo_block">
        <div class="container">
            <h3><?php echo get_the_title();?></h3>
            <div class="content item" style="width: 600px; height: 500px;">
            <?php if ( $type == 'video' ) { ?>

                <iframe width="100%" height="100%" src="<?php echo get_the_excerpt( $post_id );?>" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <?php } else { ?>

                <div class="item"  >

                    <div class="slider slider-1">

                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper top_swiper mySwiper2">
                            <div class="swiper-wrapper">
                                <?php foreach ( $in_photos as $in_photo ) { ?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo $in_photo['foto'];?>" />
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <div thumbsSlider="" class="swiper bottom_swiper mySwiper1">
                            <div class="swiper-wrapper">
                                <?php foreach ( $in_photos as $in_photo ) { ?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo $in_photo['foto'];?>" />
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>

                <script>
                        var swiper = new Swiper(".slider-1 .mySwiper1", {
                            spaceBetween: 10,
                            slidesPerView: 5,
                            freeMode: true,
                            loop: true,
                            watchSlidesProgress: true,
                        });

                        var swiper2 = new Swiper(".slider-1 .mySwiper2", {
                            spaceBetween: 10,
                            navigation: {
                                nextEl: ".slider-1 .swiper-button-next",
                                prevEl: ".slider-1 .swiper-button-prev",
                            },
                            thumbs: {
                                swiper: swiper,
                            },
                        });
                    </script>

            <?php } ?>
        </div>
        </div>
    </div>
<?php endwhile;  ?>

<?php get_footer('custom');
