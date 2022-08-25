<?php
get_header('custom');

$photos = get_field( 'photos', get_the_ID() );

$galereya_obj = new \Dkng\Wp\Galereya();

$cat      = !empty( $_GET['cat'] ) ? $_GET['cat'] : '';
var_dump($cat);
$paged    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$photos1  = $galereya_obj->get_galereya ( 'photo',     $cat, $paged, 1 );
$max_num  = $galereya_obj->get_all_galereya ( 'photo', $cat, 1 );

?>

	<div class="inner_container announces_block-banner-wrap">
		<div class="container">
			<div class="announces_block-banner"
				 style="background-image: url(<?php if ( $banner['background'] ) echo $banner['background']; ?>)">
				<div class="announces_block-banner-center">
					<h2><?php  echo "Фото"; ?></h2>
                </div>
			</div>

            <div class="row">
                <div class="col-12">

                    <?php if ( !empty( $photos1 ) ) { ?>
                        <div class="template-items ">
                            <?php foreach ( $photos1 as $video ) { ?>

                                <div class="item">

                                    <div class="item-image ">
                                       <?php echo get_the_post_thumbnail_url( $video);?>
                                    </div>

                                    <div class="item-content" style="padding: 10px;">
                                        <h3 class="item-title">
                                            <b><?php echo get_the_title( $video );?></b>
                                        </h3>
                                    </div>
                                </div>

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


<?php if ( !empty( $announces ) ) { ?>
	<div class="announces_block-list">

        <div class="container">
            <h2><?php echo "Список оголошень."; ?></h2>

            <?php foreach ( $announces as $announce ) {
                $excerpt = get_the_excerpt( $announce );
                ?>
                <div class="announces_block-item" data-num="1">
                <div class="announces_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="announces image">
                </div>
                <div class="announces_block-item-text">
                    <div class="announces_block-item-top-text">
                        <?php echo get_the_date( 'Y-m-d', $announce );?>
                    </div>
                    <h4 class="announces_block-item-title">
                        <?php if ( !empty( $announces_type ) ) { ?>
                            <a href="<?php echo get_permalink( $announce )?>">
                                <?php echo get_the_title( $announce );?>
                            </a>
                        <?php }  else { ?>
                            <?php echo get_the_title( $announce );?>
                        <?php } ?>
                    </h4>

                    <div class="announces_block-item-desc">
                        <p><?php echo $excerpt;?></p>
                    </div>

                </div>
            </div>
            <?php } ?>

        </div>
	</div>
<?php  } ?>


<?php
get_footer('custom');
wp_footer();