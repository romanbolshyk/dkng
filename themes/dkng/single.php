<?php get_header('custom'); ?>
<?php while ( have_posts() ) : the_post();

global $post;
?>

        <div class="inner_container single_post_page">
            <div class="container">
                <div class="row1">
                    <h2><?php echo the_title(); ?></h2>
                    <hr/>
                    <?php echo apply_filters('the_content', $post->post_content); ?>
                </div>
            </div>
        </div>


<?php endwhile;?>
<?php
get_footer( 'custom' );

