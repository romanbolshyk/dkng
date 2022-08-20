<div class="campaigns-report campaigns-report--widget">

    <!-- Latest Campaigns block -->
    <div class="">
        <div class="sv-container all_campaigns_block sv-section">
			<h2 class="sv-title"><?php echo __( "New Campaigns Available", "dkng" );?></h2>

            <div class="columns-grid">
                <?php if ( !empty( $latest_campaigns ) ) {
                    $i = 0;
                    foreach ( $latest_campaigns as $campaign ) {
                        $i++;
                        $title      = get_the_title( $campaign );
                        $link       = get_permalink( $campaign );
                        $start_date = get_field( 'start_date_email', $campaign );
                        $thumbnail  = get_the_post_thumbnail_url( $campaign );

                        $post_terms = wp_get_object_terms( $campaign, 'campaigns-category', array('fields' => 'slugs') );

                        $status_background = $campaigns_obj->get_status_and_background( $user_campaigns, $campaign );
                        $ribbon_background = $status_background['ribbon_background'];
                        $status            = $status_background['status'];

                        $index = $i;
                        $plugin_path = plugin_dir_path(__DIR__);
                        require $plugin_path . '/ajax-items/campaign_item.php';
                        ?>

                    <?php } ?>
                    <img src="./dist/img/loader.gif" id="loader_campaign" alt="loader" style=" display: none; position: absolute; left: 50%; top: 50%;"/>
                <?php } else { ?>
                    <h4><?php echo __( "There are no campaigns", "dkng" );?>.</h4>
                <?php }  ?>
            </div>
        </div>

        <div class="campaigns-report__link">
            <a href="<?php echo get_site_url() . '/admin-campaigns';?>">
                <?php echo __( "See More", "dkng" );?>
                <img src="./dist/img/arrow-right.png" alt="arrow right">
            </a>
        </div>

    </div>

    <!-- Recent Campaigns block -->
    <div class="">

        <div class="campaigns-report__charts">
           <?php require_once 'all_campaigns_reports_metrics.php';?>
        </div>
		<div class="sv-container">
        <h2 class="sv-title"><?php echo __( "Recent Campaigns You've Sent", "dkng" );?></h2>
        <?php if ( !empty( $user_all_campaigns) ) { ?>
            <table class="sv-table">
                <thead>
                    <tr>
                        <th><?php echo __( "Status", "dkng" );?></th>
                        <th><?php echo __( "Campaign Title", "dkng" );?></th>
                        <th><?php echo __( "Start Date", "dkng" );?></th>
                        <th><?php echo __( "Open Rate", "dkng" );?></th>
                        <th><?php echo __( "CTR", "dkng" );?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $user_all_campaigns as $campaign ) {
                        $title           = get_the_title( $campaign );
                        $start_date      = !empty( $user_campaigns['active'][$campaign] ) ? $user_campaigns['active'][$campaign] : '';
                        $link            = get_permalink( $campaign );

                        $all_percent     = $campaigns_obj->get_statistic_by_campaign( $campaign );
                        $sent_percent    = ( empty( $all_percent ) || is_nan( $all_percent['sent'] ) )    ? 0 : $all_percent['sent'];
                        $clicked_percent = ( empty( $all_percent ) || is_nan( $all_percent['clicked'] ) ) ? 0 : $all_percent['clicked'];
                        $opened_percent  = ( empty( $all_percent ) || is_nan( $all_percent['opened'] ) )  ? 0 : $all_percent['opened'];

                        $opened_percent  = !empty( $sent_percent ) ? ( $opened_percent * 100 ) / ( $sent_percent )  : 0;
                        $clicked_percent = !empty( $sent_percent ) ? ( $clicked_percent * 100 ) / ( $sent_percent ) : 0;

                        $clicked_percent = ( empty( $clicked_percent ) || is_nan( $clicked_percent ) ) ? 0 : $clicked_percent;
                        $opened_percent  = ( empty( $opened_percent ) || is_nan( $opened_percent ) )  ? 0 : $opened_percent;

                        $opened_percent  = round( $opened_percent, 2 );
                        $clicked_percent = round( $clicked_percent, 2 );

                        $general_opened_percent   = !empty( $general_sent_percent ) ? ( $general_opened_percent * 100 ) / ( $general_sent_percent ) : 0;
                        $general_clicked_percent  = !empty( $general_sent_percent ) ? ( $general_clicked_percent * 100 ) / ( $general_sent_percent ) : 0;

                        $status = $campaigns_obj->get_status_and_background( $user_campaigns, $campaign );
                        $additional_class = $status['additional_class'];
                        $status = $status['status'];

                        if ( empty( $title ) ) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td data-th="Status">
                                <div class="sv-table__status <?php echo $additional_class; ?>"><?php echo $status;?></div>
                            </td>
                            <td data-th="Campaign Title"><a href="<?php echo $link;?>"><?php echo $title;?></a></td>
                            <td data-th="Start Date"><?php echo $start_date;?></td>
                            <td data-th="Open Rate"><?php echo $opened_percent;?>%</td>
                            <td data-th="CTR"><?php echo $clicked_percent;?>%</td>
                            <td>
                                <a href="<?php echo $link . '?report=1';?>">
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
            <div class="campaigns-report__link">
                <a href="<?php echo get_site_url() . '/admin-campaigns/?page=all_reports';?>">
                    <?php echo __( "See More", "dkng" );?>
                    <img src="./dist/img/arrow-right.png" alt="arrow right">
                </a>
            </div>
        <?php } else { ?>
            <h4 >
                <?php echo __( "You have yet to send a campaign. Watch how you can send your ", "dkng" );?>
                <a href="<?php echo get_site_url().'/courses/campaign-function/';?>"> <?php echo __( "first one", "dkng" );?></a>.
            </h4>
        <?php } ?>

    </div>

</div>