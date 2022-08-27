<div class="col-12">
    <h3><?php _e( 'Оновлені Публікації', 'dkng' );?></h3>
</div>

<?php if ( !empty( $the_last_updated_posts ) ) { ?>
    <?php foreach ( $the_last_updated_posts->posts as $article ) { ?>
        <?php
        $img = get_the_post_thumbnail_url( $article );
        $img = !empty( $img ) ? $img  : './dist/img/post.jpg';
        ?>
        <div class="col-12 col-md-6 col-lg-12">
            <div class="grey-box">
                <div class="row no-gutters">
                    <div class="col-12 col-lg-3">
                        <a href="<?php echo get_permalink( $article );?>" class="read-article" data-post-id="<?php echo $article; ?>" >
                            <div class="post-image"
                                 style="background-image: url(<?php echo $img;?>); background-repeat: no-repeat;background-size: contain;">
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-lg-9 d-flex justify-content-center align-items-center pl-0">
                        <div class="row w-100">
                            <div class="col-12 col-lg-7 d-flex flex-column justify-content-center align-items-start">
                                <a href="<?php echo get_permalink( $article );?>" data-post-id="<?php echo $article; ?>" class="read-article">
                                    <p class="bold"><?php echo get_the_title( $article ); ?></p>
                                </a>
                            </div>
                            <div class="col-12 col-lg-5 d-flex flex-row justify-content-end align-items-center">
                                <a href="<?php echo get_permalink( $article );?>" style="padding-right: 10px;"><?php echo __( "Дивитись", "dkng" );?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
