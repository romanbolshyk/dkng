<?php
/**
 * Template Name: Forgot Password Page
 *
 * @package WordPress
 */

get_header();
get_template_part( 'template-parts/navigation/navigation', 'main' ); ?>

    <main class="main">
        <div class="page-bg" ></div>
        <section class="section section--page-title">
            <h3 class="section__page-title"><?php echo the_title();?></h3>
        </section>
        <section class="section section--content">
            <div class="section__content-wrap">
                <div class="section__content">

                    <div data-action="<?php echo home_url(); ?>/wp-ajax-restore-password.php" class="login-form" id="forgotPasswordForm">

                        <h2 class="pitfalls-single-h2">Forgot your password?</h2>

                        <div class="tip-off-person-form__item-wrap">
                            <div class="label-wrap">
                                <label for="user_login">Please enter your login or email address</label>
                            </div>
                            <input type="text" name="user_login" id="user_login">
                        </div>

                        <div class="btn-wrap">
                            <button class="btn tip-off">
                                <a href="#" onclick="return false;"><span></span>Reset password</a>
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </main>

    <div class="contacts-popup-wrap" id="restorePasswordPopup">
        <div class="popup restore-password-popup">
            <div class="popup-text">
                Thank you. We sent a password reset link to your email address.
            </div>
            <span class="popup-close">
                <i class="icon-popup_close_icon_grey"></i>
            </span>
        </div>
    </div>

<?php

get_footer();