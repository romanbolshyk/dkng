<?php

get_header('custom');

//$videos       = get_field( 'videos', get_the_ID() );
$galereya_obj = new \Dkng\Wp\Galereya();

$paged    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$videos   = $galereya_obj->get_galereya ( 'video', false, $paged, 6 );
$max_num  = $galereya_obj->get_all_galereya ( 'video', false, 6 );

?>
<div class="container template gallery_video_block">
    <div class="sv-filter">
        <div class="sv-filter__top">
            <h2 class="sv-filter__title">
                <?php echo __( "Архів Відео", "dkng" ); ?>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <?php /* if ( !empty( $videos ) ) { ?>
                <div class="template-items ">
                    <?php foreach ( $videos as $video ) { ?>

                        <div class="item">

                            <div class="item-image ">
                                <iframe width="100%" height="100%" src="<?php echo $video['video_link'];?>" title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>

                            <div class="item-content" style=" padding: 10px;">
                                <h3 class="item-title">
                                    <b><?php echo $video['label']; ?></b>
                                </h3>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            <?php }  */?>


            <?php if ( !empty( $videos ) ) { ?>
                <div class="template-items ">
                    <?php foreach ( $videos as $video ) { ?>

                        <div class="item">

                            <div class="item-image ">
                                <iframe width="100%" height="100%" src="<?php echo get_the_excerpt( $video );?>" title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

<?php get_footer('custom'); ?>
