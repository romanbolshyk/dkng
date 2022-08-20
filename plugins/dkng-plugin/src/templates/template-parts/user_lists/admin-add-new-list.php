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

    <div class="container single-campaign">

        <div class="row">
            <div class="col-12">
                <div class="buttons-line buttons-line--larger">
                        <a href="#" class="sv-button sv-button--nav sv-button--grey-text">
                            <?php echo __( "Back to All Lead Lists", "dkng" );?>
                        </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="sv-section">
                    <h2 class="sv-title sv-title--big-margin">Add new list</h2>

                    <div class="sv-actions">
                        <div class="sv-action">
                            <div class="sv-action__img">
                                <img src="<?php echo plugins_url( '../../assets/img/icons/import-icon.svg', __FILE__ ); ?>" alt="upload icon">
                            </div>
                            <p class="sv-action__description">
                                Import list from files
                            </p>
                            <div class="sv-action__button">
                                <a href="#" class="sv-button sv-button--nav sv-button--green sv-button--nav">Upload list</a>
                            </div>
                        </div>

                        <div class="sv-action">
                            <div class="sv-action__img">
                                <img src="<?php echo plugins_url( '../../assets/img/icons/build-icon.svg', __FILE__ ); ?>" alt="upload icon">
                            </div>
                            <p class="sv-action__description">
                                Build list manually
                            </p>
                            <div class="sv-action__button">
                                <a href="#" class="sv-button sv-button--green sv-button--nav">Build list</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container single-campaign">

        <div class="row">
            <div class="col-12">
                <div class="buttons-line buttons-line--larger">
                    <a href="#" class="sv-button sv-button--nav sv-button--grey-text">
                        <?php echo __( "Back to Lists", "dkng" );?>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="sv-section">
                    <h2 class="sv-title sv-title--big-margin">Imports</h2>

                    <div class="sv-vertical-actions">
                        <div class="sv-action-vertical">
                            <div class="sv-action-vertical__img">
                                <img src="<?php echo plugins_url( '../../assets/img/icons/watch-icon.svg', __FILE__ ); ?>" alt="watch icon">
                            </div>
                            <span class="sv-action-vertical__tag">tutorial</span>
                            <p class="sv-action-vertical__description">
                                How to prepare your spreadsheet
                            </p>

                            <div class="sv-action-vertical__button">
                                <a href="#" class="sv-button sv-button--nav js-watch-guide" data-id="226346771">Watch video</a>
                            </div>
                        </div>

                        <div class="sv-action-vertical">
                            <div class="sv-action-vertical__img">
                                <img src="<?php echo plugins_url( '../../assets/img/icons/download-icon.svg', __FILE__ ); ?>" alt="download icon">
                            </div>
                            <span class="sv-action-vertical__tag">Sample</span>
                            <p class="sv-action-vertical__description">
                                Download a sample spreadsheet
                            </p>

                            <div class="sv-action-vertical__button">
                                <a href="#" class="sv-button sv-button--nav">Download</a>
                            </div>
                        </div>

                        <div class="sv-action-vertical">
                            <div class="sv-action-vertical__img">
                                <img src="<?php echo plugins_url( '../../assets/img/icons/faq-icon.svg', __FILE__ ); ?>" alt="faq icon">
                            </div>
                            <span class="sv-action-vertical__tag">FAQ</span>
                            <p class="sv-action-vertical__description">
                                Have questions?
                            </p>

                            <div class="sv-action-vertical__button">
                                <a href="#" class="sv-button sv-button--nav">View FAQ</a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="#" class="sv-button sv-button--green sv-button--nav sv-button sv-button--small-padding sv-button-import">Start to import</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container single-campaign">

        <div class="row">
            <div class="col-12">
                <div class="buttons-line buttons-line--larger">
                    <a href="#" class="sv-button sv-button--nav sv-button--grey-text">
                        <?php echo __( "Back to Imports", "dkng" );?>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="sv-section">
                    <h2 class="sv-title sv-title--big-margin">Import your spreadsheet</h2>

                    <div class="sv-upload-space">
                        <form action="#" class="sv-upload js-drop-area">
                            <div class="sv-upload__wrapper">
                                <div class="sv-upload__img">
                                    <img src="<?php echo plugins_url( '../../assets/img/icons/import-icon.svg', __FILE__ ); ?>" alt="upload icon">
                                </div>
                                <p class="sv-upload__description">Please be sure the file is ready to upload (.xls)</p>
                                <div class="sv-upload__spiner js-progress"></div>
                                <div class="sv-upload__button">
                                    <span class="message">Drag your file here<br>or</span>
                                    <label class="sv-button sv-button--green sv-button--nav sv-button--small-padding">
                                        Upload
                                        <input name="file" accept=".xls, .xlsx" type="file" />
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container single-campaign">

        <div class="row">
            <div class="col-12">
                <div class="buttons-line buttons-line--larger">
                    <a href="#" class="sv-button sv-button--nav sv-button--grey-text">
                        <?php echo __( "Back to imports", "dkng" );?>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="sv-section">
                    <h2 class="sv-title sv-title--big-margin">New a list uploaded!</h2>

                    <div class="sv-new-list-name">
                        <p class="sv-new-list-name__label">Lead List Name</p>
                        <span class="sv-new-list-name__title">
                            July, 21 2020
                            <img src="<?php echo plugins_url( '../../assets/img/icons/edit-icon.svg', __FILE__ ); ?>"
                                 class="sv-new-list-name__edit js-edit-list"
                                 alt="edit icon"
                            >
                        </span>
                    </div>

                    <div class="sv-filter-table-wrap">
                        <table class="sv-filter-table sv-filter-table--grey-row sv-uploaded-table js-table-tab active">
                            <thead>
                            <tr>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="0">
                                        Name
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="1">
                                        Email
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="date" data-order="asc" data-td="2">
                                        Date Added
                                    </div>
                                </th>
                                <th>
                                    <div class="sv-filter-table__th js-sort-button" data-type="string" data-order="asc" data-td="3">
                                        Address
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="js-table-height">
                                <tr>
                                    <td class="sv-uploaded-table__col-1">
                                        <div class="sv-filter-table__td">Daisy Harper</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-2">
                                        <div class="sv-filter-table__td">sauer.lorenz@altenwerth.name</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-3">
                                        <div class="sv-filter-table__td">04/01/2020</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-4">
                                        <div class="sv-filter-table__td">547 McDermott Valleys Suite 115</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sv-uploaded-table__col-1">
                                        <div class="sv-filter-table__td">Raymond Sanchez</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-2">
                                        <div class="sv-filter-table__td">schuppe.elouise@yahoo.com</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-3">
                                        <div class="sv-filter-table__td">07/20/2020</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-4">
                                        <div class="sv-filter-table__td">872 Johns Crossroad Suite 957</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sv-uploaded-table__col-1">
                                        <div class="sv-filter-table__td">Ralph James</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-2">
                                        <div class="sv-filter-table__td">bradtke.vicenta@freda.com</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-3">
                                        <div class="sv-filter-table__td">04/11/2020</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-4">
                                        <div class="sv-filter-table__td">30 Lang Islands</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sv-uploaded-table__col-1">
                                        <div class="sv-filter-table__td">Callie Reeves</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-2">
                                        <div class="sv-filter-table__td">precious.emmerich@yahoo.com</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-3">
                                        <div class="sv-filter-table__td">05/17/2020</div>
                                    </td>
                                    <td class="sv-uploaded-table__col-4">
                                        <div class="sv-filter-table__td">2907 Adelbert River</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end sv-uploaded-nav">
                        <a href="#" class="sv-button sv-button--green sv-button--small-padding sv-button--nav">Back to All Lead Lists</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();