<?php
//if ( !is_user_logged_in() ) {
//    wp_redirect( get_site_url() . '/advisorlogin', 307 );
//    exit;
//}
get_header();

$tpl = new Dkng\Wp\Templates();

$asset_types = $tpl->get_asset_types();
$tpl_topics  = $tpl->get_topics();
$filters     = $tpl->filters;

$q = $tpl->get_post_query();
?>
<div class="container template">
    <div class="sv-filter">
        <div class="sv-filter__top">
            <h3 class="sv-filter__title">
                <?php echo __( "Templates for Download", "dkng" ); ?>
            </h3>
            <p class="sv-filter__description">
                <?php echo __( "Whether you need an outreach template for a client, social media graphic, or client presentation, here you'll find all of the downloads you'll need to conduct business development and marketing.", "dkng" ); ?>
            </p>
        </div>

        <form action="#" method="post" class="sv-filter__form" id="js_svTplFilter">

            <input type="hidden" name="action" value="svnGetTemplates" />
            <input type="hidden" name="page" value="1" />

            <?php if ( !empty( $tpl_topics ) ) { ?>
                <div class="sv-filter__item">
                    <label for="sv-filter-topic" class="sv-tooltip-container">
                        <?php echo __( "Topic", "dkng" ); ?>
                    </label>
                    <span class="select-wrapper">
                        <select name="topic" id="sv-filter-topic">
                            <option value="0">
                                <?php echo __( "All", "dkng" ); ?>
                            </option>
                            <?php
                            foreach ( $tpl_topics as $topic ) {
                                $sel = $topic->term_taxonomy_id == $filters[ 'topic' ] ? 'selected' : '';
                                ?>
                                <option value="<?php echo $topic->term_taxonomy_id; ?>" <?php echo $sel; ?>>
                                    <?php echo $topic->name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </span>
                </div>
            <?php } ?>
            <?php if ( !empty( $asset_types ) ) { ?>
                <div class="sv-filter__item">
                    <label for="sv-filter-type" class="sv-tooltip-container">
                        <?php echo __( "Type of Asset", "dkng" ); ?>
                    </label>
                    <span class="select-wrapper">
                        <select name="tpasst" id="sv-filter-type">
                            <option value="0">
                                <?php echo __( "All", "dkng" ); ?>
                            </option>
                            <?php
                            foreach ( $asset_types as $tp_k => $tp_lbl ) {
                                $sel = $tp_k == $filters[ 'tpasst' ] ? 'selected' : '';
                                ?>
                                <option value="<?php echo $tp_k; ?>" <?php echo $sel; ?>>
                                    <?php echo $tp_lbl; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </span>
                </div>
            <?php } ?>

        </form>
    </div>

    <div class="row">
        <div class="col-12">

            <?php if ( $q->have_posts() ) { ?>
                <div class="template-items htmlAjaxFrame">
                    <?php
                    while ( $q->have_posts() ){
                        $q->the_post();
                        include( SVN_PLUGIN_TPLS . 'template-parts/cpt-templates/template-item.php' );
                    } ?>
                </div>
            <?php } ?>

            <div class="buttonAjaxFrame">
                <?php echo $tpl->get_loadmore_button( $q ); ?>
            </div>

            <div class="template-modal">
            <div class="template-modal-close-wrap">
                <span class="template-modal-close"></span>
			</div>
                <div class="template-modal-container">

                </div>
            </div>

        </div>
    </div>

</div>

<?php get_footer(); ?>
