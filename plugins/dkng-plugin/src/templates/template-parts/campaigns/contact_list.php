<?php
/* Get User Lead List only by for 1 user */
$args = array(
'numberposts'	=> -1,
'post_type'		=> 'users-lists',
//                'meta_key'		=> 'author_id',
//                'meta_value'	=> $user->ID
);

$the_query   = new WP_Query( $args );
$user_lists  = $the_query->posts;
$count_posts = count( $user_lists );
?>

<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
            <div>
                <a href="<?php echo get_site_url() .'/admin-campaigns';?>" class="sv-button sv-button--nav sv-button--grey-text">
                    <?php echo __( "Back to Campaigns", "dkng" );?>
                </a>
            </div>

            <div>
                <a href="<?php echo get_site_url() .'/admin-campaigns/?page=add_lead';?>" class="sv-button sv-button--nav sv-button--green">
                    <?php echo __( "Add new list", "dkng" );?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <h2 class="sv-title">All lead lists</h2>

            <div class="sv-campaign-navigation d-flex align-items-center justify-content-between flex-lg-nowrap flex-wrap">
                <div class="sv-tabs">
                    <p class="sv-tabs__tab active js-table-tabs" data-tab="0">Lists Library (12)</p>
                    <p class="sv-tabs__tab js-table-tabs" data-tab="1">Unused List (2)</p>
                </div>

                <div class="sv-table-search">
                    <input type="text" placeholder="Search Lists" class="js-table-search">
                </div>
            </div>

            <div class="sv-filter-table-wrap">
                <table class="sv-filter-table sv-lead-list js-table-tab active">
                    <thead>
                    <tr>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="0">
                                <?php echo __( "Name", "dkng" );?>
                            </div>
                        </th>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="number" data-order="asc" data-td="1">
                                <?php echo __( "Contact", "dkng" );?>
                            </div>
                        </th>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="date" data-order="asc" data-td="2">
                                <?php echo __( "Last Updated", "dkng" );?>
                            </div>
                        </th>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="3">
                                <?php echo __( "Creator", "dkng" );?>
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="sv-filter-table__th js-sort-button" data-type="number" data-order="asc" data-td="4">
                                <?php echo __( "Used In", "dkng" );?>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="js-table-height">

                    <?php foreach ( $user_lists as $user_list ) {
                        $later_date   = '';
                        $user_list_id = $user_list->ID;

                        $author_id    = get_field( 'author_id', $user_list_id );
                        $author       = get_userdata( $author_id );

                        $count_leads  = \Dkng\Wp\UsersLists::get_count_leads_by_list_id( $user_list_id );
                        $later_date   = \Dkng\Wp\UsersLists::get_latest_date_by_list_id( $user_list_id );


                        $later_date   = date("m/d/Y", strtotime( $later_date['later_date'] ) );
                        ?>
                        <tr>
                            <td class="sv-lead-list__col-1">
                                <div class="sv-filter-table__td"><?php echo $user_list->post_title;?></div>
                            </td>
                            <td class="sv-lead-list__col-2">
                                <div class="sv-filter-table__td"><?php echo $count_leads['count_active'];?></div>
                            </td>
                            <td class="sv-lead-list__col-3">
                                <div class="sv-filter-table__td"><?php echo $later_date;?></div>
                            </td>
                            <td class="sv-lead-list__col-4">
                                <div class="sv-filter-table__td"><?php echo $author->display_name;?></div>
                            </td>
                            <td class="sv-lead-list__col-5">
                                <div class="sv-filter-table__td text-right">70</div>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>
            </div>

            <div class="sv-filter-table-wrap">
                <table class="sv-filter-table sv-lead-list js-table-tab" style="display: none">
                    <thead>
                    <tr>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="0">
                                Name
                            </div>
                        </th>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="number" data-order="asc" data-td="1">
                                Contact
                            </div>
                        </th>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="date" data-order="asc" data-td="2">
                                Last Updated
                            </div>
                        </th>
                        <th>
                            <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="3">
                                Creator
                            </div>
                        </th>
                        <th class="text-right">
                            <div class="sv-filter-table__th js-sort-button" data-type="number" data-order="asc" data-td="4">
                                Used In
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="js-table-height">
                        <tr>
                            <td class="sv-lead-list__col-1">
                                <div class="sv-filter-table__td">CION Investment - CADC group #1</div>
                            </td>
                            <td class="sv-lead-list__col-2">
                                <div class="sv-filter-table__td">30</div>
                            </td>
                            <td class="sv-lead-list__col-3">
                                <div class="sv-filter-table__td">04/01/2020</div>
                            </td>
                            <td class="sv-lead-list__col-4">
                                <div class="sv-filter-table__td">Alex Cavalieri</div>
                            </td>
                            <td class="sv-lead-list__col-5">
                                <div class="sv-filter-table__td text-right">70</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>