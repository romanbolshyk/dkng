<?php
/**
 * Template Name: Sign Up M
 *
 * @package WordPress
 */
get_header(); ?>


<main class="main">
    <div class="page-bg" style="background-image: url(<?php echo $page_bg; ?>"></div>
    <section class="section section--page-title">
        <h3 class="section__page-title"><?php echo the_title();?></h3>
        <div class="section__page-separator">

        </div>
    </section>
    <section class="section section--content">
        <div class="section__content-wrap">
            <div class="section__content">
                <div class="sign-up-content" id="register-page">

                    <form  action="" class="standard-form register-user-form" method="post" >

                        <input type="email" name="user_email" id="user_email" required placeholder="Email">
                        <input type="hidden" name="action_form" id="action_form" value="register_user">
                        <br/>
                        <p class="error_ajax" style="color: red; display: none;"></p>
                        <p class="done_ajax" style="color: green; display: none;"></p>
                        <input type="submit" value="Register" >
                        <div class="no-log-in">Already have an account?<a href="/log-in">Log in.</a></div>

                    </form>

                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();