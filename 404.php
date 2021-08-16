<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package thinkwp
 * @subpackage  Timber
 */

use Timber\Timber;

$context               = Timber::get_context();
$context['categories'] = Timber::get_terms( 'category' );
Timber::render( '404.twig', $context );
