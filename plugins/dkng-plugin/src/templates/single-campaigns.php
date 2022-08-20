<?php

$post_terms = wp_get_object_terms( get_the_ID(), 'campaigns-category', array('fields' => 'slugs') );
$auth_id    = get_post_field( 'post_author', get_the_ID() );
$user       = wp_get_current_user();

if ( !is_user_logged_in()  ) {
    wp_redirect( get_site_url() . '/advisorlogin', 307 );
    exit;
}
/**
 * Security for cloned campaign and if author is equal to cuurent user
 *
 */
if ( in_array( 'cloned', $post_terms ) && is_user_logged_in() && ( $user->ID != $auth_id ) ) {
    wp_redirect( get_site_url() . '/admin-campaigns/?cloned=1', 307 );
    exit;
}

get_header();

$campaigns_obj  = new \Dkng\Wp\Campaigns();
$get_report     = ( !empty( $_GET['report'] ) && ( (int)$_GET['report'] == 1 )  ) ? true : false;

$user_campaigns = get_user_meta( $user->ID, 'user_campaigns', true );
$user_campaigns = ( !empty( $user_campaigns ) ) ? $user_campaigns : array();

$leads          = \Dkng\Wp\UsersLists::get_leads_by_user_id( $user->ID );
?>
<?php while ( have_posts() ) : the_post();
    $post_id          = get_the_ID();
    $user             = wp_get_current_user();
    $emails           = get_field( 'emails', $post_id );
    $pdf_campaign     = get_field( 'campaign_pdf_file', $post_id );

    $campaign_users_statistics = get_user_meta( $user->ID, 'campaign_users_statistics', true );
    $users_statistics          = ( !empty( $campaign_users_statistics ) ) ? $campaign_users_statistics : array();
    $campaign_users_statistics = ( !empty( $campaign_users_statistics ) && !empty( $campaign_users_statistics[$post_id] ) ) ? $campaign_users_statistics[$post_id] : array();

    $all_percent      = $campaigns_obj->get_statistic_by_campaign( $post_id );
    $user_list        = $all_percent['user_list'];

    $user_email       = get_field( 'email','user_' . $user->ID );
    $full_name        = $user->user_firstname . ' ' . $user->user_lastname;
    $user_phone       = get_field( 'phone',       'user_' . $user->ID );
    $user_address     = get_field( 'address',     'user_' . $user->ID );
    $user_company     = get_field( 'name',        'user_' . $user->ID );
    $user_website     = get_field( 'custom_site', 'user_' . $user->ID );
    $user_position    = get_field( 'position',    'user_' . $user->ID );

    $email_disclosure = get_field( 'email_disclosure','user_' . $user->ID );

    $upload_dir       = wp_upload_dir();
    $file_name        = get_user_meta( $user->ID, 'avatar', true );
    $fileurl          = $upload_dir['basedir'] . '/' . $file_name;
    $filepath         = $upload_dir['baseurl'] . '/' . $file_name;
    $fileurl          = ( file_exists( $fileurl ) && !empty( $file_name ) ) ? $filepath : get_site_url() . "/wp-content/themes/seven/dist/img/avatar.png";

    $status_background = $campaigns_obj->get_status_and_background( $user_campaigns, $post_id );
    $ribbon_background = $status_background['ribbon_background'];
    $status            = $status_background['status'];
    ?>

    <div class="container single-campaign">
        <?php
        if ( $get_report ) {
            require_once 'template-parts/campaigns/single_campaign_report.php';
        }
        elseif ( !$get_report ) {
            require_once 'template-parts/campaigns/single_campaign.php';
        } ?>
    </div>
<?php endwhile;  ?>
<?php get_footer();
