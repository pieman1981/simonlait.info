<!DOCTYPE html>

<!-- 
_____________________________________________________

aspect-support.co.uk
Development: OgBit.com
Version: 1.0
_____________________________________________________

-->

<html>

<head>
	<meta charset="utf-8">
	
	<title><?php wp_title(''); ?></title>
	
	<meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1">
	
	<meta name="description" content="">
	<meta name="author" content="">	

	<!-- Typekit -->
	<script type="text/javascript" src="//use.typekit.net/umj3iqb.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<!-- For all browsers -->
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory');?>/assets/css/reset.css">
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory');?>/assets/css/general.css">
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory');?>/style.css">
	<link href='http://fonts.googleapis.com/css?family=Economica' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
	

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
	<script src="<?php bloginfo('template_directory');?>/assets/js/plugins.js"></script>

	<meta name="google-site-verification" content="kncN6JDMWbA1NHzFwiv8sPTMiGqADXsedY4yzRSgiww" />
	
	<!--[if lt IE 9]>	
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if lt IE 7 ]><link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory');?>/assets/css/ie6.css"><![endif]-->

	<!-- Icon for iPhone 4 -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_directory');?>/assets/img/apple-touch-icon.png">
	
	<!-- Specify a canonical link to avoid duplicate content issues // http://t.co/y1jPVnT -->
	<link rel="canonical" href="/">
	<?php wp_deregister_script('jquery'); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="body2"></div>
<div id="body3"></div>
<div class="container">
	<header>
		<h2><a href="<?php echo get_settings('home'); ?>"></a></h2>

		<nav class="font">
			<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => '', menu_class => 'dropdown' ) ); ?>
		</nav>
	</header>