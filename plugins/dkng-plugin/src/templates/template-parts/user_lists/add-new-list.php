<?php

/*
 *  Template Name: Add new List
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
                <div class="buttons-line d-flex justify-content-between align-items-start">
                    <div>
                        <a href="#" class="sv-button sv-button--nav sv-button--grey-text">
                            <?php echo __( "Back To Campaigns", "dkng" );?>
                        </a>
                    </div>

                    <div>
                        <a href="#" class="sv-button sv-button--nav sv-button--green">
                            <?php echo __( "add new list", "dkng" );?>
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

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">How To Boost Your Traffic Of Your Blog And Destroy The C...</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">38</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">09/16/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Herbert Welch</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">68</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Billboard Advertising</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">93</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">07/20/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Nellie Parsons</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">8</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Advertising Outdoors</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">10</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">04/11/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Josie Klein</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">40</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">How To Boost Your Traffic Of Your Blog And Destroy The C...</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">38</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">09/16/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Herbert Welch</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">68</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Billboard Advertising</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">93</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">07/20/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Nellie Parsons</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">8</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Advertising Outdoors</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">10</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">04/11/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Josie Klein</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">40</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">How To Boost Your Traffic Of Your Blog And Destroy The C...</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">38</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">09/16/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Herbert Welch</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">68</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Billboard Advertising</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">93</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">07/20/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Nellie Parsons</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">8</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Advertising Outdoors</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">10</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">04/11/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Josie Klein</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">40</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">Why Do You Need To Join An Affiliate Marketing Network</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">64</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">01/02/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Marvin Morales</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">11</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="sv-filter-table-wrap">
                        <table class="sv-filter-table sv-lead-list js-table-tab active" style="display: none">
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

                            <tr>
                                <td class="sv-lead-list__col-1">
                                    <div class="sv-filter-table__td">How To Boost Your Traffic Of Your Blog And Destroy The C...</div>
                                </td>
                                <td class="sv-lead-list__col-2">
                                    <div class="sv-filter-table__td">38</div>
                                </td>
                                <td class="sv-lead-list__col-3">
                                    <div class="sv-filter-table__td">09/16/2020</div>
                                </td>
                                <td class="sv-lead-list__col-4">
                                    <div class="sv-filter-table__td">Herbert Welch</div>
                                </td>
                                <td class="sv-lead-list__col-5">
                                    <div class="sv-filter-table__td text-right">68</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();