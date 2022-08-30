<?php
$logo   = get_field('logo_image', 'options');
$photos = get_field('footer_pictures', 'options');
?>

<!-- <div class="c-footer" style="background: url(<?php echo get_field('header_background', 'option')?>) 100% 100%;  background-size: contain;"> -->
<div class="c-footer">
    <div class="container">
        <div class="c-footer__top">
            <div class="c-footer__left">
                <div class="c-footer__info">
                    <span class="c-footer__info--item">
                        <?php echo get_field('address1', 'option');?>
                    </span>
                    <span class="c-footer__info--item">
                        <?php echo get_field('address2', 'option');?>
                    </span>
                    <span class="c-footer__info--item">
                        тел.: <?php echo get_field('phone', 'option');?>
                    </span>
                    <span class="c-footer__info--item">
                        приймальна комісія: <?php echo get_field('commision_phone', 'option');?>
                    </span>
                    <span class="c-footer__info--item">
                        e-mail: <?php echo get_field('email', 'option');?>
                    </span>
                    <span class="c-footer__info--item">
                        skype: <?php echo get_field('skype', 'option');?>
                    </span>
                </div>

                <div class="c-footer__social">
                    <a href="<?php echo get_field('facebook_link', 'option');?>" target="_blank" class="c-footer__social--item">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo get_field('linkedin_link', 'option');?>" target="_blank" class="c-footer__social--item">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo get_field('instagram_link', 'option');?>" target="_blank" class="c-footer__social--item">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="<?php echo get_field('youtube_link', 'option');?>" target="_blank" class="c-footer__social--item">
                        <i class="fa fa-youtube" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="c-footer__right">
                <div class="c-footer__gallery">
                    <?php foreach ( $photos as $photo ) { ?>
                        <a href="<?php echo $photo['link'];?>" class="c-footer__gallery--item">
                            <img src="<?php echo $photo['img'];?>" alt="">
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row- c-footer__copyright">
            <div class="separator"></div>
            <span><?php echo get_field('copyright', 'option');?></span>
        </div>
    </div>   
</div>


<?php wp_footer();?>
</body>
</html>
