<?php
$articles = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 5 ) );
foreach ( $articles->posts as $article ) { ?>
    <div class="useful-holder">
        <div class="row">
            <div class="col-5">
                <div class="user-img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $article->ID, 'thumbnail' ); ?>);"></div>
            </div>
            <div class="col-7 pl-0  flex-row justify-content-start align-items-center">
                <p>
                    <a href="<?php echo get_the_permalink( $article->ID );?>"> <?php echo $article->post_title; ?></a>
                </p>
                <p><?php echo $article->post_excerpt; ?></p>
            </div>
        </div>
    </div>
<?php }

