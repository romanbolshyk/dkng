<div class="row">
    <div class="col-12 col-lg-4">
        <div class="buttons-line d-flex justify-content-start align-items-start">
            <a href="<?php echo get_site_url() . '/admin-campaigns/?all=1';?>" class="sv-button sv-button--nav sv-button--grey-text">
                <?php echo __( "Back To Campaigns", "dkng" );?>
            </a>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="buttons-line d-flex flex-wrap justify-content-end align-items-start">
            <?php $class_file = ( !empty( $pdf_campaign ) ) ? '' : ' disabled';?>
            <a href="<?php echo get_permalink( $post_id ) . '?report=1';?>"
               class="sv-button sv-button--nav" >
                <?php echo __( "View Report", "dkng" );?>
            </a>
            <?php //if ( !in_array( 'cloned', $post_terms ) ) { ?>
            <a href="#" target="_blank" data-id="<?php echo get_the_ID();?>"
               class="sv-button sv-button--nav clone_campaign_single_page_btn" >
                <?php echo __( "Clone Campaign", "dkng" );?>
            </a>
            <?php //} ?>
            <a href="<?php echo $pdf_campaign;?>" target="_blank"
               class="sv-button sv-button--nav compilance_download_btn <?php echo $class_file;?>" data-campaginid="<?php echo $post_id;?>">
                <?php echo __( "Download for Compliance", "dkng" );?>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="sv-section">
            <div class="single_campaign_block">
                <h2 class="sv-title">
                    <?php echo __( "Email Campaign", "dkng" );?>
                </h2>
                <span class="ribbon-target" style="<?php echo $ribbon_background; ?>"><?php echo $status; ?></span>
            </div>

            <form action="" class="sv-email-campaign scheduling_campaign_form" method="post">

                <!-- it's for stopping collectiuon data form submissions from hubspot -->
                <label for="amex" style="display:none">AMEX</label>
                <input type="hidden" name="amex" required="" value="" id="amex">
                <label for="credit-card" style="display:none" class="hidden">HubspotCollectedFormsWorkaround https://community.hubspot.com/t5/APIs-Integrations/How-to-stop-collected-forms-from-collecting-a-form/m-p/299172#M28102</label>
                <input name="credit-card" type="hidden" class="hidden" required="" value="HubspotCollectedFormsWorkaround" id="credit-card">
                <label for="cc-num" style="display:none" class="hidden">credit card HubspotCollectedFormsWorkaround https://community.hubspot.com/t5/APIs-Integrations/How-to-stop-collected-forms-from-collecting-a-form/m-p/299172#M28102</label>
                <input name="cc-num" type="hidden" class="hidden" required="" value="HubspotCollectedFormsWorkaround" id="cc-num">

                <div class="sv-tales">
                    <div class="sv-tale">
                        <h4 class="sv-tale__title"><?php echo __( "Name of Campaign", "dkng" );?></h4>
                        <p class="sv-tale__copy">
                            <?php if ( in_array( 'cloned', $post_terms ) ) { ?>
                                <textarea class="cloned_name_textarea" type="text" value="" data-id="<?php echo $post_id;?>"><?php echo get_the_title();?></textarea>
                            <?php } else { ?>
                                <?php echo get_the_title();?>
                            <?php } ?>
                        </p>
                        <img src="./dist/img/loader.gif" id="loader_campaign" alt="loader" style=" display: none; position: absolute; left: 50%; top: 50%;"/>
                    </div>

                    <div class="sv-tale">
                        <h4 class="sv-tale__title"><?php echo __( "Number of Emails", "dkng" );?></h4>
                        <p class="sv-tale__copy"><?php echo count( $emails );?></p>
                    </div>

                    <div class="sv-tale">
                        <h4 class="sv-tale__title"><?php echo __( "Send Group", "dkng" );?></h4>

                        <?php
                        // $current_list = $campaigns_obj->get_scheduling_email_data( $post_id, $user->ID, $emails[0]['email_subject'] ); - old version
                        $current_list = $campaigns_obj->get_scheduling_campaign_list( $post_id, $user->ID );
                        $current_list = $current_list['user_list'];
                        $list_disabled_class = ( ( $status == 'Not Active' ) || ( $status == 'Draft' ) ) ? '' : 'disabled_btn';
                        ?>
                        <div class="sv-tale__select">
                            <select name="campaign_group" class="<?php echo $list_disabled_class;?>">
                                <?php if ( !empty( $leads['posts'] ) ) { ?>
                                    <?php foreach ( $leads['posts'] as $lead ) {
                                        $selected = ( (int)$current_list == $lead->ID ) ? "selected" : ""; ?>
                                        <option value="<?php echo $lead->ID;?>" <?php echo $selected;?>><?php echo $lead->post_title;?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="sv-tale">
                        <?php
                        $campaign_data = $campaigns_obj->get_scheduling_email_data( $post_id, $user->ID, false );
                        if ( !empty( $campaign_data ) ) {
                            $count      = count( $campaign_data );
                            $bcc_emails = $campaign_data[$count-1]['bcc_emails_list'];
                        }
                        else{
                            $bcc_emails = '';
                        }

                        ?>
                        <h4 class="sv-tale__title"><?php echo __( "BCC Emails", "dkng" );?></h4>
                        <div class="sv-tale-emails"></div>
                        <input type="text" name="bcc_emails" class="bcc_emails"
                               placeholder="<?php echo __( "BCC Emails", "dkng" );?>" value="">
                        <input type="hidden" name="bcc_emails_list" class="bcc_emails_list" value="<?php echo $bcc_emails;?>">
                    </div>
                </div>
                <input type="hidden" name="campaign_id" value="<?php echo $post_id;?>">
                <?php if ( !empty( get_the_content(null, false, $post_id) ) ) : ?>
                    <div class="sv-tales">
                        <div class="sv-tale sv-campaign-description"><?php the_content( $post_id );?></div>
                    </div>
                <?php endif; ?>
                <table class="sv-email-campaign__table js-campaign-table">
                    <thead>
                    <tr>
                        <th><?php echo __( "Email Subject", "dkng" );?></th>
                        <th><span><?php echo __( "Email Body", "dkng" );?></span></th>
                        <th><span><?php echo __( "Sending date", "dkng" );?></span></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="js-equal-subject-body">
                    <?php if ( !empty( $email_disclosure ) ) { ?>
                        <div class="email_disclosure_content" style="display: none;">
                            <?php echo $email_disclosure;?>
                        </div>
                    <?php } ?>
                    <?php
                    $check       = false;
                    $check_draft = false;

                    if ( !empty( $emails ) ) {

                        $i = 0;
                        foreach ( $emails as $email ) {

                            $i++;
                            $email_data = $campaigns_obj->get_scheduling_email_data( $post_id, $user->ID, $email['email_subject'] );

                            $email_body = !empty( $email_data["email_body"] ) ? $email_data["email_body"] : $email['email_body'];
                            $email_body = str_replace ( '@custom_paragraph', '', $email_body );
                            $email_body = stripslashes ( $email_body );

                            $original_email_body = esc_attr( str_replace ( '@custom_paragraph', '', $email['email_body'] ) );
                            $subs = array(
                                '/\[custom_link\](.+)\[\/custom_link\]/Ui' =>
                                    '<a style="background-color:#789;color:#fff;min-width:120px;text-decoration:none;font-weight:500;text-align:center;letter-spacing:.2px;display:inline-block;border-radius:17px;padding:6px 10px;" href="'.$email_data['custom_link'].'">$1</a>',
                            );

                            $str_text = preg_replace(array_keys( $subs ), array_values( $subs ), $email_body );

                            $use_custom_link = $email['use_custom_link'];
                            $str_text        = mb_strimwidth( strip_tags( $str_text ), 0, 33, '...' );

                            $sending_data_format = '';

                            if ( empty( $email_data ) ) {
                                $sending_data = 'Not scheduled yet';
                            }
                            elseif ( $email_data['status'] == 'canceled' ) {
                                $sending_data = 'Canceled';
                            }
                            elseif ( $email_data['status'] == 'draft' ) {
                                $sending_data        = 'Draft';

                                if ( $email_data["sending_time"] == '0000-00-00 00:00:00' ) {
                                    $sending_data = 'Not scheduled yet';
                                }
                                else {
                                    $old_date            = strtotime( $email_data["sending_time"] );
                                    $sending_data_format = date('m-d-Y h:ia', $old_date );
                                    $sending_data       .= ' - ' .  $sending_data_format;
                                }
                                $check_draft         = true;
                            }
                            else {
                                $sending_data        = ( $email_data["status"] == 'sent' ) ? 'Sent' : 'Active';
                                $old_date            = strtotime( $email_data["sending_time"] );
                                $sending_data_format = date('m-d-Y h:ia', $old_date );
                                $sending_data       .= ' - ' .  $sending_data_format;
                                $check = true;
                            }

                            $class              = ( $email_data['status'] == 'canceled' ) ? 'canceled' : '';
                            $custom_link_class  = ( ( $email_data["status"] == 'sent' ) || ( $email_data["status"] == 'canceled' ) || ( $email_data["status"] == 'stopped' ) || ( $email_data["status"] == 'paused' ) ) ? 'disabled' : '';
                            $custom_link_status = ( !empty( $use_custom_link ) ) ? '' : 'disabled';
                            $personal_token     = ( !empty( $email_data["custom_personal_token"] ) || empty( $email_data ) ) ? 'checked' : '';
                            $article_token      = ( !empty( $email_data["custom_article_token"] ) ) ? 'checked' : '';

                            $article_id         = !empty( $email['article'] ) ? $email['article'] : 0;
                            $article_title      = !empty( $article_id ) ? get_the_title( $article_id ) : '';

                            $article_link = '';
                            /** Section for campaign's article */
                            if ( !empty( $article_id ) ) {
                                $user_published_articles = get_user_meta($user->ID, 'published_articles', true);
                                $related                 = get_post_meta( $article_id, 'related_edited_article', true );
                                $related_user_id  = $related[$user->ID];

                                $articles_obj     = new \Dkng\Wp\ArticlesActions();
                                $get_related_post = !empty( $related_user_id ) ? $articles_obj->get_related_article_from_site2( $related_user_id ) : array();

                                $related_post_link  = ( !empty( $related_user_id ) && !empty( $get_related_post['link'] ) ) ? $get_related_post['link'] : "";
                                $related_post_title = ( !empty( $related_user_id ) && !empty( $get_related_post['title'] ) ) ? $get_related_post['title'] : "";

                                $link1         = ( !empty( $related_user_id ) ) ? $related_post_link : '';
                                $related_id    = ( !empty( $related_user_id ) && !empty( $related_post_title ) ) ? $related_user_id : 0;
                                $related_title = ( !empty( $related_user_id ) ) ? $related_post_title : '';

                                // $link  = ( array_key_exists( $id , $user_published_articles ) ) ? get_the_permalink() : '';
                                $article_link  = ( is_array( $user_published_articles ) && array_key_exists( $article_id, $user_published_articles ) ) ? $link1 : '';
                                $checked       = ( is_array( $user_published_articles ) && !empty( $link ) && array_key_exists( $article_id, $user_published_articles ) ) ? 'checked' : '';
                            }

                            $email_item_subject  = ( !empty( $email_data['email_subject_new'] ) ) ? $email_data['email_subject_new'] : $email_data['email_subject'];
                            $email_item_subject  = ( !empty( $email_item_subject ) ) ? stripslashes( $email_item_subject ) : $email['email_subject'];

                            $email_sending_time = ( $email_data["sending_time"] == '0000-00-00 00:00:00' ) ? '' : $email_data["sending_time"];
                            $email_sending_time = ( $email_data['status'] == 'canceled' ) ? 'canceled' : $email_sending_time;

                            if ( !empty( $email_item_subject ) ) {   ?>
                                <tr data-scheduling-email-id="<?php echo $email_data['id'];?>" data-scheduling-email-status="<?php echo $email_data['status'];?>"
                                    class="<?php echo $class;?>"  data-counter="<?php echo $i;?>" data-articleid="<?php echo $article_id;?>"
                                    data-article_title="<?php echo $article_title;?>" data-article_link = "<?php echo $article_link;?>"
                                    data-user="<?php echo $user->ID; ?>" data-shared-post="<?php echo $related_id; ?>"
                                >
                                    <td class="sv-email-campaign__subject" data-th="<?php echo __( 'Email Subject', 'dkng'); ?>" data-subject="<?php echo $email_item_subject;?>">
                                        <div><?php echo $email_item_subject;?></div>
                                    </td>
                                    <td class="sv-email-campaign__body" data-th="<?php echo __( 'Email Body', 'dkng'); ?>">
                                        <div>
                                            <!-- <button type="button" class=" sv-edit-field  js-custom-link --><?php //echo ' ' . $custom_link_class ?><!--" data-status="--><?php //echo $custom_link_status ?><!--"></button>-->
                                            <?php echo $str_text;?>
                                        </div>
                                    </td>
                                    <td class="sv-email-campaign__date" data-th="<?php echo __( 'Sending date', 'dkng'); ?>">
                                        <?php if ( $email_data["status"] == 'draft' ) {
                                            $status_label = __( 'Draft', 'dkng' );?>
                                            <div class="position-relative" data-prev-text="<?php echo $status_label;?> - ">
                                                <?php if ( $email_data["sending_time"] != '0000-00-00 00:00:00' ) { ?>
                                                    <button type="button" class="js-sending-date-edit sv-edit-field"></button>
                                                    <?php echo  $sending_data; ?>
                                                <?php } else { ?>
                                                    <?php echo $status_label . ': ' . $sending_data; ?>
                                                <?php } ?>
                                            </div>
                                        <?php } elseif ( $email_data["status"] == 'inprogress' )  {
                                            $status_label =  __( 'Active', 'dkng' );?>
                                            <div class="position-relative" data-prev-text="<?php echo $status_label;?> - ">
                                                <?php echo $sending_data;?>
                                                <button type="button" class="js-sending-date-edit sv-edit-field"></button>
                                            </div>
                                        <?php } elseif ( ( $email_data["status"] == 'paused' ) || ( $email_data["status"] == 'stopped' ) )  {
                                            $status_label     = ucfirst( $email_data["status"] );
                                            $send_data_format = date('m-d-Y h:ia', strtotime( $email_data["sending_time"] ) );
                                        ?>
                                            <div class="position-relative" data-prev-text="<?php echo $status_label;?> - ">
                                                <?php echo $status_label . ' - ' .  $sending_data_format;?>
                                            </div>
                                        <?php } else { ?>
                                            <div><?php echo $sending_data;?></div>
                                        <?php } ?>

                                        <input type="hidden" name="date<?php echo $i;?>" class="js-sending-date" value="<?php echo $email_sending_time;?>">
                                        <input type="hidden" name="type<?php echo $i;?>" value="create">
                                        <?php if ( !empty( $check ) || !empty( $check_draft ) || ( $i < 2 ) ) { ?>
                                            <input type="hidden" name="edited_id<?php echo $i;?>" value="<?php echo $email_data['id'];?>">
                                        <?php } ?>
                                        <?php if ( !empty( $check_draft ) ) { ?>
                                            <input type="hidden" name="was_draft" value="was_draft" id="was_draft">
                                        <?php } ?>

                                    </td>
                                    <td class="sv-email-campaign__view-button">
                                        <button
                                            type="button"
                                            class="sv-button js-view-email"
                                            data-title="<?php echo $email_item_subject;?>"
                                            data-copy="<?php echo $original_email_body; ?>"
                                            data-edited-content="<?php echo esc_attr( $email_body );?>"
                                            data-fullname="<?php echo esc_attr( $full_name ); ?>"
                                            data-userimg="<?php echo esc_attr( $fileurl ); ?>"
                                            data-email="<?php echo esc_attr( $user_email ); ?>"
                                            data-phone="<?php echo esc_attr( $user_phone ); ?>"
                                            data-website="<?php echo esc_attr( $user_website ); ?>"
                                            data-address="<?php echo esc_attr( $user_address ); ?>"
                                            data-company="<?php echo esc_attr( $user_company ); ?>"
                                            data-position="<?php echo esc_attr( $user_position ); ?>"
                                            data-disclosure=""
                                        >
                                            <?php echo __( "View Email", "dkng" );?>
                                        </button>
                                    </td>
                                    <td class="sv-email-campaign__schedule-button">
                                        <?php if( $email_data["status"] == 'sent') : ?>
                                            <button type="button" class="sv-button sv-button--blue-text js-campaign-button" disabled><?php echo __( "Scheduled", "dkng" );?></button>
                                        <?php elseif( ( $email_data["status"] == 'inprogress' ) ||  ( $email_data["status"] == 'paused' ) ||  ( $email_data["status"] == 'stopped' ) ): ?>
                                            <button type="button" class="sv-button sv-button--blue-text js-campaign-button selected disabled" ><?php echo __( "Scheduled", "dkng" );?></button>
                                        <?php elseif( ( $email_data["status"] == 'draft' ) && ( !empty( $email_data["sending_time"] ) && ( $email_data["sending_time"] != '0000-00-00 00:00:00' ) ) ): ?>
                                            <button type="button" class="sv-button sv-button--blue-text js-campaign-button selected disabled" ><?php echo __( "Scheduled", "dkng" );?></button>
                                        <?php elseif( $email_data["status"] == 'canceled' ): ?>
                                            <button type="button" class="sv-button sv-button--blue-text js-campaign-button js-datePicker" disabled><?php echo __( "Scheduled", "dkng" );?></button>
                                        <?php else: ?>
                                            <button type="button" class="sv-button sv-button--blue-text js-campaign-button js-datePicker"><?php echo __( "Schedule", "dkng" );?></button>
                                        <?php endif; ?>
                                    </td>
                                    <td class="sv-email-campaign__custom-link">
                                        <div class="sv-custom-link js-custom-link <?php echo ' ' . $custom_link_class ?>" data-status="<?php echo $custom_link_status ?>">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <input type="hidden"
                                               class="custom_link_input"
                                               placeholder="<?php echo __( "Custom link", "dkng" );?>"
                                               name="custom_link<?php echo $i;?>"
                                               value="<?php echo $email_data['custom_link'];?>"
                                            <?php echo $custom_link_class;?>
                                        >
                                        <input type="hidden"
                                               class="email_subject_input"
                                               placeholder="<?php echo __( "Email Subject", "dkng" );?>"
                                               name="email_subject<?php echo $i;?>"
                                               value="<?php echo $email_item_subject;?>"
                                            <?php echo $custom_link_class;?>
                                        >
                                        <input type="hidden"
                                               class="custom_personal_token_input"
                                               placeholder="<?php echo __( "Custom personal token", "dkng" );?>"
                                               name="custom_personal_token<?php echo $i;?>"
                                               value="<?php echo $personal_token;?>"
                                            <?php echo $custom_link_class;?>
                                        >
                                        <input type="hidden"
                                               class="custom_article_token_input"
                                               placeholder="<?php echo __( "Article on/off input", "dkng" );?>"
                                               name="custom_article_token<?php echo $i;?>"
                                               value="<?php echo $article_token;?>"
                                        >
                                        <input type="hidden"
                                               class="custom_edited_content"
                                               placeholder="<?php echo __( "Edited Content", "dkng" );?>"
                                               name="custom_edited_content<?php echo $i;?>"
                                               value="<?php echo esc_attr( $email_body );?>"
                                        >
                                    </td>
                                    <td class="sv-email-campaign__cancel">
                                        <?php if ( $email_data["status"] == 'sent' ) : ?>
                                            <button type="button" class="sv-close-button js-cancel-email <?php echo $email_data["status"];?>" disabled></button>
                                        <?php else: ?>
                                            <button type="button" class="sv-close-button js-cancel-email <?php echo $email_data["status"];?>" data-id="<?php echo $email_data['id'];?>"></button>
                                            <?php  if ( $email_data["status"] == 'canceled' ) { ?>
                                                <button type="button" class="sv-close-button js-turnon-email <?php echo $email_data["status"];?>"></button>
                                            <?php } ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php  }
                        }
                    } ?>
                    </tbody>
                </table>
                <div class="sv-row">
                    <div class="sv-email-campaign__submit">
                        <div class="sv-hr"></div>
                        <?php  if ( !empty( $check ) || !empty( $check_draft ) ) { ?>
                            <p class="was_edited_or_draft" style="display: none;"></p> <!-- needed for download edited content logic! -->
                        <?php } ?>
                        <?php $stop_class = ( empty( $check ) || ( strtolower( $status ) == 'stopped' ) || ( strtolower($status) == 'completed' ) ) ? 'disabled' : 'active'; ?>
                        <?php $save_class = ( ( ( strtolower( $status ) == 'stopped' ) || ( strtolower($status) == 'completed' ) || ( strtolower($status) == 'paused' ) ) ) ? 'disabled1' : '';
                        ?>
                        <?php if ( strtolower($status) == 'paused' ) { ?>
                            <button class="sv-button sv-button--green sv-button--small-padding js_restore_campaign active" type="button"
                                 data-id="<?php echo $post_id;?>">
                                <?php echo __( "Restore", "dkng" );?>
                            </button>
                        <?php } else { ?>
                            <button class="sv-button sv-button--green sv-button--small-padding js_pause_campaign <?php echo $stop_class;?>" type="button"
                                    data-id="<?php echo $post_id;?>">
                                <?php echo __( "Pause", "dkng" );?>
                            </button>
                        <?php  } ?>
                        <button class="sv-button sv-button--green sv-button--small-padding js_stop_campaign <?php echo $stop_class;?>" type="button"
                                data-id="<?php echo $post_id;?>" >
                            <?php echo __( "Stop", "dkng" );?>
                        </button>
                        <?php if ( empty( $check ) ) { ?>
                            <button class="sv-button sv-button--green sv-button--small-padding js-draft-submit-campaign" type="button" >
                                <?php echo __( "Save as Draft", "dkng" );?>
                            </button>
                        <?php } ?>
                        <button class="sv-button sv-button--green sv-button--small-padding js-submit-campaign <?php echo $save_class;?>" type="submit" disabled>
                            <?php
                            if ( !empty( $check ) ) {
                                echo __( "Save", "dkng" );
                            }
                            else {
                                echo __( "Start", "dkng" );
                            }
                            ?>
                        </button>
                        <img src="./dist/img/loader.gif" id="loader" alt="loader"/>
                    </div>
                    <?php
                    $campaigns_link_title  = get_field( 'campaigns_link_title', 'option' );
                    $campaigns_popup_body  = get_field( 'campaigns_popup_body', 'option' );
                    ?>
                    <?php if(!empty($campaigns_link_title)):?>
                        <a href="#" class="js-link-popup-new"><?php echo $campaigns_link_title;?></a>
                    <?php endif;?>
                    <div class="sv-link-popup sv-link-popup-new">
                        <div class="sv-link-popup__header">
                            <h5><?php echo __( 'Items to Check Before Sending a Campaign', 'dkng');?></h5>
                            <span class="sv-link-popup__close sv-link-popup__close-new">
                                <i class="fa fa-times"></i>
                            </span>
                        </div>
                        <?php if(!empty($campaigns_popup_body)):?>
                            <div class="sv-link-popup__body  ">
                                <?php echo wp_kses_post($campaigns_popup_body);?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>