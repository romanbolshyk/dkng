<div class="footer bg-color-grey no-bg-img">
    <div class="default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?php echo get_site_url();?>"><img src="./dist/img/footer-logo.svg" alt="logo footer"/></a>

                    <p>3 Park Avenue, 36th Floor<br/>
                        New York, NY 10016
                    </p>

                    <div class="socials">
                        <a href="#"><img src="./dist/img/linkedin.png" alt="linkedin icon"/></a>
                        <a href="#"><img src="./dist/img/facebook.png" alt="facebook icon"/></a>
                        <a href="#"><img src="./dist/img/twitter.png" alt="twitter icon"/></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php wp_nav_menu( [
                        'container'      => '',
                        'theme_location' => 'footer_top_sign_group',
                        'items_wrap'     => '<ul class="d-flex justify-content-between">%3$s</ul>',
                    ] ); ?>
                    <?php wp_nav_menu( [
                        'container'      => '',
                        'theme_location' => 'footer_bottom_sign_group',
                        'items_wrap'     => '<ul class="d-flex justify-content-between">%3$s</ul>',
                    ] ); ?>
                </div>
            </div>
            <div class="row">
                <div class="separator"></div>
                <div class="col-lg-4">
                    <p class="copyright">Copyright © 2022 ger . All rights reserved.</p>
                </div>
                <div class="col-lg-8">
                    <?php wp_nav_menu( [
                        'container'      => '',
                        'theme_location' => 'footer_copyright_sign_group',
                        'items_wrap'     => '<ul class="d-flex justify-content-end">%3$s</ul>',
                    ] ); ?>
                </div>
                <div class="separator"></div>
            </div>
        </div>

    </div>
</div>
<?php wp_footer();?>
</body>
</html>
