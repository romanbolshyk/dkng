<div class="row">
    <div class="col-12">
        <div class="buttons-line buttons-line--larger">
            <a href="<?php echo get_site_url();?>/admin-campaigns/?page=add_lead" class="sv-button sv-button--nav sv-button--grey-text">
                <?php echo __( "Back to Imports", "dkng" );?>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <h2 class="sv-title sv-title--big-margin">  <?php echo __( "Import Your Spreadsheet", "dkng" );?></h2>

            <div class="sv-upload-space">
                <form action="#" class="sv-upload js-drop-area">
                    <div class="sv-upload__wrapper">
                        <div class="sv-upload__img">
                            <img src="<?php echo plugins_url( '../../../../assets/img/icons/import-icon.svg', __FILE__ ); ?>" alt="upload icon">
                        </div>
                        <p class="sv-upload__description"><?php echo __( "Please be sure the file is ready to upload (.xlsx)", "dkng" );?></p>
                        <div class="sv-upload__spiner js-progress"></div>
						<p class="sv-action__notification f-roboto"><?php echo __( "Email lists should contain <b>no more</b> than 2,000 contacts. Please double check for duplicate emails prior to uploading to the platform.", "dkng" );?></p>
						<div class="sv-upload__button">
                            <span class="message">
                                <?php echo __( "Drag your file here", "dkng" );?><br>
                                <?php echo __( "or", "dkng" );?>
                            </span>
                            <label class="sv-button sv-button--green sv-button--nav sv-button--small-padding">
                                <?php echo __( "Upload", "dkng" );?>
                                <input name="file" accept=".xls, .xlsx" type="file" />
                            </label>
                        </div>
                    </div>
                </form>
            </div>
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