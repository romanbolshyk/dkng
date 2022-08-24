<div class="news-block-list">

    <div class="sv-container all_campaigns_block sv-section">
        <h2 class="sv-title"><?php echo __( "Останні Новини", "dkng" );?>:</h2>

        <div class="columns-grid">
            <?php if ( !empty( $novyny ) ) {
                $i = 0;
                foreach ( $novyny as $new ) {
                    $i++;
                    $title      = get_the_title( $new );
                    $link       = get_permalink( $new );
                    $excerpt    = get_the_excerpt( $new );
                    $thumbnail  = get_the_post_thumbnail_url( $new );
                    ?>

                    <div class="campaign" id="<?php echo $new;?>">
                        <a class="campaign__image d-block ribbon" href="<?php echo $link;?>" style="background-image: url(<?php echo $thumbnail;?>);">
                            <span class="ribbon-target" >Топ Новина!</span>
                        </a>
                        <div class="campaign__info">
                            <span class="campaign__number"><?php echo __( "Новина", "dkng" );?> №<?php echo $index;?></span>
                            <h3 class="campaign__title"><a href="<?php echo $link;?>"><?php echo $title;?></a></h3>
                            <p class="campaign__excerpt"  style="display: initial;">
                                <?php echo $excerpt;?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <h4><?php echo __( "Наразі ще немає новин.", "dkng" );?>.</h4>
            <?php }  ?>
        </div>
    </div>

    <div class="campaigns-report__link">
        <a href="<?php echo get_site_url() . '/novyny';?>">
            <?php echo __( "Всі новини", "dkng" );?>
            <img src="./dist/img/arrow-right.png" alt="arrow right">
        </a>
    </div>

</div>