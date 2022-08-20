<?php

/*
 *  Template Name: Add New List
 * */

if ( !is_user_logged_in() ) {
    wp_redirect( get_site_url() . '/advisorlogin', 301 );
    exit;
}

get_header();

$user              = wp_get_current_user();
$wealthbox_api_key = get_field( 'wealthbox_api_key', 'user_' . $user->ID );
$wealthbox_api_key = ( !empty( $wealthbox_api_key ) ) ? $wealthbox_api_key : "";

$weathbox_actions_obj = new \Dkng\Wp\WealthboxActions();
$user_lists_obj     = new \Dkng\Wp\UsersLists();
$count_page        = ( !empty( $_GET['per_page'] ) ) ? (int)$_GET['per_page'] : 1;
$per_page          = $weathbox_actions_obj->per_page;

$contacts_all      = $weathbox_actions_obj->get_contact_persons( $wealthbox_api_key, $count_page );
$contacts_all      = !empty( $contacts_all ) ? $contacts_all['response'] : array();

$count_contacts    = ( $contacts_all['meta']['total_count'] >= $user_lists_obj->limit ) ? $user_lists_obj->limit : $contacts_all['meta']['total_count'];
$show_limit_msg    = ( $contacts_all['meta']['total_count'] >= $user_lists_obj->limit ) ? 'shown' : 'hidden';
$pagination_counts = (int)( $count_contacts / $per_page );

$contacts_tags     = $weathbox_actions_obj->get_all_contacts_tags( $wealthbox_api_key );
$contacts_tags     = !empty( $contacts_tags ) ? $contacts_tags['response']['tags'] : array();

?>

    <div class="row">
        <div class="col-12">
            <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
                <div>
                    <a href="<?php echo get_site_url();?>/admin-campaigns/?page=all_leads" class="sv-button sv-button--nav sv-button--grey-text">
                        <?php echo __( "Back to All Lead List", "dkng" );?>s
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="sv-section">
                <h2 class="sv-title"> <?php echo __( "Wealthbox New List", "dkng" );?></h2>
				<h4 class="description-filter">
					<?php echo __( "Select your tags to filter your list to be able to create your list.", "dkng" ); ?>
				</h4>
                <div class=" d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                    <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center limit_message_block <?php echo $show_limit_msg;?>" >

						<?php if ( !empty( $show_limit_msg ) ) { ?>
                            <h4   class="message-filter">
                                <?php echo __( "You wanted to load more than our limit of ", "dkng" ) . $user_lists_obj->limit . ' contacts, ' . __( "we will show only", "dkng") .'  ' . $user_lists_obj->limit . __( " contacts", "dkng" );?>.
                            </h4>
                        <?php } ?>
                    </div>
                </div>

                <?php if ( $pagination_counts > 1 ) { ?>
                    <div class=" d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center " >
                            <?php if ( !empty( $contacts_tags ) ) { ?>
                                <?php for ( $i = 1; $i <= $pagination_counts;  $i++ ) { ?>
                                    <a href="<?php echo get_site_url() . "/admin-campaigns/?page=import_wealthbox_list&per_page=$i";?>" style="margin: 10px; padding: 10px;">
                                        <span >Page <?php echo $i;?></span>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <form class="sv-contact-list-form js-contact-list-form" id="tags_wealthbox_form" method="post">
                    <div class="sv-campaign-navigation sv-campaign-navigation--small-m d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex  flex-lg-row align-items-start align-items-lg-center wealthbox_tags_block" >
                            <?php if ( !empty( $contacts_tags ) ) { ?>
                                <?php foreach ( $contacts_tags as $contacts_tag ) { ?>
                                    <span>
                                         <input  id="<?php echo $contacts_tag['id'];?>" type="checkbox" name="contact_tags[]" value="<?php echo $contacts_tag['name'];?>" >
										 <label for="<?php echo $contacts_tag['id'];?>"> <?php echo $contacts_tag['name'];?></label>
									</span>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <input type='hidden' name='count_page' value='<?php echo $count_page;?>' >

                        <div class="">
							<span class="js-wealthbox-clear-filter" style="display: none;">Clear Filter</span>
                            <button type="submit" href="#" class="sv-button sv-button--nav sv-button--green filter_wealthbox_lists" >
                                <?php echo __( "Filter", "dkng" );?>
                            </button>
                        </div>
                    </div>
                </form>

                <form class="sv-contact-list-form js-contact-list-form" id="import_wealthbox_list" name="import_wealthbox_list_name" method="post">

                    <div class="sv-campaign-navigation sv-campaign-navigation--small-m d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <label> <?php echo __( "Wealthbox List Name", "dkng" );?></label>
                            <input type="text" name="list_name" value="<?php echo __( "Wealhbox List", "dkng" );?>" required>
                        </div>

                        <img src="./dist/img/loader.gif" id="wealthbox_loader" alt="loader" />
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
                                        <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="2">
                                            <?php echo __( "Date Added", "dkng" );?>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="sv-filter-table__th js-sort-button" data-type="tag" data-order="asc" data-td="2">
                                            <?php echo __( "Tag", "dkng" );?>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="sv-filter-table__th sv-filter-table__th--no-filter">
                                            <div class="sv-checkbox">
                                                <input type="checkbox" id="all-contacts">
                                                <label for="all-contacts"> <?php echo __( "Add All", "dkng" );?> (340)</label>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="js-table-height">
                                <?php if ( !empty( $contacts_all['contacts'] ) ) {
                                    $i = 0;
                                    $plugin_path = plugin_dir_path(__DIR__);
                                    $emails_all  = array();
                                    ?>
                                    <?php foreach ( $contacts_all['contacts'] as $contact ) {
                                        $email = $contact['email_addresses'][0]['address'];
                                        if ( !in_array( $email, $emails_all ) && !empty( $email ) ) {
                                            $emails_all[] = $email;
                                            require $plugin_path . '/ajax-items/wealthbox_contact_item.php';
                                        }
                                    } ?>
                                <?php } ?>
                                <input type='hidden' name='count_contacts'  id="count_contacts" value='<?php echo count( $emails_all );?>' >
                                <input type='hidden' name='count_page' id="count_page" value='<?php echo $count_page;?>' >
                            </tbody>
                        </table>
                        <span class="error_txt" style="display: none"></span>
                    </div>

                    <div class="sv-contact-list-form__controls d-flex justify-content-end flex-column flex-lg-row align-items-end align-items-lg-center">
                        <div class="sv-contact-list-form__remove-button">
                            <p class="js-selected"> <?php echo __( "Selected", "dkng" );?> (<span>0</span> <?php echo __( "contacts", "dkng" );?>)</p>
                            <button class="sv-button sv-button--nav sv-button--grey-text sv-button--small-padding js-remove-contact" type="button" disabled>
                                <?php echo __( "Delete Selected Contacts", "dkng" );?>
                            </button>
                        </div>

                        <button class="sv-button sv-button--nav sv-button--green sv-button--small-padding" type="submit">
                            <?php echo __( "Create List", "dkng" );?>
                        </button>
                    </div>
                </form>

			</div>
        </div>
    </div>

    <div class="modal exit_popup_block" id="add_lead_popup" >
        <div class="exit-popup">
            <div class="exit-popup-wrap">
            </div>
            <span class="exit_b_popup add_lead_popup_close">x</span>
        </div>
    </div>
<?php
get_footer();