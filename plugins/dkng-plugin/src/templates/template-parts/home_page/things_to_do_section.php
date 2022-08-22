<?php
/* Get right count of things to do which need to add for new week */
$number = 7;
$count  = 0;

$user_phase      = get_field( 'user_phase', 'user_'. $user->ID );
$week_done       = get_user_meta( $user->ID, 'things_done-' . $user_phase, true );

$week_done       = !empty( $week_done ) ? $week_done : array();
$week_number     = get_user_meta( $user->ID, 'week_number', true );
$changed_monday  = get_user_meta( $user->ID, 'changed_monday', true );
$changed_monday1 = get_user_meta( $user->ID, 'changed_monday1', true );

$summary = 0;
for ( $i = 1; $i < $week_number; $i++ ) {
    if ( !empty( $week_done['week_'. $i] ) && is_array( $week_done['week_'. $i] ) ) {
        $summary += count( $week_done['week_'. $i] );
    }
}

if ( is_array( $week_done ) && !empty( $week_done ) ) {
    $new_number = (int)$summary + $number;
}
else {
    $new_number = $number;
}

$count  = ( ( $changed_monday == '1' ) && ( $changed_monday1 == '1' ) ) ? $new_number : $number;

$week_done_count = !empty( $week_done['week_'.$week_number] ) ? count( $week_done['week_'.$week_number] ) : 0;
$week_done_count = $number-$week_done_count;

$next_phase = explode( 'phase', $user_phase );
$next_phase = (int)$next_phase[1]+1;
$next_phase = 'phase'.$next_phase;

$add_recomendations = array();
$query  =  array(
    'post_type'      => 'recomendations',
    'posts_per_page' => $count,
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
$recomendations   = new WP_Query( $query );
$recomendations   = $recomendations->posts;
$count_things     = count( $recomendations );

if ( $count_things < $number ) {
    $diff_count = $number - $count_things;

    $query  =  array(
        'post_type'      => 'recomendations',
        'posts_per_page' => $diff_count,
        'meta_query'     => array(
            array(
                'key'     => 'thing_to_do_phase',
                'value'   => $next_phase,
                'compare' => '=',
            ),
        ),
        'order'         => 'ASC',
        'post__not_in'  => $excluded_things
    );
    $add_recomendations = new WP_Query( $query );
    $add_recomendations = $add_recomendations->posts;

}
$recomendations   = array_merge( $recomendations, $add_recomendations );
$count_things1    = count( $recomendations );

?>
<div class="sv-tasklist">
    <div class="sv-tasklist__header">
        <h4 class="sv-tasklist__title"><?php  echo __( "Things to Do This Week", "dkng" );?></h4>
        <p class="sv-tasklist__period"><?php echo $monday .' - ' .  $sunday;?></p>
    </div>

    <ul class="tabs">
        <li class="tab-link active" data-tab="tab-1"><?php echo __( "This Week", "dkng" );?></li>
        <li class="tab-link" data-tab="tab-2"><?php echo __( "Saved", "dkng" );?></li>
    </ul>

    <div id="tab-1" class="tab-content active">
        <div class="tab-content__head">
            <span></span>
            <div class="tab-content__labels">
                <span><?php echo __( "Done", "dkng" );?></span>
                <span><?php echo __( "Save", "dkng" );?></span>
                <span><?php echo __( "Not for Me", "dkng" );?></span>
            </div>
        </div>

        <?php
        $i=0;
        foreach ( $recomendations as $recomedation ) {
            $i++;

            $checked     = ( \Dkng\Wp\CompletedRecomendations::check_completed_recomendation( $user->ID, $recomedation->ID ) ) ? "checked" : "";
            $background  = ( empty( $checked ) ) ? "background: lightgrey" : "";
            $disabled    = !in_array('subscriber', $user->roles ) ? true : false;

            $thing_phase = get_field( 'thing_to_do_phase', $recomedation->ID );
            if (
                ( !in_array( $recomedation->ID, $saved_things_to_do ) )
                &&
                ( $i <= $week_done_count )
//                                    && ( !in_array( $recomedation->ID, $excluded_things ) )
            ) { ?>
                <div class="sv-task">
                    <p class="sv-task__aim"><?php echo get_the_title( $recomedation->ID );?></p>
                    <div class="sv-task__checkboxes">
                        <form action="" class="thing_to_do" method="post">
                            <div class="checkout__recomendation-checkbox">
                                <input id="recomendation-done<?php echo $recomedation->ID;?>" type="checkbox" name="recomendation"
                                       data-type="done"
                                       data-idr="<?php echo $recomedation->ID;?>" data-idu="<?php echo $user->ID;?>"
                                    <?php echo $checked; ?>
                                    <?php if ( $disabled ) echo "disabled";?>
                                >
                                <label for="recomendation-done<?php echo $recomedation->ID;?>">
                                    <span class="checkout__recomendation-box" style="<?php echo $background;?>"></span>
                                </label>
                            </div>
                            <div class="checkout__recomendation-checkbox">
                                <input id="recomendation-save<?php echo $recomedation->ID;?>" type="checkbox" name="recomendation"
                                       data-idr="<?php echo $recomedation->ID;?>" data-idu="<?php echo $user->ID;?>"
                                       data-type="save"
                                    <?php if ( $disabled ) echo "disabled";?>
                                >
                                <label for="recomendation-save<?php echo $recomedation->ID;?>">
                                    <span class="checkout__recomendation-box" style="<?php echo $background;?>"></span>
                                </label>
                            </div>
                            <div class="checkout__recomendation-checkbox">
                                <input id="recomendation-not-for-me<?php echo $recomedation->ID;?>" type="checkbox" name="recomendation"
                                       data-idr="<?php echo $recomedation->ID;?>" data-idu="<?php echo $user->ID;?>"
                                       data-type="not-for-me"
                                    <?php if ( $disabled ) echo "disabled";?>
                                >
                                <label for="recomendation-not-for-me<?php echo $recomedation->ID;?>">
                                    <span class="checkout__recomendation-box" style="<?php echo $background;?>"></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div id="tab-2" class="tab-content">
        <div class="tab-content__head">
            <span></span>
            <div class="tab-content__labels">
                <span><?php echo __( "Done", "dkng" );?></span>
                <span><?php echo __( "Save", "dkng" );?></span>
                <span><?php echo __( "Not for Me", "dkng" ); ?></span>
            </div>
        </div>
        <?php foreach ( $saved_things_to_do as $recomedation ) {
            $disabled    = !in_array('subscriber', $user->roles ) ? true : false;
            $thing_phase = get_field( 'thing_to_do_phase', $recomedation );

            if ( !empty( get_the_title( $recomedation ) ) ) { ?>
                <div class="sv-task">
                    <p class="sv-task__aim"><?php echo get_the_title( $recomedation );?></p>
                    <div class="sv-task__checkboxes">
                        <form action="" class="thing_to_do">
                            <div class="checkout__recomendation-checkbox">
                                <input id="recomendation-done<?php echo $recomedation;?>" type="checkbox" name="recomendation"
                                       data-type="done"
                                       data-idr="<?php echo $recomedation;?>" data-idu="<?php echo $user->ID;?>"
                                >
                                <label for="recomendation-done<?php echo $recomedation;?>">
                                    <span class="checkout__recomendation-box" style="background: lightgrey;"></span>
                                </label>
                            </div>
                            <div class="checkout__recomendation-checkbox">
                                <input id="recomendation-save<?php echo $recomedation;?>" type="checkbox" name="recomendation"
                                       data-idr="<?php echo $recomedation;?>" data-idu="<?php echo $user->ID;?>"
                                       data-type="save" checked
                                    <?php if ( $disabled ) echo "disabled";?>
                                >
                                <label for="recomendation-save<?php echo $recomedation;?>">
                                    <span class="checkout__recomendation-box"  ></span>
                                </label>
                            </div>
                            <div class="checkout__recomendation-checkbox">
                                <input id="recomendation-not-for-me<?php echo $recomedation;?>" type="checkbox" name="recomendation"
                                       data-idr="<?php echo $recomedation;?>" data-idu="<?php echo $user->ID;?>"
                                       data-type="not-for-me"
                                    <?php if ( $disabled ) echo "disabled";?>
                                >
                                <label for="recomendation-not-for-me<?php echo $recomedation;?>">
                                    <span class="checkout__recomendation-box" style="background: lightgrey;"></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

</div>