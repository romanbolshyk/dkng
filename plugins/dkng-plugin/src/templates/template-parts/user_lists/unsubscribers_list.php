<?php
$user    = wp_get_current_user();
$user_id = $user->ID;

$user_lists = \Dkng\Wp\UsersLists::get_leads_by_user_id( $user_id );
$user_lists = $user_lists['posts'];

$campaign_users_statistics = get_user_meta( $user_id, 'campaign_users_statistics', true );
$campaign_users_statistics = !empty( $campaign_users_statistics ) ? $campaign_users_statistics : array();
$user_unsubscribers        = $campaign_users_statistics['unsubscribers'];
?>

<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
            <div>
                <a href="<?php echo get_site_url() .'/admin-campaigns';?>" class="sv-button sv-button--nav sv-button--grey-text">
                    <?php echo __( "Back to Campaigns", "dkng" );?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <h2 class="sv-title"> <?php echo __( "All Unsubscribers", "dkng" );?></h2>

            <div class="sv-campaign-navigation d-flex align-items-center justify-content-between flex-lg-nowrap flex-wrap">

                <div class="sv-table-search">
                    <input type="text" placeholder=" <?php echo __( "Search Unsubscribers", "dkng" );?>" class="js-table-search">
                </div>
            </div>

            <div class="sv-filter-table-wrap">
                <table class="sv-filter-table sv-lead-list js-table-tab active">
                    <thead>
                        <tr>
                            <th>
                                <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="0">
                                    <?php echo __( "Email", "dkng" );?>
                                </div>
                            </th>
                            <th>
                                <div class="sv-filter-table__th js-sort-button" data-type="number" data-order="asc" data-td="1">
                                    <?php echo __( "Name", "dkng" );?>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="js-table-height">
                        <?php if ( !empty( $user_unsubscribers ) ) {  ?>
                            <?php foreach ( $user_unsubscribers as $unsubscriber ) {
                                $unsubscriber_data = \Dkng\Wp\UsersLists::get_first_last_name_by_email( $unsubscriber, $user_lists );
                                ?>
                                <tr class="lead-<?php echo $unsubscriber;?>">
                                    <td class="sv-lead-list__col-1">
                                        <div class="sv-filter-table__td">
                                            <?php echo $unsubscriber;?>
                                        </div>
                                    </td>
                                    <td class="sv-lead-list__col-1">
                                        <div class="sv-filter-table__td"><?php echo $unsubscriber_data['name'] . ' ' . $unsubscriber_data['last_name'];?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>