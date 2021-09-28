<?php
/**
 * thinkwp twig integration via timber
 *
 * @link https://timber.github.io/docs/getting-started/setup/
 * @package thinkwp
 * @subpackage  Timber
 */

$timber            = new Timber\Timber();
Timber::$locations = [ get_template_directory() . '/templates', get_template_directory() ];

/**
 * ThemeTimber class that integrates Twig templating with WordPress.
 */
class ThemeTimber extends Timber\Site {
	/**
	 * Construct the class adding actions, filters, and other initiation code
	 */
	public function __construct() {
		// Actions!
		// Filters!
		add_filter( 'timber/context', [ $this, 'add_to_context' ] );
		add_filter( 'timber/twig', [ $this, 'add_to_twig' ] );

		// new Timber_Acf_Wp_Blocks(); // Register blocks in views/blocks with ACF.
		parent::__construct();
	}

	/**
	 * Register properties with global context object for use in Timber templates
	 *
	 * @param object $context The existing TimberContext as built by Timber.
	 *
	 * @return object the modified (added to) TimberContext
	 */
	public function add_to_context( $context ) {
		$context['header_menu'] = new TimberMenu( 'header-menu' );
		$context['footer_menu'] = new TimberMenu( 'footer-menu' );
		$context['footer_copy'] = new TimberMenu( 'footer-copyright' );
		$context['theme_mods']  = get_theme_mods();
		$context['path']        = get_stylesheet_directory_uri();
		$context['stylesheet']  = get_stylesheet_directory_uri() . '/dist/main.css';
		$context['site_logo']   = wp_get_attachment_image_url( $context['theme_mods']['custom_logo'], 'full' );

		return $context;
	}

	/**
	 * Console Logging PHP Values
	 *
	 * @param multi $value The variables to be logged.
	 */
	public function php_console( $value = null ) {
		// Console Log a mixed var.
		echo '<script type="text/javascript">console.log(' . wp_json_encode( $value ) . ');</script>';
	}

	/**
	 * Register custom functions with Timber for use in Twig templates
	 *
	 * @param object $twig The Twig class as instantiated by Timber.
	 *
	 * @return object the modified Twig class with functions added
	 */
	public function add_to_twig( $twig ) {
		// PHP Console.
		$twig->addFunction(
			new Timber\Twig_Function(
				'console',
				array( $this, 'php_console' )
			)
		);

		return $twig;
	}

}
