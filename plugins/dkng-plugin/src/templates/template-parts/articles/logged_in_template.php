<?php
$related_user_id  = $related[$user->ID];

$articles_obj     = new \Dkng\Wp\ArticlesActions();
$get_related_post = !empty( $related_user_id ) ? $articles_obj->get_related_article_from_site2( $related_user_id ) : array();

$related_post_link  = ( !empty( $related_user_id ) && !empty( $get_related_post['link'] ) ) ? $get_related_post['link'] : "";
$related_post_title = ( !empty( $related_user_id ) && !empty( $get_related_post['title'] ) ) ? $get_related_post['title'] : "";

$link1         = ( !empty( $related_user_id ) ) ? $related_post_link : '';
$related_id    = ( !empty( $related_user_id ) && !empty( $related_post_title ) ) ? $related_user_id : 0;
$related_title = ( !empty( $related_user_id ) ) ? $related_post_title : '';

$link          = ( is_array( $user_published_articles ) && array_key_exists( $id, $user_published_articles ) ) ? $link1 : '';
$current_time  = current_time('Y-m');
$get_downloads = get_user_meta($user->ID, $current_time, true);
$get_downloads = ( !empty( $get_downloads ) ) ? $get_downloads : array();

/* it was limit 5 , for mow it's unlimited
$disable_class_pdf   = ( ( count( $get_downloads ) >= 5 ) || empty( $pdf_file ) )   ? 'disabled_hrefs' : '';
$disable_class_word  = ( ( count( $get_downloads ) >= 5 ) || empty( $word_file ) )  ? 'disabled_hrefs' : '';
$disable_class_video = ( ( count( $get_downloads ) >= 5 ) || empty( $video_file ) ) ? 'disabled_hrefs' : '';
*/

$disable_class_pdf   = '';
$disable_class_word  = '';
$disable_class_video = '';

?>

<?php if ( empty( $cloned_article ) ) { ?>
    <div class="col-12 col-md-7 col-lg-8">
        <div class="row d-flex flex-row justify-content-end align-items-center">
            <div class="col-12 col-md-4 col-lg-2">
                <div class="small-white d-flex justify-content-center align-items-center edit-post-button">
                    <a href="#" class=""><i class="fa fa-edit"></i> <?php echo __( "Edit", "dkng" ); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="col-12 col-lg-8">
    <div class="investment-holder article_content_block">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="sv-content__block">
                    <h4 class="type-title type-title--no-margin title-icon title-icon--<?php echo $article_type; ?>">
                        <?php echo ucfirst( $article_type ); ?>
                    </h4>
                    <p>
                        <?php if ( !empty( $cloned_article ) ) {
                            echo  $modified_text;
                        } ?>
                    </p>
                    <?php if ( !empty( $cloned_article ) && !empty( $show_custom_link_message ) && !empty( $link ) ) { ?>
                        <span class="show_customlink_text"><?php echo __( "Please ensure you re-publish the custom link reflecting any new changes", "dkng" ); ?>.</span>
                    <?php } ?>
                </div>
                <?php if ( !empty( $cloned_article ) ) { ?>
                    <div class="sv-content__block small-white d-flex justify-content-center align-items-center ">
                        <a href="#" class="edit_article_button" style="margin: 0 20px;"><i class="fa fa-edit"></i> <?php echo __( "Edit Article", "dkng" ); ?></a>
                        <a href="#" class="reset_article_button" style="margin: 0 20px;" data-id=<?php echo $id;?>><?php echo __( "Reset Article", "dkng" );?></a>
                    </div>
                <?php } ?>
            </div>

            <?php if ( $article_type != 'article' ) {
                $title = '';
                if ( $article_type == 'email' ) {
                    $title = __( "Subject line", "dkng" );
                } elseif ( $article_type == 'video' ) {
                    $title = __( "Video Title   ", "dkng" );
                }
                ?>
                <div class="col-12 col-md-12">
                    <div class="sv-content__block">
                        <h4 class="type-title"><?php echo $title; ?></h4>
                        <p class="title-subject title-subject--no-margin"><?php the_title(); ?></p>
                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="sv-content__block <?php echo $article_type; ?>-block sv-content__block--pb-100">
                    <?php if ( $article_type != 'article' ) { ?>
                        <h4 class="type-title type-title--mb-45"><?php echo __( "Content", "dkng" ); ?></h4>
                    <?php } ?>
                    <div class="content_area">
                        <?php if ( $article_type == 'article' ) { ?>
                            <?php if ( !empty(get_the_post_thumbnail_url()) ) { ?>
                                <div class="inv-img"
                                     style="background-image: url(<?php echo the_post_thumbnail_url(); ?>); margin-bottom: 20px;"></div>
                            <?php } ?>
                            <h2 class="title-subject"><?php the_title(); ?></h2>
                            <span class="sv-content__date"><?php the_date('M d'); ?></span>
                        <?php } ?>
                        <?php if ( $article_type == 'video' ) { ?>
                            <video controls style="width: 100%;">
                                <source src="<?php echo $video_file; ?>" type="video/mp4">
                                <?php echo __( "Your browser does not support the video tag", "dkng" );?>.
                            </video>
                        <?php } ?>
                        <?php if ( $article_type != 'video' ) { ?>
                            <?php echo apply_filters('the_content', $post->post_content); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12 col-lg-4 mt-3 mt-md-0 investment-right-holder single_article_sharing_block">
    <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
            <div class="download_block " data-post="<?php echo get_the_ID(); ?>"
                 data-link="<?php echo $link; ?>">
                <h3 class="download_text sv-tooltip-container">
                    <?php if ( !empty( $cloned_article ) ) { ?>
                        <span><?php echo __( "Download the original piece for your marketing efforts", "dkng"); ?>.</span>
                    <?php } else { ?>
                        <span><?php echo __( "Download for your marketing efforts", "dkng"); ?>.</span>
                    <?php } ?>
                    <span class="sv-tooltip" data-tooltip="<?php echo esc_attr( $info_download ); ?>"></span>
                </h3>
                <?php if ( $article_type != 'video' ) { ?>
                    <!--  <a class="word-pdf-button different --><?php //echo $disable_class_pdf;?><!--"-->
                    <!--       href="--><?php //echo $pdf_file;?><!--"-->
                    <!--       data-post-id="--><?php //echo $id;?><!--"-->
                    <!--       data-file-type="pdf" >-->
                    <!--     --><?php //echo __( "PDF", "dkng" );?>
                    <!--  </a>-->
					<a class="word-pdf-button1 ">
						<?php echo __( "Word Document", "dkng" ); ?>
					</a>
					<div class="download-document-popup-wrap ">
						<div class="download-overlay"></div>
						<div class="download-document-popup sv-contact-popup">
							<span class="close-popup">x</span>
							<?php if ( !empty( get_field('text_before_link', 'options') ) ): ?>
								<div class="download-document-popup-text" >
									<?php echo wp_kses(get_field('text_before_link', 'options'), 'post')?>
								</div>
							<?php endif; ?>

							<?php if ( !empty( get_field('text_after_link', 'options' ) ) ): ?>
								<div class="download-document-popup-text" id="popup-text">
									<?php echo wp_kses(get_field('text_after_link', 'options'), 'post')?>
									<?php $link1 = get_the_permalink();?>
									<div class="download-document-popup-copy-link" data-link="<?php echo $link1;?>">
									</div>
								</div>
								<span class="btn_link_copy_popup"><?php echo __( "Copy message", "dkng" );?></span>
							<?php endif; ?>
							<div class="buttons-popup">
								<a class="cancel">
									<?php echo __( "Back", "dkng" ); ?>
								</a>
								<a class="word-pdf-button different <?php echo $disable_class_word; ?>"
								   data-post-id="<?php echo $article_id; ?>"
								   href="<?php echo $word_file; ?>"
								   data-file-type="word">
									<?php echo __( "Proceed", "dkng" ); ?>
								</a>
							</div>
					</div>
                <?php } else { ?>
                    <a class="word-pdf-button different <?php echo $disable_class_video; ?>"
                       data-post-id="<?php echo $article_id; ?>"
                       href="<?php echo $video_file; ?>"
                       data-file-type="word">
                        <?php echo __( "MP4", "dkng" ); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <?php if ( $article_type != 'email' ) { ?>

                <div class="sharing_block" data-post="<?php echo get_the_ID(); ?>"
                     data-link="<?php echo $link; ?>">
                    <h3 class="download_text sv-tooltip-container">
                        <span><?php echo __( "Share from the Seven platform.", "dkng" ); ?></span>
                        <span class="sv-tooltip" data-tooltip="<?php echo esc_attr( $info_share ); ?>"></span>
                    </h3>
                    <div class="small-white small-white-right custom_url_block">
                        <form class="sharing_form">
                            <div class="sharing_form__link-gen">
                                <?php $checked = ( is_array( $user_published_articles ) && !empty( $link ) && array_key_exists( $id, $user_published_articles ) ) ? 'checked' : ''; ?>
                                <div class="d-flex flex-row block_custom_url">
                                    <input type="checkbox" class="form-control" name="published"
                                           id="published"
                                           data-user="<?php echo $user->ID; ?>"
                                           data-post="<?php echo $id; ?>"
                                           data-shared-post="<?php echo $related_id; ?>"
                                           data-permalink="<?php echo get_the_permalink(); ?>"
                                        <?php echo $checked; ?>
                                    >
                                    <label for="published"> <?php echo __("Create Custom Link", "dkng"); ?> </label>
                                </div>
                                <div class="d-flex flex-row justify-content-center align-items-center block_custom_url right">
                                    <?php
                                    $link1 = ( !empty( $related_user_id ) ) ? $related_post_link : '';
                                    $link = ( is_array( $user_published_articles ) && array_key_exists( $id, $user_published_articles ) ) ? $link1 : '';
                                    ?>
                                    <input type="url" id="input_url" class="input_url" name="share"  value="<?php echo $link; ?>">
                                    <span class="btn_link_copy"><?php echo __( "copy link", "dkng" );?>
                                        <span class="message"><?php echo __( "Copied", "dkng" );?></span>
                                    </span>
                                    <img src="./dist/img/loader.gif" id="loader1" alt="loader"/>
                                </div>
                            </div>
                            <div class="block_custom_url third">
                                <?php echo do_shortcode("[addtoany url='" . $link . "']"); ?>
                            </div>
                        </form>
                    </div>
                </div>

            <?php } ?>
            <?php // include_once 'article-social-sharing.php';?>
        </div>
    </div>
    <div class="">
        <div class="col-12">
            <h5><?php echo __( "View More", "dkng" ); ?></h5>
        </div>
        <div class="col-12">
            <?php echo $other_posts; ?>
        </div>
    </div>
</div>