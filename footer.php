<?php
/**
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the view/page-plugin.twig template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package thinkwp
 * @subpackage  Timber
 */

use Timber\Timber;

$timber_context = $GLOBALS['timberContext'];
if ( ! isset( $timber_context ) ) {
	throw new \Exception( 'Timber context not set in footer.' );
}
$timber_context['content'] = ob_get_contents();
ob_end_clean();
$templates = array( 'page-plugin.twig' );
Timber::render( $templates, $timber_context );
