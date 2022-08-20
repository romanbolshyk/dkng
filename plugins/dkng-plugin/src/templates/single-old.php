<?php get_header('custom'); ?>
<?php
    $user         = wp_get_current_user();
    $id           = get_the_ID();
    $current_post = get_post($id);
    $author_wp    = get_userdata($current_post->post_author);
    $posts        = new WP_Query( array ( 'post_type' => 'post', 'posts_per_page' => 2, 'post__not_in' => array( $id ) ) );
    $author_by    = get_field( 'author_by', $id );
    $author       = ( !empty( $author_by ) ) ? $author_by : $author_wp->user_nicename;;

    ob_start();
    foreach ( $posts->posts as $post ) { ?>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="one-card">
                <div class="img-top-card" style="background: url(<?php echo get_the_post_thumbnail_url( $post->ID ); ?>)">
                    <img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>"/>
                </div>
                <div class="card-content">
                    <h3><?php echo $post->post_title; ?></h3>
                    <a href="<?php echo get_the_permalink( $post->ID );?>">Read article</a>
                </div>
            </div>
        </div>
    <?php }
    $other_posts = ob_get_clean();
?>
        <div class="inner_container blog_block">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="inner_content">
                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="post_single_container">
        <div class="smaller-padding">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <h2><?php echo $current_post->post_title; ?></h2>
                        <h4>by <?php echo $author;?></h4>
                    </div>
                    <div class="col-4">
                        <ul class="navbar social-nav d-flex flex-column justify-content-start align-items-end social_block_single_post">
                            <li>Share</li>
                            <?php echo do_shortcode("[addtoany url='". get_permalink( $current_post->ID ) ."' title='" . $current_post->post_title . "']"); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-padding post-holder post_single_content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo apply_filters( 'the_content', $current_post->post_content ); ?>
                        <hr class="w-100 mt-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( $other_posts ) { ?>
        <div class="default-padding case-studies">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>More Articles</h2>
                    </div>
                    <div class="col-lg-6 d-flex flex-row justify-content-end align-items-start">
                        <a href="<?php echo get_site_url();?>/blog" class="read-more green-more">View All <span class="fa fa-angle-right"></span></a>
                    </div>
                </div>

                <div class="row d-flex justify-content-between">
                    <?php echo $other_posts;?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php
get_footer('custom');
wp_footer();