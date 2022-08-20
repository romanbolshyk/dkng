<?php
$content      = apply_filters( 'the_content', $post->post_content );
/*
$half_length  = strlen($content) / 2;
$half_content = substr( $content, 0, $half_length );
$half_content = empty( $half_content ) ? $half_content : $half_content . " ...";
*/

$half_content = Dkng\Wp\Functions::trunc_text_by_words( $content, 150 );
$half_content = empty( $half_content ) ? $half_content : $half_content . " ...";
?>

<div class="col-12 col-lg-12">
    <div class="investment-holder article_content_block">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="sv-content__block">
                    <h4 class="type-title type-title--no-margin title-icon title-icon--<?php echo $article_type; ?>">
                        <?php echo ucfirst( $article_type ); ?>
                    </h4>
                </div>
            </div>

            <?php if ( $article_type != 'article' ) {
                $title = '';
                if ( $article_type == 'email' ) {
                    $title = __("Subject line", "dkng");
                } elseif ( $article_type == 'video' ) {
                    $title = __("Video Title   ", "dkng");
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
                            <?php if ( !empty( get_the_post_thumbnail_url( $id ) ) ) { ?>
                                <div class="inv-img"
                                     style="background-image: url(<?php echo the_post_thumbnail_url( $id ); ?>); margin-bottom: 20px;"></div>
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
<!--                            --><?php //echo $content; ?>
                            <?php echo $half_content; ?>
                        <?php } ?>
                    </div>
					<div class="acces_popup">
						<?php if ( !empty   (get_field('not_login_title', 'options')) ): ?>
							<h3><?php echo esc_html(get_field('not_login_title', 'options'));?></h3>
						<?php endif; ?>
						<?php if ( !empty   (get_field('not_login_description', 'options')) ): ?>
							<?php echo wp_kses_post(get_field('not_login_description', 'options'));?>
						<?php endif; ?>
						<div class="planbox">
							<div class="flexrow">
								<div>
									<?php if ( !empty   (get_field('not_login_box_title', 'options')) ): ?>
										<div class="headline"><?php echo esc_html(get_field('not_login_box_title', 'options'));?></div>
									<?php endif; ?>
									<div class="belowheadline">
										<?php if ( !empty   (get_field('not_login_price', 'options')) ): ?>
											<span class="price"><?php echo esc_html(get_field('not_login_price', 'options'));?></span>
										<?php endif; ?>
										<?php if ( !empty   (get_field('not_login_price_label', 'options')) ): ?>
											<span class="pricedetail"><?php echo esc_html(get_field('not_login_price_label', 'options'));?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="btn-wrap">
									<?php if (!empty   (get_field('not_login_button', 'options'))): ?>
									<a href="<?php echo get_field('not_login_button', 'options')['url']; ?>" class="btn"><?php echo get_field('not_login_button', 'options')['title']; ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php if ( !empty   (get_field('already_a_member_text', 'options')) ): ?>
							<?php echo wp_kses_post(get_field('already_a_member_text', 'options'));?>
						<?php endif; ?>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
