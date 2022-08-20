<?php
//if ( !is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/login', 301 );
//    exit;
//}

$count_per_page      = 20;
$user                = wp_get_current_user();
$completed_courses   = get_user_meta( $user->ID, 'completed_courses' );
$progressing_courses = get_user_meta( $user->ID, 'progressing_courses' );

get_header();
$query = array (
    'post_type'      => 'courses',
    'posts_per_page' => $count_per_page
);
$courses        = new WP_Query( $query );
$count          = $courses->found_posts;
$all_categories = get_categories( array ( "taxonomy" => "courses-category" ) );
$cat_list       = [];
?>
<div class="container educational" >
    <div class="investor-holder">
        <div class="row">
            <div class="col-4 col-md-12 col-lg-8 d-flex flex-row justify-content-start align-items-center">
                <h4>Marketing Courses</h4>
            </div>
            <div class="col-4 col-md-4 col-lg d-flex flex-row justify-content-end align-items-center">
                <h4>Courses ( <span class="count-articles"> <?php echo count( $courses->posts );?></span>  )</h4>
            </div>
            <div class="col-4 col-md-4 col-lg d-flex flex-row justify-content-end align-items-center">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By: All
                    </button>
                    <div class="dropdown-menu sorting-categories" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="all">All</a>
                        <?php foreach ( $all_categories as $category ) { ?>
                            <a class="dropdown-item" href="<?php echo $category->slug;?>"><?php echo $category->name;?></a>
                        <?php } ?>
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
                    <tbody class="body-items" data-all="<?php echo $count;?>" data-getcat="all" data-cpt="courses">
                        <?php foreach ( $courses->posts as $course ) {
                            $post_status    = ( $course->post_status == 'publish' ) ?  'Published' : 'Unpublished';
                            $categories     = get_the_category( $course->ID );
                            $categories     = get_the_terms( $course->ID, "courses-category");
                            $lessons        = get_field( 'lessons', $course->ID );
                            $number_lessons = ( $lessons ) ? count($lessons) : 0;

                            if ( in_array( $course->ID, $progressing_courses[0] ) ) {
                                $status = 'In Progress';
                            }
                            else if ( in_array( $course->ID, $completed_courses[0] ) ) {
                                $status = 'Completed';
                            }
                            else {
                                $status = 'New';
                            }

                            if ( !empty( $categories ) ) {
                                foreach( $categories as $cat ){
                                    $cat_list[$course->ID][] = $cat->name;
                                }
                            }
                            $cats_string = ( $cat_list[$course->ID] ) ? implode( ", ", $cat_list[$course->ID] ) : '';
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo get_permalink( $course->ID );?>" >
                                        <img src="<?php echo get_the_post_thumbnail_url( $course->ID, 'thumbnail' ); ?>" alt="img1"/>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo get_permalink( $course->ID );?>" ><?php echo $course->post_title; ?></a>
                                    <p class="grey"><?php echo $course->post_excerpt; ?></p>
                                </td>
                                <td><?php echo $number_lessons;?></td>
                                <td><?php echo $status; ?></td>
                                <td><?php echo get_the_date( 'Y/m/d', $course->ID ); ?></td>
                                <td>
                                    <?php echo $cats_string; ?>
                                </td>
                                <td>
                                    <a class="btn btn-view read-course" data-course-id="<?php echo $course->ID;?>" href="<?php echo get_permalink( $course->ID );?>">VIEW</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if ( count ( $courses->posts ) >= $count_per_page ) { ?>
                    <a id="load_more_button">Load more</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer();

