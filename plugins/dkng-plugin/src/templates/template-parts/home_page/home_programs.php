<div class="default-padding  home_programs_block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3 ><?php echo $philosophy_block['title']; ?></h3>
            </div>
        </div>

        <div class="news-block-list">

            <div class="sv-container all_campaigns_block sv-section">

                <div class="columns-grid">
                    <?php if ( !empty( $programs ) ) {
                        $i = 0;
                        foreach ( $programs as $program ) {
                            $i++;
                            $post       = get_post( $program );
                            $content    = $post->post_content;
                            $speciality = get_field( 'speciality', $program );
                            $img = !empty( get_the_post_thumbnail_url( $program ) ) ? get_the_post_thumbnail_url( $program ) : './dist/img/post.jpg';
                            ?>

                            <div class="campaign" >
                                <a class="campaign__image d-block ribbon" href="<?php echo get_permalink( $program );?>" style="background-image: url(<?php echo $img;?>);">
                                </a>
                                <div class="campaign__info">
                                    <h3 class="campaign__title">
                                        <a href="<?php echo get_permalink( $program );?>" >
                                            <?php echo  get_the_title( $program );?>
                                        </a>
                                    </h3>
                                    <p class="campaign__excerpt"  style="display: initial;">
                                        <?php echo get_the_title( $speciality );?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

            <div class="campaigns-report__link">
                <a href="<?php if ( $philosophy_block['page_link'] ) echo $philosophy_block['page_link'];?>">
                    <?php echo  $philosophy_block['page_title'];;?>
                    <img src="./dist/img/arrow-right.png" alt="arrow right">
                </a>
            </div>

        </div>

    </div>
</div>