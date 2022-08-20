<?php

/*
 *  Template Name: Contact List
 * */

if ( !is_user_logged_in() ) {
    wp_redirect( get_site_url() . '/advisorlogin', 301 );
    exit;
}

get_header();
?>

<div class="container single-campaign">

    <div class="row">
        <div class="col-12">
            <div class="buttons-line buttons-line--wide-buttons d-flex justify-content-between align-items-start">
                <div>
                    <a href="#" class="sv-button sv-button--nav sv-button--grey-text">
                        <?php echo __( "Back to add new list", "dkng" );?>
                    </a>
                </div>

                <div>
                    <a href="#" class="sv-button sv-button--nav sv-button--green">
                        <?php echo __( "Save", "dkng" );?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="sv-section">
                <h2 class="sv-title">Lead List</h2>

                <form class="sv-contact-list-form js-contact-list-form">

                    <div class="sv-campaign-navigation sv-campaign-navigation--small-m d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <label>Lead List Name</label>
                            <input type="text" value="Success Group">
                        </div>
                        <div class="sv-table-search sv-table-search--thin">
                            <input type="text" placeholder="Search" class="js-table-search">
                        </div>
                    </div>

                    <div class="sv-filter-table-wrap">
                        <table class="sv-filter-table sv-filter-table--grey-row js-table-tab sv-lead-list active">
                            <thead>
                            <tr>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="0">
                                        Name
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="1">
                                        Email
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="date" data-order="asc" data-td="2">
                                        Date Added
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="input-string" data-order="asc" data-td="3">
                                        Address
                                    </div>
                                </th>
                                <th class="text-right">
                                    <div class="sv-filter-table__th sv-filter-table__th--no-filter">
                                        <div class="sv-checkbox">
                                            <input type="checkbox" id="all-contacts">
                                            <label for="all-contacts">Add All (340)</label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="js-table-height">
                            <tr>
                                <td class="sv-new-lead__col-1">
                                    <div class="sv-filter-table__td">
                                        <input type="text" name="name-1" value="Daisy Harper" placeholder="Name">
                                    </div>
                                </td>
                                <td class="sv-new-lead__col-2">
                                    <div class="sv-filter-table__td">
                                        <input type="email" name="email-1" value="sauer.lorenz@altenwerth.name" placeholder="Email">
                                    </div>
                                </td>
                                <td class="sv-new-lead__col-3">
                                    <div class="sv-filter-table__td">04/01/2020</div>
                                </td>
                                <td class="sv-new-lead__col-4">
                                    <div class="sv-filter-table__td">
                                        <input type="text" name="address-1" value="547 McDermott Valleys Suite 115" placeholder="Address">
                                    </div>
                                </td>
                                <td class="sv-new-lead__col-5">
                                    <div class="sv-filter-table__td sv-filter-table__td text-right">
                                        <span class="sv-checkbox sv-checkbox--empty">
                                            <input type="checkbox" id="contact-1">
                                            <label for="contact-1"></label>
                                            <input type="hidden" class="row-id" name="contact-1">
                                        </span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-new-lead__col-1">
                                    <div class="sv-filter-table__td">
                                        <input type="text" name="name-2" value="Raymond Sanchez" placeholder="Name">
                                    </div>
                                </td>
                                <td class="sv-new-lead__col-2">
                                    <div class="sv-filter-table__td">
                                        <input type="email" name="email-2" value="schuppe.elouise@yahoo.com" placeholder="Email">
                                    </div>
                                </td>
                                <td class="sv-new-lead__col-3">
                                    <div class="sv-filter-table__td">07/20/2020</div>
                                </td>
                                <td class="sv-new-lead__col-4">
                                    <div class="sv-filter-table__td">
                                        <input type="text" name="address-2" value="872 Johns Crossroad Suite 957" placeholder="Address">
                                    </div>
                                </td>
                                <td class="sv-new-lead__col-5">
                                    <div class="sv-filter-table__td sv-filter-table__td text-right">
                                        <span class="sv-checkbox sv-checkbox--empty">
                                            <input type="checkbox" id="contact-2">
                                            <label for="contact-2"></label>
                                            <input type="hidden" class="row-id" name="contact-2">
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="sv-contact-list-form__controls d-flex justify-content-end flex-column flex-lg-row align-items-end align-items-lg-center">
                        <div class="sv-contact-list-form__remove-button">
                            <p class="js-selected"> Selected (<span>0</span> contacts)</p>
                            <button class="sv-button sv-button--nav sv-button--grey-text sv-button--small-padding js-remove-contact" type="button" disabled>Delete selected contacts</button>
                        </div>
                        <button class="sv-button sv-button--nav sv-button--green sv-button--small-padding js-add-row" type="button">Add new contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();