<?php

//if ( !is_user_logged_in() ) {
////    wp_redirect( get_site_url() . '/advisorlogin', 307 );
////    exit;
//}

$count_per_page      = 20;
$user                = wp_get_current_user();
$completed_courses   = get_user_meta( $user->ID, 'completed_courses' );
$progressing_courses = get_user_meta( $user->ID, 'progressing_courses' );
get_header();

if ( is_user_logged_in() ) {


    $query = array (
        'post_type'      => 'courses',
        'posts_per_page' => $count_per_page
    );
    $courses        = new WP_Query( $query );
    $count          = $courses->found_posts;
    $all_categories = get_categories( array ( "taxonomy" => "courses-category" ) );
    $cat_list       = array(); ?>

    <div class="container training" >
        <div class="investor-holder">
            <div class="row">
                <div class="col-12 col-sm-4 col-lg-8 d-flex flex-row justify-content-start align-items-center">
                    <h4><?php echo __( 'Marketing Courses', 'dkng');?></h4>
                </div>
                <div class="col-12 col-sm-4 col-lg d-flex flex-row justify-content-start justify-content-sm-end align-items-center">
                    <h4><?php echo __( 'Courses', 'dkng');?> ( <span class="count-articles"> <?php echo $count;?></span>  )</h4>
                </div>
                <div class="col-12 col-sm-4 col-lg d-flex flex-row justify-content-start justify-content-sm-end align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo __( 'Sort By', 'dkng');?>:  <?php echo __( 'All', 'dkng');?>
                        </button>
                        <div class="dropdown-menu sorting-categories" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="all"><?php echo __( 'All', 'dkng');?></a>
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
                                <th><?php echo __( 'Courses', 'dkng' );?></th>
                                <th></th>
                                <th><?php echo __( 'Number of Courses', 'dkng' );?></th>
                                <th><?php echo __( 'Status', 'dkng' );?></th>
                                <th><?php echo __( 'Start Date', 'dkng' );?></th>
                                <th><?php echo __( 'Topic', 'dkng' );?></th>
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

                                if ( !empty( $progressing_courses ) && is_array( $progressing_courses[0] ) && in_array( $course->ID, $progressing_courses[0] ) ) {
                                    $status = 'In Progress';
                                }
                                elseif ( !empty( $completed_courses ) && is_array( $completed_courses ) && in_array( $course->ID, $completed_courses[0] ) ) {
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

                                require 'template-parts/ajax-items/course_item.php' ?>

                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if ( count ( $courses->posts ) >= $count_per_page ) { ?>
                        <a id="load_more_button"><?php echo __( 'Load More', 'dkng' );?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="container training not_logged_admin_page" >
    </div>
<?php }
get_footer();


