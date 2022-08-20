<?php
namespace Dkng\Wp;

class Activation {
    const TAG = 'dkng-plugin';

    public static function do_my_hook() {
        Activation::creating_pages();
//        Activation::creating_completed_recomendations_table();
    }

    /**
     * Function initializing functions
     *
     */
    public static function creating_pages() {

        $user_id = get_current_user_id();
        /*
        $id1  = Activation::creatingPage( 'Admin Dashboard', 'templates/dashboard-home.php',          true,  false, false );
        $id2  = Activation::creatingPage( 'Admin Content',   'templates/dashboard-content.php',       true,  false, false );
        $id3  = Activation::creatingPage( 'Admin Training',  'templates/dashboard-training.php',      true,  false, false );
        $id4  = Activation::creatingPage( 'Home',            'templates/home.php',                    false, true,  false );
        $id5  = Activation::creatingPage( 'About',           'templates/about-us.php',                false, false, false );
        $id6  = Activation::creatingPage( 'Services',        'templates/services.php',                false, false, false );
        $id7  = Activation::creatingPage( 'Blog',            'templates/blog.php',                    false, false, false );
        $id8  = Activation::creatingPage( 'Contact',         'templates/contact.php',                 false, false, false );
        $id9  = Activation::creatingPage( 'Advisorlogin',    'templates/login.php',                   false, false, 'login );
        $id10 = Activation::creatingPage( 'Sign Up',         'templates/sign-up.php',                 false, false, 'sign-up' );
        $id11 = Activation::creatingPage( 'Sign Up 2',       'templates/sign-up-without-payment.php', false, false, 'sign-up2' );
        $pages_id  = $id1 . '-' . $id2 . '-' . $id3 . '-' . $id4 . '-' . $id5 . '-' . $id6. '-' . $id7. '-' . $id8.
                 '-' . $id9 . '-' . $id10 . '-' . $id11;
        add_user_meta( $user_id, '_wp_pages_id', $pages_id );
         - need to uncomment after finish
        */

    }

    /**
     * Function creating page by params
     *
     * @param $user_id
     * @param $name
     * @param $template_file
     * @return int|\WP_Error
     */
    public static function creatingPage( $name, $template_file, $admin_page,  $main, $sign_up = false ) {

        $content_text = '';
        if ( !empty( $sign_up ) ) {
            $login_link  = get_site_url() . '/admin-dashboard';
            $login_href  = '[login_form redirect="' . $login_link . '"]';
            if ( $sign_up == 'sign-up' ) {
                $content_text = '[register_form]';
            }
            elseif ( $sign_up == 'sign-up2' ) {
                $content_text = '[register_form id="2"]';
            }
            elseif ( $sign_up == 'login' ) {
                $content_text = $login_href;
            }
        }

        $post = array(
            'post_author'    => 1,
            'post_content'   => $content_text,
            'post_date'      => current_time( 'mysql' ),
            'post_status'    => 'publish',
            'post_title'     => $name,
            'post_type'      => 'page'
        );

        $post_id = wp_insert_post( $post, true );
        update_post_meta( $post_id , '_wp_page_template', $template_file );

        if ( $main ) {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $post_id );
        }

        return $post_id;
    }


}
