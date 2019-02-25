<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package thinkwp
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

    <script>
	    if(navigator.userAgent.indexOf('MSIE')!==-1
		    || navigator.appVersion.indexOf('Trident/') > -1){
	    	    var script = document.createElement('script');
	    	    script.type = 'text/javascript';
			    script.src = '/wp-content/themes/thinkwp/js/lib/css-polyfills.min.js';
			    document.getElementsByTagName('head')[0].appendChild(script);
	    }
    </script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- 12-Grid Layout Checker -->
<?php
if ( get_query_var('show-grid' ) ) {
  get_template_part( 'template-parts/ts-custom/ts-grid' );
}
?>
<!-- END 12-Grid Layout Checker -->

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'thinkwp' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$thinkwp_description = get_bloginfo( 'description', 'display' );
			if ( $thinkwp_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $thinkwp_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'thinkwp' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
