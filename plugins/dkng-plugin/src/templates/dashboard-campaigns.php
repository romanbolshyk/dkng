<?php

/*
 *  Template Name: Dashboard Campaigns
 *
 */

//if ( !is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/advisorlogin', 307 );
//    exit;
//}

get_header();

$campaigns_obj  = new \Dkng\Wp\Campaigns();
$campaigns_btn_class = ( !empty( $_GET['cloned'] ) && ( $_GET['cloned']  == '1') ) ? 'cloned' : 'new';
$get_campaigns  = $campaigns_obj->get_campaigns( 10, $campaigns_btn_class );
$user_campaigns_reports = $campaigns_obj->get_user_campaigns( -1, $campaigns_btn_class );

$count_per_page = 20;
$all_campaigns  = $campaigns_obj->get_campaigns( $count_per_page, $campaigns_btn_class );

$general_statistic        = $campaigns_obj->get_general_statistic( $count_per_page );
$general_sent_percent     = $general_statistic['sent'];
$general_opened_percent   = $general_statistic['opened'];
$general_clicked_percent  = $general_statistic['clicked'];

$general_sent_percent     = ( empty( $general_sent_percent ) || is_nan( $general_sent_percent ) ) ? 0 : $general_sent_percent;

//$general_opened_percent   = ( $general_opened_percent * 100 ) / ( $general_sent_percent );
//$general_clicked_percent  = ( $general_clicked_percent * 100 ) / ( $general_sent_percent );

$general_opened_percent   = round( $general_opened_percent, 2 );
$general_clicked_percent  = round( $general_clicked_percent, 2 );

$general_opened_percent   = ( empty( $general_opened_percent ) || is_nan( $general_opened_percent ) ) ? 0 : $general_opened_percent;
$general_clicked_percent  = ( empty( $general_clicked_percent ) || is_nan( $general_clicked_percent ) ) ? 0 : $general_clicked_percent;

$count_all      = count( $campaigns_obj->get_campaigns( -1, $campaigns_btn_class )  );
$get_all        = ( !empty( $_GET['all'] ) && ( (int)$_GET['all'] == 1 )  ) ? true : false;
$get_page       = ( !empty( $_GET['page'] ) ) ? sanitize_text_field( $_GET['page'] ) : '';

$user           = wp_get_current_user();
$user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
$user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

$url             = $_SERVER['REQUEST_URI'];
$user_list_limit = get_field('user_lists_limit', 'options');
$user_list_limit = !empty( $user_list_limit ) ? (int)$user_list_limit : 5;

$count_allowed_lists = \Dkng\Wp\UsersLists::get_leads_by_user_id( $user->ID );
$style_allowed_lists = ( $count_allowed_lists['count'] >= $user_list_limit ) ? 'pointer-events: none; opacity: 0.5;' : '';


?>

    <div class="container campaigns" data-count-userlists-limit="<?php echo $user_list_limit;?>">
        <?php
        if ( !empty( $get_page ) && ( $get_page == 'all_reports' ) ) {
            require_once 'template-parts/campaigns/all_reports.php';
        }

        if ( !$get_page ) {
            require_once 'template-parts/campaigns/all_campaigns.php';
        }

        if ( !empty( $get_page ) && ( $get_page == 'unsubscribers' ) ) {
            require_once 'template-parts/user_lists/unsubscribers_list.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'all_leads' ) ) {
            require_once 'template-parts/user_lists/contact_list.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'add_lead' ) ) {
            require_once  'template-parts/user_lists/import_page1.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'create_lead_manually' ) ) {
            require_once  'template-parts/user_lists/admin-create-new-list.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'import_wealthbox_list1' ) ) {
            require_once 'template-parts/user_lists/import_wealthbox_list1.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'import_wealthbox_list' ) ) {
            require_once 'template-parts/user_lists/import_wealthbox_list.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'add_lead/build_list' ) ) {
            require_once  'template-parts/user_lists/import_page-build-list.php';
        }
        elseif ( !empty( $get_page ) && ( $get_page == 'add_lead/upload' ) ) {
            require_once  'template-parts/user_lists/import_page-uploading.php';
        }

        $uploaded    = strstr( $url, '?page=leads/uploaded/id' );
        $single_lead = strstr( $url, '?page=leads/id' );
        if ( !empty( $get_page ) && ( $uploaded ) ) {
            require_once 'template-parts/user_lists/uploaded_single_lead_page.php';
        }
        if ( !empty( $get_page ) && ( $single_lead ) ) {
            require_once 'template-parts/user_lists/single_lead_page.php';
        }
        ?>
    </div>
<?php
get_footer();