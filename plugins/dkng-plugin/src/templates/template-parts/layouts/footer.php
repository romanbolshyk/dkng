
            </div>
        </div>
    </div>

    <div class="main-content footer">
        <div class="default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xs-12 col-md-12">
                    <a href="#"><img src="./dist/img/footer-logo.svg"/></a>
                    <p>
                    <?php echo esc_html__("3 Park Avenue, 36th Floor", "dkng");?><br/>
                    <?php echo esc_html__("New York, NY 10016", "dkng"); ?>
                    </p>
                    </div>
                    <div class="col-lg-8  col-xs-12 col-md-12">
                        <ul class="d-flex justify-content-between">
                            <li>
                                <span class="a"><?php echo esc_html( "Seven Group", "dkng");?></span>
                                <?php wp_nav_menu( [
                                    'container'      => '',
                                    'theme_location' => 'seven_group',
                                    'items_wrap'     => '<ul>%3$s</ul>',
                                    'walker'         => new My_Walker_Mobile_Menu(),
                                ] ); ?>
                            </li>
                            <li>
                                <span class="a"><?php echo esc_html( "Advisors", "dkng");?></span>
                                <?php wp_nav_menu( [
                                    'container'      => '',
                                    'theme_location' => 'advisors_group',
                                    'items_wrap'     => '<ul>%3$s</ul>',
                                    'walker'         => new My_Walker_Mobile_Menu(),
                                ] ); ?>>
                            </li>
                            <li>
                                <span class="a"><?php echo esc_html( "Resources", "dkng");?></span>
                                <?php wp_nav_menu( [
                                    'container'      => '',
                                    'theme_location' => 'resources_group',
                                    'items_wrap'     => '<ul>%3$s</ul>',
                                    'walker'         => new My_Walker_Mobile_Menu(),
                                ] ); ?>
                            </li>
                            <li><a href="#"></a>
                                <ul>
                                    <li><a href="#"></a></li>
                                    <li><a href="#"></a></li>
                                    <li><a href="#"></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="separator"></div>
                    <div class="col-lg-4 col-xs-12 col-md-12">
                        <p class="copyright"><?php echo esc_html__("Copyright © 2019 Seven Group, LLC. All rights reserved.", "dkng"); ?></p>
                    </div>
                    <div class="separator"></div>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>

  </body>
</html>
