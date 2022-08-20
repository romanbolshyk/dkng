<?php

$exploded  = explode( 'page=leads/id=', $url );
$get_id    = $exploded[1];
$post      = get_post( $get_id );
$post_type = get_post_type( $get_id );
$leads     = \Dkng\Wp\UsersLists::get_leads_by_list_id( $get_id );

$author_id = get_field( 'author_id', $get_id );
$count_leads   = \Dkng\Wp\UsersLists::get_count_leads_by_list_id( $get_id );
$unsubscribers = \Dkng\Wp\UsersLists::get_user_unsubscribers();
$style_allowed = ( $author_id != $user->ID )  ? 'pointer-events: none; opacity: 0.5;' : '';

?>
<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
            <div>
                <a href="<?php echo get_site_url();?>/admin-campaigns/?page=all_leads" class="sv-button sv-button--nav sv-button--grey-text">
                    <?php echo __( "Back to All Lead Lists", "dkng" );?>
                </a>
            </div>

            <div>
                <a href="#" class="sv-button sv-button--nav sv-button--green save_lead_changes_button" style="<?php echo $style_allowed;?>">
                    <?php echo __( "Save", "dkng" );?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section single_lead_page">
            <?php if ( !empty( $post ) && ( !empty( $post_type ) && ( $post_type == 'users-lists' ) ) ) { ?>
                <h2 class="sv-title"> <?php echo __( "Lead List", "dkng" );?></h2>

                <form class="sv-contact-list-form js-contact-list-form" id="lead_edit_form" data-id="<?php echo $get_id;?>">

                    <div class="sv-campaign-navigation sv-campaign-navigation--small-m d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <label> <?php echo __( "Lead List Name", "dkng" );?></label>
                            <input type="text" id="lead_list_name" value="<?php echo $post->post_title;?>">
                        </div>
                        <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <p>
                                <span><?php echo __( "Number of Contacts", "dkng" ) . ': ' . $count_leads['count_active'] . ' / ' . $count_leads['count_all'];?> </span>   |
                                <span>
                                    <a href="<?php echo get_site_url() . '/admin-campaigns/?page=unsubscribers';?>"><?php echo  __( "Unsubscribers", "dkng" );?></a>: <?php echo $count_leads['count_unsubscribers'];?>
                                </span>
                            </p>
                        </div>
                        <div class="sv-table-search sv-table-search--thin">
                            <input type="text" placeholder=" <?php echo __( "Search", "dkng" );?>" class="js-table-search">
                        </div>
                    </div>

                    <div class="sv-filter-table-wrap">
                        <table class="sv-filter-table sv-filter-table--grey-row js-table-tab sv-lead-list sv-table-fixed-header active">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="0">
                                            <?php echo __( "First Name", "dkng" );?>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="0">
                                            <?php echo __( "Last Name", "dkng" );?>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="1">
                                            <?php echo __( "Email", "dkng" );?>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="sv-filter-table__th js-sort-button" data-type="date" data-order="asc" data-td="2">
                                            <?php echo __( "Date Added", "dkng" );?>
                                        </div>
                                    </th>
                                    <th class="text-right">
                                        <div class="sv-filter-table__th sv-filter-table__th--no-filter">
                                            <div class="sv-checkbox">
                                                <input type="checkbox" id="all-contacts">
                                                <label for="all-contacts"> <?php echo __( "Add all", "dkng" );?> (340)</label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="js-table-height">
                                <?php
                                    $i = 0;
                                    foreach ( $leads as $lead ) {

                                        $tr_class =  ( in_array( $lead['email'], $unsubscribers ) ) ? "hidden_contact" : "";
                                        $i++;
                                        $new_date = date( 'd/m/Y', strtotime( $lead['date_added'] ) );  ?>
                                        <tr class="<?php echo $tr_class;?>">
                                            <td class="sv-new-lead__col-1">
                                                <div class="sv-filter-table__td name_td">
                                                    <input type="text" name="name-<?php echo $i;?>" value="<?php echo $lead['name'];?>"
                                                           placeholder="<?php echo __( "First Name", "dkng" );?>"
                                                           maxlength="300"
                                                           autocomplete="off"
                                                    >
                                                </div>
                                            </td>
                                            <td class="sv-new-lead__col-1">
                                                <div class="sv-filter-table__td name_td">
                                                    <input type="text" name="last_name-<?php echo $i;?>" value="<?php echo $lead['last_name'];?>"
                                                           placeholder="<?php echo __( "Last Name", "dkng" );?>"
                                                           maxlength="300"
                                                           autocomplete="off"
                                                    >
                                                </div>
                                            </td>
                                            <td class="sv-new-lead__col-2">
                                                <div class="sv-filter-table__td email_td">
                                                    <input type="email" name="email-<?php echo $i;?>" value="<?php echo $lead['email'];?>"
                                                           placeholder="<?php echo __( "Email", "dkng" );?>"
                                                           maxlength="200"
                                                           autocomplete="off"
                                                    >
                                                </div>
                                            </td>
                                            <td class="sv-new-lead__col-3">
                                                <div class="sv-filter-table__td">
                                                    <input type="text" name="date-<?php echo $i;?>" value="<?php echo $new_date;?>" readonly="">
                                                </div>
                                            </td>
                                            <td class="sv-new-lead__col-5">
                                                <div class="sv-filter-table__td sv-filter-table__td text-right">
                                                    <span class="sv-checkbox sv-checkbox--empty">
                                                        <input type="checkbox" id="contact-<?php echo $i;?>" autocomplete="off">
                                                        <label for="contact-<?php echo $i;?>"></label>
                                                        <input type="hidden" class="row-id" name="contact-<?php echo $i;?>">
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <span class="error_txt" style="display: none"></span>
                    </div>

                    <div class="sv-contact-list-form__controls d-flex justify-content-end flex-column flex-lg-row align-items-end align-items-lg-center">
                        <div class="sv-contact-list-form__remove-button">
                            <p class="js-selected"> <?php echo __( "Selected", "dkng" );?> (<span>0</span> <?php echo __( "contacts", "dkng" );?>)</p>
                            <button class="sv-button sv-button--nav sv-button--grey-text sv-button--small-padding js-remove-contact" type="button" disabled>
                                <?php echo __( "Delete selected contacts", "dkng" );?>
                            </button>
                        </div>

                        <button class="sv-button sv-button--nav sv-button--green sv-button--small-padding js-add-row" type="button"
                            <?php if ( $author_id != $user->ID ) echo "disabled"; ?> >
                            <?php echo __( "Add new contact", "dkng" );?>
                        </button>
                    </div>
                </form>
            <?php } else { ?>
                <h4><?php echo __( "Wrong id of user list", "dkng" );?>.</h4>
            <?php }  ?>
        </div>
    </div>
</div>