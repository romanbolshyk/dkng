<div class="all_campaigns_block" data-all="<?php echo $count_all;?>" data-getcat="all" data-cpt="campaigns" >
    <div class="row">
        <div class="col-12">
            <div class="buttons-line d-flex flex-column flex-md-row justify-content-end align-items-start">
                <a href="<?php echo get_site_url() . '/admin-campaigns/?page=unsubscribers'?>" class="sv-button sv-button--nav"><?php echo __( "Unsubscribers List", "dkng" );?></a>
                <a href="<?php echo get_site_url() . '/admin-campaigns/?page=all_leads'?>" class="sv-button sv-button--nav"><?php echo __( "View Lists", "dkng" );?></a>
                <a href="<?php echo get_site_url() . '/admin-campaigns/?page=all_reports';?>" class="sv-button sv-button--nav"><?php echo __( "View Campaigns Reports", "dkng" );?></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="sv-section">
                <h2 class="sv-title"><?php echo __( "All Campaigns", "dkng" );?></h2>
                <div class="tabs buttons-line d-flex flex-column flex-md-row justify-content-center align-items-start" >
                    <a class="tab tab1 sv-button sv-button--nav <?php if ( $campaigns_btn_class != 'cloned' ) echo 'active';?>" href="<?php echo get_site_url() . '/admin-campaigns/?new=1'?>"><?php echo __( "New Campaigns", "dkng" );?> </a>
                    <a class="tab tab2 sv-button sv-button--nav <?php if ( $campaigns_btn_class == 'cloned' ) echo 'active';?>" href="<?php echo get_site_url() . '/admin-campaigns/?cloned=1"'?>"><?php echo __( "Cloned Campaigns", "dkng" );?> </a>
                </div>

                <div class="columns-grid">
                    <?php if ( !empty( $all_campaigns ) ) {
                        $i = 0;
                        foreach ( $all_campaigns as $campaign ) {
                            $i++;
                            $title      = get_the_title( $campaign );
                            $link       = get_permalink( $campaign );
                            $start_date = get_field( 'start_date_email', $campaign );
                            $thumbnail  = get_the_post_thumbnail_url( $campaign );

                            $post_terms = wp_get_object_terms( $campaign, 'campaigns-category', array('fields' => 'slugs') );

                            $status_background = $campaigns_obj->get_status_and_background( $user_campaigns, $campaign );
                            $ribbon_background = $status_background['ribbon_background'];
                            $status            = $status_background['status'];

                            $index = $i;
                            $plugin_path = plugin_dir_path(__DIR__);
                            require $plugin_path . '/ajax-items/campaign_item.php';
                            ?>

                        <?php } ?>
                        <img src="./dist/img/loader.gif" id="loader_campaign" alt="loader" style=" display: none; position: absolute; left: 50%; top: 50%;"/>
                    <?php } else { ?>
                        <h4><?php echo __( "There are no campaigns", "dkng" );?>.</h4>
                    <?php }  ?>
                </div>
            </div>

            <?php if ( $count_all > $count_per_page ) { ?>
                <div class="sv-load-more-space">
                    <a href="#" id="load_more_campaigns" class="<?php echo $campaigns_btn_class;?> sv-button--border"><?php echo __( "See More", "dkng" );?></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>