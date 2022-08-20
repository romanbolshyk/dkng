<?php

/*
 *  Template Name: Add New List
 * */

if ( !is_user_logged_in() ) {
    wp_redirect( get_site_url() . '/advisorlogin', 301 );
    exit;
}

get_header();
?>

    <div class="row">
        <div class="col-12">
            <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
                <div>
                    <a href="<?php echo get_site_url();?>/admin-campaigns/?page=all_leads" class="sv-button sv-button--nav sv-button--grey-text">
                        <?php echo __( "Back to All Lead List", "dkng" );?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="sv-section">
                <h2 class="sv-title"> <?php echo __( "Lead List", "dkng" );?></h2>

                <form class="sv-contact-list-form js-contact-list-form" id="lead_create_form" method="post">

                    <div class="sv-campaign-navigation sv-campaign-navigation--small-m d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <label> <?php echo __( "Lead List Name", "dkng" );?></label>
                            <input type="text" name="list_name" value="<?php echo __( "New Name", "dkng" );?>" required>
                        </div>
                        <div class="">
                            <a href="#" class="sv-button sv-button--nav sv-button--green save_create_lead" style="<?php echo $style_allowed;?>">
                                <?php echo __( "Save", "dkng" );?>
                            </a>
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
                                            <label for="all-contacts"> <?php echo __( "Add All", "dkng" );?> (340)</label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="js-table-height">

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

                        <button class="sv-button sv-button--nav sv-button--green sv-button--small-padding js-add-row" type="button">
                            <?php echo __( "Add New Contact", "dkng" );?>
                        </button>
                    </div>
                </form>
				<p class="sv-action__notification sv-action__notification-margin d-none f-roboto"><?php echo __( "Email lists should contain <b>no more</b> than 2,000 contacts. Please double check for duplicate emails prior to uploading to the platform.", "dkng" );?></p>
			</div>
        </div>
    </div>

    <div class="modal exit_popup_block" id="add_lead_popup" >
        <div class="exit-popup">
            <div class="exit-popup-wrap">
                <div class="top">
                    <h3 ></h3>
                </div>
                <div class="right block bottom text-center justify-content-center" style="margin: 0 auto">

                </div>
            </div>
			<div class=" text-center justify-content-center" style="margin: 0 auto"><span class="sv-button sv-button--green sv-button--small-padding js-close-popup">OK</span></div>
			<span class="exit_b_popup add_lead_popup_close">x</span>
        </div>
    </div>

<?php
get_footer();