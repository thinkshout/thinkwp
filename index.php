<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package thinkwp
 * @subpackage  Timber
 */

use Timber\Timber;

$context                 = Timber::get_context();
$context['post']         = Timber::get_post();
$context['posts']        = Timber::get_posts();
$context['pagination']   = Timber::get_pagination();
$context['categories']   = Timber::get_terms( 'category' );
$context['is_archive']   = true;
$context['archive_slug'] = str_replace( ' ', '-', strtolower( $context['wp_title'] ) );

$templates = array( 'archive/archive.twig' );
Timber::render( $templates, $context );
