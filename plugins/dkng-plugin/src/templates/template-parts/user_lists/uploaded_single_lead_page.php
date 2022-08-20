<?php

$exploded  = explode( 'page=leads/uploaded/id=', $url );
$get_id    = $exploded[1];
$post      = get_post( $get_id );
$post_type = get_post_type( $get_id );
$leads     = \Dkng\Wp\UsersLists::get_leads_by_list_id( $get_id );

$author_id = get_field( 'author_id', $get_id );
?>
<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--larger">
            <a href="<?php echo get_site_url();?>/admin-campaigns/?page=add_lead" class="sv-button sv-button--nav sv-button--grey-text">
                <?php echo __( "Back to imports", "dkng" );?>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <?php if ( !empty( $post ) && ( !empty( $post_type ) && ( $post_type == 'users-lists' ) ) ) { ?>

                <h2 class="sv-title sv-title--big-margin"><?php echo __( "New list is uploaded!", "dkng" );?></h2>

                <div class="sv-new-list-name">
                    <p class="sv-new-list-name__label"><?php echo __( "Lead list name", "dkng" );?></p>
                    <span class="sv-new-list-name__title">
                        <?php echo $post->post_title;?>
                        <?php if ( $author_id == $user->ID ) { ?>
                            <img src="<?php echo plugins_url( '../../../../assets/img/icons/edit-icon.svg', __FILE__ ); ?>"
                                class="sv-new-list-name__edit js-edit-list"
                                alt="edit icon"
                            >
                        <?php } ?>
                    </span>
                    <input type="hidden" id="new_name" data-id="<?php echo $get_id;?>">
                </div>

                <div class="sv-filter-table-wrap">
                    <table class="sv-filter-table sv-filter-table--grey-row sv-uploaded-table js-table-tab sv-table-fixed-header active">
                        <thead>
                            <tr>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="0">
                                        <?php echo __( "First Name", "dkng" );?>
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="0">
                                        <?php echo __( "Last Name", "dkng" );?>
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="1">
                                        <?php echo __( "Email", "dkng" );?>
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="date" data-order="asc" data-td="2">
                                        <?php echo __( "Date Added", "dkng" );?>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="js-table-height">
                            <?php foreach ( $leads as $lead ) {
                                $new_date = date( 'm/d/Y', strtotime( $lead['date_added'] ) );  ?>
                                <tr>
                                    <td class="sv-uploaded-table__col-1">
                                        <div class="sv-filter-table__td"><?php echo $lead['name'];?></div>
                                    </td>
                                    <td class="sv-uploaded-table__col-1">
                                        <div class="sv-filter-table__td"><?php echo $lead['last_name'];?></div>
                                    </td>
                                    <td class="sv-uploaded-table__col-2">
                                        <div class="sv-filter-table__td"><?php echo $lead['email'];?></div>
                                    </td>
                                    <td class="sv-uploaded-table__col-3">
                                        <div class="sv-filter-table__td"><?php echo $new_date;?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end sv-uploaded-nav">
                    <a href="<?php echo get_site_url();?>/admin-campaigns/?page=all_leads" class="sv-button sv-button--green sv-button--small-padding sv-button--nav">
                        <?php echo __( "Back to All Lead Lists", "dkng" );?>
                    </a>
                </div>
            <?php } else { ?>
                <h4><?php echo __( "Wrong id of user list", "dkng" );?>.</h4>
            <?php }  ?>
        </div>
    </div>
</div>