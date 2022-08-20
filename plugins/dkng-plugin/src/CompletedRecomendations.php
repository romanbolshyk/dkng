<?php

namespace Dkng\Wp;


class CompletedRecomendations
{

    /**
     * Main function of tracking system
     *
     */
    public function main() {
        // add_action( 'admin_menu', [ $this, 'prowp_create_menu' ] );

//        add_action( 'wp_ajax_thing_to_do',         [ $this, 'thing_to_do_function' ] );
//        add_action( 'wp_ajax_nopriv_thing_to_do',  [ $this, 'thing_to_do_function' ] );
    }

    /**
     * Create menus in plugin
     */
    public function prowp_create_menu() {
        add_menu_page(
            'Completed Recomendations page',
            'Completed Recomendations',
            'manage_options',
            'completed_recomendations',
            [ $this, 'completed_recomendations_page' ],
            'dashicons-admin-site-alt'
        );
    }

    /**
     * Function getting all tracking data for tracking page
     *
     * @return array|object|null
     */
    private function get_all_completed_recomendations_data() {
        global $wpdb;
        $table_name  = $wpdb->prefix . 'completed_recomendations';
        $results     = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A );

        return $results;
    }

    /**
     * Function getting all tracking data for tracking page
     *
     * @param $user_id
     * @return array|object|null
     */
    public function get_all_done_things_by_user( $user_id ) {
        global $wpdb;
        $table_name  = $wpdb->prefix . 'completed_recomendations';
        $results     = $wpdb->get_results("SELECT id_r FROM $table_name where id_u = $user_id", ARRAY_A );

        return $results;
    }

    /**
     * Function getting completed recomendations by params
     *
     * @param $gets
     * @return array|object|null
     */
    private function get_completed_recomendations_data_by_params( $gets ) {

        global $wpdb;
        $table_name  = $wpdb->prefix . 'completed_recomendations';

        $sql = "SELECT * FROM $table_name WHERE ";
        $i   = 0;
        foreach ( $gets as $k => $get ) {
            $i++;
            if ( $i == 1 ) {
                $sql .= "$k = $get ";
            }
            else {
                $sql .= "AND $k = $get ";
            }
        }

        $results = $wpdb->get_results(
            $sql , ARRAY_A
        );

        return $results;

    }

    /**
     * Function checking if exist completed recommendation by params
     *
     * @param $id_u
     * @param $id_r
     * @return array|object|null
     */
    public static function check_completed_recomendation( $id_u, $id_r ) {
        global $wpdb;
        $table_name  = $wpdb->prefix . 'completed_recomendations';

        $results     = $wpdb->get_results(
            $wpdb->prepare( "SELECT id FROM $table_name  
                        WHERE id_u = %d AND id_r = %s", $id_u, $id_r
            ), ARRAY_A
        );

        return $results;
    }

    /**
     * Function saving data to db
     *
     * @param $id_u
     * @param $id_r
     * @param $type
     * @return bool
     */
    private function save_to_db( $id_u, $id_r, $type ) {

        if ( $type == 'save' ) {
            $saved_things_to_do  = get_user_meta( $id_u, 'saved_things_to_do', true );
            $saved_things_to_do  = ( empty( $saved_things_to_do ) ) ? array() : $saved_things_to_do;

            if ( !in_array( $id_r, $saved_things_to_do ) ) {
                $saved_things_to_do[] = $id_r;
                update_user_meta( $id_u, 'saved_things_to_do', $saved_things_to_do );
            }
        }
        else {
            global $wpdb;

            $name = ( $type == 'done' ) ? 'completed_recomendations' : 'not_for_me_recommendations';

            $saved_things_to_do = get_user_meta( $id_u, 'saved_things_to_do', true );
            $saved_things_to_do = ( empty( $saved_things_to_do ) ) ? array() : $saved_things_to_do;

            if ( in_array( $id_r, $saved_things_to_do ) ) {
                $key = array_search( $id_r, $saved_things_to_do );
                if ( false !== $key ) {
                    unset( $saved_things_to_do[$key] );
                }
                update_user_meta( $id_u, 'saved_things_to_do', $saved_things_to_do );
            }

            $week_number  = get_user_meta( $id_u, 'week_number', true );
            $week_number  = !empty( $week_number ) ? $week_number : 1;
            $user_phase   = get_field( 'user_phase', 'user_'. $id_u );
            $week_done    = get_user_meta( $id_u, 'things_done-' . $user_phase, true );
            $week_done    = !empty( $week_done ) ? $week_done : array();

            $week_done['week_'. $week_number][]  = $id_r;
            update_user_meta( $id_u, 'things_done-' . $user_phase, $week_done );

            $table_name  = $wpdb->prefix . $name;
            $data        = array (
                'id_u'   => $id_u,
                'id_r'   => $id_r
            );
            $wpdb->insert( $table_name, $data );

            $this->finish_phase_things( $id_u );
        }

        return true;

    }

    /**
     * Function checking if all thing from current phase is done then allow to see things from next phase
     *
     * @param $id_u
     */
    private function finish_phase_things( $id_u ) {

        $user_phase = get_field( 'user_phase', 'user_'. $id_u );
        $new_phase  = explode( 'phase', $user_phase );
        $new_phase  = (int)$new_phase[1]+1;

        /* Old functionality
        $query  =  array(
            'post_type'      => 'recomendations',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'thing_to_do_phase',
                    'value'   => $user_phase,
                    'compare' => '=',
                ),
            ),
            'order'          => 'ASC',
        );
        $recomendations   = new \WP_Query( $query );
        $all_things_phase = $recomendations->found_posts;

        $week_done        = get_user_meta( $id_u, 'things_done-' . $user_phase, true );
        $week_done        = !empty( $week_done ) ? $week_done : array();
        $week_number      = get_user_meta( $id_u, 'week_number', true );

        $summary = 0;
        for ( $i = 1; $i <= $week_number; $i++ ) {
            $summary += count( $week_done['week_'. $i] );
        }

        if ( (int)$summary >= (int)$all_things_phase ) {
            update_field( 'user_phase', 'phase'. $new_phase, 'user_'. $id_u );
        }
        */

        $user_phase         = get_field( 'user_phase', 'user_'. $id_u );
        $not_for_me_model   = new NotForMeRecomendations();

        $not_for_me_things  = $not_for_me_model->get_all_not_for_me_recomendations_by_user( $id_u );
        $done_things        = $this->get_all_done_things_by_user( $id_u );
        $done_things_array  = array();
        $not_things_array   = array();

        foreach ( $done_things as $v ) {
            $done_things_array[] = $v['id_r'];
        }
        foreach ( $not_for_me_things as $v ) {
            $not_things_array[]  = $v['id_r'];
        }
        $excluded_things   = array_merge( $done_things_array, $not_things_array );

        $query  =  array(
            'post_type'      => 'recomendations',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'thing_to_do_phase',
                    'value'   => $user_phase,
                    'compare' => '=',
                ),
            ),
            'order'         => 'ASC',
            'post__not_in'  => $excluded_things
        );
        $recomendations   = new \WP_Query( $query );
        $recomendations   = $recomendations->posts;

        if ( ( count( $recomendations ) < 1 ) && ( $user_phase != 'phase5' ) ) {
            update_field( 'user_phase', 'phase'. $new_phase, 'user_'. $id_u );
        }

    }

    /**
     * Tracking system page
     *
     */
    public function completed_recomendations_page() {
        $gets           = array();
        $recomendations = get_posts( 'post_type=recomendations&post_status=publish&posts_per_page=-1');
        $users          = get_users( 'orderby=id&role=subscriber' );
        $id_r_get       = sanitize_text_field( $_GET['id_r'] );
        $id_u_get       = sanitize_text_field( $_GET['id_u'] );
        ?>
        <form class="completed_system" method="get">
            <input type="hidden" name="page" value="completed_recomendations">
            <p>
                <span><?php echo __( "List of all Users (subscribers)", "dkng" );?></span>
            </p>
            <p>
                <select name="id_u">
                    <option value=""><?php echo __( "Choose User", "dkng" );?></option>
                    <?php foreach ( $users as $user ) {
                        if ( $id_u_get ) $selected = ( $user->ID == $id_u_get ) ? "selected" : ""; ?>
                        <option value="<?php echo $user->ID;?>" <?php echo $selected;?> ><?php echo $user->user_firstname . ' ' .  $user->user_lastname;?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <span><?php echo __( "Recomendations", "dkng" );?></span>
            </p>
            <p>
                <select name="id_r">
                    <option value=""><?php echo __( "Choose recomendation", "dkng" );?></option>
                    <?php foreach ( $recomendations as $recomendation ) {
                        if ( $id_r_get ) $selected = ( $recomendation->ID == $id_r_get ) ? "selected" : ""; ?>
                        <option value="<?php echo $recomendation->ID;?>" <?php echo $selected;?> ><?php echo get_the_title($recomendation->ID);?></option>
                    <?php } ?>
                </select>
            </p>
            <input type="submit" value="Submit">
        </form>

        <h3><?php echo __( "Completed recomendations:", "dkng" );?></h3>
        <?php
        if ( !empty( $id_u_get ) ) {
            $gets['id_u']  = $id_u_get;
        }
        if ( !empty( $id_r_get ) ) {
            $gets['id_r'] = $id_r_get;
        }
        $this->set_html_layout( $gets );
    }

    /**
     * Function setting html layout by params
     *
     * @param $gets
     */
    private function set_html_layout( $gets ) {
        if ( empty ( $gets ) ) {
            $data  = $this->get_all_completed_recomendations_data();
        } else {
            $data  = $this->get_completed_recomendations_data_by_params( $gets );
        }
        if ( !$data ) {
            echo "<h4>" . __( 'There are no data for these parameters yet', 'dkng' ) . "</h4>";
            exit;
        }  ?>
        <table border="1" class="tablesorter" id="completed_recomendation_table" >
            <thead>
            <tr class=''>
                <th class='tracking_th head'><?php echo __( 'User', 'dkng' ); ?></th>
                <th class='tracking_th head'><?php echo __( 'Recommendation', 'dkng' ); ?></th>
            </tr>
            </thead>
            <?php foreach ( $data as $item ) : ?>
                <?php
                $user          = get_userdata( (int)$item['id_u'] );
                $recomendation = get_post( (int)$item['id_r'] );

                if ( $user && ( !empty( $recomendation ) && ( $recomendation->post_status == 'publish' ) ) ) { ?>
                    <tr>
                        <th class='tracking_th'><?php echo $user->user_firstname . ' ' . $user->user_lastname; ?></th>
                        <th class='tracking_th'><?php echo $recomendation->post_title; ?></th>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
        </table>
        <?php
    }

    /**
     * Function callback for saving data to db from ajax
     *
     */
    public function thing_to_do_function() {
        $id_u = sanitize_text_field( $_POST['id_u'] );
        $id_r = sanitize_text_field( $_POST['id_r'] );
        $type = sanitize_text_field( $_POST['type'] );

        if ( empty( $id_u ) || empty( $id_r ) ) {
            wp_send_json( array( 'error' => true, 'message' => 'Empty fields.' ), 200 );
        }

        $this->save_to_db( $id_u, $id_r, $type );

        wp_send_json( array( 'error' => false, 'message' => 'Recomendation is completed.' ), 200 );
    }

    /**
     * Function monday things operations
     *
     * @param $monday_thing
     * @param $monday
     */
    public function monday_thing_operations( $monday ) {
        $user = wp_get_current_user();

        $user_phase    = get_field( 'user_phase', 'user_'.$user->ID );

        //$monday      = "Oct 1th"; // manually changing
        $monday_thing  = get_user_meta( $user->ID, 'monday_thing_to_do-' . $user_phase, true );
        $monday_thing  = !empty( $monday_thing ) ? $monday_thing : '';

        if ( empty( $monday_thing ) ) {
            $week_number = 1;
            update_user_meta( $user->ID, 'changed_monday', 0 );
            update_user_meta( $user->ID, 'changed_monday', 0 );

            update_user_meta( $user->ID, 'monday_thing_to_do-' . $user_phase, $monday );
            update_user_meta( $user->ID, 'week_number', $week_number );
        }
        elseif ( !empty( $monday_thing) && ( $monday_thing != $monday ) ) {
            $week_number  = get_user_meta( $user->ID, 'week_number', true );
            $week_number  = !empty( $week_number ) ? $week_number : 1;
            $week_number  += 1;
            update_user_meta( $user->ID, 'week_number', $week_number );

            update_user_meta( $user->ID, 'changed_monday', 1 );
            update_user_meta( $user->ID, 'changed_monday1', 1 );
            update_user_meta( $user->ID, 'monday_thing_to_do-' . $user_phase, $monday );
        }
        else {
            update_user_meta( $user->ID, 'changed_monday', 0 );
            update_user_meta( $user->ID, 'changed_monday', 1 );
        }

        return true;
    }

    /**
     * Function getting excluded tings for user
     *
     * @return array
     */
    public function getting_excluded_things() {

        $user = wp_get_current_user();

        $excluded_things     = array();

        return $excluded_things;
    }

}
