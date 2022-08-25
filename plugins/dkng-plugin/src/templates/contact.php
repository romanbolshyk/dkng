<?php
get_header('custom');

$form_block          = get_field(  'form_block' );
$contact_info_block  = get_field(  'contact_info_block' );
$visit_us_block      = get_field(  'visit_us_block' );
$success_message     = get_field( 'success_message', 'option' )
?>
        <div class="inner_container profile">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="inner_content">
                            <div class="row">
                                <div class="col-xs-12 col-lg-8">
                                    <h2>Контакти</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="contact-form">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-4 contact_page_block">
                    <div class="contact-form__col">
                        <p>
                            <b>E-mail: </b> <a href="mailto:<?php echo get_field('email', 'option'); ?>"><?php echo get_field('email', 'option'); ?></a>
                        </p>
                        <p> <b>Тел. приймальної комісії: </b>
                            <a href="tel:<?php echo  get_field( 'commision_phone', 'option'); ?>">
                                <?php echo  get_field( 'commision_phone', 'option'); ?>
                            </a>
                        </p>
                        <p> <b> Тел./факс: </b>
                            <a href="tel:<?php echo  get_field( 'phone', 'option'); ?>">
                                <?php echo  get_field( 'phone', 'option'); ?>
                            </a>
                        </p>
                        <p> <b>Skype: </b> <?php echo  get_field( 'skype', 'option'); ?></p>
                        <p> <b>Viber, Telegram, WhatsApp: </b>
                            <a href="tel:<?php echo  get_field( 'commision_phone', 'option'); ?>">
                                <?php echo  get_field( 'commision_phone', 'option'); ?>
                            </a>
                        </p>
                    </div>

                    <br><br>

                    <div class="contact-form__col">
                        <p><b>Адреса: </b></p>
                        <p><?php echo get_field('address1', 'option');?></p>
                        <p><?php echo get_field('address2', 'option');?></p>
                    </div>

                </div>
                <div class="col-xs-12 col-lg-8 d-flex d-lg-block contact-form__info">
                    <div class="box form_contact_box form_contact_box_css">

                        <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2598.924264417638!2d23.519989!3d49.353582!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc506d9182b3b1fd!2z0JTRgNC-0LPQvtCx0LjRhtGM0LrQuNC5INGE0LDRhdC-0LLQuNC5INC60L7Qu9C10LTQtiDQvdCw0YTRgtC4INGWINCz0LDQt9GD!5e0!3m2!1suk!2sua!4v1661361421090!5m2!1suk!2sua" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php
get_footer('custom');
wp_footer();
