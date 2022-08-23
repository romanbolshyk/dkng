<?php

get_header('custom');

$object1    = new \Dkng\Wp\Novyny();
$novyny     = $object1->get_news( -1 );

$i = 0;
?>
<div class="container template">
    <div class="sv-filter">
        <div class="sv-filter__top">
            <h3 class="sv-filter__title">
                <?php echo __( "Архів Новин", "dkng" ); ?>
            </h3>
            <p class="sv-filter__description">
                <?php echo __( "Можете фільтрувати їх тут.", "dkng" ); ?>
            </p>
        </div>

        <form action="#" method="post" class="sv-filter__form" id="js_svTplFilter">

            <input type="hidden" name="action" value="svnGetTemplates" />
            <input type="hidden" name="page" value="1" />

            <div class="sv-filter__item">
                <label for="sv-filter-topic" class="sv-tooltip-container">
                    <?php echo __( "Фільтр 1", "dkng" ); ?>
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

            <div class="sv-filter__item">
                <label for="sv-filter-type" class="sv-tooltip-container">
                    <?php echo __( "Фільтр 2", "dkng" ); ?>
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
        </form>
    </div>

    <div class="row">
        <div class="col-12">

            <?php if ( !empty( $novyny ) ) { ?>
                <div class="template-items ">
                    <?php foreach ( $novyny as $novyna ) {
                        $i++; ?>

                        <div class="item">

                            <div class="item-image ">
                                <img src="<?php echo get_the_post_thumbnail_url( $novyna ); ?>" alt="image">
                            </div>

                            <div class="item-content">
                                <span class="item-topic">
                                    Новина № <?php echo $i;?>
                                </span>

                                <h4 class="item-title">
                                    <?php echo get_the_title( $novyna ); ?>
                                </h4>

                                <p class="item-topic">
                                   <?php echo get_the_excerpt( $novyna );?>
                                </p>

                                <div class="item-btn-wrap">
                                    <a href="<?php echo get_permalink( $novyna );?>" class="btn btn-view">
                                        <?php _e( 'Дивитись', 'dkng' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            <?php } ?>

        </div>
    </div>

</div>

<?php get_footer('custom'); ?>
