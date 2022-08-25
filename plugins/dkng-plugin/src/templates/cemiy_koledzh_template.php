<?php
get_header('custom');

$query = array (
    'post_type'      => 'cemijkoledzh',
    'posts_per_page' => -1
);
$vidguky        = new WP_Query( $query );
$count          = $vidguky->found_posts;
?>
<div class="super_container">
    <div class="container content ">

        <div class="white-element page-template-announces">
                <div class="row">
                    <div class="announces_block-list inner_container w-100">
                        <div class="container">
                            <h2>Список Відгуків:</h2>
                            <?php foreach ( $vidguky->posts as $vidguk ) {
                                $excerpt = get_the_excerpt( $vidguk );
                                $original_thumbnail = get_the_post_thumbnail_url( $vidguk );

                                $grupa = get_field( 'grupa', $vidguk );
                                ?>
                                <div class="announces_block-item" data-num="1">
                                    <div class="announces_block-item-image">
                                        <a href="<?php echo get_permalink( $vidguk )?>">
                                            <img src="<?php echo $original_thumbnail;?>" alt="logo of people" style="height: 100%;">
                                        </a>
                                    </div>
                                    <div class="announces_block-item-text">
                                        <div class="announces_block-item-top-text">
                                            <?php echo $grupa;?>
                                        </div>
                                        <h4 class="announces_block-item-t">
                                            <a href="<?php echo get_permalink( $vidguk )?>">
                                                <?php echo get_the_title( $vidguk );?>
                                            </a>
                                        </h4>

                                        <div class="announces_block-item-desc">
                                            <p><?php echo $excerpt;?></p>
                                        </div>

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
