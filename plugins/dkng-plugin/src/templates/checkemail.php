<?php
$current_url  = $_SERVER['REQUEST_URI'];
$template_dir = get_template_directory_uri();

wp_enqueue_script("jquery");
wp_head();

$body_class = ( ( strpos( $current_url, 'login' ) ) || ( strpos( $current_url, 'contact' ) )  ) ? "profile-page" : '';

?>
	<!DOCTYPE html>
	<html lang="en">
<head>
	<title>Seven Group</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Seven Group">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?php echo $template_dir; ?>/">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $template_dir; ?>/favicon.ico">
	<link rel="icon" type="image/x-icon"  href="<?php echo $template_dir; ?>/favicon.ico">
</head>


<body class="<?php echo $body_class;?> checkmailbody" >
	<div class="super_container">
		<div class="inner_container profile checkmail"  >
			<div id="login">
				<h1 class="message">Have no fear. A link to reset your password is on the way.</h1>
				<div class="logo">
					<a href="<?php echo get_site_url();?>">
						<img src="./dist/img/logo_c.svg"/>
					</a>
				</div>
			</div>
		</div>
	</div>
</body>

<?php

wp_footer();
