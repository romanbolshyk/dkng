<?php
/*
Template Name: Dashboard Content
*/
?>
<?php get_header(); ?>

<?php

$wp_query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => -1 ) );
$count    = $wp_query->found_posts;
?>
<div class="container ">
    <div class="investor-holder">
        <div class="row">
            <div class="col-4 col-md-12 col-lg-8 d-flex flex-row justify-content-start align-items-center">
                <h4>Approved Content</h4>
            </div>
            <div class="col-4 col-md-4 col-lg d-flex flex-row justify-content-end align-items-center">
                <h4>Articles ( <?php echo $count;?> )</h4>
            </div>
            <div class="col-4 col-md-4 col-lg d-flex flex-row justify-content-end align-items-center">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by: All
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">1</a>
                        <a class="dropdown-item" href="#">2</a>
                        <a class="dropdown-item" href="#">3</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive video">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th></th>
                            <th>Upload date</th>
                            <th>Word Count</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                            $approval        = get_field_object('approval_post' );
                            $key             = $approval['value'];
                            $approve_status  = $approval['choices'][$key];
                            $word_count      = strlen( get_the_content() );
                            $post_status     = ( get_post_status($id) == 'publish' ) ? 'Published' : 'Unpublished'; ?>
                            <tr>
                                <td>
                                    <img src="<?php echo the_post_thumbnail_url(); ?>" alt="img1"/>
                                </td>
                                <td>
                                    <?php the_title(); ?>
                                    <p class="grey"><?php the_excerpt(); ?></p>
                                </td>
                                <td> <?php the_date('Y/m/d');?> </td>
                                <td> <?php echo $word_count;?>  </td>
                                <td> <?php echo $post_status;?> </td>
                                <td>
                                    <a class="btn btn-line">FINRA: <?php echo $approve_status;?></a>
                                </td>
                                <td>
                                    <a class="btn btn-view" href="<?php echo the_permalink();?>">VIEW</a>
                                </td>
                            </tr>
                        <?php endwhile; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php get_footer();
