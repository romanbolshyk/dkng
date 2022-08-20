<div class="col-12">
    <h4><?php _e('Upcoming Webinars', 'dkng');?></h4>
</div>
<div class="col-12">
    <div class="top-border">
        <div class="upcoming-accordion" id="accordion-upcoming">
            <?php if ( $webinars ) { ?>
                <?php foreach ( $webinars->posts as $i => $webinar ) {

                    $data         = get_field('date_starting', $webinar->ID );
                    $sign_up_link = get_field('sign_up_link', $webinar->ID );
                    $sign_up_text = get_field('sign_up_text', $webinar->ID );
                    $data_parts   = explode(" ", $data);

                    $dmy_str      = explode( '/', $data_parts[0] );
                    $hms_str      = explode( ':', $data_parts[1] );
                    $date_str     = $dmy_str[1] . '/' .  $dmy_str[0] . '/' . $dmy_str[2] . ' '
                        . $hms_str[0] . ':' . $hms_str[1] . ' ' . $data_parts[2];

                    $post_date    = date( 'Y/m/d h:i A', strtotime( $date_str ) );
                    $now_date     = date( 'Y/m/d h:i A' );

                    $active       =  ( $i == 0 ) ?  'active' : '';
                    $show         =  ( $i == 0 ) ?  'show' : '';

                    if ( ( strtotime( $post_date ) > strtotime( $now_date ) )  && ( $i < 10 ) ) {
                        ?>
                        <div class="card">
                            <div class="card-header <?php echo $active;?> " id="heading-1">
                                <div class="row">
                                    <div class="col-12">
                                        <h5><?php echo get_the_title( $webinar->ID );?></h5>
                                    </div>
                                    <div class="col-12" style="margin-bottom: 10px;">
                                        <a href="<?php if ( $sign_up_link) echo $sign_up_link;?>" target="_blank" class="sign_up_webinar">
                                            <?php if ( $sign_up_text) echo $sign_up_text;?>
                                        </a>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex flex-row justify-content-start align-items-center">
                                        <p><?php echo $data_parts[1] . $data_parts[2]; ?></p>
                                        <p class="border-left"><?php echo $data_parts[0]; ?></p>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex flex-row justify-content-end align-items-center">
                                        <button class="btn btn-link card-button view_details" type="button"
                                                data-toggle="collapse"
                                                data-target="#collapse-<?php echo $webinar->ID; ?>" aria-expanded="true"
                                                aria-controls="collapse-<?php echo $webinar->ID; ?>"
                                                data-heading="heading-<?php echo $webinar->ID;?>">
                                            <?php _e('VIEW DETAILS', 'dkng');?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="collapse-<?php echo $webinar->ID; ?>" class="collapse <?php echo $show;?>"
                                 aria-labelledby="headingOne"
                                 data-parent="#accordion-upcoming">
                                <div class="card-body 1">
                                    <?php echo wp_trim_words( get_post_field('post_content',  $webinar->ID ), 27, '...' );?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>