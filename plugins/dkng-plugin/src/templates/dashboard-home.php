<?php
//if ( !is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/advisorlogin', 301 );
//    exit;
//}
get_header();

$user                = wp_get_current_user();


/* Article part */
$article_actions_obj = new \Dkng\Wp\ArticlesActions();

$preparing_articles_arr = $article_actions_obj->preparing_articles_objects();
$articles_arr        = array( 'post_type' => 'articles', 'posts_per_page' => 5, 'post__not_in' => $preparing_articles_arr['excluded_articles'] );
$articles_arr        = array_merge( $articles_arr, $preparing_articles_arr['original_articles_arr'] );
$articles            = new WP_Query( $articles_arr );
/* End of Article part */

$webinars            = new WP_Query( array( 'post_type' => 'webinars', 'posts_per_page' => 10  ) );
$recomendation_tags  = get_terms('recomendations-tag');
$courses             = new WP_Query( array( 'post_type' => 'courses',  'posts_per_page' => 40  ) );

$completed_courses   = get_user_meta( $user->ID, 'completed_courses' );
$count_completed     = empty( $completed_courses[0] ) ? 0 : count( $completed_courses[0] );
$progressing_courses = get_user_meta( $user->ID, 'progressing_courses' );

$shared_articles     = get_user_meta( $user->ID, 'shared_articles' );
$count_shared        = empty( $shared_articles[0] ) ? 0 : count( $shared_articles[0] );

$read_articles       = get_user_meta( $user->ID, 'read_articles' );
$count_read          = empty( $read_articles[0] ) ? 0 : count( $read_articles[0] );

$monday              = date( 'M jS', strtotime( 'monday this week' ) );
$sunday              = date( 'M jS', strtotime( 'sunday this week' ) );

/* */
$last_iteraction     = get_user_meta( $user->ID, 'last_iteraction' );
if ( !empty( $last_iteraction ) ) {
    $link_iteraction  = get_permalink( $last_iteraction[0]['course'] );
    $title_iteraction = get_the_title( $last_iteraction[0]['course'] );
}

$video_module_title  = get_field( 'video_module_title', 'option' );
$video_module_link   = get_field( 'video_module_link',  'option' );


/* Things To Do Preparing Info */
$completed_things    = new \Dkng\Wp\CompletedRecomendations();
$user_phase          = get_field( 'user_phase', 'user_'.$user->ID );

// Monday thing operation for Things to do block
$completed_things->monday_thing_operations( $monday );

$saved_things_to_do  = get_user_meta( $user->ID, 'saved_things_to_do', true );
$saved_things_to_do  = ( empty( $saved_things_to_do ) ) ? array() : $saved_things_to_do;

$excluded_things     = $completed_things->getting_excluded_things();
/* End Things To Do Preparing Info */

/* Campaigns Preparing Info */
$campaigns_obj       = new \Dkng\Wp\Campaigns();
$get_campaigns       = $campaigns_obj->get_campaigns( 4, 'start_time' );

$user_campaigns      = get_user_meta( $user->ID, 'user_campaigns', true );
$user_campaigns      = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();


$count_per_page      = 5;
$all_campaigns       = $campaigns_obj->get_campaigns( $count_per_page );
$user_all_campaigns  = $campaigns_obj->get_user_campaigns( $count_per_page );
$latest_campaigns    = $campaigns_obj->get_campaigns( 3 );

$general_statistic        = $campaigns_obj->get_general_statistic( 20 );
$general_sent_percent     = $general_statistic['sent'];
$general_opened_percent   = $general_statistic['opened'];
$general_clicked_percent  = $general_statistic['clicked'];

$general_sent_percent     = ( empty( $general_sent_percent ) || is_nan( $general_sent_percent ) ) ? 0 : $general_sent_percent;

$general_opened_percent   = round( $general_opened_percent, 2 );
$general_clicked_percent  = round( $general_clicked_percent, 2 );
$general_sent_percent     = round( $general_sent_percent, 2 );

$general_opened_percent   = ( empty( $general_opened_percent ) || is_nan( $general_opened_percent ) ) ? 0 : $general_opened_percent;
$general_clicked_percent  = ( empty( $general_clicked_percent ) || is_nan( $general_clicked_percent ) ) ? 0 : $general_clicked_percent;

/* End of Campaigns Preparing Info */
?>
<div id="collapse-info"  class="welcome_block collapse">
    <div class="container">
        <div class="row">
            <?php require_once 'template-parts/dashboard/welcome_section.php';?>
        </div>
    </div>
</div>
<div class="container home-container">
    <div class="row">
        <div class="col-12">
            <div class="white-element">
                <?php require_once 'template-parts/dashboard/info_section.php';?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-7">
            <div class="white-element mb-100">
                <div class="row">
                    <?php require_once 'template-parts/dashboard/articles_section.php';?>
                </div>
            </div>
            <div class="white-element mb-100">
                <div class="row">
                    <?php require_once 'template-parts/dashboard/courses_section.php';?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="white-element right-holder-video">
                <div class="row video_module_block" id="video_module player3">
                    <div class="col-12">
                        <?php require_once 'template-parts/dashboard/video_section.php';?>
                    </div>
                </div>
            </div>

            <div class="white-element right-holder">
                <div class="row">
                    <?php require_once 'template-parts/dashboard/things_to_do_section.php';?>
                </div>
            </div>
            <div class="white-element webinars-holder">
                <div class="row">
                    <?php require_once 'template-parts/dashboard/webinars_section.php';?>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php require_once 'template-parts/campaigns/home_dashboard_campaigns.php';?>
        </div>
    </div>
</div>

<?php
get_footer();
