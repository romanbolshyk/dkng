<?php

$sent_percent     = ( empty( $all_percent ) || is_nan( $all_percent['sent'] ) )    ? 0 : $all_percent['sent'];
$clicked_percent  = ( empty( $all_percent ) || is_nan( $all_percent['clicked'] ) ) ? 0 : $all_percent['clicked'];
$opened_percent   = ( empty( $all_percent ) || is_nan( $all_percent['opened'] ) )  ? 0 : $all_percent['opened'];
$unsubscribed_percent = ( empty( $all_percent ) || is_nan( $all_percent['unsubscribers_percent'] ) )  ? 0 : $all_percent['unsubscribers_percent'];

$count_sent    = ( empty( $all_percent['count_sent'] ) || is_nan( $all_percent['count_sent'] ) ) ? 0 : $all_percent['count_sent'];
$count_opened  = ( empty( $all_percent['count_opened'] ) || is_nan( $all_percent['count_opened'] ) ) ? 0 : $all_percent['count_opened'];
$count_clicked = ( empty( $all_percent['count_clicked'] ) || is_nan( $all_percent['count_clicked'] ) ) ? 0 : $all_percent['count_clicked'];
$count_unsubscribers = ( empty( $all_percent['unsubscribers_count'] ) || is_nan( $all_percent['unsubscribers_count'] ) ) ? 0 : $all_percent['unsubscribers_count'];

$unsubscribers = $campaign_users_statistics['unsubscribers'];
$unsubscribers = !empty( $unsubscribers ) ? $unsubscribers : array();

$tab_statistic = $campaigns_obj->get_single_report_tab( $campaign_users_statistics, 'delivered' );
?>

<div class="row">
    <div class="col-12">
        <div class="buttons-line d-flex justify-content-start align-items-start">
            <a href="<?php echo get_site_url() . '/admin-campaigns/?all=1';?>" class="sv-button sv-button--nav sv-button--grey-text">
                <?php echo __( "Back To Campaigns", "dkng" );?>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section sv-section--radius-top">
            <h2 class="sv-title"><?php echo get_the_title();?></h2>
            <div class="sv-tale__select sv-campaigns-select">
                <select class="time_sorting single" class="time_period clicked" data-campaign-id=<?php echo $post_id;?>>
                    <option selected value="all_time"><?php echo __( "All Time", "dkng" );?></option>
                    <option value="7_days"><?php echo __( "Last 7 days", "dkng" );?></option>
                    <option value="30_days"><?php echo __( "Last 30 days", "dkng" );?></option>
                </select>
            </div>

            <div class="campaigns-report__charts">
                <div class="sv-progress-bar sent " style="display: none;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Delivery Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart "><span class="count"><?php echo $count_sent;?> emails</span></div>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $sent_percent;?>"><span class="count"><?php echo $sent_percent;?>%</span></div>
                </div>

                <div class="sv-progress-bar count_contacts" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Number of Emails Sent in Campaign", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart " >
                        <span class="count">
                            <span class="sent_emails">
                                <?php echo $all_percent['count_sentstatus_emails'];?>
                            </span> /
                            <span class="all_emails"><?php echo $all_percent['count_emails'];?></span>
                            <?php echo __( "emails", "dkng" );?>
                        </span>
                    </div>
                </div>

                <div class="sv-progress-bar number_contacts_sent" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Number of Contacts Sent ", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart " >
                        <span class="count"><?php echo $all_percent['count_all_receivers'];?></span>
                    </div>
                </div>

                <div class="sv-progress-bar sent_delivered" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Number of Emails Successfully Delivered", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart "><span class="count"><span class="sent_emails"><?php echo $count_sent;?></span> <?php echo __( "emails", "dkng" );?></span></div>
                </div>

                <div class="sv-progress-bar sent" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Delivery Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $sent_percent;?>"><span class="count"><?php echo $sent_percent;?>%</span></div>
                </div>

            </div>

            <div class="campaigns-report__charts">

                <div class="sv-progress-bar opened" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Average Open Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart add_count" >
                        <span class="count">
                            <span class="emails"><?php echo $count_opened;?></span> <?php echo __( "emails", "dkng" );?>
                        </span>
                    </div>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $opened_percent;?>"><span class="count"><?php echo $opened_percent;?>%</span></div>
                </div>

                <div class="sv-progress-bar clicked" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Average Click Through Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart add_count" >
                        <span class="count">
                            <span class="emails"><?php echo $count_clicked;?></span> <?php echo __( "emails", "dkng" );?>
                        </span>
                    </div>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $clicked_percent;?>"><span class="count"><?php echo $clicked_percent;?>%</span></div>
                </div>

                <div class="sv-progress-bar unsubscribers_count" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Unsubscribers", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart " >
                        <br><span class="count" style="display: none;"><?php echo __( "Contacts", "dkng" ) ;?>:</span>
                        <div class="sv-progress-bar__chart " >
                            <span class="count">
                                <span class="emails"><?php echo $count_unsubscribers;?></span> <?php echo __( "contacts", "dkng" );?>
                            </span>
                        </div>
                    </div>

                    <ul class="unsubscribers_list" style="display: none;">
                        <?php if ( !empty( $unsubscribers ) ) {
                            foreach ( $unsubscribers as $unsubscriber ) { ?>
                                <li><?php echo $unsubscriber;?></li>
                            <?php }
                        } ?>
                    </ul>

                </div>

                <div class="sv-progress-bar unsubscriber_rate" style="flex-basis: 385px;">
                    <h4 class="sv-progress-bar__title"><?php echo __( "Unsubscribe Rate", "dkng" );?></h4>
                    <div class="sv-progress-bar__chart js-chart" data-percent="<?php echo $unsubscribed_percent;?>"><span class="count"><?php echo $unsubscribed_percent;?>%</span></div>
                </div>

            </div>

            <div class="sv-contact-list" style="display: none;">

                <h2 class="sv-title sv-title--small-margin"><?php echo __( "Contact List", "dkng" );?></h2>

                <table class="sv-table sv-table--wide">
                    <thead>
                        <tr>
                            <th><?php echo __( "First Name", "dkng" );?></th>
                            <th><?php echo __( "Last Name", "dkng" );?></th>
                            <th><?php echo __( "Email", "dkng" );?></th>
                            <th><?php echo __( "Status", "dkng" );?></th>
                        </tr>
                    </thead>
                    <tbody class=" js-equal-subject-body">
                        <?php if ( !empty( $campaign_users_statistics ) ) {
                            foreach ( $campaign_users_statistics as $campaign_user => $statistic ) {

                                if ( $campaign_user == 'unsubscribers' ) {
                                    continue;
                                }

                                $result = '';

                                $result = substr( $result, 0, -1 );
                                $user_for_email    = \Dkng\Wp\UsersLists::get_username_for_email( $post_id, $user->ID, $campaign_user );
                                $list_email_status = \Dkng\Wp\UsersLists::get_status_for_email( $post_id, $user->ID, $campaign_user );

                                foreach ( $statistic as $email => $data ) {
                                    $tags    = implode(', ', $data );
                                    $result .= " $email : $tags |";
                                }

                                $result .= strstr( $tags, "Unsubscribed" ) ? "<p style='font-weight: bold;'>" . __( "Unsubscribed", "dkng" ) . "</p>" : "";
                                if (
                                    empty( $user_for_email['name'] ) ||
                                    ( empty( $campaign_user ) || ( !empty( $campaign_user ) && !filter_var( $campaign_user, FILTER_VALIDATE_EMAIL) ) )
                                ) {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td data-th="<?php echo __( 'Name', 'dkng');?>"><?php echo $user_for_email['name'];?></td>
                                    <td data-th="<?php echo __( 'Name', 'dkng');?>"><?php echo $user_for_email['last_name'];?></td>
                                    <td data-th="<?php echo __( 'Email', 'dkng');?>"><?php echo $campaign_user;?></td>
                                    <td data-th="<?php echo __( 'Status', 'dkng');?>"><?php echo $result;?></td>
                                </tr>
                                <?php
                            }
                        } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="sv-section  statistic_single_report_block">
            <div class="sv-contact-list">

                <h2 class="sv-title sv-title--small-margin"><?php echo __( "Recipient Actions", "dkng" );?></h2>
				<br>
                <div class="statistic_single_report_tabs sv-tabs" data-post_id="<?php echo $post_id;?>">
                    <p data-status="delivered" class="report_tab active sv-tabs__tab "><?php echo __( "Delivered", "dkng");?>(<?php echo $count_sent;?>)</p>
                    <p data-status="opened" class="report_tab sv-tabs__tab"><?php echo __( "Opened", "dkng");?>(<?php echo $count_opened;?>)</p>
                    <p data-status="clicked" class="report_tab sv-tabs__tab "><?php echo __( "Clicked", "dkng");?>(<?php echo $count_clicked;?>)</p>
                    <p data-status="unsubscribed" class="report_tab sv-tabs__tab "><?php echo __( "Unsubscribed", "dkng");?>(<?php echo $count_unsubscribers;?>)</p>
                    <img src="./dist/img/loader.gif" alt="loader"  class="loader" />
                </div>

                <table class="sv-table sv-table--wide statistics_tabs_table">
                    <thead>
                        <tr>
                            <th><?php echo __( "Recipient", "dkng" );?></th>
                            <th><?php echo __( "Email Subject", "dkng" );?></th>
                        </tr>
                    </thead>
                    <tbody class=" js-equal-subject-body">
                        <?php if ( !empty( $tab_statistic ) ) {
                            foreach ( $tab_statistic as $campaign_user => $statistic ) {

                                if ( $campaign_user == 'unsubscribers' ) {
                                    continue;
                                }

                                $result = '';

                                $tags    = implode(', ', $statistic );

                                if ( empty( $campaign_user ) ) {
                                    continue;
                                }

                                foreach ( $statistic as $stat ) { ?>
                                    <tr>
                                        <td data-th="<?php echo __( 'Email', 'dkng');?>"><?php echo $campaign_user;?></td>
                                        <td data-th="<?php echo __( 'Subject', 'dkng');?>"><?php echo $stat;?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="sv-section sv-section--radius-bottom">
            <div class="sv-contact-list__button">
                <a href="#" class="sv-button sv-button--green export_list_btn" data-id="<?php echo $post_id;?>">
                    <?php echo __( "Export List", "dkng" );?>
                </a>
            </div>
        </div>
    </div>
</div>