<?php
if ( !is_user_logged_in() ) {
    wp_redirect( get_site_url() . '/advisorlogin', 301 );
    exit;
}

get_header();
?>
<?php while ( have_posts() ) : the_post();
    $post_id  = get_the_ID();
    $courses  = new WP_Query( array ( 'post_type' => 'courses', 'posts_per_page' => 20, 'post__not_in' => array( $post_id ) ) );
    $pdf_file = get_field( 'pdf_course', $post_id );
    $user     = wp_get_current_user();
    ob_start();
    foreach ( $courses->posts as $course ) { ?>
        <div class="item course_other_training">
            <div class="strategies-holder status-new d-flex flex-column justify-content-start align-items-center">
                <a href="<?php echo get_permalink( $course->ID );?>">
                    <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                </a>
                <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                    <div class="point-full"></div>
                    <div class="point-full"></div>
                    <div class="point-half"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                </div>
                <p>
                    <a href="<?php echo get_permalink( $course->ID );?>" style="border: 0;"><?php echo $course->post_title; ?></a>
                </p>
                <p class="grey">New</p>
            </div>
        </div>
    <?php }
    $other_courses   = ob_get_clean();

    $last_iteraction = get_user_meta( $user->ID, 'last_iteraction' );
    $faqs            = get_field( 'faq_block', $post_id );
    $helpful_posts   = get_field( 'helpful_articles', $post_id );

    $lessons         = get_field( 'lessons', $post_id );
    $videos_api      = new \Dkng\Wp\VideosApi();
    $progress_course = get_user_meta( $user->ID, 'progress_bar_courses', true );
    $progress_lesson = get_user_meta( $user->ID, 'progress_bar_lessons', true );
    $progress_lesson = $progress_lesson[$post_id];

    $lesson_seconds  = get_user_meta( $user->ID, 'progress_bar_lessons_seconds', true );
    $lesson_seconds  = $lesson_seconds[$post_id];

    if ( $post_id == (int)$last_iteraction[0]['course'] ) {
        $video_current_id = $last_iteraction[0]['lesson_video'];

        $last_seconds        = ( empty( $last_iteraction[0]['seconds'] ) )     ? 0  : (int)$last_iteraction[0]['seconds'];
        $last_link           = ( empty( $last_iteraction[0]['lesson_link'] ) ) ? '' : $last_iteraction[0]['lesson_link'];

        $current_lesson_name = $last_iteraction[0]['lesson_name'];
        $current_lesson_link = $last_iteraction[0]['lesson_link'];
    }
    else {
        $first_link          = ( !empty( $lessons[0]['lessons_under'] ) && ( $lessons[0]['is_under'] == 'yes' ) ) ? $lessons[0]['lessons_under'][0]['video_link'] : $lessons[0]['video_link'];
        $first_name          = ( !empty( $lessons[0]['lessons_under'] ) && ( $lessons[0]['is_under'] == 'yes' ) ) ? $lessons[0]['lessons_under'][0]['name']       : $lessons[0]['name'];
        $query_str           = parse_url( $first_link, PHP_URL_QUERY );
        parse_str( $query_str, $query_params );
        $video_current_id    = $query_params['v'];

        $last_seconds = 0;
        if ( $lessons[0]['is_under'] == "no" ) {
            $last_seconds     = !empty( $lesson_seconds['simples'][$lessons[0]['name']] ) ? (int)$lesson_seconds['simples'][$lessons[0]['name']] : 0;
        }
        else {
            if ( !empty( $lesson_seconds['unders'] ) ) {
                $last_seconds = !empty( $lesson_seconds['unders'][$lessons[0]['lessons_under'][0]['name']] ) ?  (int)$lesson_seconds['unders'][$lessons[0]['lessons_under'][0]['name']] : 0;
            }
        }

        $last_link           = $first_link;
        $current_lesson_name = $first_name;
        $current_lesson_link = $last_link;
    }

    $total              = ( ! empty( $progress_course[$post_id] ) ) ? $videos_api->get_total_lessons_in_course( $progress_course[$post_id] ) : 0;
    $all_count          = $videos_api->get_all_lessons_by_course( $post_id );
    $percentage         = $videos_api->get_percent_by_progress_bar( $total, $all_count );
    $disable            = ( (int)$percentage == 100 ) ? "" : "disabled";
    $protocol           = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';

    $single_transcript  = array();
    ?>

    <div class="right-content marketing">
        <div class="top-info">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-start align-items-center flex-row">
                        <div class="progress circle circle_progress_bar" data-value='<?php echo $percentage;?>'>
                            <span class="progress-left">
                                <span class="progress-bar border-primary"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar border-primary"></span>
                            </span>
                            <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                <div class="h2 font-weight-bold percent_count"><span class="count"><?php echo $percentage;?></span><span>%</span></div>
                            </div>
                        </div>
                        <div>
                            <h3><?php echo __( "Keep it up!", "dkng" );?></h3>
                            <p class="percent_count"><?php echo __( "Your progress from this module is", "dkng" );?>
                                <span class="count"><?php echo $percentage;?></span>%
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <div class="dark-box clearfix">
        <div class="container video-player training">
            <div class="row">
                <div class="container container_back_modules">
                    <a href="<?php echo get_site_url()?>/admin-training/"><?php echo __( "Back to All", "dkng" );?></a>
                </div>
            </div>
            <div class="row mobile_block">
                <div class="col-12 video-title mt-5 mt-md-0">
                    <label><?php echo the_title(); ?></label>
                    <p><?php echo __( "An Introduction to", "dkng" );?> <?php echo the_title(); ?></p>
                    <div class="progress_bar" style="display: none;">
                        <span class="percent_count">
                        <?php echo $percentage;?></span>% <?php echo __( "of", "dkng" );?> 100%
                        (
                            <span class="int_count"> <?php echo $total;?></span> <?php echo __( "of", "dkng" );?>
                            <span class="all_count"><?php echo $all_count;?></span>
                        )
                        <progress max="100" value="<?php echo $percentage;?>" id="percent">
                    </div>
                </div>

                <div class="col-12  col-lg-8 video-content">
                    <?php
                        /* for Youtube
                            <div id="player" class="main-video" data-course-id="<?php echo $post_id;?>"
                                 data-video-current-id="<?php echo $video_current_id;?>"
                                 data-video-current-seconds="<?php echo $last_seconds;?>">
                            </div>
                        */
                    ?>
                    <!-- for Youtube
                    <div data-vimeo-url="<?php //echo $video_src;?>"  data-video-current-id="<?php //echo $video_current_id;?>"
                         data-video-current-seconds="<?php //echo $lesson_seconds;?>">
                     -->
                    <div data-vimeo-url="<?php echo $last_link;?>"
                         data-vimeo-width="750"
                         data-vimeo-height="465"
                         data-course-id="<?php echo $post_id;?>"
                         id="player"
                         data-video-current-id="<?php echo $video_current_id;?>"
                         data-video-current-seconds="<?php echo $last_seconds;?>">
                    </div>
                </div>

                <?php
                    /* Functionality for youtube API frontend
                    <script src="https://www.youtube.com/player_api" type="text/javascript"></script>
                    <script src="<?php echo plugins_url();?>/dkng-plugin/assets/youtube4.js?16" type="text/javascript"></script>
                    */
                ?>

                <script src="<?php echo plugins_url();?>/dkng-plugin/assets/vimeo.js?3" type="text/javascript"></script>

                <div class="col-12  col-lg-4 video-list mt-3 mt-md-0">
                    <label><?php echo __( "Lessons", "dkng" );?></label>
                    <ul class="link-holder single_course_list" data-course="<?php echo $post_id;?>">
                        <?php if ( $lessons = get_field( 'lessons', $post_id ) ) {
                            $i = 0;
                            foreach ( $lessons as $lesson ) {
                                $i++;
                                if ( !empty( $last_iteraction ) && ( (int)$last_iteraction[0]['course'] == $post_id ) &&
                                    ( (int)$last_iteraction[0]['lesson'] == $i ) && empty( $last_iteraction[0]['parent_lesson'] ) )  {
                                    $checked = "checked";
                                }
                                else {
                                    $checked = ( $i == 1 ) ? "checked" : "";
                                }

                                if ( ( $lesson['video_link'] == $current_lesson_link ) && ( $lesson['name'] == $current_lesson_name ) ) {
                                    $single_transcript['text']  = $lesson['lesson_transcript'];
                                    $single_transcript['title'] = $lesson['lesson_transcript_title'];
                                }

                                if ( empty( $lesson['lessons_under'] ) || ( $lesson['is_under'] == 'no' ) ) {
                                    $progress_lesson_procent = ( !empty( $progress_lesson['simples'][$i] ) ) ? $progress_lesson['simples'][$i] : 0;
                                    $query_str    = parse_url( $lesson['video_link'], PHP_URL_QUERY );
                                    parse_str($query_str, $query_params);
                                    $video_id     = !empty( $query_params['v'] ) ? $query_params['v'] : 0;

                                    $str_time1    = \Dkng\Wp\VideosApi::get_vimeo_duration( $lesson['video_link'] );
                                    $str_time2    = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time1 );
                                    sscanf( $str_time2, "%d:%d:%d", $hours, $minutes, $seconds);
                                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                    $time_seconds = ( $time_seconds * $progress_lesson_procent ) / 100;

                                    $vimeo_id     = \Dkng\Wp\VideosApi::get_vimeo_id_by_url( $lesson['video_link'] );
                                    ?>
                                    <li class="lesson <?php echo $checked;?>" data-index="<?php echo $i;?>"
                                        data-video-id="<?php echo $video_id;?>"
                                        <?php /* onclick="loadPlaylistVideoIds(['<?php echo $video_id;?>//', 390]);" */ ?>
                                        data-seconds="<?php echo $time_seconds;?>">
                                        <a href="" class="video-link" data-link="<?php echo $lesson['video_link'];?>"
                                            data-vimeo-id="<?php echo $vimeo_id;?>"
                                        >
                                            <?php if ( (int)$progress_lesson_procent == 100 ) { ?>
                                                <span class="number"><i class="fa fa-check"></i></span>
                                            <?php } else {  ?>
                                                <span class="number"><?php echo $i;?></span>
                                            <?php } ?>
                                            <span class="video-name"><?php echo $lesson['name'];?></span>
                                            <span class="time"><?php echo $str_time1;?></span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo $progress_lesson['simples'][$i];?>%"
                                                     aria-valuenow="<?php echo $progress_lesson['simples'][$i];?>"
                                                     aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <ul class="parent">
                                        <li class="lesson_parent" data-index="<?php echo $i;?>">
                                            <a href="" class="video-link">
                                                <span class="number"><?php echo $i;?></span>
                                                <span class="video-name"><?php echo $lesson['name'];?></span>
                                            </a>
                                        </li>
                                        <?php $j = 0;
                                        foreach ( $lesson['lessons_under'] as $lesson1 ) {
                                            $j++;
                                            $checked     = "";
                                            $query_str   = parse_url( $lesson1['video_link'], PHP_URL_QUERY );
                                            parse_str( $query_str, $query_params );
                                            $video_id    = !empty( $query_params['v'] ) ? $query_params['v'] : 0;

                                            if ( ( $lesson1['video_link'] == $current_lesson_link ) && ( $lesson1['name'] == $current_lesson_name ) ) {
                                                $single_transcript['text']  = $lesson1['lesson_transcript'];
                                                $single_transcript['title'] = $lesson1['lesson_transcript_title'];
                                            }

                                            $progress_lesson_procent = ( !empty( $progress_lesson['unders'][$i][$j] ) ) ? $progress_lesson['unders'][$i][$j] : 0;

                                            // $str_time1   = \Dkng\Wp\VideosApi::get_video_duration( $video_id ); - for Youtube
                                            $str_time1    = \Dkng\Wp\VideosApi::get_vimeo_duration( $lesson1['video_link'] );
                                            $str_time2    = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time1 );
                                            sscanf( $str_time2, "%d:%d:%d", $hours, $minutes, $seconds );
                                            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                            $time_seconds = ( $time_seconds * $progress_lesson_procent ) / 100;
                                            $vimeo_id     = \Dkng\Wp\VideosApi::get_vimeo_id_by_url( $lesson1['video_link'] );

                                            if (
                                                ( !empty( $last_iteraction[0]['course'] ) && (int)$last_iteraction[0]['course'] == $post_id )
                                                &&
                                                ( !empty( $last_iteraction[0]['lesson'] ) && (int)$last_iteraction[0]['lesson'] == $j )
                                                &&
                                                ( !empty( $last_iteraction[0]['parent_lesson'] ) && (int)$last_iteraction[0]['parent_lesson'] == $i )
                                            ) {
                                                $checked = "checked";
                                            }  ?>
                                            <li class="lesson <?php echo $checked;?>" data-index="<?php echo $j;?>"
                                                data-video-id="<?php echo $video_id;?>"
                                                <?php /* onclick="loadPlaylistVideoIds(['<?php echo $video_id;?>//', 200]);" */ ?>
                                                data-seconds="<?php echo $time_seconds;?>" >
                                                <a href="" class="video-link" data-link="<?php echo $lesson1['video_link'];?>"
                                                   data-vimeo-id="<?php echo $vimeo_id;?>"
                                                >
                                                    <?php if ( (int)$progress_lesson_procent == 100 ) { ?>
                                                         <span class="number"><i class="fa fa-check"></i></span>
                                                    <?php } else {  ?>
                                                        <span class="number"><?php echo $i . '.' . $j;?></span>
                                                    <?php } ?>
                                                    <span class="video-name"><?php echo $lesson1['name'];?></span>
                                                    <span class="time"><?php echo $str_time1;?></span>
                                                    <div class="progress" >
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: <?php echo $progress_lesson_procent;?>%"
                                                             aria-valuenow="<?php echo $progress_lesson_procent;?>"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                            <li class="lesson"><?php echo __( "There are no lessons yet.", "dkng" );?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <?php
            $completed_courses = get_user_meta( $user->ID, 'completed_courses', true );
            $completed_courses = !empty( $completed_courses ) ? $completed_courses : array();
            if ( is_array( $completed_courses ) && !in_array( $post_id, $completed_courses ) ) { ?>
                <p class="complete_task_button btn btn-view <?php echo $disable;?>" data-course-id="<?php echo $post_id;?>">I've completed this course.</p>
            <?php } else { ?>
                <p class="btn btn-view"><?php echo __( "Already completed.", "dkng" );?></p>
            <?php } ?>
        </div>

    </div>

    <div class="container course-single">

        <div class="row">
            <div class="col-12 investment-right-holder">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs hide-after-element" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-faq-tab" data-toggle="tab" href="#nav-faq" role="tab" aria-controls="nav-faq" aria-selected="false">FAQ</a>
<!--                                <a class="nav-link " id="nav-transcript-tab" data-toggle="tab" href="#nav-transcript" role="tab" aria-controls="nav-transcript" aria-selected="true">Transcript</a>-->
                                <?php if ( !empty( $pdf_file ) ) { ?>
                                    <a class="nav-link" target="_blank" href="<?php echo $pdf_file;?>" role="tab" aria-controls="nav-downloadPlaybook" >
                                        <?php echo __( "Download Playbook", "dkng" );?>
                                    </a>
                                <?php } ?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 investment-right-holder  border-right">

                <div class="row">
                    <div class="col-12">

                        <div class="tab-content video-tabs" id="nav-tabContent">

                            <?php if ( !empty( $faqs ) ) { ?>
                                <div class="tab-pane fade show active" id="nav-faq" role="tabpanel" aria-labelledby="nav-faq-tab">
                                    <?php foreach ( $faqs as $faq ) { ?>
                                        <div class="faq" >
                                            <h6><?php echo $faq['title'];?></h6>
                                            <p class="grey"><?php echo $faq['text'];?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="tab-pane fade" id="nav-transcript" role="tabpanel" aria-labelledby="nav-transcript-tab">
                                <?php //foreach ( $single_transcript as $transcript ) { ?>
                                    <div class="transcript" >
                                        <?php if ( !empty( $single_transcript ) ) { ?>
                                            <h6><?php if ( !empty( $single_transcript['title'] ) ) echo $single_transcript['title'];?></h6>
                                            <p class="grey"><?php if ( !empty( $single_transcript['text'] ) ) echo $single_transcript['text'];?></p>
                                        <?php } ?>
                                    </div>
                                <?php //} ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 investment-right-holder">
                <div class="row">
                    <div class="col-12">
                        <h3><?php echo __( "Helpful Articles", "dkng" );?></h3>
                        <p class="grey"><?php echo __( "Some useful membership articles to support your learning.", "dkng" );?></p>
                    </div>
                    <div class="col-12 mt-2">
                        <?php require_once ( plugin_dir_path( __FILE__ ) . 'template-parts/sidebar/single-course.php' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endwhile;  ?>
<?php get_footer();
