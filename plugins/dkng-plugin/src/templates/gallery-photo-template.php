<?php
get_header('custom');

$object    = new \Dkng\Wp\Ogoloshennya();
$count     = $object->count;
$announces_type = ( isset( $_GET['old'] ) ) ? true : false;
$announces = $object->get_announces( $announces_type );

?>

	<div class="inner_container announces_block-banner-wrap">
		<div class="container">
			<div class="announces_block-banner"
				 style="background-image: url(<?php if ( $banner['background'] ) echo $banner['background']; ?>)">
				<div class="announces_block-banner-center">
					<h1><?php  echo "Оголошення"; ?></h1>
                    <h4><?php  echo "Список оголошень."; ?></h4>
                    <h4>
                        <a href="<?php echo get_site_url() . $_SERVER['REQUEST_URI'] . "?old";?>">
                        <?php  echo "Історія оголошень."; ?>
                    </h4>
                </div>
			</div>
		</div>
	</div>


<?php if ( !empty( $announces ) ) { ?>
	<div class="announces_block-list">

        <div class="container">
            <h2><?php echo "Список оголошень."; ?></h2>

            <?php foreach ( $announces as $announce ) {
                $excerpt = get_the_excerpt( $announce );
                ?>
                <div class="announces_block-item" data-num="1">
                <div class="announces_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="announces image">
                </div>
                <div class="announces_block-item-text">
                    <div class="announces_block-item-top-text">
                        <?php echo get_the_date( 'Y-m-d', $announce );?>
                    </div>
                    <h4 class="announces_block-item-title">
                        <?php if ( !empty( $announces_type ) ) { ?>
                            <a href="<?php echo get_permalink( $announce )?>">
                                <?php echo get_the_title( $announce );?>
                            </a>
                        <?php }  else { ?>
                            <?php echo get_the_title( $announce );?>
                        <?php } ?>
                    </h4>

                    <div class="announces_block-item-desc">
                        <p><?php echo $excerpt;?></p>
                    </div>

                </div>
            </div>
            <?php } ?>

            <!--
            <div class="announces_block-item" data-num="2">
                <div class="announces_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="announces image">
                </div>
                <div class="announces_block-item-text">
                    <div class="announces_block-item-top-text">
                        Wed Aug 03 2022 | Episode 108 | Advisor I/O, A CION Investments Company
                    </div>
                    <h4 class="announces_block-item-title">
                        exp2: Shifting From Busy to Productive: A Conversation with SEI's Shauna Mace
                    </h4>

                    <div class="announces_block-item-desc">
                        <p>In this episode, we sit down with SEI's Head of Practice Management, Shauna Mace. We get into her experience in working with advisors on how to go from busy to productive. We also dive into the launch of SEI's Growth Lab - a place where advisors can find resources and tools to help them build their practice.&nbsp;</p> <p>Learn more: <a href="https://info.seic.com/welcome-to-the-sei-growth-lab">https://info.seic.com/welcome-to-the-sei-growth-lab</a></p> <p>Learn more about us: advisorio.co</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_12.mp3?dest-id=1706015" id="track"></audio>
                    <div class="player-container">
                        <div class="box">
                            <div class="next-prev">
                                <i title="Back 30 seconds" id="back30"></i>
                                <div class="play-pause">
                                    <i id="play"></i>
                                    <i id="pause"></i>
                                </div>
                                <i title="Forward 30 seconds" id="forward30"></i>
                            </div>
                            <div class="progress-bar">
                                <input type="range" id="progressBar" min="0" max="1670.903667" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">27:50</div>
                            </div>
                            <div class="volume-container">
                                <div class="volume-button">
                                    <div class="volume icono-volumeMedium"></div>
                                </div>
                                <div class="volume-slider">
                                    <span class="slide" style="width: 100%;"><span class="slide-icon"></span></span>
                                    <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
                                </div>
                            </div>
                            <div class="audio-buttons">
                                <div class="audio-buttons-share">
                                    <div class="audio-buttons-share-container">
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_12.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_12.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_12.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_12.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_12.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="announces_block-item" data-num="3">
                <div class="announces_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="announces image">
                </div>
                <div class="announces_block-item-text">
                    <div class="announces_block-item-top-text">
                        Wed Jul 20 2022 | Episode 107 | Seven Group
                    </div>
                    <h4 class="announces_block-item-title">
                        Aligning Your Practice &amp; Life: How to Work and Live With Purpose
                    </h4>

                    <div class="announces_block-item-desc">
                        <p>No matter where you are in your practice life cycle, setting goals and objectives is a major part of your practice. In this episode, we welcome Matt Spielman, Chief Performance Officer and Head Coach of Inflection Point Partners, an organizational, career, and executive coaching firm. Matt has coached folks like Alex Rodriguez to optimize their lives throughout the years.&nbsp;</p> <p>Find out more about Matt: https://www.theinflectionpointsbook.com/</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_11.mp3?dest-id=1706015" id="track"></audio>
                    <div class="player-container">
                        <div class="box">
                            <div class="next-prev">
                                <i title="Back 30 seconds" id="back30"></i>
                                <div class="play-pause">
                                    <i id="play"></i>
                                    <i id="pause"></i>
                                </div>
                                <i title="Forward 30 seconds" id="forward30"></i>
                            </div>
                            <div class="progress-bar">
                                <input type="range" id="progressBar" min="0" max="1841.879917" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">30:41</div>
                            </div>
                            <div class="volume-container">
                                <div class="volume-button">
                                    <div class="volume icono-volumeMedium"></div>
                                </div>
                                <div class="volume-slider">
                                    <span class="slide" style="width: 100%;"><span class="slide-icon"></span></span>
                                    <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
                                </div>
                            </div>
                            <div class="audio-buttons">
                                <div class="audio-buttons-share">
                                    <div class="audio-buttons-share-container">
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_11.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_11.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_11.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_11.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_11.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="announces_block-item" data-num="4">
                <div class="announces_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="announces image">
                </div>
                <div class="announces_block-item-text">
                    <div class="announces_block-item-top-text">
                        Thu Jul 14 2022 | Episode 106 | Seven Group
                    </div>
                    <h4 class="announces_block-item-title">
                        The Power of Workflows and Systems: A Conversation with Kate Guillen
                    </h4>

                    <div class="announces_block-item-desc">
                        <p>Operations and optimizing your CRM is something near and dear to every advisors heart and in this episode, we welcome Kate Guillen – founder of Simplicity Ops, a firm that helps advisors fix and optimize their CRM, we get into how to clean up your CRM data and begin to extra true value for your business and the pivots you should make going forward. We cover the exact blueprint to help you do this.&nbsp;</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_10.mp3?dest-id=1706015" id="track"></audio>
                    <div class="player-container">
                        <div class="box">
                            <div class="next-prev">
                                <i title="Back 30 seconds" id="back30"></i>
                                <div class="play-pause">
                                    <i id="play"></i>
                                    <i id="pause"></i>
                                </div>
                                <i title="Forward 30 seconds" id="forward30"></i>
                            </div>
                            <div class="progress-bar">
                                <input type="range" id="progressBar" min="0" max="1881.73525" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">31:21</div>
                            </div>
                            <div class="volume-container">
                                <div class="volume-button">
                                    <div class="volume icono-volumeMedium"></div>
                                </div>
                                <div class="volume-slider">
                                    <span class="slide" style="width: 100%;"><span class="slide-icon"></span></span>
                                    <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
                                </div>
                            </div>
                            <div class="audio-buttons">
                                <div class="audio-buttons-share">
                                    <div class="audio-buttons-share-container">
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_10.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_10.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_10.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_10.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_10.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="announces_block-item" data-num="5">
                <div class="announces_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="announces image">
                </div>
                <div class="announces_block-item-text">
                    <div class="announces_block-item-top-text">
                        Wed Jul 06 2022 | Episode 105 | Seven Group
                    </div>
                    <h4 class="announces_block-item-title">
                        Voice, Video, and the Future of Marketing Media
                    </h4>

                    <div class="announces_block-item-desc">
                        <p>This episode is from a recent panel we did at Snappy Kraken’s Jolt conference with some others in the space, including Taylor Schulte, Matt Halloran, Emily Binder, and David Armstrong. We dove into voice and video marketing – including the ins and outs of how to get started, what you need to produce, and why your early data won’t tell you the full picture.&nbsp;</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_9.mp3?dest-id=1706015" id="track"></audio>
                    <div class="player-container">
                        <div class="box">
                            <div class="next-prev">
                                <i title="Back 30 seconds" id="back30"></i>
                                <div class="play-pause">
                                    <i id="play"></i>
                                    <i id="pause"></i>
                                </div>
                                <i title="Forward 30 seconds" id="forward30"></i>
                            </div>
                            <div class="progress-bar">
                                <input type="range" id="progressBar" min="0" max="2941.735833" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">49:01</div>
                            </div>
                            <div class="volume-container">
                                <div class="volume-button">
                                    <div class="volume icono-volumeMedium"></div>
                                </div>
                                <div class="volume-slider">
                                    <span class="slide" style="width: 100%;"><span class="slide-icon"></span></span>
                                    <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
                                </div>
                            </div>
                            <div class="audio-buttons">
                                <div class="audio-buttons-share">
                                    <div class="audio-buttons-share-container">
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_9.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_9.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_9.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_9.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_9.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </div>


        <?php $type = ( !empty( $announces_type ) ) ? 0 : 1; ?>
        <?php if ( count( $announces ) > $count  ) { ?>
            <a href="#" class="announces_loadmore announced_loadmore" data-type="<?php echo $type;?>" data-page="1">
                Загрузити більше оголошень
                <img src="./dist/img/loader.gif" alt="loader_more"  id="loader_more" />
            </a>
        <?php } ?>

	</div>
<?php  } ?>


<?php
get_footer('custom');
wp_footer();