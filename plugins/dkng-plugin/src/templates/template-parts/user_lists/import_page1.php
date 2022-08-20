
<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--larger">
            <a href="<?php echo get_site_url();?>/admin-campaigns/?page=all_leads" class="sv-button sv-button--nav sv-button--grey-text">
                <?php echo __( "Back to All Lead Lists", "dkng" );?>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <h2 class="sv-title sv-title--big-margin"> <?php echo __( "Add New List", "dkng" );?></h2>

            <div class="sv-actions">
                <div class="sv-action">
                    <div class="sv-action__img">
                        <img src="<?php echo plugins_url( '../../../../assets/img/icons/import-icon.svg', __FILE__ ); ?>" alt="upload icon">
                    </div>
                    <p class="sv-action__description">
                        <?php echo __( "Import List From Files", "dkng" );?>
                    </p>
                    <div class="sv-action__button">
                        <a href="<?php echo get_site_url() .'/admin-campaigns/?page=add_lead/build_list';?>" class="sv-button sv-button--nav sv-button--green sv-button--nav"
                            style="<?php echo $style_allowed_lists;?>" >
                            <?php echo __( "Upload List", "dkng" );?>
                        </a>
                    </div>
                </div>

                <div class="sv-action">
                    <div class="sv-action__img">
                        <img src="<?php echo plugins_url( '../../../../assets/img/icons/build-icon.svg', __FILE__ ); ?>" alt="upload icon">
                    </div>
                    <p class="sv-action__description">
                        <?php echo __( "Build List Manually", "dkng" );?>
                    </p>
                    <div class="sv-action__button">
                        <a href="<?php echo get_site_url() .'/admin-campaigns/?page=create_lead_manually';?>"
                            class="sv-button sv-button--green sv-button--nav">
                            <?php echo __( "Build List", "dkng" );?>
                        </a>
                    </div>
                </div>

                <?php if ( !empty( $wealthbox_api_key ) ) { ?>
                    <div class="sv-action">
                        <div class="sv-action__img">
                            <img src="<?php echo plugins_url( '../../../../assets/img/icons/import-icon-wealthbox.svg', __FILE__ ); ?>" alt="upload icon">
                        </div>
                        <p class="sv-action__description">
                            <?php echo __( "Create Wealthbox List", "dkng" );?>
                        </p>
                        <div class="sv-action__button">
                            <a href="<?php echo get_site_url() .'/admin-campaigns/?page=import_wealthbox_list1';?>"
                               class="sv-button sv-button--green sv-button--nav">
                                <?php echo __( "Create List", "dkng" );?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
			<p class="sv-action__notification sv-action__notification-margin f-roboto"><?php echo __( "Email lists should contain <b>no more</b> than 2,000 contacts. Please double check for duplicate emails prior to uploading to the platform.", "dkng" );?></p>
        </div>
    </div>
</div>
