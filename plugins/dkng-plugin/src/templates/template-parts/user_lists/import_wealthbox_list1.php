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
                        <?php echo __( "Back to All Lead List", "dkng" );?>s
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="sv-section import_wealthbox_page">

                <form class="sv-contact-list-form js-contact-list-form" id="tags_wealthbox_form" method="post">

                    <div class="sv-campaign-navigation sv-campaign-navigation--small-m d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between">
                        <div class="sv-lead-name d-flex flex-column " >
							<h2 class="sv-title"> <?php echo __( "Add Your Contacts from Wealthbox", "dkng" );?></h2>
							<h6 class="sv-title"><?php echo __( "Before you can create a list from your Wealthbox contacts, you do need to import them. Please start your import now", "dkng");?>.</h6>
                        </div>

                        <div>
                            <a href="<?php echo get_site_url() . '/admin-campaigns/?page=import_wealthbox_list' ;?>"  class="sv-button sv-button--nav sv-button--green " >
                              <?php echo __( "Start to import", "dkng" );?>
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php
get_footer();