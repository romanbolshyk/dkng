<?php

$bottom_popup_image    = get_field( 'bottom_popup_image',       'options');
$bottom_popup_image_id = get_image_id($bottom_popup_image);
$bottom_popup_image_alt = get_post_meta($bottom_popup_image_id, '_wp_attachment_image_alt', TRUE);

$bottom_popup_text1    = get_field( 'bottom_popup_text1',       'options');
$bottom_popup_text2    = get_field( 'bottom_popup_text2',       'options');
$bottom_popup_btn_name = get_field( 'bottom_popup_button_name', 'options');
$bottom_popup_btn_link = get_field( 'bottom_popup_button_link', 'options');

$exit_popup_image      = get_field( 'exit_popup_image',             'options');
$exit_popup_image_id = get_image_id($exit_popup_image);
$exit_popup_image_alt = get_post_meta($exit_popup_image_id, '_wp_attachment_image_alt', TRUE);

$exit_popup_text1      = get_field( 'exit_popup_text1',             'options');
$exit_popup_text2      = get_field( 'exit_popup_text2',             'options');
$exit_popup_email_txt  = get_field( 'exit_popup_email_placeholder', 'options');
$exit_popup_btn_name   = get_field( 'exit_popup_button_name',       'options');
$exit_popup_cancel_txt = get_field( 'exit_popup_cancel_text',       'options');

$bottom_popup_image    = !empty( $bottom_popup_image )    ? $bottom_popup_image    : '';
$bottom_popup_text1    = !empty( $bottom_popup_text1 )    ? $bottom_popup_text1    : '';
$bottom_popup_text2    = !empty( $bottom_popup_text2 )    ? $bottom_popup_text2    : '';
$bottom_popup_btn_name = !empty( $bottom_popup_btn_name ) ? $bottom_popup_btn_name : '';
$bottom_popup_btn_link = !empty( $bottom_popup_btn_link ) ? $bottom_popup_btn_link : '';

$exit_popup_image      = !empty( $exit_popup_image )      ? $exit_popup_image      : '';
$exit_popup_text1      = !empty( $exit_popup_text1 )      ? $exit_popup_text1      : '';
$exit_popup_text2      = !empty( $exit_popup_text2 )      ? $exit_popup_text2      : '';
$exit_popup_email_txt  = !empty( $exit_popup_email_txt )  ? $exit_popup_email_txt  : '';
$exit_popup_btn_name   = !empty( $exit_popup_btn_name )   ? $exit_popup_btn_name   : '';
$exit_popup_cancel_txt = !empty( $exit_popup_cancel_txt ) ? $exit_popup_cancel_txt : '';

?>

<div class="footer">
    <?php if ( !is_user_logged_in() ) { ?>
        <div class="footer_popup_block">
            <div class="footer-popup">
                <div class="left block" >
                    <div class="img_block">
                        <img src="<?php echo  $bottom_popup_image;?>" alt="<?php echo esc_attr( $bottom_popup_image_alt ); ?>">
                    </div>
                    <div class="txt_block">
                        <p ><?php echo $bottom_popup_text1;?></p>
                        <p ><?php echo $bottom_popup_text2;?></p>
                    </div>
                </div>
                <div class="right block">
                    <a href="<?php echo $bottom_popup_btn_link;?>" >
                        <?php echo $bottom_popup_btn_name;?>
                    </a>
                </div>
                <span class="exit_b_popup">x</span>
            </div>
        </div>

        <div class="modal exit_popup_block" id="exit_popup_block" >
            <div class="exit-popup">
                <div class="top">
                    <h3 ><?php echo $exit_popup_text1;?></h3>
                </div>
                <div class="bottom">
                    <div class="left block" >
                        <div class="img_block">
                            <img src="<?php echo $exit_popup_image;?>" alt="<?php echo esc_attr( $exit_popup_image_alt ); ?>">
                        </div>
                    </div>
                    <div class="right block form_contact_box">
                        <p class="under_form"><?php echo $exit_popup_text2;?></p>
                        <form action="" id="contact_form" method="post">
                            <input type="hidden" name="company" value="" />
							<input type="text" class="email top" name="name"  placeholder="First Name"  required/>
							<input type="text" class="email top" name="lastname"  placeholder="Last Name"  required/>
                            <input type="email" class="email"  name="email"  placeholder="<?php echo $exit_popup_email_txt;?>" required />
                            <input type="submit" value="Send Me the Details" class="btn btn-primary contact_submit"/>
                        </form>
                        <div class="success_message_block success_message_block_none" >
                            <h3><?php if ( $success_message ) echo  $success_message;?></h3>
                        </div>
                        <img src="./dist/img/loader.gif" alt="loader"  id="loader" style="display: none;"/>
                        <span class="exit_e_popup" data-dismiss="modal"><?php echo $exit_popup_cancel_txt;?></span>
                    </div>
                </div>
                <span class="exit_b_popup exit_exit_popup">x</span>
            </div>
        </div>

    <?php } ?>
    <div class="default-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12 col-md-12">
                    <a href="<?php echo get_site_url();?>"><img src="./dist/img/footer-logo.svg" alt="footer logo" /></a>
                    <p>
                        <?php echo esc_html__("3 Park Avenue, 36th Floor", "dkng");?><br/>
                        <?php echo esc_html__("New York, NY 10016", "dkng");?>
                    </p>
                </div>
                <div class="col-lg-8  col-xs-12 col-md-12 menus_footer">
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
                            ] ); ?>
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
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="separator"></div>
                <div class="col-lg-4 col-xs-12 col-md-12">
                    <p class="copyright"><?php echo esc_html__( "Copyright © 2022  Group, LLC. All rights reserved.", "dkng" );?></p>
                </div>
                <div class="separator"></div>
            </div>
        </div>

    </div>
</div>

<div id="youtubem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-x" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <div class="videoWrapper">
                    <div class="player"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php wp_footer();?>
</body>
</html>
