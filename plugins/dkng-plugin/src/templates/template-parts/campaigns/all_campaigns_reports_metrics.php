<?php

$general_statistic        = $campaigns_obj->get_general_statistic( -1 );
$general_sent_percent     = !empty( $general_statistic['sent'] ) ? $general_statistic['sent'] : 0;
$general_opened_percent   = !empty( $general_statistic['opened'] ) ? $general_statistic['opened'] : 0;
$general_clicked_percent  = !empty( $general_statistic['clicked'] ) ? $general_statistic['clicked'] : 0;
$general_count_receivers  = !empty( $general_statistic['count_all_receivers'] ) ? $general_statistic['count_all_receivers'] : 0;
$general_count_sent       = !empty( $general_statistic['count_sent'] ) ? $general_statistic['count_sent'] : 0;
$general_count_opened     = !empty( $general_statistic['count_opened'] ) ? $general_statistic['count_opened'] : 0;
$general_count_clicked    = !empty( $general_statistic['count_clicked'] ) ? $general_statistic['count_clicked'] : 0;
$general_count_sentstatus = !empty( $general_statistic['count_sentstatus_emails'] ) ? $general_statistic['count_sentstatus_emails'] : 0;
$general_count_scheduled_emails = !empty( $general_statistic['count_scheduled_emails'] ) ? $general_statistic['count_scheduled_emails'] : 0;
$unsubscribers_percent    = !empty( $general_statistic['unsubscribers_percent'] ) ? $general_statistic['unsubscribers_percent'] : 0;
$unsubscribers_count      = !empty( $general_statistic['unsubscribers_count'] ) ? $general_statistic['unsubscribers_count'] : 0;

?>

<div class="row">
    <div class="col-12">
        <div class="sv-container sv-section sv-section--radius-top" style="border-radius: 12px;">
            <h2 class="sv-title"><?php echo __( "How Your Campaigns Have Performed", "dkng" );?></h2>

            <?php if ( !empty( $all_report_page ) ) { ?>
                <p class="all_reports_underhead"><?php echo __( "Check out how your recent campaigns have performed", "dkng" );?>.</p>
            <?php } ?>

            <div class="sv-tale__select sv-campaigns-select">
                <select class="time_sorting single" class="time_period clicked" data-campaign-id=<?php echo $post_id;?>>
                    <option selected value="all_time"><?php echo __( "All Time", "dkng" );?></option>
                    <option value="7_days"><?php echo __( "Last 7 days", "dkng" );?></option>
                    <option value="30_days"><?php echo __( "Last 30 days", "dkng" );?></option>
                </select>
            </div>

            <div class="campaigns-report__charts">
                <div class="sv-progress-bar count_contacts" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Number of Emails Sent in Campaigns", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart " >
                        <span class="count">
                            <span class="sent_emails">
                                <?php echo $general_count_sentstatus;?>
                            </span> /
                            <span class="all_emails"><?php echo $general_count_scheduled_emails;?></span>
                            <?php echo __( "emails", "dkng" );?>
                        </span>
                    </div>
                </div>

                <div class="sv-progress-bar number_contacts_sent" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Number of Contacts Sent ", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart " >
                        <span class="count"><?php echo $general_count_receivers;?></span>
                    </div>
                </div>

                <div class="sv-progress-bar sent_delivered" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Number of Emails Successfully Delivered", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart "><span class="count"><span class="sent_emails"><?php echo $general_count_sent;?></span> <?php echo __( "emails", "dkng" );?></span></div>
                </div>

                <div class="sv-progress-bar sent" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Delivery Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $general_sent_percent;?>"><span class="count"><?php echo $general_sent_percent;?>%</span></div>
                </div>

            </div>

            <div class="campaigns-report__charts">

                <div class="sv-progress-bar opened" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Average Open Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart add_count" >
                        <span class="count">
                            <span class="emails"><?php echo $general_count_opened;?></span> <?php echo __( "emails", "dkng" );?>
                        </span>
                    </div>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $general_opened_percent;?>"><span class="count"><?php echo $general_opened_percent;?>%</span></div>
                </div>

                <div class="sv-progress-bar clicked" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Average Click Through Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart add_count" >
                        <span class="count">
                            <span class="emails"><?php echo $general_count_clicked;?></span> <?php echo __( "emails", "dkng" );?>
                        </span>
                    </div>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $general_clicked_percent;?>"><span class="count"><?php echo $general_clicked_percent;?>%</span></div>
                </div>

                <div class="sv-progress-bar unsubscribers_count" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Unsubscribers", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart " >
                        <div class="sv-progress-bar__chart " >
                            <span class="count">
                                <span class="emails"><?php echo $unsubscribers_count;?></span> <?php echo __( "contacts", "dkng" );?>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="sv-progress-bar unsubscriber_rate" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Unsubscribe Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $unsubscribers_percent;?>"><span class="count"><?php echo $unsubscribers_percent;?>%</span></div>
                </div>

            </div>
        </div>

    </div>
</div>