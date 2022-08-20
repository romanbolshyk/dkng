<?php
    $video_link    = get_field( 'video_spreadsheet_link', 'options' );
    $video_link    = explode( '/', $video_link );
    $video_link_id = $video_link[3];
?>
<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--larger">
            <a href="<?php echo get_site_url();?>/admin-campaigns/?page=all_leads" class="sv-button sv-button--nav sv-button--grey-text">
                <?php echo __( "Back to Lists", "dkng" );?>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <h2 class="sv-title sv-title--big-margin"><?php echo __( "Imports", "dkng" );?></h2>

            <div class="sv-vertical-actions">
                <div class="sv-action-vertical">
                    <div class="sv-action-vertical__img">
                        <img src="<?php echo plugins_url( '../../../../assets/img/icons/watch-icon.svg', __FILE__ ); ?>" alt="watch icon">
                    </div>
                    <span class="sv-action-vertical__tag"><?php echo __( "tutorial", "dkng" );?> </span>
                    <p class="sv-action-vertical__description">
                        <?php echo __( "How to prepare your spreadsheet", "dkng" );?>
                    </p>

                    <div class="sv-action-vertical__button">
                        <a href="#" class="sv-button sv-button--nav js-watch-guide" data-id="<?php echo $video_link_id;?>">
                            <?php echo __( "Watch Video", "dkng" );?>
                        </a>
                    </div>
                </div>

                <div class="sv-action-vertical">
                    <div class="sv-action-vertical__img">
                        <img src="<?php echo plugins_url( '../../../../assets/img/icons/download-icon.svg', __FILE__ ); ?>" alt="download icon">
                    </div>
                    <span class="sv-action-vertical__tag"><?php echo __( "Sample", "dkng" );?> </span>
                    <p class="sv-action-vertical__description">
                        <?php echo __( "Download a sample spreadsheet", "dkng" );?>
                    </p>

                    <div class="sv-action-vertical__button">
                        <a href="<?php echo get_site_url();?>/wp-content/plugins/dkng-plugin/lead-list.xlsx" class="sv-button sv-button--nav"><?php echo __( "Download", "dkng" );?> </a>
                    </div>
                </div>

                <div class="sv-action-vertical">
                    <div class="sv-action-vertical__img">
                        <img src="<?php echo plugins_url( '../../../../assets/img/icons/faq-icon.svg', __FILE__ ); ?>" alt="faq icon">
                    </div>
                    <span class="sv-action-vertical__tag"><?php echo __( "FAQ", "dkng" );?> </span>
                    <p class="sv-action-vertical__description">
                        <?php echo __( "Have questions?", "dkng" );?>
                    </p>

                    <div class="sv-action-vertical__button">
                        <a href="<?php echo get_site_url();?>/faq" class="sv-button sv-button--nav"><?php echo __( "View FAQ", "dkng" );?> </a>
                    </div>
                </div>
            </div>
			<p class="sv-action__notification sv-action__notification-margin f-roboto"><?php echo __( "Email lists should contain <b>no more</b> than 2,000 contacts. Please double check for duplicate emails prior to uploading to the platform.", "dkng" );?></p>

            <div class="d-flex justify-content-end">
                <a href="<?php echo get_site_url();?>/admin-campaigns/?page=add_lead/upload"
                   class="sv-button sv-button--green sv-button--nav sv-button sv-button--small-padding sv-button-import"
                   style="<?php echo $style_allowed_lists;?>" >
                    <?php echo __( "Start to Import", "dkng" );?>
                </a>
            </div>
        </div>
    </div>
</div>