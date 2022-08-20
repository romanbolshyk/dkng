<?php
$args = array(
    'posts_per_page' => -1,
    'post_type'		 => 'users-lists',
    'meta_query'     => array(
        'relation'   => 'AND',
        array (
            'key'     => 'count_of_using',
            'value'   => 0,
            'compare' => '>',
        ),
        array (
            'key'     => 'author_id',
            'value'   => $user->ID,
            'compare' => '='
        ),
    )
);

$the_query   = new WP_Query( $args );
$user_lists  = $the_query->posts;

$args1 = array(
    'posts_per_page' => -1,
    'post_type'		 => 'users-lists',
    'meta_key'       => 'author_id',
    'meta_value'     => $user->ID,
    'meta_query'     => array(
        'relation'   => 'OR',
        array (
            'key'     => 'count_of_using',
            'value'   => 0,
            'compare' => '=',
        ),
        array (
            'key'     => 'count_of_using',
            'value'   => '',
            'compare' => 'NOT EXISTS'
        ),
    )
);

$the_query1          = new WP_Query( $args1 );
$not_used_user_lists = $the_query1->posts;

$count_posts  = count( $user_lists );
$count_unused = count( $not_used_user_lists );
?>

<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
            <div>
                <a href="<?php echo get_site_url() .'/admin-campaigns';?>" class="sv-button sv-button--nav sv-button--grey-text">
                    <?php echo __( "View All Campaigns", "dkng" );?>
                </a>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-end align-items-start">
				<a href="<?php echo get_site_url() . '/admin-campaigns/?page=unsubscribers'?>" class="sv-button sv-button--green sv-button--nav"><?php echo __( "Unsubscribers List", "dkng" );?></a>
				<a href="<?php echo get_site_url() . '/admin-campaigns/?page=add_lead'; ?>"
                   class="sv-button sv-button--nav sv-button--green"
                    style="<?php echo $style_allowed_lists;?>"
                    >
                    <?php echo __( "Add New List", "dkng" ); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <h2 class="sv-title"> <?php echo __( "All Lead Lists", "dkng" );?></h2>

            <div class="sv-campaign-navigation d-flex align-items-center justify-content-between flex-lg-nowrap flex-wrap">
                <div class="sv-tabs">
                    <p class="sv-tabs__tab active js-table-tabs" data-tab="0"> <?php echo __( "Lists Library", "dkng" );?> ( <span class="count"><?php echo $count_posts;?></span> )</p>
                    <p class="sv-tabs__tab js-table-tabs" data-tab="1"> <?php echo __( "Unused List", "dkng" );?> ( <span class="count"><?php echo $count_unused;?></span> )</p>
                </div>

                <div class="sv-table-search">
                    <input type="text" placeholder=" <?php echo __( "Search Lists", "dkng" );?>" class="js-table-search">
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="js-table-height">
                        <?php if ( !empty( $user_lists ) ) {  ?>
                            <?php foreach ( $user_lists as $user_list ) {
                                $later_date   = '';
                                $user_list_id = $user_list->ID;

                                $author_id    = get_field( 'author_id', $user_list_id );
                                $author       = get_userdata( $author_id );

                                $count_leads  = \Dkng\Wp\UsersLists::get_count_leads_by_list_id( $user_list_id );
                                $later_date   = \Dkng\Wp\UsersLists::get_latest_date_by_list_id( $user_list_id );

                                $count_using_lead  = get_field( 'count_of_using', $user_list_id );
                                $count_using_lead  = empty( $count_using_lead ) ? 0 : $count_using_lead;

                                if ( !empty( $later_date['later_date'] ) ) {
                                    $later_date  = date("m/d/Y", strtotime( $later_date['later_date'] ) );
                                }
                                else {
                                    $later_date  = date("m/d/Y", time() );
                                }
                                ?>
                                <tr class="lead-<?php echo $user_list_id;?>">
                                    <td class="sv-lead-list__col-1">
                                        <div class="sv-filter-table__td">
                                            <?php if ( $author_id == $user->ID ) { ?>
                                                <a href="<?php echo get_site_url();?>/admin-campaigns/?page=leads/id=<?php echo $user_list_id;?>">
                                                    <?php echo $user_list->post_title;?>
                                                </a>
                                            <?php } else { ?>
                                                <?php echo $user_list->post_title;?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="sv-lead-list__col-2">
                                        <div class="sv-filter-table__td"><?php echo $count_leads['count_active'];?></div>
                                    </td>
                                    <td class="sv-lead-list__col-3">
                                        <div class="sv-filter-table__td"><?php echo $later_date;?></div>
                                    </td>
                                    <td class="sv-lead-list__col-4">
                                        <div class="sv-filter-table__td"><?php echo $author->first_name . ' ' . $author->last_name;?></div>
                                    </td>
                                    <td class="sv-lead-list__col-5">
                                        <div class="sv-filter-table__td text-right"><?php echo $count_using_lead;?></div>
                                    </td>
                                    <td class="sv-lead-list__col-6">
                                        <div class="sv-filter-table__td d-flex align-items-center justify-content-end">
                                            <i class="fa fa-trash delete_list" data-id="<?php echo $user_list_id;?>"></i>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="js-table-height">
                        <?php if ( !empty( $not_used_user_lists ) ) { ?>
                            <?php foreach ( $not_used_user_lists as  $list ) {
                                $later_date   = '';
                                $user_list_id = $list->ID;

                                $author_id    = get_field( 'author_id', $user_list_id );
                                $author       = get_userdata( $author_id );

                                $count_leads  = \Dkng\Wp\UsersLists::get_count_leads_by_list_id( $user_list_id );
                                $later_date   = \Dkng\Wp\UsersLists::get_latest_date_by_list_id( $user_list_id );

                                if ( !empty( $later_date['later_date'] ) ) {
                                    $later_date  = date("m/d/Y", strtotime( $later_date['later_date'] ) );
                                }
                                else {
                                    $later_date  = date("m/d/Y", time() );
                                }
                                ?>
                                <tr class="lead-<?php echo  $user_list_id;?>">
                                    <td class="sv-lead-list__col-1">
                                        <div class="sv-filter-table__td">
                                            <?php if ( $author_id == $user->ID ) { ?>
                                                <a href="<?php echo get_site_url();?>/admin-campaigns/?page=leads/id=<?php echo $user_list_id;?>">
                                                    <?php echo $list->post_title;?>
                                                </a>
                                            <?php } else { ?>
                                                <?php echo $list->post_title;?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="sv-lead-list__col-2">
                                        <div class="sv-filter-table__td"><?php echo $count_leads['count_active'];?></div>
                                    </td>
                                    <td class="sv-lead-list__col-3">
                                        <div class="sv-filter-table__td"><?php echo $later_date;?></div>
                                    </td>
                                    <td class="sv-lead-list__col-4">
                                        <div class="sv-filter-table__td"><?php echo $author->first_name . ' ' . $author->last_name;?></div>
                                    </td>
                                    <td class="sv-lead-list__col-5">
                                        <div class="sv-filter-table__td text-right">0</div>
                                    </td>
                                    <td class="sv-lead-list__col-6">
                                        <div class="sv-filter-table__td d-flex align-items-center justify-content-end">
                                            <i class="fa fa-trash delete_list" data-id="<?php echo $user_list_id;?>"></i>
                                        </div>
                                    </td>
                                </tr>
                            <?php  } ?>
                         <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>