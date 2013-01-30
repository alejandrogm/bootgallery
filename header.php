<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php
			$metadata = get_post_meta( $post->ID, 'SEO', true);
			if ( is_category() ) {
				echo 'Category Archive for &quot;'; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
			} elseif ( is_tag() ) {
				echo 'Tag Archive for &quot;'; single_tag_title(); echo '&quot; | '; bloginfo( 'name' );
			} elseif ( is_archive() ) {
				wp_title(''); echo ' Archive | '; bloginfo( 'name' );
			} elseif ( is_search() ) {
				echo 'Search for &quot;'.wp_specialchars($s).'&quot; | '; bloginfo( 'name' );
			} elseif (is_home()){
				if(!validaMetadata(get_option('bg_title'))){
					bloginfo('name');
				}
				else{
					echo get_option('bg_title');
				}
			} elseif ( is_404() ) {
				echo 'Error 404 Not Found | '; bloginfo( 'name' );
			} elseif ( is_single() ) {
				if(!validaMetadata($metadata['title'])){ the_title();}
				else{ echo $metadata['title']; }	
			} else {
				echo wp_title(''); echo ' | '; bloginfo( 'name' );
			} ?></title>
		<?php 
		// Conditional Meta Description
		if (is_home()){
			if(!validaMetadata(get_option('bg_description'))){
				echo '<meta name="description" content="'; bloginfo('description'); echo '"/>';
			}
			else{ echo '<meta name="description" content="'.get_option('bg_description'); echo '"/>';}
		}
		elseif ( is_single() ) {
			if(!validaMetadata($metadata['description'])){}
			else{ echo '<meta name="description" content="'.$metadata['description']; echo '"/>';}
		}
		// End Meta Description
		?>
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
		<!--[if lt IE 9]>
			 <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<meta name="viewport" content="width=device-width , initial-scale=1 ,maximum-scale=1" />
		<?php wp_enqueue_script("jquery");
			wp_head(); ?>
	</head>
	<body>
		<header>
			<div class="container">
				<?php if ( is_home() ) {echo '<h1 id="logo"><a href="';bloginfo('url'); echo '" title="';bloginfo('name'); echo '">';bloginfo('name'); echo '</a></h1>';} else { echo '<span id="logo"><a href="';bloginfo('url'); echo '" title="';bloginfo('name'); echo '">';bloginfo('name'); echo '</a></span>'; } ?>
			</div>
		</header>
		<nav class="navbar container">
			<div class="navbar-inner">
				<?php wp_nav_menu( array( 'theme_location' => 'header', 'container_class' => 'container', 'items_wrap' => '
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        </a>
				<a class="brand" href="#">Menu</a>
				<div class="nav-collapse collapse">
					<ul class="nav">%3$s</ul>
				</div>
				'));?>
			</div>
		</nav>