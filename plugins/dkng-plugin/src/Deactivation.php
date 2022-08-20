<?php
namespace Dkng\Wp;


class Deactivation {

    const TAG = 'dkng-plugin';

    /**
     * Function by deactivating plugin
     *
     */
    static function do_my_hook() {
        Deactivation::deletingPages();
    }

    /**
     * Function deleting Pages
     *
     */
    static function deletingPages() {

        $user_id = get_current_user_id();
        /*
        $pages_id = explode( '-', get_user_meta( $user_id, '_wp_pages_id', true ) );
        foreach ( $pages_id as $id ) {
            wp_delete_post( $id, true );
        }

        delete_user_meta( $user_id, '_wp_pages_id' ); - need to uncomment after finish
        */
    }

}
