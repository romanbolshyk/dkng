<?php
$welcome_title       = get_field( 'welcome_title',  'option' );
$welcome_text        = get_field( 'welcome_text',   'option' );
$crushing_text       = get_field( 'additional_text','option' );
?>
<div class="col-12 col-md-11">
    <h4><?php if ( !empty( $welcome_title ) ) echo $welcome_title; ?></h4>
    <p><?php if ( !empty( $welcome_text ) ) echo $welcome_text; ?></p>
</div>
<div class="col-12 col-md-1 d-flex justify-content-end align-items-start">
    <a href="#" class="close-collapse close-welcome"><i class="fa fa-times"></i></a>
</div>