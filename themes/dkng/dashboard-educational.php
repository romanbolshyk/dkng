<?php
/*
Template Name: Dashboard Educational
*/
?>
<?php get_header(); ?>

<?php

$query = array (
    'post_type'      => 'courses',
    'posts_per_page' => -1,
);
$courses  = new WP_Query( $query );
$count    = $courses->found_posts;
$cat_list = [];
?>
<div class="container" >
    <div class="investor-holder">
        <div class="row">
            <div class="col-4 col-md-12 col-lg-8 d-flex flex-row justify-content-start align-items-center">
                <h4>Marketing Courses</h4>
            </div>
            <div class="col-4 col-md-4 col-lg d-flex flex-row justify-content-end align-items-center">
                <h4>Courses ( <?php echo $count; ?> )</h4>
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
                            <th>Courses</th>
                            <th></th>
                            <th>Number of Courses</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Topic</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $courses->posts as $course ) {
                            $post_status = ( $course->post_status == 'publish' ) ?  'Published' : 'Unpublished';
                            $categories  = get_the_category( $course->ID );
                            $categories  = get_the_terms( $course->ID, "courses-category");

                            if ( !empty( $categories ) ) {
                                foreach( $categories as $cat ){
                                    $cat_list[$course->ID][] = $cat->name;
                                }
                            }
                            $cats_string =  ( $cat_list[$course->ID] ) ? implode( ", ", $cat_list[$course->ID] ) : '';
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo get_the_post_thumbnail_url( $course->ID, 'thumbnail' ); ?>" alt="img1"/>
                                </td>
                                <td>
                                    <?php echo  $course->post_title; ?>
                                    <p class="grey"><?php echo $course->post_excerpt; ?></p>
                                </td>
                                <td>12</td>
                                <td><?php echo $post_status; ?></td>
                                <td><?php echo get_the_date( 'Y/m/d', $course->ID ); ?></td>
                                <td>
                                    <?php echo $cats_string; ?>
                                </td>
                                <td>
                                    <a class="btn btn-view" href="<?php echo get_permalink( $course->ID );?>">VIEW</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php get_footer();

