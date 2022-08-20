<?php
//$articles = new WP_Query( array ( 'post_type' => 'edited_articles', 'posts_per_page' => 5,  'author__not_in' => $user->ID ) );
if ( empty( $helpful_posts ) ) { ?>
    <p class="single_course_bold"><?php echo esc_html( "There are no articles for now yet.", "dkng" );?></p> <?php
}

foreach ( $helpful_posts as $article ) { ?>
    <div class="useful-holder">
        <div class="row">
            <div class="col-5">
                <a href="<?php echo get_the_permalink( $article->ID );?>">
                    <div class="user-img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $article->ID, 'thumbnail' ); ?>);"></div>
                </a>
            </div>
            <div class="col-7 pl-0  flex-row justify-content-start align-items-center">
                <p>
                    <a href="<?php echo get_the_permalink( $article->ID );?>" class="read-article" data-post-id="<?php echo $article->ID; ?>">
                        <?php echo $article->post_title; ?>
                    </a>
                </p>
                <p><?php echo $article->post_excerpt; ?></p>
            </div>
        </div>
    </div>
<?php }

