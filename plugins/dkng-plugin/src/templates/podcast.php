<?php
get_header('custom');

$banner  = get_field('banner');
$podcast = get_field('podcast');

?>
	</div>
	<div class="inner_container podcast_block-banner-wrap">
		<div class="container">
			<div class="podcast_block-banner"
				 style="background-image: url(<?php if ( $banner['background'] ) echo $banner['background']; ?>)">
				<div class="podcast_block-banner-left">
					<?php if ( $banner['left_image'] ) echo '<img src="' . $banner['left_image'] . '" class="podcast_block-banner-left-image" alt="left image" >'; ?>
				</div>
				<div class="podcast_block-banner-center">
					<h4><?php if ( $banner['text'] ) echo $banner['text']; ?></h4>
					<h1><?php if ( $banner['title'] ) echo $banner['title']; ?></h1>
				</div>
				<div class="podcast_block-banner-right">
					<div class="podcast_block-banner-right-text">
						<div class="podcast_block-banner-right-text1"><?php if ( $banner['text_right1'] ) echo $banner['text_right1']; ?></div>
						<div class="podcast_block-banner-right-text2"><?php if ( $banner['text_right2'] ) echo $banner['text_right2']; ?></div>
						<div class="podcast_block-banner-right-text3"><?php if ( $banner['text_right3'] ) echo $banner['text_right3']; ?></div>
					</div>
					<?php if ( $banner['right_image'] ) echo '<img src="' . $banner['right_image'] . '" class="podcast_block-banner-right-image" alt="right image" >'; ?>
				</div>
			</div>
			<div class="podcast_block-banner-bottom">
				<?php if ( $banner['bottom_image1'] ) echo '<a href="'.$banner['link1'].'" target="_blank"><img src="' . $banner['bottom_image1'] . '" class="podcast_block-banner-bottom-image" alt="bottom image" ></a>'; ?>
				<?php if ( $banner['bottom_image2'] ) echo '<a href="'.$banner['link2'].'" target="_blank"><img src="' . $banner['bottom_image2'] . '" class="podcast_block-banner-bottom-image" alt="bottom image" ></a>'; ?>
			</div>
		</div>
	</div>



<?php if ( $podcast ) { ?>
	<div class="podcast_block-list">

        <div class="container">
            <h2>The Advisor Lab Episodes</h2>


            <div class="podcast_block-item" data-num="1">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Aug 10 2022 | Episode 109 | Advisor I/O, A CION Investments Company
                    </div>
                    <h4 class="podcast_block-item-title">
                        exp1: Building an Engaged Audience on Social: How Callie Cox and eToro Do It
                    </h4>

                    <div class="podcast_block-item-desc">
                        <p>In this episode, we catch up with Callie Cox, an investment analyst at eToro who has built an incredibly engaged audience on Twitter talking all things macro and the market. Everything Callie puts out pulls and engages new readers, so we wanted to get into the details of her blueprint, personality, and thought process. We also discuss her take on what's happening in the macro economy.&nbsp;</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_14.mp3?dest-id=1706015" id="track"></audio>
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
                                <input type="range" id="progressBar" min="0" max="2425.72925" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">40:25</div>
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
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_14.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_14.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_14.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_14.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_14.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="podcast_block-item" data-num="2">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Aug 03 2022 | Episode 108 | Advisor I/O, A CION Investments Company
                    </div>
                    <h4 class="podcast_block-item-title">
                        exp2: Shifting From Busy to Productive: A Conversation with SEI's Shauna Mace
                    </h4>

                    <div class="podcast_block-item-desc">
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
            <div class="podcast_block-item" data-num="3">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Jul 20 2022 | Episode 107 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        Aligning Your Practice &amp; Life: How to Work and Live With Purpose
                    </h4>

                    <div class="podcast_block-item-desc">
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
            <div class="podcast_block-item" data-num="4">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Thu Jul 14 2022 | Episode 106 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        The Power of Workflows and Systems: A Conversation with Kate Guillen
                    </h4>

                    <div class="podcast_block-item-desc">
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
            <div class="podcast_block-item" data-num="5">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Jul 06 2022 | Episode 105 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        Voice, Video, and the Future of Marketing Media
                    </h4>

                    <div class="podcast_block-item-desc">
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
            <div class="podcast_block-item" data-num="6">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Jun 29 2022 | Episode 104 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        Focusing Your Marketing Strategy to Gain More Traction
                    </h4>

                    <div class="podcast_block-item-desc">
                        <p>We’re flipping the script in today’s episode, and in this episode, it comes from a session I recently did with Marie Swift of Impact Communications on her podcast, Swift Chat. We dive into what Advisors can be doing to market towards their niche, including how to think about your audience and persona, what kind of content you should be creating, and what you should be measuring.&nbsp;</p> <p>Learn more about what we do: www.thesevengroup.com</p> <p>&nbsp;</p> <p>&nbsp;</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/Marie_Swift.mp3?dest-id=1706015" id="track"></audio>
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
                                <input type="range" id="progressBar" min="0" max="1640.069333" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">27:20</div>
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
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/Marie_Swift.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/Marie_Swift.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/Marie_Swift.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/Marie_Swift.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/Marie_Swift.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="podcast_block-item" data-num="7">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Jun 22 2022 | Episode 103 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        Marketing Actions to Take in Volatile Markets
                    </h4>

                    <div class="podcast_block-item-desc">
                        <p>In this episode, we dive into the 3-actions to take with clients when it comes to the current market environment, including what to share, how often to share, and how you can conduct meetings.&nbsp;</p> <p>Check out more on out blog: https://www.thesevengroup.com/blog/</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/Solo_8_mixdown.mp3?dest-id=1706015" id="track"></audio>
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
                                <input type="range" id="progressBar" min="0" max="561.317333" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">9:21</div>
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
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/Solo_8_mixdown.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/Solo_8_mixdown.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/Solo_8_mixdown.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/Solo_8_mixdown.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/Solo_8_mixdown.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="podcast_block-item" data-num="8">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Jun 15 2022 | Episode 102 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        Using Your Data More Effectively to Drive Client Conversion &amp; Retention
                    </h4>

                    <div class="podcast_block-item-desc">
                        <p>In this episode, we sit down with Erica Pauly - founder and owner of Track That Advisor. Erica is all about metrics and what advisors could and should be tracking from a metrics perspective. We dive into what metrics make sense to track, how to get started on your baselines, and how much time it should take to measure consistently.&nbsp;</p> <p>Learn more on: https://trackthatadvisor.com/</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_7.mp3?dest-id=1706015" id="track"></audio>
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
                                <input type="range" id="progressBar" min="0" max="1673.694583" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">27:53</div>
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
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_7.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_7.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_7.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_7.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_7.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="podcast_block-item" data-num="9">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed Jun 08 2022 | Episode 101 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        The Evolution of the Portfolio: A Conversation with Anthony Zhang of Vinovest
                    </h4>

                    <div class="podcast_block-item-desc">
                        In this episode, we sit down with Anthony Zhang, founder of Vinovest. Vinovest is changing the wine investing game by offering retail investors the ability to invest in wine more seamlessly. We dive into how he's built the business, their eudcaiotn process, and his learnings around growth.&nbsp; <p>Learn more about them at vinovest.co</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_6.mp3?dest-id=1706015" id="track"></audio>
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
                                <input type="range" id="progressBar" min="0" max="2120.267333" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">35:20</div>
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
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_6.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_6.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_6.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_6.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/cioninvestments_mixdown_6.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="podcast_block-item" data-num="10">
                <div class="podcast_block-item-image">
                    <img src="https://ssl-static.libsyn.com/p/assets/f/1/7/0/f170eb47e4d8545e/White_Logo2x.jpg " alt="podcast image">
                </div>
                <div class="podcast_block-item-text">
                    <div class="podcast_block-item-top-text">
                        Wed May 25 2022 | Episode 100 | Seven Group
                    </div>
                    <h4 class="podcast_block-item-title">
                        The Evolving Investor Mindset and What it Means for Advisors: A Conversation With Zoe’s Andres Garcia-Amaya
                    </h4>

                    <div class="podcast_block-item-desc">
                        <p>We're at ep 100! In this episode, we sit down with Andres Garcia-Amaya, Founder of Zoe Financial - a platform that connects investors with advisors, while educating the market on different financial planning topics and discussions.&nbsp;</p> <p>Zoe has become a huge asset for financial advisors trying to grow their practice, but they're also seeing every day what investors want. We get into the biggest investor trends and how you can be thinking about serving clients in a future world.&nbsp;</p> <p>Check out Zoe at: https://zoefin.com/</p>
                    </div>
                    <audio src="https://traffic.libsyn.com/secure/advisorlab/Seven_Group_-_Advisor_Lab_-_Andres.mp3?dest-id=1706015" id="track"></audio>
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
                                <input type="range" id="progressBar" min="0" max="1904.58425" value="0">
                            </div>
                            <div class="track-time">
                                <div id="currentTime">0:00</div>
                                <div id="durationTime">31:44</div>
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
                                        <a href="http://www.facebook.com/sharer.php?u=https://traffic.libsyn.com/secure/advisorlab/Seven_Group_-_Advisor_Lab_-_Andres.mp3?dest-id=1706015" title="facebook" target="_blank"></a>
                                        <a href="https://twitter.com/share?url=https://traffic.libsyn.com/secure/advisorlab/Seven_Group_-_Advisor_Lab_-_Andres.mp3?dest-id=1706015" title="twitter" target="_blank"></a>
                                        <a href=" http://www.linkedin.com/shareArticle?mini=true&amp;url=https://traffic.libsyn.com/secure/advisorlab/Seven_Group_-_Advisor_Lab_-_Andres.mp3?dest-id=1706015" title="linkedin" target="_blank"></a>
                                        <a href=" http://pinterest.com/pin/create/button/?url=https://traffic.libsyn.com/secure/advisorlab/Seven_Group_-_Advisor_Lab_-_Andres.mp3?dest-id=1706015" title="pinterest" target="_blank"></a>
                                    </div>
                                </div>
                                <a class="audio-buttons-download" href="https://traffic.libsyn.com/secure/advisorlab/Seven_Group_-_Advisor_Lab_-_Andres.mp3?dest-id=1706015" target="_blank">	</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<a href="#" class="podcast_loadmore">Load More Episodes</a>
	</div>
<?php } ?>


<?php
get_footer('custom');
//get_footer();
wp_footer();