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
                                    <h4><?php if ( $form_block['title'] ) echo $form_block['title'];?></h4>

                                    <h1><?php if ( $form_block['text'] ) echo $form_block['text'];?></h1>
                                </div>
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
                <div class="col-xs-12 col-lg-8 contact_page_block">
                    <div class="box form_contact_box form_contact_box_css">
                        <form action="" id="contact_form">
                            <label><?php echo __( "Company", "dkng" );?></label>
                            <input type="text" name="company"/>
                            <label><?php echo __( "First Name*", "dkng" );?></label>
                            <input type="text" name="name"  required/>
							<label><?php echo __( "Last Name*", "dkng" );?></label>
                            <input type="text" name="lastname"  required/>
                            <label><?php echo __( "Email*", "dkng" );?></label>
                            <input type="email" name="email" required/>
                            <input type="submit" value="Send" class="btn btn-primary contact_submit"/>
                        </form>
                        <br>
                    </div>
                    <div class="success_message_block success_message_block_none" >
                        <h3 ><?php if ( $success_message) echo  $success_message;?></h3>
                    </div>
                    <img src="./dist/img/loader.gif" alt="loader"  id="loader" />
                </div>
                <div class="col-xs-12 col-lg-4 d-flex d-lg-block contact-form__info">
                    <div class="contact-form__col">
                        <h4><?php if ( $contact_info_block['title'] ) echo $contact_info_block['title'];?></h4>

                        <?php if ( $contact_info_block['email'] ) : ?>
                            <a href="mailto:<?php echo esc_attr( $contact_info_block['email'] ); ?>"><?php echo $contact_info_block['email']; ?></a>
                        <?php endif; ?>

                        <?php if ( $contact_info_block['phone'] ) : ?>
                            <br><a href="tel:<?php echo esc_attr( preg_replace("/[^0-9]/", "", $contact_info_block['phone']) ); ?>">
                                <?php echo $contact_info_block['phone']; ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <br><br>

                    <div class="contact-form__col">
                        <h4><?php if ( $visit_us_block['title'] ) echo $visit_us_block['title'];?></h4>

                        <p><?php if ( $visit_us_block['address1'] ) echo $visit_us_block['address1'];?></p>
                        <p><?php if ( $visit_us_block['address2'] ) echo $visit_us_block['address2'];?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer('custom');
wp_footer();
