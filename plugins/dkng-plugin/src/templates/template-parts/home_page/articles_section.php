<div class="col-12">
    <h3><?php _e( 'Список оголошень', 'dkng' );?></h3>
</div>
<?php if ( $articles ) { ?>
    <?php foreach ( $articles->posts as $article ) { ?>
        <div class="col-12 col-md-6 col-lg-12">
            <div class="grey-box">
                <div class="row no-gutters">
                    <div class="col-12 col-lg-3">
                        <a href="<?php echo get_permalink( $article->ID );?>" class="read-article" data-post-id="<?php echo $article->ID; ?>" >
                            <div class="post-image"
                                 style="background-image: url(<?php echo get_the_post_thumbnail_url( $article->ID ); ?>);">
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-9 d-flex justify-content-center align-items-center pl-0">
                        <div class="row w-100">
                            <div class="col-12 col-lg-7 d-flex flex-column justify-content-center align-items-start">
                                <a href="<?php echo get_permalink( $article->ID );?>" data-post-id="<?php echo $article->ID; ?>" class="read-article">
                                    <p class="bold"><?php echo get_the_title( $article->ID ); ?></p>
                                </a>
                                <!-- <p><?php //echo get_the_excerpt( $article->ID ); ?></p> -->
                            </div>
                            <div class="col-12 col-lg-5 d-flex flex-row justify-content-end align-items-center">
                                <a href="<?php echo get_permalink( $article->ID );?>" style="padding-right: 10px;"><?php echo __( "View", "dkng" );?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<div class="col-12">
    <div class="link-box d-flex flex-row justify-content-end align-items-center">
        <a href="<?php echo get_site_url()?>/admin-content" class="read-more"><?php echo __( "See More", "dkng" );?> <img src="./dist/img/arrow-right.png" alt="arrow right"></a>
    </div>
</div>