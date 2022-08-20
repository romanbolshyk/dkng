<?php
    get_header();
    $i = 0;
?>
<?php while ( have_posts() ) : the_post();
    $post_id  = get_the_ID();
    $courses = new WP_Query( array ( 'post_type' => 'courses', 'posts_per_page' => 20, 'post__not_in' => array( $post_id ) ) );
    ob_start();
    foreach ( $courses->posts as $course ) { ?>
        <div class="item">
            <div class="strategies-holder status-new d-flex flex-column justify-content-start align-items-center">
                <img src="./dist/img/icon-hands.png" alt="icon-hands"/>
                <div class="point-holder d-flex flex-row justify-content-center align-items-center">
                    <div class="point-full"></div>
                    <div class="point-full"></div>
                    <div class="point-half"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                    <div class="point-dot"></div>
                </div>
                <p><?php echo $course->post_title; ?></p>
                <p class="grey">New</p>
            </div>
        </div>
    <?php }
    $other_courses = ob_get_clean();
?>
    <div class="dark-box clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12 video-title mt-5 mt-md-0">
                    <label>LinkedIn</label>
                    <p>An Introduction to <?php echo the_title(); ?></p>
                </div>
                <div class="col-12 col-md-7 col-lg-8 video-content">
                    <iframe style="border-radius: 20px;" width="750" height="465" src="https://www.youtube.com/embed/LTL-lkdF45w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="col-12 col-md-5 col-lg-4 video-list mt-3 mt-md-0">
                    <label>Courses</label>
                    <ul class="link-holder">
                        <?php if ( $lessons = get_field( 'lessons', $post_id) ) {
                            foreach ( $lessons as $lesson ):
                                $i++; ?> 
                                <li>
                                    <a href="" class="video-link" data-link="<?php echo $lesson['video_link'];?>">
                                        <span class="number"><?php echo $i;?></span>
                                        <span class="video-name"><?php echo $lesson['name'];?></span>
                                        <span class="time"><?php echo $lesson['duration'];?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?> 
                        <?php } ?> 
                    </ul>
                </div>
            </div>
            <p class="complete_task_button btn btn-view">I've completed this course</p>
        </div>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 investment-right-holder   border-right">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h5><?php echo the_title(); ?></h5>
                        <h2><?php echo the_excerpt(); ?></h2>
                    </div>
                    <div class="col-12 col-md-4 d-flex justify-content-end align-items-center">
                        <a href="#" class="btn btn-download btn-lg">Download Playbook</a>
                    </div>
                    <div class="col-12">
                        <p><label>with <span><?php echo get_the_author_meta('display_name'); ?></span></label></p>
                        <p><?php echo get_the_content(); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="nav-outline-tab" data-toggle="tab" href="#nav-outline" role="tab" aria-controls="nav-outline" aria-selected="true">Outline</a>
                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                                <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
                            </div>
                        </nav>
                        <div class="tab-content video-tabs" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-outline" role="tabpanel" aria-labelledby="nav-outline-tab">
                                <?php if ( $lessons = get_field( 'lessons', $post_id ) ) {
                                    foreach ( $lessons as $lesson ): ?>
                                        <h6><?php echo $lesson['name'];?></h6>
                                        <p class="grey"><?php echo $lesson['description'];?></p>
                                    <?php endforeach; ?>
                                <?php } ?> 
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</h6>
                                <p class="grey"> Cras sit amet libero eget erat porta lobortis quis id neque. Vestibulum pretium mauris eu dui venenatis, a finibus enim pulvinar. Etiam mollis risus ut accumsan scelerisque.</p>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</h6>
                                <p class="grey"> Cras sit amet libero eget erat porta lobortis quis id neque. Vestibulum pretium mauris eu dui venenatis, a finibus enim pulvinar. Etiam mollis risus ut accumsan scelerisque.</p>
                                <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit?</h6>
                                <p class="grey"> Cras sit amet libero eget erat porta lobortis quis id neque. Vestibulum pretium mauris eu dui venenatis, a finibus enim pulvinar. Etiam mollis risus ut accumsan scelerisque.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 border-top">
                        <div class="row">
                            <div class="col-12">
                                <h5>Other Training Courses</h5>
                            </div>
                            <div class="strategy-slider owl-carousel">
                                <?php echo $other_courses; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 investment-right-holder">
                <div class="row">
                    <div class="col-12">
                        <h5>LinkedIn</h5>
                        <h3>Helpful Articles</h3>
                        <p class="grey">Some useful membership articles to support your learning.</p>
                    </div>
                    <div class="col-12 mt-2">
                        <?php get_template_part( 'template-parts/sidebar/single', 'course' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endwhile;  ?>
<?php get_footer();