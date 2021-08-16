<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package thinkwp
 * @subpackage  Timber
 */

/**
 * Grab necessary classes from lib dir
 */
require_once 'lib/index.php';

/**
 * Instantiate the theme class from lib/class-theme.php
 */
new Theme();

if ( is_admin() ) {
	new AdminTheme();
}
