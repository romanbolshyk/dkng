<div class="col-12">
    <h4><?php _e( 'Coaching for You', 'dkng' );?></h4>
</div>
<?php if ( $courses ) {
    $i = 0;?>
    <?php foreach ( $courses->posts as $course ) {  ?>
        <?php
        $unlisteners_list = get_post_meta( $course->ID, 'unlisteners_list', true );
        $unlisteners_list = ( !empty( $unlisteners_list ) ) ? $unlisteners_list : array();
        if ( ( !empty( $unlisteners_list ) && is_array( $unlisteners_list ) && in_array( $user->ID, $unlisteners_list ) ) || ( $unlisteners_list == 'none' ) ) {
            continue;
        }
        $i++;
        if ( $i > 6 ) {
            break;
        }

        if ( !empty( $progressing_courses[0] ) && $progressing_courses[0] && in_array( $course->ID, $progressing_courses[0] ) ) {
            $status = 'In progress';
        }
        else if ( !empty( $completed_courses[0] ) && $completed_courses[0] && in_array( $course->ID, $completed_courses[0] ) ) {
            $status = 'Completed';
        }
        else {
            $status = 'New';
        }
        $thumbnail = get_the_post_thumbnail_url(  $course->ID );
        $thumbnail = ( empty( $thumbnail ) ) ? "./dist/img/icon-hands.png" : $thumbnail;
        ?>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="white-element grey-bg-sect strategies-holder status-new d-flex flex-column justify-content-start align-items-center">
                <a href="<?php echo get_permalink( $course->ID );?>" >
                    <img src="<?php echo $thumbnail;?>" alt="icon-hands"/>
                </a>
                <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                </div>
                <p>
                    <a href="<?php echo get_permalink( $course->ID );?>" class="read-course" data-course-id="<?php echo $course->ID;?>">
                        <?php echo get_the_title( $course->ID );?>
                    </a>
                </p>
                <p class="grey"><?php echo $status;?></p>
            </div>
        </div>
    <?php } ?>
<?php } ?>

<div class="col-12">
    <div class="link-box d-flex flex-row justify-content-end align-items-center">
        <a href="<?php echo get_site_url()?>/admin-training/" class="read-more"><?php echo __( "See More", "dkng" );?>
            <img src="./dist/img/arrow-right.png" alt="arrow right">
        </a>
    </div>
</div>