<?php

get_header('custom');

$main_commision = get_field( 'main_commision', get_the_ID() );
$participants   = get_field( 'participant_commision', get_the_ID() );
?>
<div class="inner_container">
    <div class="container content ">

        <!-- Bread Crumbs -->
        <div class="row bread_menu">
            <?php custom_breadcrumbs( );  ?>
        </div>
        <!-- Bread Crumbs -->

        <div class="white-element page-template-announces">
            <div class="row1">
                <div class="announces_block-list ">
                    <h2 class="aligncenter"><?php echo get_the_title();?></h2>
                </div>
            </div>

            <div class="row1">
                <div class="announces_block-list ">
                    <div class="container">
                        <p><?php  echo apply_filters('the_content', get_the_content() );?></p>
                    </div>

                    <div class="container">
                        <h3>Голова Комісії:</h3>
                        <?php foreach ( $main_commision as $boss ) {
                            $img = !empty( get_the_post_thumbnail_url( $boss['pracivnyk'] ) ) ? get_the_post_thumbnail_url( $boss['pracivnyk'] ) : './dist/img/avatar.png';?>
                            <div class="announces_block-item" data-num="1">
                                <div class="announces_block-item-image">
                                    <a href="<?php echo get_permalink( $boss['pracivnyk'] );?>">
                                        <img src="<?php echo $img;?>" alt="керівник" style="height: 100%; width: 90%;">
                                    </a>
                                </div>
                                <div class="announces_block-item-text">
                                    <div class="announces_block-item-top-text">
                                        <h3>
                                            <a href="<?php echo get_permalink( $boss['pracivnyk'] );?>">
                                                <?php echo get_the_title( $boss['pracivnyk'] );?>
                                            </a>
                                        </h3>
                                    </div>
                                    <h4 class="announces_block-item-t">
                                        <?php echo get_the_excerpt( $boss['pracivnyk'] );?>
                                    </h4>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="container" style="margin-top: 40px;">
                        <h3>Члени Комісії:</h3>
                        <?php foreach ( $participants as $boss ) {
                            $img = !empty( get_the_post_thumbnail_url( $boss['pracivnyk'] ) ) ? get_the_post_thumbnail_url( $boss['pracivnyk'] ) : './dist/img/avatar.png';?>
                            <div class="announces_block-item" data-num="1">
                                <div class="announces_block-item-image">
                                    <a href="<?php echo get_permalink( $boss['pracivnyk'] );?>">
                                        <img src="<?php echo $img;?>" alt="керівник" style="height: 100%;  width: 90%;">
                                    </a>
                                </div>
                                <div class="announces_block-item-text">
                                    <div class="announces_block-item-top-text">
                                        <h3>
                                            <a href="<?php echo get_permalink( $boss['pracivnyk'] );?>">
                                                <?php echo get_the_title( $boss['pracivnyk'] );?>
                                            </a>
                                        </h3>
                                    </div>
                                    <h4 class="announces_block-item-t">
                                        <?php echo get_the_excerpt( $boss['pracivnyk'] );?>
                                    </h4>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer('custom');
