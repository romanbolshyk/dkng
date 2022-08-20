<div class="row">
    <div class="col-12">
        <div class="campaigns-report">
            <div class="">
                <?php
                $all_report_page = true;
                require_once 'all_campaigns_reports_metrics.php';
                ?>
				<div class="sv-container">
                <?php if ( !empty( $user_campaigns_reports ) ) { ?>
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
                            <?php foreach ( $user_campaigns_reports as $campaign ) {
                                $title       = get_the_title( $campaign );
                                $link        = get_permalink( $campaign );
                                $start_date  = get_user_meta( $campaign, 'start_date', true );
                                $start_date  = $user_campaigns['active'][$campaign];

                                $all_percent = $campaigns_obj->get_statistic_by_campaign( $campaign );

                                $sent_percent    = ( empty( $all_percent ) || is_nan( $all_percent['sent'] ) )    ? 0 : $all_percent['sent'];
                                $clicked_percent = ( empty( $all_percent ) || is_nan( $all_percent['clicked'] ) ) ? 0 : $all_percent['clicked'];
                                $opened_percent  = ( empty( $all_percent ) || is_nan( $all_percent['opened'] ) )  ? 0 : $all_percent['opened'];

                                $opened_percent  = ( $opened_percent * 100 ) / ( $sent_percent );
                                $clicked_percent = ( $clicked_percent * 100 ) / ( $sent_percent );

                                $clicked_percent = ( empty( $clicked_percent ) || is_nan( $clicked_percent ) ) ? 0 : $clicked_percent;
                                $opened_percent  = ( empty( $opened_percent ) || is_nan( $opened_percent ) )  ? 0 : $opened_percent;

                                $opened_percent  = round( $opened_percent, 2 );
                                $clicked_percent = round( $clicked_percent, 2 );

                                $status  = $campaigns_obj->get_status_and_background( $user_campaigns, $campaign );
                                $additional_class = $status['additional_class'];
                                $status1 = $status['status'];

                                if ( empty( $title ) ) {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td data-th="Status">
                                        <div class="sv-table__status <?php echo $additional_class; ?>"><?php echo $status1;?></div>
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
                <?php } else { ?>
                    <h4 >
                        <?php echo __( "You have yet to send a campaign. Watch how you can send your ", "dkng" );?>
                        <a href="<?php echo get_site_url().'/courses/campaign-function/';?>"> <?php echo __( "first one", "dkng" );?></a>.
                    </h4>
                <?php } ?>
            </div>
            </div>
        </div>
    </div>
</div>