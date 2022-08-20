<?php require_once 'template-parts/edited-articles/header.php'; ?>

<?php
    $post_id   = get_the_ID();
    $title     = explode(' by ', get_the_title( $post_id ) );
    $author_id = get_post_field( 'post_author', $post_id );

    $articles  = new WP_Query( array ( 'post_type' => 'edited_articles', 'posts_per_page' => 5, 'post__not_in' => array( $post_id ), 'author' => $author_id ) );
    ob_start();
    foreach ( $articles->posts as $article ) { ?>
        <div class="useful-holder">
            <div class="row">
                <div class="col-5">
                    <div class="user-img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $article->ID, 'thumbnail' ); ?>);"></div>
                </div>
                <div class="invisible-holder col-7 pl-0 d-flex flex-row justify-content-start align-items-center">
                    <p><a href="<?php echo get_the_permalink( $article->ID );?>"><?php echo $article->post_title; ?></a></p>
                </div>
            </div>
        </div>
    <?php }
    $related_posts = ob_get_clean();

    $image         = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
    $image         = str_replace( '-150x150', '', $image );
    $min_height    = ( !empty( $image ) ) ? '' : 'min-height: auto;';
    $style_direct  .= $min_height;
    $style_direct  .= ( !empty( $image ) ) ? " background-image: url(" . $image . ")" : '';
?>
    <div class="main-content-white edited_article_block">

        <div class="right-content">
            <div class="container">

                <div class="row">
                    <div class="col-12 col-md-8 investment-holder article_content_block">
                        <div class="row">
                            <div class="col-12 d-flex flex-column justify-content-center align-items-start">
                                <div class="inv-img smart" style="<?php echo $style_direct;?>"></div>
                                <h2><?php echo $title[0];?></h2>
                                <span><?php echo get_the_date( 'F jS', $post_id );?></span>
                                <p><?php echo apply_filters( 'the_content', get_post_field( 'post_content', $post_id) ); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 investment-right-holder white-investment">

                        <div class="row">
                            <div class="col-12">
                                <h4><?php echo __( "Related Articles", "dkng" );?><h4>
                                <?php echo $related_posts;?>
                            </div>
                            <div class="row related-edited-articles-sharing">
                                <div class="col-12">
                                    <div class="col-12 d-flex flex-row justify-content-start align-items-center">
                                        <?php echo do_shortcode("[addtoany url='". get_the_permalink( $post_id ) ."']"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php require 'template-parts/edited-articles/footer.php'; ?>
