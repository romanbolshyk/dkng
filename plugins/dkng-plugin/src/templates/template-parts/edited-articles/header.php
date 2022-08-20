<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	$sharing_image         = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
	$sharing_image         = str_replace( '-150x150', '', $sharing_image );
	$sharing_image_small   = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
	$sharing_image_small   = str_replace( '-150x150', '-350x350', $sharing_image_small );
    $title                 = get_the_title( get_the_ID() ) ;
	?>
    <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $title;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="image" property="og:image" content="<?php echo $sharing_image?>">
	<meta property="twitter:image" content="<?php echo $sharing_image_small?>">
	<meta property="og:image:secure_url" content="<?php echo $sharing_image?>">
    <base href="./">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?php wp_head();?>
</head>
<body>
    <?php
    $post         = get_post( get_the_ID() );
    $author_id    = $post->post_author;
    $user         = wp_get_current_user();

    $phone        =  get_field( 'phone',      'user_' . $author_id );
    $email        =  get_field( 'email',      'user_' . $author_id );
    $custom_site  =  get_field( 'custom_site','user_' . $author_id );
    $custom_site1 = '';
    $custom_site  =  !empty( $custom_site ) ? $custom_site : get_site_url();
    $custom_site1 =  ( !strstr( $custom_site, 'https://' ) && !strstr( $custom_site, 'http://' ) ) ? 'http://' . $custom_site : $custom_site;
    $email        =  ( !empty( $email ) ) ? $email : $user->user_email;

    $upload_dir   = wp_upload_dir();
    $file_name    = get_user_meta( $author_id, 'avatar', true );
    $fileurl      = $upload_dir['basedir'] . '/' . $file_name;
    $filepath     = $upload_dir['baseurl'] . '/' . $file_name;
    $fileurl      = ( file_exists( $fileurl ) && !empty( $file_name ) ) ? $filepath : get_template_directory_uri() . "/dist/img/avatar.png";
    ?>
    <div class="super_container">

        <div class="dashboard-page">

            <!-- Header -->
            <header class="dark-header">
                <div class="container">
                    <div class="row">
                        <div class="col-5 col-md-4 col-lg-7 col-xl-8 d-flex flex-row justify-content-start align-items-center">
                            <a href="<?php echo $custom_site1;?>">
                                <img src="<?php echo $fileurl;?>" alt="logo-white"  style="max-width: 220px; margin-top: -5px; height: 100px;"/>
                            </a>
                        </div>
                        <div class="right-link col-7 col-md-8 col-lg-5 col-xl-4 mt-3 mt-md-0">
                            <div class="pull-right">
                                <a href="#"><div class="text-center icon-box"><i class="fa fa-mobile-phone"></i></div><?php echo $phone?></a>
                                <a href="#"><div class="text-center icon-box"><i class="fa fa-laptop"></i></div><?php echo $email;?></a>
                                <?php if ( !empty( $custom_site ) ) { ?>
                                    <a href="<?php echo $custom_site1;?>">
                                        <div class="text-center icon-box"><i class="fa fa-globe"></i></div>
                                        <?php echo $custom_site;?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
