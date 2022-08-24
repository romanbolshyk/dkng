<?php

namespace Dkng\Wp;

class CoursesActions {

    /**
     * Actions on Init
     */
    public function init_actions() {

        // enqueve js/CSS resources
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts_styles' ] );

        add_action( 'add_meta_boxes',  [ $this,   'listeners_box_add' ] );
        add_action( 'save_post',       [ $this,   'course_save_postdata' ] );

        // ajax actions
        add_action( 'wp_ajax_complete_course',           [ $this,  'complete_course_function' ] );
        add_action( 'wp_ajax_nopriv_complete_course',    [ $this,  'complete_course_function' ] );

        add_action( 'wp_ajax_read_course',               [ $this,  'read_course_function' ] );
        add_action( 'wp_ajax_nopriv_read_course',        [ $this,  'read_course_function' ] );
    }

    /**
     * Function of including scripts for current cpt
     *
     */
    public function enqueue_scripts_styles() {

        if (
            is_page_template( 'templates/dashboard-training.php' )
            || ( is_singular( 'courses') )
        ) {
            wp_enqueue_script( 'courses-scripts', SVN_PLUGIN_URL . '/assets/courses.js', array( 'jquery' ), 1, true );
        }
    }

    /**
     * Function completing course
     *
     */
    public function complete_course_function ( ) {

        if ( empty( $_POST['course_id'] ) ) {
            return;
        }

        $course_id  = ( !empty( $_POST['course_id'] ) ) ? $_POST['course_id'] : 0;
        $user       = wp_get_current_user();

        $completed_courses = get_user_meta ( $user->ID, 'completed_courses', true );
        if ( empty( $completed_courses ) ) $completed_courses = array();

        if ( !in_array( $course_id, $completed_courses ) ) {

            $progressing_courses = get_user_meta ( $user->ID, 'progressing_courses', true );
            foreach ( $progressing_courses as $k => $course ) {
                if ( (int)$course == (int)$course_id ) {
                    unset( $progressing_courses[$k] );
                }
            }
            update_user_meta ( $user->ID, 'progressing_courses', $progressing_courses );

            $completed_courses[] = $course_id;
            update_user_meta ( $user->ID, 'completed_courses', $completed_courses );
        }

        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function reading course ( status *in progress* )
     *
     */
    public function read_course_function ( ) {

        if ( empty( $_POST['course_id'] ) ) {
            return;
        }

        $course_id  = $_POST['course_id'];
        $user       = wp_get_current_user();

        $completed_courses = get_user_meta ( $user->ID, 'completed_courses', true );
        if ( in_array( $course_id, $completed_courses ) ) {
            return;
        }

        $progressing_courses = get_user_meta ( $user->ID, 'progressing_courses', true );
        if ( empty( $progressing_courses ) ) $progressing_courses = array();

        if ( !in_array( $course_id, $progressing_courses ) ) {
            $progressing_courses[] = $course_id;
            update_user_meta ( $user->ID, 'progressing_courses', $progressing_courses );
        }

        wp_send_json( array( 'status' => 'Done' ), 200 );
    }

    /**
     * Function adding metabox for courses
     *
     */
    public function listeners_box_add() {
        add_meta_box( 'my-meta-box-id', 'Course listeners', array( $this, 'listeners_box' ), 'courses', 'normal', 'high' );
    }

    /**
     * Function adding html layout for listeners list
     *
     * @param $post
     */
    public function listeners_box( $post ) {
        $unlisteners_list  = get_post_meta( $post->ID, 'unlisteners_list', true );

        $standart_checked  = ( ( $unlisteners_list == "none" ) && !is_array( $unlisteners_list ) )  ? "" : "checked";
        $none_checked      = ( ( $unlisteners_list == "none" ) && !is_array( $unlisteners_list ) )  ? "checked" : "";

        $users  = get_users( array(
            'role__not_in' => array( 'administrator' ),
            'role__in'     => array( 'subscriber' ),
            'fields'       => array( 'display_name', 'id' ),
        ) );

        ?>
        <div>
            <p>
                <span class="span_radios" >
                    <input type="radio" name="need_listeners" id="yes_listener" <?php echo $standart_checked;?> value="yes">
                    <label for="yes_listener">Yes</label>
                </span>
                <span class="span_radios" >
                    <input type="radio" name="need_listeners" id="no_listener" <?php echo $none_checked;?> value="no">
                    <label for="no_listener">No</label>
                </span>
            </p>
            <p><label for="unlisteners_list"><?php _e( "Listeners:", "dkng" );?> </label></p>
            <select name='unlisteners_list[]' id='unlisteners_list' multiple >
                <?php foreach ( $users as $user ) {
                    if ( empty( $unlisteners_list ) ) {
                        $selected = "selected";
                    }
                    else {
                        $selected = ( ( is_array( $unlisteners_list ) ) && ( in_array( $user->id, $unlisteners_list ) ) ) ? "" : "selected";
                    }
                    ?>
                    <option value="<?php echo esc_attr( $user->id ); ?>" <?php echo $selected; ?>
                            style="padding: 6px;border-bottom: 2px solid silver;">
                        <?php echo esc_html( $user->display_name ); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php
    }

    /**
     * Function callback on saving course
     *
     * @param $post_id
     */
    public function course_save_postdata( $post_id ){

        $need_listeners = !empty( $_POST['need_listeners'] ) ? sanitize_text_field( $_POST['need_listeners'] ) : "";
        if ( $need_listeners == "yes" ) {
            $listeners_post   = isset( $_POST['unlisteners_list'] ) ? (array) $_POST['unlisteners_list'] : array();
            $listeners_post   = array_map( 'esc_attr', $listeners_post );
            $unlisteners_list = array();

            $users  = get_users( array (
                'role__not_in' => array( 'administrator' ),
                'role__in'     => array( 'subscriber' ),
                'fields'       => array( 'id' ),
            ) );

            foreach ( $users as $user ) {
                if ( !in_array( $user->id, $listeners_post ) ) {
                    $unlisteners_list[] = (int)$user->id;
                }
            }

            if ( array_key_exists( 'unlisteners_list', $_POST ) ) {
                update_post_meta( $post_id, 'unlisteners_list', $unlisteners_list );
            }
        }
        else {
            update_post_meta( $post_id, 'unlisteners_list', 'none' );
        }
    }

}
