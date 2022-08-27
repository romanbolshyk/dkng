<?php
get_header('custom');

$object    = new \Dkng\Wp\Ogoloshennya();
$count     = $object->count;
$paged     = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$announces_type = ( isset( $_GET['old'] ) ) ? true : false;
$announces = $object->get_ogoloshennya( $announces_type, $paged, 3 );

$max_num    = ceil( $announces->found_posts / $count );
$announces  = $announces->posts;

$announces_type_txt = !empty( $announces_type ) ? "Не Актуальні" : "Актуальні";
?>

	<div class="inner_container  page-template-announces announces_block-banner-wrap">
		<div class="container">

            <!-- Bread Crumbs -->
            <div class="row bread_menu">
                <?php custom_breadcrumbs( );  ?>
            </div>
            <!-- Bread Crumbs -->

            <div class="row">
			    <div class="announces_block-banner" >
				<div class="announces_block-banner-center">
					<h2 class="aligncenter"><?php  echo "Оголошення"; ?></h2>
                    <h4>
                        <a href="<?php echo get_permalink( get_the_ID() );?>" style="padding: 10px;">
                            <?php  echo "Актуальні оголошення"; ?>
                        </a>

                        <a href="<?php echo get_permalink( get_the_ID() ) . "?old";?>" style="padding: 10px;">
                            <?php  echo "Історія оголошень( Не актуальні )"; ?>
                        </a>
                    </h4>

                </div>
			</div>
            </div>
		</div>

        <?php if ( !empty( $announces ) ) { ?>
            <div class="container announces_block-list" style="margin-top: 30px;">

                <div class="block">
                    <h3 class="aligncenter"><?php echo "Список оголошень: $announces_type_txt"; ?></h3>

                    <?php foreach ( $announces as $announce ) {
                        $excerpt = get_the_excerpt( $announce );
                        ?>
                        <div class="announces_block-item" data-num="1">
                        <div class="announces_block-item-image">
                            <img src="./dist/img/ogoloshennya.jpeg" alt="announces image" style="height: 100%">
                        </div>
                        <div class="announces_block-item-text">
                            <div class="announces_block-item-top-text">
                                <?php echo get_the_date( 'Y-m-d', $announce );?>
                            </div>
                            <h4 class="announces_block-item-title">
                                <?php if ( empty( $announces_type ) ) { ?>
                                    <a href="<?php echo get_permalink( $announce )?>">
                                        <?php echo get_the_title( $announce );?>
                                    </a>
                                <?php } else { ?>
                                    <?php echo get_the_title( $announce );?>
                                <?php } ?>
                            </h4>

                            <div class="announces_block-item-desc">
                                <p><?php echo $excerpt;?></p>
                            </div>

                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="custom_pagination">
                    <?php
                    $var = is_page() ? 'page' : 'paged';
                    $big = 999999999;

                    echo paginate_links( array(
                        'base'     => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'paged'    => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
                        'current'  => max( 1, get_query_var( 'paged' ) ),
                        'format'   => '?paged=%#%',
                        'total'    => $max_num
                    ) );
                    ?>
                </div>

            </div>
        <?php  } ?>
	</div>

<?php
get_footer('custom');
wp_footer();