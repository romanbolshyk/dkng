<?php
get_header('custom');


$galereya_obj = new \Dkng\Wp\Galereya();

$cat      = get_field( 'category', get_the_ID() );
$cat_slug = $cat[0]->slug;
$cat_name = $cat[0]->name;

$paged    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$photos1  = $galereya_obj->get_galereya ( 'photo',     $cat_slug,  $paged, 2 );
$max_num  = $galereya_obj->get_all_galereya ( 'photo', $cat_slug, 2 );
$i        = 1;
?>

	<div class="inner_container announces_block-banner-wrap gallery_photo_block">
		<div class="container">
			<div class="announces_block-banner" >
				<div class="announces_block-banner-center">
					<h2><?php  echo "Ахрів фото: $cat_name"; ?></h2>
                </div>
			</div>

            <div class="row">
                <div class="col-12">
                    <?php if ( !empty( $photos1 ) ) { ?>
                        <div class="template-items ">
                            <?php foreach ( $photos1 as $photo ) {
                                $in_photos = get_field( 'photos', $photo );
                                $i++; ?>

                                <div class="item"  >

                                    <div class="item-content" >
                                        <h3 class="item-title" >
                                            <b><?php echo get_the_title( $photo );?></b>
                                        </h3>
                                    </div>

                                    <div class="slider slider-<?php echo $i;?>">

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
                                <hr/>

                                <script>
                                    var swiper = new Swiper(".slider-<?php echo $i;?> .mySwiper1", {
                                        spaceBetween: 10,
                                        slidesPerView: 5,
                                        freeMode: true,
                                        loop: true,
                                        watchSlidesProgress: true,
                                    });

                                    var swiper2 = new Swiper(".slider-<?php echo $i;?> .mySwiper2", {
                                        spaceBetween: 10,
                                        navigation: {
                                            nextEl: ".slider-<?php echo $i;?> .swiper-button-next",
                                            prevEl: ".slider-<?php echo $i;?> .swiper-button-prev",
                                        },
                                        thumbs: {
                                            swiper: swiper,
                                        },
                                    });
                                </script>

                            <?php } ?>

                            <div class="custom_pagination">
                                <?php
                                $var = is_page() ? 'page' : 'paged';
                                $big = 999999999;

                                echo paginate_links( array(
                                    'base'     => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'paged'    => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                                    'current'  => max( 1, get_query_var( 'paged' ) ),
                                    'format'   => '?paged=%#%',
                                    'total'    => $max_num
                                ) );
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
		</div>
	</div>


<?php
get_footer('custom');
wp_footer();